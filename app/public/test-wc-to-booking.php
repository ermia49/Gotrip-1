<?php
/**
 * Test WooCommerce → Booking Sync
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

global $wpdb;

// Get a WooCommerce order that has a booking
$test_data = $wpdb->get_row("
    SELECT b.*, b.id as booking_id, b.source_id as order_id
    FROM {$wpdb->prefix}gtub_bookings b
    WHERE b.source = 'woocommerce' AND b.source_id IS NOT NULL
    ORDER BY b.id DESC
    LIMIT 1
");

// Test action
if (isset($_GET['test']) && $test_data) {
    $order_id = $test_data->order_id;
    $booking_id = $test_data->booking_id;
    
    $order = wc_get_order($order_id);
    if ($order) {
        $old_status = $order->get_status();
        
        // Change to a different status
        $new_status = ($old_status === 'pending') ? 'processing' : 'pending';
        
        echo "<h2>Testing WooCommerce → Booking Sync</h2>";
        echo "<p>Changing WooCommerce Order #$order_id status...</p>";
        echo "<p>Old Status: <strong>$old_status</strong></p>";
        echo "<p>New Status: <strong>$new_status</strong></p>";
        
        // Change the status
        $order->update_status($new_status, 'Test sync from test script');
        
        // Wait a moment
        sleep(1);
        
        // Check if booking was updated
        $updated_booking = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE id = $booking_id");
        
        echo "<p>Booking #$booking_id Status: <strong>{$updated_booking->status}</strong></p>";
        echo "<p>Booking updated_at: <strong>{$updated_booking->updated_at}</strong></p>";
        
        // Check logs
        $log_file = WP_CONTENT_DIR . '/debug.log';
        if (file_exists($log_file)) {
            $logs = file($log_file);
            $recent_logs = array_slice($logs, -20);
            $relevant_logs = array_filter($recent_logs, function($line) use ($order_id, $booking_id) {
                return (strpos($line, "order #$order_id") !== false || strpos($line, "booking #$booking_id") !== false);
            });
            
            if (!empty($relevant_logs)) {
                echo "<h3>Recent Logs:</h3>";
                echo "<pre style='background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;'>";
                echo htmlspecialchars(implode('', $relevant_logs));
                echo "</pre>";
            }
        }
        
        echo "<p><a href='?' style='padding: 10px 20px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px;'>Back</a></p>";
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test WC → Booking Sync</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 40px; max-width: 1200px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        .box { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .btn { display: inline-block; padding: 15px 30px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 10px 5px; font-size: 16px; }
        .btn:hover { background: #3d7f5f; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .success { color: #28a745; }
        .info { color: #2196F3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test WooCommerce → Booking Sync</h1>
        
        <?php if ($test_data): ?>
            <div class="box">
                <h2>Test Data:</h2>
                <table>
                    <tr>
                        <th>WooCommerce Order</th>
                        <td>
                            <a href="/wp-admin/post.php?post=<?php echo $test_data->order_id; ?>&action=edit" target="_blank">
                                Order #<?php echo $test_data->order_id; ?>
                            </a>
                            <?php
                            $order = wc_get_order($test_data->order_id);
                            if ($order) {
                                echo '<br>Current Status: <strong>' . $order->get_status() . '</strong>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Linked Booking</th>
                        <td>
                            Booking #<?php echo $test_data->booking_id; ?> (<?php echo $test_data->booking_number; ?>)<br>
                            Current Status: <strong><?php echo $test_data->status; ?></strong><br>
                            Last Updated: <?php echo $test_data->updated_at; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="box">
                <h2>🎯 Test Instructions:</h2>
                <ol>
                    <li><strong>Option 1 - Automatic Test:</strong>
                        <p>Click the button below to automatically change the order status and see if the booking updates:</p>
                        <a href="?test=1" class="btn">🚀 Run Automatic Test</a>
                    </li>
                    <li><strong>Option 2 - Manual Test:</strong>
                        <p>Open these in separate tabs:</p>
                        <a href="/wp-admin/post.php?post=<?php echo $test_data->order_id; ?>&action=edit" target="_blank" class="btn">Open WooCommerce Order</a>
                        <a href="/wp-admin/admin.php?page=gtub-bookings" target="_blank" class="btn">Open Admin Bookings (Press Cmd+Option+I)</a>
                        <p>Then:</p>
                        <ul>
                            <li>Change order status in WooCommerce</li>
                            <li>Watch Admin Bookings console for updates within 5 seconds</li>
                            <li>Check debug.log for sync messages</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
            <div class="box">
                <h2>✅ Expected Result:</h2>
                <ol>
                    <li>Change WooCommerce order status</li>
                    <li>debug.log shows:
                        <pre style="background: #f4f4f4; padding: 10px; border-radius: 4px;">GTUB: WooCommerce order #<?php echo $test_data->order_id; ?> status changed from X to Y
GTUB: Updating booking #<?php echo $test_data->booking_id; ?> status from A to B
GTUB: Booking #<?php echo $test_data->booking_id; ?> updated successfully</pre>
                    </li>
                    <li>Booking status updates in database</li>
                    <li>Real-time sync detects change (5 seconds)</li>
                    <li>Admin/Staff Portal shows update</li>
                </ol>
            </div>
            
        <?php else: ?>
            <div class="box">
                <h2>⚠️ No Test Data Found</h2>
                <p>No WooCommerce orders with linked bookings found.</p>
                <p>Please create a WooCommerce order first:</p>
                <a href="/wp-admin/post-new.php?post_type=shop_order" class="btn">Create WooCommerce Order</a>
            </div>
        <?php endif; ?>
        
        <div class="box">
            <h2>🔍 Check Logs:</h2>
            <?php
            $log_file = WP_CONTENT_DIR . '/debug.log';
            if (file_exists($log_file)) {
                $logs = file($log_file);
                $recent_logs = array_slice($logs, -30);
                $gtub_logs = array_filter($recent_logs, function($line) {
                    return strpos($line, 'GTUB') !== false;
                });
                
                if (!empty($gtub_logs)) {
                    echo "<p class='success'>✅ Found recent GTUB logs:</p>";
                    echo "<pre style='background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;'>";
                    echo htmlspecialchars(implode('', array_slice($gtub_logs, -15)));
                    echo "</pre>";
                } else {
                    echo "<p class='info'>No recent GTUB logs found in last 30 lines</p>";
                }
            } else {
                echo "<p>debug.log not found at: $log_file</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

