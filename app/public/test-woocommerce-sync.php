<?php
/**
 * Test WooCommerce Sync
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

// Force sync all recent orders
if (isset($_GET['force_sync'])) {
    require_once(WP_PLUGIN_DIR . '/gotrip-unified-booking/includes/integrations/class-woocommerce-booking-sync.php');
    
    echo "<h2>Force Syncing Recent Orders...</h2>";
    
    $orders = wc_get_orders(array(
        'limit' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
    ));
    
    foreach ($orders as $order) {
        // Skip refunds
        if ($order->get_type() === 'shop_order_refund') {
            continue;
        }
        
        $order_id = $order->get_id();
        echo "Order #" . $order->get_order_number() . " - ";
        
        // Check if already synced
        global $wpdb;
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
            $order_id
        ));
        
        if ($existing) {
            echo "Already synced (Booking ID: " . $existing->id . ")<br>";
            
            // Force update
            GTUB_WooCommerce_Booking_Sync::sync_order_status_change($order_id, '', $order->get_status(), $order);
            echo "→ Updated status<br>";
        } else {
            try {
                $result = GTUB_WooCommerce_Booking_Sync::sync_new_order($order_id);
                if ($result) {
                    echo "✅ Synced! New booking ID: " . $result . "<br>";
                } else {
                    echo "❌ Failed to sync - Result: " . var_export($result, true) . "<br>";
                    
                    // Try to extract booking data to see what's wrong
                    $booking_data = GTUB_WooCommerce_Booking_Sync::extract_booking_from_order($order);
                    if ($booking_data === false) {
                        echo "→ Reason: Not a booking order (no booking data found)<br>";
                    } else {
                        echo "→ Booking data extracted but create failed<br>";
                        echo "<pre style='font-size: 11px;'>" . print_r($booking_data, true) . "</pre>";
                    }
                }
            } catch (Exception $e) {
                echo "❌ Exception: " . $e->getMessage() . "<br>";
            }
        }
    }
    
    echo "<hr><a href='?'>Back</a>";
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test WooCommerce Sync</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 20px; max-width: 1200px; margin: 0 auto; }
        .section { background: #f5f5f5; padding: 20px; margin: 20px 0; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .btn { display: inline-block; padding: 10px 20px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #3d7f5f; }
    </style>
</head>
<body>
    <h1>🔧 WooCommerce Sync Test</h1>
    
    <div class="section">
        <h2>1. Check WooCommerce Integration Status</h2>
        <?php
        // Check if WooCommerce is active
        if (class_exists('WooCommerce')) {
            echo "<p class='success'>✅ WooCommerce is active</p>";
        } else {
            echo "<p class='error'>❌ WooCommerce is NOT active</p>";
        }
        
        // Check if sync class exists
        if (class_exists('GTUB_WooCommerce_Booking_Sync')) {
            echo "<p class='success'>✅ GTUB_WooCommerce_Booking_Sync class exists</p>";
        } else {
            echo "<p class='error'>❌ GTUB_WooCommerce_Booking_Sync class NOT found</p>";
        }
        
        // Check hooks
        global $wp_filter;
        $hooks = array(
            'woocommerce_new_order',
            'woocommerce_order_status_changed',
            'woocommerce_order_status_completed'
        );
        
        foreach ($hooks as $hook) {
            echo "Hook '$hook': ";
            if (isset($wp_filter[$hook])) {
                echo "<span class='success'>✅ Registered</span><br>";
            } else {
                echo "<span class='error'>❌ NOT registered</span><br>";
            }
        }
        ?>
    </div>
    
    <div class="section">
        <h2>2. Recent WooCommerce Orders</h2>
        <?php
        if (!function_exists('wc_get_orders')) {
            echo "<p class='error'>WooCommerce not available</p>";
        } else {
            $orders = wc_get_orders(array(
                'limit' => 10,
                'orderby' => 'date',
                'order' => 'DESC',
            ));
            
            if (empty($orders)) {
                echo "<p>No orders found</p>";
            } else {
                ?>
                <table>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Synced?</th>
                        <th>Booking ID</th>
                    </tr>
                    <?php
                    global $wpdb;
                    foreach ($orders as $order) {
                        $order_id = $order->get_id();
                        
                        // Check if synced
                        $booking = $wpdb->get_row($wpdb->prepare(
                            "SELECT id, booking_number, status, updated_at FROM {$wpdb->prefix}gtub_bookings WHERE source = 'woocommerce' AND source_id = %d",
                            $order_id
                        ));
                        ?>
                        <tr>
                            <td>#<?php echo $order->get_order_number(); ?></td>
                            <td><?php echo $order->get_date_created()->format('Y-m-d H:i'); ?></td>
                            <td><?php echo $order->get_status(); ?></td>
                            <td><?php echo $order->get_formatted_order_total(); ?></td>
                            <td>
                                <?php if ($booking): ?>
                                    <span class="success">✅ Yes</span>
                                <?php else: ?>
                                    <span class="error">❌ No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($booking): ?>
                                    <?php echo $booking->id; ?> (#<?php echo $booking->booking_number; ?>)<br>
                                    <small>Updated: <?php echo $booking->updated_at; ?></small>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
        }
        ?>
    </div>
    
    <div class="section">
        <h2>3. Test Create Order → Booking</h2>
        <p>Create a test WooCommerce order and see if it syncs:</p>
        <a href="/wp-admin/post-new.php?post_type=shop_order" class="btn" target="_blank">Create Test Order</a>
        <a href="?force_sync=1" class="btn">Force Sync All Orders</a>
    </div>
    
    <div class="section">
        <h2>4. Check Recent Bookings</h2>
        <?php
        global $wpdb;
        $recent_bookings = $wpdb->get_results("
            SELECT * FROM {$wpdb->prefix}gtub_bookings 
            WHERE source = 'woocommerce' 
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        
        if ($recent_bookings) {
            ?>
            <table>
                <tr>
                    <th>Booking #</th>
                    <th>WC Order ID</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                </tr>
                <?php foreach ($recent_bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking->booking_number; ?></td>
                    <td><?php echo $booking->source_id; ?></td>
                    <td><?php echo $booking->status; ?></td>
                    <td><?php echo $booking->created_at; ?></td>
                    <td><?php echo $booking->updated_at; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php
        } else {
            echo "<p>No WooCommerce bookings found</p>";
        }
        ?>
    </div>
    
    <div class="section">
        <h2>5. Instructions</h2>
        <ol>
            <li>Check if recent WooCommerce orders are synced (should have ✅)</li>
            <li>If not synced, click "Force Sync All Orders"</li>
            <li>Create a new WooCommerce order</li>
            <li>Check if it appears in bookings within 5 seconds</li>
            <li>Change order status and see if booking updates</li>
        </ol>
    </div>
</body>
</html>
