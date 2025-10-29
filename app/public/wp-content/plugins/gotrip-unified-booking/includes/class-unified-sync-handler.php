<?php
/**
 * Unified Sync Handler - Ensures all booking changes trigger real-time sync
 */

if (!defined('ABSPATH')) {
    exit;
}

class GTUB_Unified_Sync_Handler {
    
    /**
     * Initialize unified sync handler
     */
    public static function init() {
        // Hook into ALL booking create/update actions
        add_action('gtub_booking_created', array(__CLASS__, 'handle_booking_created'), 10, 2);
        add_action('gtub_booking_updated', array(__CLASS__, 'handle_booking_updated'), 10, 3);
        add_action('gtub_booking_deleted', array(__CLASS__, 'handle_booking_deleted'), 10, 1);
        
        // Ensure all sources trigger these actions
        self::setup_source_hooks();
    }
    
    /**
     * Setup hooks for all booking sources
     */
    private static function setup_source_hooks() {
        // WooCommerce hooks
        add_action('woocommerce_new_order', array(__CLASS__, 'handle_woocommerce_new_order'), 999);
        add_action('woocommerce_order_status_changed', array(__CLASS__, 'handle_woocommerce_status_change'), 999, 4);
        
        // CHBS hooks (if active)
        add_action('chbs_after_booking_sent', array(__CLASS__, 'handle_chbs_booking'), 999);
        add_action('chbs_booking_status_changed', array(__CLASS__, 'handle_chbs_status_change'), 999);
        
        // JetBooking hooks (if active)
        add_action('jet-booking/rest-api/add-booking/booking-added', array(__CLASS__, 'handle_jetbooking_new'), 999);
        add_action('jet-booking/actions/cancel-booking/cancelled', array(__CLASS__, 'handle_jetbooking_cancel'), 999);
        
        // Manual/Admin updates
        add_action('save_post_gtub_booking', array(__CLASS__, 'handle_manual_update'), 999, 3);
    }
    
    /**
     * Handle booking created
     */
    public static function handle_booking_created($booking_id, $source = 'manual') {
        error_log('GTUB Sync: Booking created - ID: ' . $booking_id . ', Source: ' . $source);
        
        // Update the booking to ensure updated_at is set
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        $wpdb->update(
            $table,
            array('updated_at' => current_time('mysql')),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );
        
        // Trigger real-time sync
        if (class_exists('GTUB_Realtime_Sync')) {
            GTUB_Realtime_Sync::log_booking_update($booking_id, 'created', null, $source);
        }
        
        // Log in audit
        GTUB_Audit_Log::log($booking_id, 'booking_created', 'Booking created from ' . $source);
    }
    
