<?php
/**
 * Diagnose WooCommerce Sync Issue
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

global $wpdb;

// Test specific booking
$booking_id = $_GET['booking_id'] ?? null;
if ($booking_id) {
    $booking = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE id = %d",
        $booking_id
    ));
    
    if ($booking) {
        echo "<h1>Diagnosing Booking #$booking_id</h1>";
        
        echo "<h2>Booking Details:</h2>";
        echo "<pre>";
        print_r($booking);
        echo "</pre>";
        
        // Check if it has a WooCommerce order
        if ($booking->source === 'woocommerce' && $booking->source_id) {
            echo "<h2>Linked WooCommerce Order:</h2>";
            $order = wc_get_order($booking->source_id);
            
            if ($order) {
                echo "Order ID: " . $order->get_id() . "<br>";
                echo "Order Number: " . $order->get_order_number() . "<br>";
                echo "Order Status: <strong>" . $order->get_status() . "</strong><br>";
                echo "Order Date: " . $order->get_date_created()->format('Y-m-d H:i:s') . "<br>";
                echo "Order Total: " . $order->get_total() . " " . $order->get_currency() . "<br>";
                echo "Is Paid: " . ($order->is_paid() ? 'Yes' : 'No') . "<br>";
                
                // Check meta
                echo "<h3>Order Meta:</h3>";
                echo "_gtub_booking_id: " . $order->get_meta('_gtub_booking_id') . "<br>";
                echo "_gtub_last_sync: " . $order->get_meta('_gtub_last_sync') . "<br>";
                echo "_gtub_booking_status: " . $order->get_meta('_gtub_booking_status') . "<br>";
            } else {
                echo "<p style='color: red;'>❌ WooCommerce order #" . $booking->source_id . " not found!</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠️ This booking is not from WooCommerce</p>";
            echo "Source: " . $booking->source . "<br>";
            echo "Source ID: " . $booking->source_id . "<br>";
        }
        
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Diagnose WC Sync</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 40px; max-width: 1400px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; }
        .box { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ff9800; }
        .btn { display: inline-block; padding: 8px 16px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; font-size: 12px; }
        .btn:hover { background: #3d7f5f; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; overflow-x: auto; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnose WooCommerce Sync</h1>
        
        <div class="box">
            <h2>All Bookings with WooCommerce Link:</h2>
            <?php
            $bookings = $wpdb->get_results("
                SELECT b.*, 
                       b.id as booking_id,
                       b.source_id as order_id
                FROM {$wpdb->prefix}gtub_bookings b
                WHERE b.source = 'woocommerce' AND b.source_id IS NOT NULL
                ORDER BY b.updated_at DESC
                LIMIT 20
            ");
            
            if ($bookings) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Booking ID</th>";
                echo "<th>Booking #</th>";
                echo "<th>Booking Status</th>";
                echo "<th>WC Order</th>";
                echo "<th>WC Status</th>";
                echo "<th>Synced?</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                
                foreach ($bookings as $booking) {
                    $order = wc_get_order($booking->order_id);
                    $wc_status = $order ? $order->get_status() : 'not found';
                    
                    // Check if statuses match mapping
                    $expected_booking_status = isset($map_wc_to_booking[$wc_status]) ? $map_wc_to_booking[$wc_status] : 'unknown';
                    $matches = ($booking->status === $expected_booking_status);
                    
                    echo "<tr>";
                    echo "<td>{$booking->booking_id}</td>";
                    echo "<td><strong>{$booking->booking_number}</strong></td>";
                    echo "<td><code>{$booking->status}</code></td>";
                    echo "<td><a href='/wp-admin/post.php?post={$booking->order_id}&action=edit' target='_blank'>#{$booking->order_id}</a></td>";
                    echo "<td><code>$wc_status</code></td>";
                    echo "<td>" . ($matches ? "<span class='success'>✅</span>" : "<span class='error'>❌ Should be: $expected_booking_status</span>") . "</td>";
                    echo "<td><a href='?booking_id={$booking->booking_id}' class='btn'>Diagnose</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='warning'>⚠️ No WooCommerce bookings found</p>";
                echo "<p>Create a WooCommerce order or run sync: <a href='/test-woocommerce-sync.php?force_sync=1'>Force Sync</a></p>";
            }
            ?>
        </div>
        
        <div class="box">
            <h2>🔧 WooCommerce Integration Check:</h2>
            <?php
            // Check if WooCommerce is active
            if (class_exists('WooCommerce')) {
                echo "<p class='success'>✅ WooCommerce is active (v" . WC()->version . ")</p>";
            } else {
                echo "<p class='error'>❌ WooCommerce is NOT active</p>";
            }
            
            // Check if hooks are registered
            global $wp_filter;
            $hooks_to_check = array(
                'woocommerce_new_order',
                'woocommerce_checkout_order_processed',
                'woocommerce_order_status_changed',
                'woocommerce_order_status_processing',
                'woocommerce_order_status_completed',
            );
            
            echo "<h3>Registered Hooks:</h3>";
            foreach ($hooks_to_check as $hook) {
                echo "$hook: ";
                if (isset($wp_filter[$hook])) {
                    echo "<span class='success'>✅ Registered</span>";
                    
                    // Check if our class is hooked
                    $our_hook_found = false;
                    foreach ($wp_filter[$hook]->callbacks as $priority => $callbacks) {
                        foreach ($callbacks as $callback) {
                            if (is_array($callback['function'])) {
                                $class_name = is_string($callback['function'][0]) ? $callback['function'][0] : get_class($callback['function'][0]);
                                if (strpos($class_name, 'GTUB_WooCommerce') !== false) {
                                    echo " (priority: $priority)";
                                    $our_hook_found = true;
                                }
                            }
                        }
                    }
                    if (!$our_hook_found) {
                        echo " <span class='error'>⚠️ But GTUB handler not found!</span>";
                    }
                } else {
                    echo "<span class='error'>❌ NOT registered</span>";
                }
                echo "<br>";
            }
            ?>
        </div>
        
        <div class="box">
            <h2>📋 Recent Debug Logs:</h2>
            <?php
            $log_file = WP_CONTENT_DIR . '/debug.log';
            if (file_exists($log_file)) {
                $logs = file($log_file);
                $recent_logs = array_slice($logs, -50);
                $gtub_logs = array_filter($recent_logs, function($line) {
                    return strpos($line, 'GTUB') !== false || strpos($line, 'WooCommerce') !== false;
                });
                
                if (!empty($gtub_logs)) {
                    echo "<pre>";
                    echo htmlspecialchars(implode('', array_slice($gtub_logs, -20)));
                    echo "</pre>";
                } else {
                    echo "<p class='warning'>No recent GTUB/WooCommerce logs found</p>";
                }
            } else {
                echo "<p class='error'>debug.log not found</p>";
                echo "<p>Enable debug logging in wp-config.php:</p>";
                echo "<pre>define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);</pre>";
            }
            ?>
        </div>
    </div>
</body>
</html>
