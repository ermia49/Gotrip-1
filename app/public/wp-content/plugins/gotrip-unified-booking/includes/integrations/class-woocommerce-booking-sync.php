<?php
/**
 * WooCommerce Booking Sync - Primary Sync Source
 * 
 * Syncs all bookings from WooCommerce orders
 * This is the main sync method since all CHBS and JetBooking go through WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

class GTUB_WooCommerce_Booking_Sync {
    
    public static function init() {
        // Hook into WooCommerce order creation - HIGHEST PRIORITY
        add_action('woocommerce_new_order', array(__CLASS__, 'sync_new_order'), 999, 1);
        add_action('woocommerce_checkout_order_processed', array(__CLASS__, 'sync_new_order'), 999, 1);
        add_action('woocommerce_thankyou', array(__CLASS__, 'sync_new_order'), 999, 1);
        
        // Hook into order status changes - HIGHEST PRIORITY
        add_action('woocommerce_order_status_changed', array(__CLASS__, 'sync_order_status_change'), 999, 4);
        
        // Hook into specific status transitions
        add_action('woocommerce_order_status_pending', array(__CLASS__, 'sync_order_status_transition'), 999, 1);
        add_action('woocommerce_order_status_processing', array(__CLASS__, 'sync_order_status_transition'), 999, 1);
        add_action('woocommerce_order_status_completed', array(__CLASS__, 'sync_order_status_transition'), 999, 1);
        add_action('woocommerce_order_status_cancelled', array(__CLASS__, 'sync_order_status_transition'), 999, 1);
        
        // Hook into order updates
        add_action('woocommerce_update_order', array(__CLASS__, 'sync_order_update'), 999, 1);
        add_action('save_post_shop_order', array(__CLASS__, 'sync_order_save'), 999, 3);
        
        // Fallback: Sync recent orders every 5 minutes
        add_action('gtub_woocommerce_fallback_sync', array(__CLASS__, 'fallback_sync'));
        
        // Log initialization
        error_log('GTUB WooCommerce Sync initialized');
    }
    
    /**
     * Sync new WooCommerce order
     */
    public static function sync_new_order($order_id) {
        if (!$order_id) {
            return false;
        }
        
        error_log('GTUB: Syncing WooCommerce order #' . $order_id);
        
        $order = wc_get_order($order_id);
        if (!$order) {
            error_log('GTUB: Order #' . $order_id . ' not found');
            return false;
        }
        
        // Skip refunds and subscriptions - only sync actual orders
        if ($order->get_type() !== 'shop_order') {
            error_log('GTUB: Skipping order #' . $order_id . ' - type: ' . $order->get_type());
            return false;
        }
        
        // Check if already synced (check both source_id AND booking_number)
        global $wpdb;
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}gtub_bookings 
            WHERE (source = 'woocommerce' AND source_id = %d) 
            OR booking_number = %s
            LIMIT 1",
            $order_id,
            $order->get_order_number()
        ));
        
        if ($existing) {
            error_log('GTUB: Order #' . $order_id . ' already synced as booking #' . $existing);
            
            // Update the existing booking instead of creating new
            $booking_data = self::extract_booking_from_order($order);
            if ($booking_data) {
                unset($booking_data['booking_number']); // Don't update booking number
                unset($booking_data['created_at']); // Don't update created_at
                $booking_data['updated_at'] = current_time('mysql');
                $booking_data['last_synced_at'] = current_time('mysql');
                
                $wpdb->update(
                    $wpdb->prefix . 'gtub_bookings',
                    $booking_data,
                    array('id' => $existing),
                    null,
                    array('%d')
                );
                
                error_log('GTUB: Updated existing booking #' . $existing . ' from order #' . $order_id);
            }
            
            return $existing; // Already synced
        }
        
        // Extract booking data from order
        $booking_data = self::extract_booking_from_order($order);
        
        if (!$booking_data) {
            return false; // Not a booking order
        }
        
        // Create unified booking
        $booking_id = GTUB_Booking::create($booking_data);
        
        if ($booking_id) {
            error_log('GTUB: Created booking #' . $booking_id . ' from WooCommerce order #' . $order_id);
            
            // Send push notifications
            self::send_push_notifications($booking_id, 'new_booking');
            
            // Link order to booking
            $order->update_meta_data('_gtub_booking_id', $booking_id);
            $order->save();
            
            // Trigger real-time sync
            if (class_exists('GTUB_Realtime_Sync')) {
                GTUB_Realtime_Sync::log_booking_update($booking_id, 'new_booking', null, 'woocommerce');
            }
            
            // Force update timestamp to ensure real-time detection
            global $wpdb;
            $wpdb->update(
                $wpdb->prefix . 'gtub_bookings',
                array('updated_at' => current_time('mysql')),
                array('id' => $booking_id),
                array('%s'),
                array('%d')
            );
            
            error_log('GTUB: Booking #' . $booking_id . ' ready for real-time sync');
        } else {
            error_log('GTUB: FAILED to create booking from order #' . $order_id);
        }
        
        return $booking_id;
    }
    
    /**
     * Extract booking data from WooCommerce order
     */
    public static function extract_booking_from_order($order) {
        $order_id = $order->get_id();
        
        // Get order items
        $items = $order->get_items();
        if (empty($items)) {
            return false;
        }
        
        // Determine booking type and source
        $booking_type = 'transfer';
        $source_system = 'woocommerce';
        
        // Check order meta for CHBS data
        $chbs_data = $order->get_meta('_chbs_booking_data');
        $chbs_booking_id = $order->get_meta('_chbs_booking_id');
        
        // Check order meta for JetBooking data
        $jet_booking_id = $order->get_meta('_jet_booking_id');
        $jet_apartment_id = $order->get_meta('_apartment_id');
        
        // Initialize booking data
        $booking_data = array(
            'source' => 'woocommerce',
            'source_id' => $order_id,
            'booking_number' => $order->get_order_number(),
            'customer_name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
            'customer_email' => $order->get_billing_email(),
            'customer_phone' => $order->get_billing_phone(),
            'currency' => $order->get_currency(),
            'total' => $order->get_total(),
            'status' => self::map_order_status($order->get_status()),
            'payment_status' => self::map_payment_status($order),
            'wc_order_id' => $order_id,
            'created_at' => $order->get_date_created()->date('Y-m-d H:i:s'),
        );
        
        // Extract CHBS booking data
        if ($chbs_booking_id || $chbs_data) {
            $booking_data['booking_type'] = 'transfer';
            $booking_data['chbs_order'] = true;
            
            // Try to get CHBS booking details
            if ($chbs_booking_id) {
                $chbs_details = self::get_chbs_booking_details($chbs_booking_id);
                if ($chbs_details) {
                    $booking_data = array_merge($booking_data, $chbs_details);
                    $booking_data['chbs_booking_id'] = $chbs_booking_id;
                }
            }
            
            // Fallback: Extract from order meta
            if (empty($booking_data['pickup_location'])) {
                $booking_data['pickup_location'] = $order->get_meta('_chbs_pickup_location') ?: $order->get_meta('pickup_location') ?: '';
                $booking_data['dropoff_location'] = $order->get_meta('_chbs_dropoff_location') ?: $order->get_meta('dropoff_location') ?: '';
                $booking_data['pickup_datetime'] = $order->get_meta('_chbs_pickup_date') ?: $order->get_meta('pickup_date') ?: current_time('mysql');
                $booking_data['passengers'] = $order->get_meta('_chbs_passengers') ?: $order->get_meta('passengers') ?: 1;
                $booking_data['vehicle_type'] = $order->get_meta('_chbs_vehicle') ?: $order->get_meta('vehicle_type') ?: '';
            }
        }
        
        // Extract JetBooking data
        elseif ($jet_booking_id || $jet_apartment_id) {
            $booking_data['booking_type'] = 'tour';
            $booking_data['jetbooking_order'] = true;
            
            if ($jet_booking_id) {
                $jet_details = self::get_jetbooking_details($jet_booking_id);
                if ($jet_details) {
                    $booking_data = array_merge($booking_data, $jet_details);
                    $booking_data['jetbooking_id'] = $jet_booking_id;
                }
            }
            
            // Fallback: Extract from order meta
            if (empty($booking_data['tour_name'])) {
                $booking_data['tour_id'] = $jet_apartment_id ?: 0;
                $booking_data['tour_name'] = $jet_apartment_id ? get_the_title($jet_apartment_id) : '';
                $booking_data['pickup_location'] = $booking_data['tour_name'];
                $booking_data['checkin_date'] = $order->get_meta('_checkin_date') ?: $order->get_meta('check_in_date') ?: '';
                $booking_data['checkout_date'] = $order->get_meta('_checkout_date') ?: $order->get_meta('check_out_date') ?: '';
                $booking_data['pickup_datetime'] = $booking_data['checkin_date'] ? $booking_data['checkin_date'] . ' 09:00:00' : current_time('mysql');
                $booking_data['passengers'] = $order->get_meta('_guests') ?: $order->get_meta('guests') ?: 1;
            }
        }
        
        // Generic WooCommerce order (not CHBS or JetBooking)
        else {
            // Extract what we can from order
            $booking_data['booking_type'] = 'order';
            $booking_data['pickup_datetime'] = $order->get_date_created()->date('Y-m-d H:i:s');
            $booking_data['passengers'] = 1;
            
            // Try to extract from order notes or item meta
            foreach ($items as $item) {
                $item_meta = $item->get_meta_data();
                foreach ($item_meta as $meta) {
                    $key = strtolower($meta->key);
                    if (strpos($key, 'pickup') !== false || strpos($key, 'from') !== false) {
                        $booking_data['pickup_location'] = $meta->value;
                    }
                    if (strpos($key, 'dropoff') !== false || strpos($key, 'to') !== false) {
                        $booking_data['dropoff_location'] = $meta->value;
                    }
                    if (strpos($key, 'date') !== false || strpos($key, 'time') !== false) {
                        $booking_data['pickup_datetime'] = $meta->value;
                    }
                    if (strpos($key, 'passenger') !== false || strpos($key, 'guest') !== false) {
                        $booking_data['passengers'] = intval($meta->value);
                    }
                }
            }
        }
        
        // Ensure required fields
        if (empty($booking_data['pickup_location'])) {
            $booking_data['pickup_location'] = 'Order #' . $order->get_order_number();
        }
        if (empty($booking_data['pickup_datetime'])) {
            $booking_data['pickup_datetime'] = current_time('mysql');
        }
        
        return $booking_data;
    }
    
    /**
     * Get CHBS booking details
     */
    private static function get_chbs_booking_details($chbs_booking_id) {
        global $wpdb;
        
        // Try different possible CHBS table names
        $possible_tables = array(
            $wpdb->prefix . 'chbs_booking',
            $wpdb->prefix . 'chbs_bookings',
            $wpdb->prefix . 'chbs_booking_form',
        );
        
        foreach ($possible_tables as $table) {
            if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
                $booking = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $chbs_booking_id));
                
                if ($booking) {
                    $meta = maybe_unserialize($booking->meta ?? '');
                    if (!is_array($meta)) {
                        $meta = array();
                    }
                    
                    return array(
                        'pickup_location' => $meta['route_start_location'] ?? $booking->pickup_location ?? '',
                        'dropoff_location' => $meta['route_end_location'] ?? $booking->dropoff_location ?? '',
                        'pickup_datetime' => ($booking->pickup_date ?? date('Y-m-d')) . ' ' . ($booking->pickup_time ?? '00:00:00'),
                        'passengers' => $meta['passenger_count'] ?? $booking->passengers ?? 1,
                        'vehicle_type' => $meta['vehicle_name'] ?? $booking->vehicle ?? '',
                        'trip_type' => 'one-way',
                    );
                }
            }
        }
        
        return false;
    }
    
    /**
     * Get JetBooking details
     */
    private static function get_jetbooking_details($jet_booking_id) {
        global $wpdb;
        
        $jet_table = $wpdb->prefix . 'jet_apartment_bookings';
        
        if ($wpdb->get_var("SHOW TABLES LIKE '$jet_table'") == $jet_table) {
            $booking = $wpdb->get_row($wpdb->prepare("SELECT * FROM $jet_table WHERE booking_id = %d", $jet_booking_id));
            
            if ($booking) {
                $apartment = get_post($booking->apartment_id);
                
                return array(
                    'tour_id' => $booking->apartment_id ?? 0,
                    'tour_name' => $apartment ? $apartment->post_title : '',
                    'pickup_location' => $apartment ? $apartment->post_title : '',
                    'checkin_date' => $booking->check_in_date ?? '',
                    'checkout_date' => $booking->check_out_date ?? '',
                    'pickup_datetime' => ($booking->check_in_date ?? date('Y-m-d')) . ' 09:00:00',
                    'passengers' => get_post_meta($jet_booking_id, '_apartment_booking_guests', true) ?: 1,
                );
            }
        }
        
        return false;
    }
    
    /**
     * Sync order status change
     */
    public static function sync_order_status_change($order_id, $old_status, $new_status, $order) {
        // Prevent infinite loop - check if this update came from booking system
        if (defined('GTUB_SYNCING_TO_WC') && GTUB_SYNCING_TO_WC) {
            error_log('GTUB: Skipping booking sync (already syncing to WC)');
            return;
        }
        
        // Set flag to prevent infinite loop
        if (!defined('GTUB_SYNCING_FROM_WC')) {
            define('GTUB_SYNCING_FROM_WC', true);
        }
        
        error_log('GTUB: WooCommerce order #' . $order_id . ' status changed from ' . $old_status . ' to ' . $new_status);
        
        global $wpdb;
        
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
            $order_id
        ));
        
        if ($booking) {
            $old_booking_status = $booking->status;
            $new_booking_status = self::map_order_status($new_status);
            
            error_log('GTUB: Updating booking #' . $booking->id . ' status from ' . $old_booking_status . ' to ' . $new_booking_status);
            
            GTUB_Booking::update($booking->id, array(
                'status' => $new_booking_status,
                'payment_status' => self::map_payment_status($order),
                'last_synced_at' => current_time('mysql'),
            ));
            
            // Send notification if status changed
            if ($old_booking_status !== $new_booking_status) {
                self::send_push_notifications($booking->id, 'status_changed', array(
                    'old_status' => $old_booking_status,
                    'new_status' => $new_booking_status,
                ));
            }
            
            // Trigger real-time sync
            if (class_exists('GTUB_Realtime_Sync')) {
                GTUB_Realtime_Sync::log_booking_update($booking->id, 'status_changed', $old_booking_status, $new_booking_status);
            }
            
            error_log('GTUB: Booking #' . $booking->id . ' updated successfully from WooCommerce order #' . $order_id);
        } else {
            // Booking doesn't exist yet, create it
            error_log('GTUB: Booking not found for order #' . $order_id . ', creating new booking');
            self::sync_new_order($order_id);
        }
    }
    
    /**
     * Sync order completed
     */
    public static function sync_order_completed($order_id) {
        // Just trigger status change sync
        $order = wc_get_order($order_id);
        if ($order) {
            self::sync_order_status_change($order_id, 'processing', 'completed', $order);
        }
    }
    
    /**
     * Fallback sync - runs every 5 minutes
     */
    public static function fallback_sync() {
        if (!function_exists('wc_get_orders')) {
            return;
        }
        
        // Get recent orders from last 24 hours
        $orders = wc_get_orders(array(
            'limit' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
            'date_created' => '>' . (time() - DAY_IN_SECONDS),
        ));
        
        $synced = 0;
        foreach ($orders as $order) {
            $order_id = $order->get_id();
            
            // Check if already synced
            global $wpdb;
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
                $order_id
            ));
            
            if (!$existing) {
                $result = self::sync_new_order($order_id);
                if ($result) {
                    $synced++;
                }
            }
        }
        
        if ($synced > 0) {
            error_log("GTUB WooCommerce Fallback Sync: Synced $synced missed orders");
        }
    }
    
    /**
     * Map WooCommerce order status to booking status
     */
    private static function map_order_status($wc_status) {
        // Remove 'wc-' prefix if present
        $wc_status = str_replace('wc-', '', $wc_status);
        
        $map = array(
            'pending' => 'pending',
            'processing' => 'confirmed',
            'on-hold' => 'pending',
            'completed' => 'completed',
            'cancelled' => 'cancelled',
            'refunded' => 'cancelled',
            'failed' => 'cancelled',
        );
        
        return $map[$wc_status] ?? 'pending';
    }
    
    /**
     * Map WooCommerce payment status
     */
    private static function map_payment_status($order) {
        if ($order->is_paid()) {
            return 'paid';
        }
        
        $status = $order->get_status();
        
        if (in_array($status, array('completed', 'processing'))) {
            return 'paid';
        }
        
        if (in_array($status, array('refunded'))) {
            return 'refunded';
        }
        
        if (in_array($status, array('cancelled', 'failed'))) {
            return 'cancelled';
        }
        
        return 'unpaid';
    }
    
    /**
     * Send push notifications
     */
    private static function send_push_notifications($booking_id, $event_type, $extra_data = array()) {
        $booking = GTUB_Booking::get($booking_id);
        
        if (!$booking) {
            return;
        }
        
        // Prepare notification message
        $message = '';
        switch ($event_type) {
            case 'new_booking':
                $type_emoji = ($booking->booking_type === 'tour') ? '🎫' : '🚗';
                $type_name = ($booking->booking_type === 'tour') ? 'Tour' : 'Transfer';
                
                $message = "$type_emoji New WooCommerce $type_name Booking!\n\n";
                $message .= "📋 Booking: {$booking->booking_number}\n";
                $message .= "👤 Customer: {$booking->customer_name}\n";
                $message .= "📧 Email: {$booking->customer_email}\n";
                $message .= "📍 From: {$booking->pickup_location}\n";
                if ($booking->dropoff_location) {
                    $message .= "📍 To: {$booking->dropoff_location}\n";
                }
                $message .= "📅 Date: " . date('M d, Y @ H:i', strtotime($booking->pickup_datetime)) . "\n";
                $message .= "👥 Passengers: {$booking->passengers}\n";
                $message .= "💰 Total: {$booking->currency} " . number_format($booking->total, 2);
                break;
                
            case 'status_changed':
                $message = "🔄 Booking Status Changed!\n\n";
                $message .= "📋 Booking: {$booking->booking_number}\n";
                $message .= "👤 Customer: {$booking->customer_name}\n";
                $message .= "📊 Status: {$extra_data['old_status']} → {$extra_data['new_status']}";
                break;
        }
        
        // Send Telegram notification
        if (class_exists('GTUB_Notification')) {
            GTUB_Notification::send_telegram($message);
        }
        
        // Send WhatsApp notification
        if (class_exists('GTUB_Notification')) {
            GTUB_Notification::send_whatsapp($message);
        }
        
        // Send email notification to admin
        $admin_email = get_option('admin_email');
        $subject = ($event_type === 'new_booking') ? 'New WooCommerce Booking Received' : 'Booking Status Changed';
        wp_mail($admin_email, $subject, $message);
    }
    
    /**
     * Handle order status transition
     */
    public static function sync_order_status_transition($order_id) {
        error_log('GTUB: Order #' . $order_id . ' status transitioned');
        
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }
        
        // Find booking
        global $wpdb;
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
            $order_id
        ));
        
        if ($booking) {
            // Update existing booking
            GTUB_Booking::update($booking->id, array(
                'status' => self::map_order_status($order->get_status()),
                'payment_status' => self::map_payment_status($order),
            ));
            error_log('GTUB: Updated booking #' . $booking->id . ' from order #' . $order_id);
        } else {
            // Create new booking
            self::sync_new_order($order_id);
        }
    }
    
    /**
     * Handle order update
     */
    public static function sync_order_update($order_id) {
        error_log('GTUB: Order #' . $order_id . ' updated');
        self::sync_order_status_transition($order_id);
    }
    
    /**
     * Handle order save
     */
    public static function sync_order_save($post_id, $post, $update) {
        if ($post->post_type !== 'shop_order') {
            return;
        }
        
        error_log('GTUB: Order post #' . $post_id . ' saved');
        self::sync_order_status_transition($post_id);
    }
    
    /**
     * Manual sync all WooCommerce orders
     */
    public static function sync_all() {
        if (!function_exists('wc_get_orders')) {
            return array('error' => 'WooCommerce not active');
        }
        
        // Get all orders
        $orders = wc_get_orders(array(
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $synced = 0;
        $errors = 0;
        
        foreach ($orders as $order) {
            $result = self::sync_new_order($order->get_id());
            if ($result) {
                $synced++;
            } else {
                $errors++;
            }
        }
        
        return array(
            'synced' => $synced,
            'errors' => $errors,
            'total' => count($orders),
        );
    }
}