    /**
     * Handle booking updated
     */
    public static function handle_booking_updated($booking_id, $old_data, $new_data) {
        error_log('GTUB Sync: Booking updated - ID: ' . $booking_id);
        
        // Ensure updated_at is current
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        $wpdb->update(
            $table,
            array('updated_at' => current_time('mysql')),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );
        
        // Get the booking to check its source
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE id = %d",
            $booking_id
        ));
        
        // Determine what changed
        $changes = array();
        if (is_array($old_data) && is_array($new_data)) {
            foreach ($new_data as $key => $value) {
                if (!isset($old_data[$key]) || $old_data[$key] != $value) {
                    $changes[$key] = array('old' => $old_data[$key] ?? null, 'new' => $value);
                }
            }
        }
        
        // Sync back to source system
        if ($booking && $booking->source === 'woocommerce' && $booking->source_id) {
            self::sync_booking_to_woocommerce($booking, $changes);
        } elseif ($booking && $booking->chbs_booking_id) {
            // Sync to CHBS if needed
            self::sync_booking_to_chbs($booking, $changes);
        }
        
        // Trigger real-time sync
        if (class_exists('GTUB_Realtime_Sync')) {
            GTUB_Realtime_Sync::log_booking_update($booking_id, 'updated', json_encode($old_data), json_encode($new_data));
        }
        
        // Log significant changes
        if (!empty($changes)) {
            GTUB_Audit_Log::log($booking_id, 'booking_updated', 'Booking updated: ' . json_encode(array_keys($changes)));
        }
    }
    
    /**
     * Sync booking changes back to WooCommerce
     */
    private static function sync_booking_to_woocommerce($booking, $changes) {
        if (!function_exists('wc_get_order')) {
            return;
        }
        
        // Prevent infinite loop - check if this update came from WooCommerce
        if (defined('GTUB_SYNCING_FROM_WC') && GTUB_SYNCING_FROM_WC) {
            error_log('GTUB: Skipping WC sync (already syncing from WC)');
            return;
        }
        
        $order = wc_get_order($booking->source_id);
        if (!$order) {
            error_log('GTUB: WooCommerce order #' . $booking->source_id . ' not found for booking #' . $booking->id);
            return;
        }
        
        error_log('GTUB: Syncing booking #' . $booking->id . ' back to WooCommerce order #' . $booking->source_id);
        
        // Set flag to prevent infinite loop
        define('GTUB_SYNCING_TO_WC', true);
        
        $updated = false;
        
        // Sync status changes
        if (isset($changes['status'])) {
            $wc_status = self::map_booking_status_to_wc($changes['status']['new']);
            if ($order->get_status() !== $wc_status) {
                // Remove our hooks temporarily to prevent loop
                remove_action('woocommerce_order_status_changed', array('GTUB_WooCommerce_Booking_Sync', 'sync_order_status_change'), 999);
                
                $order->update_status($wc_status, 'Updated from booking system');
                $updated = true;
                error_log('GTUB: Updated WooCommerce order #' . $booking->source_id . ' status to ' . $wc_status);
                
                // Re-add hooks
                add_action('woocommerce_order_status_changed', array('GTUB_WooCommerce_Booking_Sync', 'sync_order_status_change'), 999, 4);
            }
        }
        
        // Sync payment status
        if (isset($changes['payment_status'])) {
            if ($changes['payment_status']['new'] === 'paid' && !$order->is_paid()) {
                $order->payment_complete();
                $updated = true;
                error_log('GTUB: Marked WooCommerce order #' . $booking->source_id . ' as paid');
            }
        }
        
        // Update order meta with booking details
        $order->update_meta_data('_gtub_last_sync', current_time('mysql'));
        $order->update_meta_data('_gtub_booking_status', $booking->status);
        $order->save();
        
        if ($updated) {
            error_log('GTUB: Successfully synced booking #' . $booking->id . ' to WooCommerce order #' . $booking->source_id);
        }
    }
    
    /**
     * Map booking status to WooCommerce status
     */
    private static function map_booking_status_to_wc($booking_status) {
        $map = array(
            'pending' => 'pending',
            'confirmed' => 'processing',
            'in-progress' => 'processing',
            'completed' => 'completed',
            'cancelled' => 'cancelled',
            'refunded' => 'refunded',
        );
        
        return $map[$booking_status] ?? 'pending';
    }
    
    /**
     * Sync booking changes back to CHBS
     */
    private static function sync_booking_to_chbs($booking, $changes) {
        // TODO: Implement CHBS sync if needed
        error_log('GTUB: CHBS sync for booking #' . $booking->id . ' not yet implemented');
    }
    
    /**
     * Handle booking deleted
     */
    public static function handle_booking_deleted($booking_id) {
        error_log('GTUB Sync: Booking deleted - ID: ' . $booking_id);
        
        // Trigger real-time sync for deletion
        if (class_exists('GTUB_Realtime_Sync')) {
            GTUB_Realtime_Sync::log_booking_update($booking_id, 'deleted', null, null);
        }
    }
    
    /**
     * Handle WooCommerce new order
     */
    public static function handle_woocommerce_new_order($order_id) {
        // Wait a moment for order to be fully saved
        wp_schedule_single_event(time() + 2, 'gtub_sync_woocommerce_order', array($order_id));
    }
    
    /**
     * Handle WooCommerce status change
     */
    public static function handle_woocommerce_status_change($order_id, $old_status, $new_status, $order) {
        // Find the booking
        global $wpdb;
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
            $order_id
        ));
        
        if ($booking) {
            // Trigger update
            do_action('gtub_booking_updated', $booking->id, 
                array('status' => $booking->status), 
                array('status' => $new_status)
            );
        }
    }
    
    /**
     * Handle CHBS booking
     */
    public static function handle_chbs_booking($booking_data) {
        if (isset($booking_data['booking_id'])) {
            // Check if synced
            global $wpdb;
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}gtub_bookings WHERE chbs_booking_id = %d",
                $booking_data['booking_id']
            ));
            
            if (!$existing) {
                // Create new booking
                $booking_id = GTUB_Booking::create(array(
                    'source' => 'chbs',
                    'chbs_booking_id' => $booking_data['booking_id'],
                    'status' => 'pending',
                    // ... other fields
                ));
                
                if ($booking_id) {
                    do_action('gtub_booking_created', $booking_id, 'chbs');
                }
            }
        }
    }
    
    /**
     * Handle manual update
     */
    public static function handle_manual_update($post_id, $post, $update) {
        if ($post->post_type !== 'gtub_booking') {
            return;
        }
        
        // This is a manual update from admin
        global $wpdb;
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE wp_post_id = %d",
            $post_id
        ));
        
        if ($booking) {
            do_action('gtub_booking_updated', $booking->id, array(), array('manual_update' => true));
        }
    }
    
    /**
     * Force sync a specific booking
     */
    public static function force_sync_booking($booking_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        // Force update the timestamp
        $result = $wpdb->update(
            $table,
            array('updated_at' => current_time('mysql')),
            array('id' => $booking_id),
            array('%s'),
            array('%d')
        );
        
        // Trigger real-time sync
        if (class_exists('GTUB_Realtime_Sync')) {
            GTUB_Realtime_Sync::log_booking_update($booking_id, 'force_sync', null, 'manual');
        }
        
        return $result !== false;
    }
}

// Hook to sync scheduled WooCommerce orders
add_action('gtub_sync_woocommerce_order', function($order_id) {
    GTUB_WooCommerce_Booking_Sync::sync_new_order($order_id);
});
