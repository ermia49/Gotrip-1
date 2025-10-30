<?php
/**
 * Check WooCommerce Statuses vs Booking Statuses
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Check WooCommerce Statuses</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 40px; max-width: 1200px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; }
        .box { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .status { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block; }
        .error { color: #dc3545; }
        .success { color: #28a745; }
        .warning { color: #ff9800; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Check WooCommerce vs Booking Statuses</h1>
        
        <div class="box">
            <h2>1. WooCommerce Order Statuses</h2>
            <?php
            if (function_exists('wc_get_order_statuses')) {
                $wc_statuses = wc_get_order_statuses();
                echo "<table>";
                echo "<tr><th>Status Key</th><th>Status Label</th></tr>";
                foreach ($wc_statuses as $key => $label) {
                    // Remove 'wc-' prefix
                    $clean_key = str_replace('wc-', '', $key);
                    echo "<tr><td><code>$clean_key</code></td><td>$label</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>❌ WooCommerce not active</p>";
            }
            ?>
        </div>
        
        <div class="box">
            <h2>2. Booking System Statuses</h2>
            <?php
            global $wpdb;
            $booking_statuses = $wpdb->get_col("SELECT DISTINCT status FROM {$wpdb->prefix}gtub_bookings");
            
            if ($booking_statuses) {
                echo "<table>";
                echo "<tr><th>Status</th><th>Count</th></tr>";
                foreach ($booking_statuses as $status) {
                    $count = $wpdb->get_var($wpdb->prepare(
                        "SELECT COUNT(*) FROM {$wpdb->prefix}gtub_bookings WHERE status = %s",
                        $status
                    ));
                    echo "<tr><td><code>$status</code></td><td>$count</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No bookings found</p>";
            }
            ?>
        </div>
        
        <div class="box">
            <h2>3. Current Status Mapping</h2>
            <p>Current mapping in the code:</p>
            <table>
                <tr><th>WooCommerce → Booking</th><th>Booking → WooCommerce</th></tr>
                <tr>
                    <td>
                        <pre><?php
$map_wc_to_booking = array(
    'pending' => 'pending',
    'processing' => 'confirmed',
    'on-hold' => 'pending',
    'completed' => 'completed',
    'cancelled' => 'cancelled',
    'refunded' => 'refunded',
    'failed' => 'cancelled',
);
print_r($map_wc_to_booking);
                        ?></pre>
                    </td>
                    <td>
                        <pre><?php
$map_booking_to_wc = array(
    'pending' => 'pending',
    'confirmed' => 'processing',
    'in-progress' => 'processing',
    'completed' => 'completed',
    'cancelled' => 'cancelled',
    'refunded' => 'refunded',
);
print_r($map_booking_to_wc);
                        ?></pre>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="box">
            <h2>4. Test Mapping</h2>
            <p>Let's test the actual mapping with real orders:</p>
            <?php
            $test_orders = wc_get_orders(array('limit' => 5));
            if ($test_orders) {
                echo "<table>";
                echo "<tr><th>Order #</th><th>WC Status</th><th>→</th><th>Should Map To</th><th>Actual Booking Status</th><th>Match?</th></tr>";
                
                foreach ($test_orders as $order) {
                    $order_id = $order->get_id();
                    $wc_status = $order->get_status();
                    
                    // What it should map to
                    $should_be = isset($map_wc_to_booking[$wc_status]) ? $map_wc_to_booking[$wc_status] : 'unknown';
                    
                    // What it actually is
                    $booking = $wpdb->get_row($wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
                        $order_id
                    ));
                    
                    $actual_status = $booking ? $booking->status : 'not synced';
                    $match = ($actual_status === $should_be);
                    
                    echo "<tr>";
                    echo "<td>#" . $order->get_order_number() . "</td>";
                    echo "<td><code>$wc_status</code></td>";
                    echo "<td>→</td>";
                    echo "<td><code>$should_be</code></td>";
                    echo "<td><code>$actual_status</code></td>";
                    echo "<td>" . ($match ? "<span class='success'>✅</span>" : "<span class='error'>❌</span>") . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
        
        <div class="box">
            <h2>5. Fix Needed?</h2>
            <?php
            // Check if there are unmapped statuses
            $wc_keys = array_keys($wc_statuses ?? array());
            $clean_keys = array_map(function($key) {
                return str_replace('wc-', '', $key);
            }, $wc_keys);
            
            $unmapped = array_diff($clean_keys, array_keys($map_wc_to_booking));
            
            if (!empty($unmapped)) {
                echo "<p class='warning'>⚠️ Found WooCommerce statuses not in mapping:</p>";
                echo "<ul>";
                foreach ($unmapped as $status) {
                    echo "<li><code>$status</code></li>";
                }
                echo "</ul>";
                echo "<p>These need to be added to the mapping!</p>";
            } else {
                echo "<p class='success'>✅ All WooCommerce statuses are mapped!</p>";
            }
            ?>
        </div>
        
        <div class="box">
            <h2>6. Recommended Mapping:</h2>
            <p>Based on actual WooCommerce statuses, here's the complete mapping:</p>
            <pre><?php
// WooCommerce → Booking
$recommended_wc_to_booking = array(
    'pending'    => 'pending',      // Payment pending
    'processing' => 'confirmed',    // Payment received, processing
    'on-hold'    => 'pending',      // On hold
    'completed'  => 'completed',    // Completed
    'cancelled'  => 'cancelled',    // Cancelled
    'refunded'   => 'refunded',     // Refunded
    'failed'     => 'cancelled',    // Failed
);

// Booking → WooCommerce  
$recommended_booking_to_wc = array(
    'pending'     => 'pending',     // Waiting
    'confirmed'   => 'processing',  // Confirmed
    'in-progress' => 'processing',  // In progress
    'completed'   => 'completed',   // Done
    'cancelled'   => 'cancelled',   // Cancelled
    'refunded'    => 'refunded',    // Refunded
);

print_r(array(
    'WC_to_Booking' => $recommended_wc_to_booking,
    'Booking_to_WC' => $recommended_booking_to_wc
));
            ?></pre>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="/test-wc-to-booking.php" style="padding: 12px 24px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px;">
                Test WC → Booking Sync
            </a>
            <a href="/test-two-way-sync.php" style="padding: 12px 24px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px;">
                Test Two-Way Sync
            </a>
        </div>
    </div>
</body>
</html>

