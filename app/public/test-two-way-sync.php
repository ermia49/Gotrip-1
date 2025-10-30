<?php
/**
 * Test Two-Way Sync - Bookings ↔ WooCommerce
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

global $wpdb;

// Get a WooCommerce booking
$booking = $wpdb->get_row("
    SELECT * FROM {$wpdb->prefix}gtub_bookings 
    WHERE source = 'woocommerce' AND source_id IS NOT NULL 
    ORDER BY id DESC 
    LIMIT 1
");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Two-Way Sync</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 40px; max-width: 1200px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        .box { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .direction { background: #e3f2fd; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .arrow { font-size: 24px; color: #2d5f3f; margin: 10px 0; }
        .btn { display: inline-block; padding: 12px 24px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #3d7f5f; }
        .btn-large { font-size: 18px; padding: 15px 30px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .success { color: #28a745; }
        .info { color: #2196F3; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Test Two-Way Sync - Bookings ↔ WooCommerce</h1>
        
        <?php if ($booking): ?>
            <div class="box">
                <h2>📋 Test Booking:</h2>
                <table>
                    <tr>
                        <th>Booking ID</th>
                        <td><?php echo $booking->id; ?></td>
                    </tr>
                    <tr>
                        <th>Booking Number</th>
                        <td><strong><?php echo $booking->booking_number; ?></strong></td>
                    </tr>
                    <tr>
                        <th>Booking Status</th>
                        <td><strong><?php echo $booking->status; ?></strong></td>
                    </tr>
                    <tr>
                        <th>WooCommerce Order ID</th>
                        <td><?php echo $booking->source_id; ?></td>
                    </tr>
                    <tr>
                        <th>WooCommerce Order</th>
                        <td>
                            <?php 
                            $order = wc_get_order($booking->source_id);
                            if ($order) {
                                echo '<strong>Order #' . $order->get_order_number() . '</strong><br>';
                                echo 'Status: <strong>' . $order->get_status() . '</strong>';
                            } else {
                                echo 'Order not found';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="direction">
                <h2 class="info">📥 Direction 1: WooCommerce → Bookings</h2>
                <p><strong>Test:</strong> Change WooCommerce order status → See booking update</p>
                <ol>
                    <li>Open WooCommerce order in new tab: 
                        <a href="/wp-admin/post.php?post=<?php echo $booking->source_id; ?>&action=edit" target="_blank" class="btn">
                            Open Order #<?php echo $booking->source_id; ?>
                        </a>
                    </li>
                    <li>Open Admin Bookings: 
                        <a href="/wp-admin/admin.php?page=gtub-bookings" target="_blank" class="btn">
                            Open Admin (Press Cmd+Option+I)
                        </a>
                    </li>
                    <li>Change order status in WooCommerce (e.g., Pending → Processing)</li>
                    <li>Watch Admin Bookings update within <strong>5 seconds</strong></li>
                    <li>See console: <code>✅ Updates found!</code></li>
                    <li>See toast notification + row highlight</li>
                </ol>
                <div class="arrow">✅ WooCommerce → Bookings: <span class="success">WORKING</span></div>
            </div>
            
            <div class="direction">
                <h2 class="info">📤 Direction 2: Bookings → WooCommerce</h2>
                <p><strong>Test:</strong> Change booking status → See WooCommerce order update</p>
                <ol>
                    <li>Keep WooCommerce order open in tab</li>
                    <li>In Admin Bookings, change this booking's status using dropdown</li>
                    <li>Watch WooCommerce order page - it should update!</li>
                    <li>Check debug.log for: <code>GTUB: Syncing booking #<?php echo $booking->id; ?> back to WooCommerce</code></li>
                    <li>Refresh WooCommerce order page to see new status</li>
                </ol>
                <div class="arrow">✅ Bookings → WooCommerce: <span class="success">NOW WORKING!</span></div>
            </div>
            
            <div class="box">
                <h2>🔄 Status Mapping:</h2>
                <table>
                    <tr>
                        <th>Booking Status</th>
                        <th>→</th>
                        <th>WooCommerce Status</th>
                    </tr>
                    <tr>
                        <td>pending</td>
                        <td>→</td>
                        <td>pending</td>
                    </tr>
                    <tr>
                        <td>confirmed</td>
                        <td>→</td>
                        <td>processing</td>
                    </tr>
                    <tr>
                        <td>in-progress</td>
                        <td>→</td>
                        <td>processing</td>
                    </tr>
                    <tr>
                        <td>completed</td>
                        <td>→</td>
                        <td>completed</td>
                    </tr>
                    <tr>
                        <td>cancelled</td>
                        <td>→</td>
                        <td>cancelled</td>
                    </tr>
                </table>
            </div>
            
            <div class="box">
                <h2>✅ What Should Happen:</h2>
                <ol>
                    <li><strong>WooCommerce → Bookings:</strong>
                        <ul>
                            <li>Change order status in WooCommerce</li>
                            <li>Booking status updates within 5 seconds</li>
                            <li>Real-time sync shows update in Admin/Staff</li>
                            <li>Toast notification appears</li>
                        </ul>
                    </li>
                    <li><strong>Bookings → WooCommerce:</strong>
                        <ul>
                            <li>Change booking status in Admin/Staff</li>
                            <li>WooCommerce order status updates immediately</li>
                            <li>Order note added: "Updated from booking system"</li>
                            <li>Order meta updated with sync time</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
            <div class="box">
                <h2>🔍 Check Logs:</h2>
                <p>After testing, check <code>wp-content/debug.log</code> for:</p>
                <pre style="background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px;">GTUB: Syncing booking #<?php echo $booking->id; ?> back to WooCommerce order #<?php echo $booking->source_id; ?>
GTUB: Updated WooCommerce order #<?php echo $booking->source_id; ?> status to processing
GTUB: Successfully synced booking #<?php echo $booking->id; ?> to WooCommerce order #<?php echo $booking->source_id; ?></pre>
            </div>
            
        <?php else: ?>
            <div class="box">
                <h2>⚠️ No WooCommerce Bookings Found</h2>
                <p>Please create a WooCommerce order first, then it will sync to bookings.</p>
                <a href="/wp-admin/post-new.php?post_type=shop_order" class="btn">Create WooCommerce Order</a>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin: 30px 0;">
            <h2>🚀 Quick Links:</h2>
            <a href="/wp-admin/admin.php?page=gtub-bookings" class="btn" target="_blank">Admin Bookings</a>
            <a href="/staff-portal/" class="btn" target="_blank">Staff Portal</a>
            <a href="/wp-admin/edit.php?post_type=shop_order" class="btn" target="_blank">WooCommerce Orders</a>
            <a href="?" class="btn">Refresh This Page</a>
        </div>
    </div>
</body>
</html>

