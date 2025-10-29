<?php
/**
 * Booking CRUD Operations
 */

if (!defined('ABSPATH')) {
    exit;
}

class GTUB_Booking {
    
    /**
     * Get all bookings with filters
     */
    public static function get_all($args = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        $defaults = array(
            'source' => '',
            'status' => '',
            'payment_status' => '',
            'search' => '',
            'date_from' => '',
            'date_to' => '',
            'limit' => 50,
            'offset' => 0,
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $where = array('1=1');
        
        if (!empty($args['source'])) {
            $where[] = $wpdb->prepare('source = %s', $args['source']);
        }
        
        if (!empty($args['status'])) {
            $where[] = $wpdb->prepare('status = %s', $args['status']);
        }
        
        if (!empty($args['payment_status'])) {
            $where[] = $wpdb->prepare('payment_status = %s', $args['payment_status']);
        }
        
        if (!empty($args['search'])) {
            $search = '%' . $wpdb->esc_like($args['search']) . '%';
            $where[] = $wpdb->prepare(
                '(booking_number LIKE %s OR customer_name LIKE %s OR customer_email LIKE %s)',
                $search, $search, $search
            );
        }
        
        if (!empty($args['date_from'])) {
            $where[] = $wpdb->prepare('DATE(pickup_datetime) >= %s', $args['date_from']);
        }
        
        if (!empty($args['date_to'])) {
            $where[] = $wpdb->prepare('DATE(pickup_datetime) <= %s', $args['date_to']);
        }
        
        $where_sql = implode(' AND ', $where);
        
        $sql = "SELECT * FROM $table WHERE $where_sql ORDER BY pickup_datetime DESC LIMIT %d OFFSET %d";
        
        return $wpdb->get_results($wpdb->prepare($sql, $args['limit'], $args['offset']));
    }
    
    /**
     * Get booking by ID
     */
    public static function get($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    }
    
    /**
     * Get booking by source and source ID
     */
    public static function get_by_source($source, $source_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE source = %s AND source_id = %d",
            $source,
            $source_id
        ));
    }
    
    /**
     * Create new booking
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        // Generate booking number if not provided
        if (empty($data['booking_number'])) {
            $data['booking_number'] = self::generate_booking_number();
        }
        
        // Set defaults
        $defaults = array(
            'source' => 'manual',
            'booking_type' => 'transfer',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'currency' => 'EUR',
            'created_at' => current_time('mysql'),
        );
        
        $data = wp_parse_args($data, $defaults);
        
        $inserted = $wpdb->insert($table, $data);
        
        if ($inserted) {
            $booking_id = $wpdb->insert_id;
            
            // Log creation
            GTUB_Audit_Log::log($booking_id, 'booking_created', 'Booking created', null, json_encode($data));
            
            // Trigger unified sync
            do_action('gtub_booking_created', $booking_id, $data['source'] ?? 'manual');
            
            return $booking_id;
        }
        
        // Log the error
        error_log('GTUB Booking::create() FAILED - Error: ' . $wpdb->last_error);
        error_log('GTUB Booking::create() - Data: ' . json_encode($data));
        
        return false;
    }
    
    /**
     * Update booking
     */
    public static function update($id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        $old_booking = self::get($id);
        
        // Always update the updated_at timestamp
        $data['updated_at'] = current_time('mysql');
        
        $updated = $wpdb->update(
            $table,
            $data,
            array('id' => $id)
        );
        
        if ($updated !== false) {
            // Log update
            GTUB_Audit_Log::log($id, 'booking_updated', 'Booking updated', json_encode($old_booking), json_encode($data));
            
            // Trigger unified sync
            do_action('gtub_booking_updated', $id, (array)$old_booking, $data);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Delete booking
     */
    public static function delete($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        $booking = self::get($id);
        
        $deleted = $wpdb->delete($table, array('id' => $id), array('%d'));
        
        if ($deleted) {
            // Log deletion
            GTUB_Audit_Log::log($id, 'booking_deleted', 'Booking deleted', json_encode($booking), null);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Generate unique booking number
     */
    private static function generate_booking_number() {
        $prefix = 'GT';
        $date = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $random;
    }
    
    /**
     * Get booking count by status
     */
    public static function count_by_status($status) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE status = %s", $status));
    }
    
    /**
     * Get total revenue
     */
    public static function get_total_revenue($filters = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        $where = array("payment_status = 'paid'");
        
        if (!empty($filters['date_from'])) {
            $where[] = $wpdb->prepare('DATE(pickup_datetime) >= %s', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $where[] = $wpdb->prepare('DATE(pickup_datetime) <= %s', $filters['date_to']);
        }
        
        $where_sql = implode(' AND ', $where);
        
        return $wpdb->get_var("SELECT SUM(total) FROM $table WHERE $where_sql") ?: 0;
    }
}
