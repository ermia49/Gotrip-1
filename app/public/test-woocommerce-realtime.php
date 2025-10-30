<?php
/**
 * Test WooCommerce Real-Time Sync
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test WooCommerce Real-Time Sync</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 40px; max-width: 1200px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        .box { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .btn { display: inline-block; padding: 12px 24px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #3d7f5f; }
        .btn-large { font-size: 18px; padding: 15px 30px; }
        .step { background: #e3f2fd; padding: 15px; margin: 10px 0; border-radius: 4px; border-left: 4px solid #2196F3; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .success { color: #28a745; }
        .warning { color: #ff9800; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Test WooCommerce Real-Time Sync</h1>
        
        <div class="box">
            <h2>📋 Step-by-Step Test:</h2>
            
            <div class="step">
                <strong>Step 1: Open 3 Tabs</strong>
                <ul>
                    <li><a href="/wp-admin/admin.php?page=gtub-bookings" target="_blank">Tab 1: Admin Bookings</a> (Press Cmd+Option+I for console)</li>
                    <li><a href="/staff-portal/" target="_blank">Tab 2: Staff Portal</a> (Press Cmd+Option+I for console)</li>
                    <li><a href="/wp-admin/edit.php?post_type=shop_order" target="_blank">Tab 3: WooCommerce Orders</a></li>
                </ul>
            </div>
            
            <div class="step">
                <strong>Step 2: Verify Real-Time Sync is Running</strong>
                <p>In Tab 1 and Tab 2 consoles, you should see:</p>
                <code>✅ Real-time sync initialized</code><br>
                <code>🔍 Checking for updates, last_check: ...</code> (every 5 seconds)
            </div>
            
            <div class="step">
                <strong>Step 3: Create or Update WooCommerce Order</strong>
                <p>In Tab 3 (WooCommerce Orders):</p>
                <ul>
                    <li><strong>Option A:</strong> Create a new order manually</li>
                    <li><strong>Option B:</strong> Change status of an existing order</li>
                </ul>
            </div>
            
            <div class="step">
                <strong>Step 4: Watch Real-Time Sync (5 seconds)</strong>
                <p>In Tab 1 and Tab 2 consoles, within 5 seconds you should see:</p>
                <code>📥 Response: {success: true, data: {has_updates: true...}}</code><br>
                <code>✅ Updates found!</code><br>
                <code>🔄 1 booking updated</code>
                <p>On screen:</p>
                <ul>
                    <li>✅ Toast notification appears</li>
                    <li>✅ New booking row appears (or existing row highlights)</li>
                    <li>✅ Status badge updates</li>
                </ul>
            </div>
        </div>
        
        <div class="box">
            <h2>🔍 Check WooCommerce Integration Status:</h2>
            <?php
            // Check if WooCommerce is active
            if (class_exists('WooCommerce')) {
                echo "<p class='success'>✅ WooCommerce is active</p>";
            } else {
                echo "<p class='warning'>⚠️ WooCommerce is NOT active</p>";
            }
            
            // Check if sync class exists
            if (class_exists('GTUB_WooCommerce_Booking_Sync')) {
                echo "<p class='success'>✅ GTUB_WooCommerce_Booking_Sync is loaded</p>";
            } else {
                echo "<p class='warning'>⚠️ GTUB_WooCommerce_Booking_Sync NOT loaded</p>";
            }
            
            // Check logs
            $log_file = WP_CONTENT_DIR . '/debug.log';
            if (file_exists($log_file)) {
                $logs = file($log_file);
                $recent_logs = array_slice($logs, -50);
                $gtub_logs = array_filter($recent_logs, function($line) {
                    return strpos($line, 'GTUB') !== false;
                });
                
                if (!empty($gtub_logs)) {
                    echo "<p class='success'>✅ Found GTUB logs in debug.log (last 50 lines):</p>";
                    echo "<pre style='background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;'>";
                    echo htmlspecialchars(implode('', array_slice($gtub_logs, -10)));
                    echo "</pre>";
                } else {
                    echo "<p class='warning'>⚠️ No recent GTUB logs found</p>";
                }
            }
            ?>
        </div>
        
        <div class="box">
            <h2>✅ What Should Happen:</h2>
            <ol>
                <li>You create/update a WooCommerce order</li>
                <li>WooCommerce hook fires (check debug.log for "GTUB: Syncing WooCommerce order")</li>
                <li>Booking is created/updated in database with <code>updated_at = NOW()</code></li>
                <li>Real-time sync polling detects the change (every 5 seconds)</li>
                <li>Admin and Staff Portal update automatically</li>
                <li>Toast notification appears</li>
                <li>Row highlights</li>
            </ol>
        </div>
        
        <div class="box">
            <h2>🚨 Troubleshooting:</h2>
            
            <h3>If booking doesn't appear:</h3>
            <ul>
                <li>Check debug.log for: <code>GTUB: Syncing WooCommerce order</code></li>
                <li>Check if booking was created: <a href="/test-woocommerce-sync.php" target="_blank">Check WooCommerce Sync Status</a></li>
                <li>Try manual sync: <a href="/test-woocommerce-sync.php?force_sync=1" target="_blank">Force Sync All Orders</a></li>
            </ul>
            
            <h3>If real-time sync doesn't detect it:</h3>
            <ul>
                <li>Check console for "Checking for updates" messages</li>
                <li>Check if <code>updated_at</code> timestamp actually changed</li>
                <li>Try manually: <a href="/test-realtime-detection.php" target="_blank">Test Real-Time Detection</a></li>
            </ul>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <h2>🚀 Quick Access:</h2>
            <a href="/wp-admin/admin.php?page=gtub-bookings" class="btn" target="_blank">Open Admin Bookings</a>
            <a href="/staff-portal/" class="btn" target="_blank">Open Staff Portal</a>
            <a href="/wp-admin/edit.php?post_type=shop_order" class="btn" target="_blank">Open WooCommerce Orders</a>
            <a href="/test-woocommerce-sync.php" class="btn" target="_blank">Check Sync Status</a>
        </div>
    </div>
</body>
</html>

