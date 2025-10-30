<?php
/**
 * Test Real-Time Detection
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

global $wpdb;
$table = $wpdb->prefix . 'gtub_bookings';

// Get the most recent booking
$booking = $wpdb->get_row("SELECT * FROM $table ORDER BY id DESC LIMIT 1");

if (!$booking) {
    die('No bookings found');
}

// Test actual update
if (isset($_GET['test'])) {
    echo "<h1>Testing Real-Time Detection</h1>";
    
    $booking_id = intval($_GET['booking_id']);
    
    echo "<h2>Before Update:</h2>";
    $before = $wpdb->get_row("SELECT * FROM $table WHERE id = $booking_id");
    echo "Booking ID: " . $before->id . "<br>";
    echo "Status: " . $before->status . "<br>";
    echo "updated_at: " . $before->updated_at . "<br>";
    
    echo "<h2>Performing Update:</h2>";
    $new_status = $before->status === 'confirmed' ? 'pending' : 'confirmed';
    
    $result = $wpdb->update(
        $table,
        array(
            'status' => $new_status,
            'updated_at' => current_time('mysql')
        ),
        array('id' => $booking_id),
        array('%s', '%s'),
        array('%d')
    );
    
    echo "Update result: " . ($result !== false ? '✅ SUCCESS' : '❌ FAILED') . "<br>";
    echo "Changed status from {$before->status} to {$new_status}<br>";
    
    echo "<h2>After Update:</h2>";
    $after = $wpdb->get_row("SELECT * FROM $table WHERE id = $booking_id");
    echo "Status: " . $after->status . "<br>";
    echo "updated_at: " . $after->updated_at . "<br>";
    
    if ($before->updated_at !== $after->updated_at) {
        echo "<p style='color: green; font-size: 20px;'>✅ Timestamp CHANGED! Real-time sync should detect this!</p>";
    } else {
        echo "<p style='color: red; font-size: 20px;'>❌ Timestamp NOT changed! Problem!</p>";
    }
    
    echo "<h2>What Real-Time Sync Should See:</h2>";
    $recent_updates = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table WHERE updated_at > %s ORDER BY updated_at DESC LIMIT 5",
        date('Y-m-d H:i:s', strtotime('-1 minute'))
    ));
    
    echo "Bookings updated in last minute: " . count($recent_updates) . "<br>";
    if ($recent_updates) {
        echo "<ul>";
        foreach ($recent_updates as $b) {
            echo "<li>Booking #{$b->booking_number} - Updated: {$b->updated_at}</li>";
        }
        echo "</ul>";
    }
    
    echo "<hr>";
    echo "<a href='/wp-admin/admin.php?page=gtub-bookings' style='padding: 10px 20px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px;'>Open Admin (Check Console)</a>";
    echo "<a href='/staff-portal/' style='padding: 10px 20px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px;'>Open Staff Portal (Check Console)</a>";
    
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Real-Time Detection</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 40px; max-width: 1200px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        .test-box { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .btn { display: inline-block; padding: 12px 24px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #3d7f5f; }
        .btn-large { font-size: 18px; padding: 15px 30px; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test Real-Time Detection</h1>
        
        <div class="test-box">
            <h2>📋 Instructions:</h2>
            <ol>
                <li><strong>FIRST:</strong> Open these 2 tabs:
                    <ul>
                        <li><a href="/wp-admin/admin.php?page=gtub-bookings" target="_blank">Admin Bookings</a> - Press Cmd+Option+I to open console</li>
                        <li><a href="/staff-portal/" target="_blank">Staff Portal</a> - Press Cmd+Option+I to open console</li>
                    </ul>
                </li>
                <li><strong>THEN:</strong> Click the button below to trigger an update</li>
                <li><strong>WATCH:</strong> Both console tabs - you should see within 5 seconds:
                    <pre>🔍 Checking for updates, last_check: ...
📥 Response: {success: true, data: {has_updates: true, bookings: [...]}}
✅ Updates found!
Booking updated: #<?php echo $booking->booking_number; ?>
🔄 1 booking updated</pre>
                </li>
                <li><strong>LOOK FOR:</strong> Toast notification and row highlight in both tabs</li>
            </ol>
        </div>
        
        <div class="test-box">
            <h2>🎯 Current Test Booking:</h2>
            <p><strong>Booking #<?php echo $booking->booking_number; ?></strong></p>
            <p>ID: <?php echo $booking->id; ?></p>
            <p>Current Status: <strong><?php echo $booking->status; ?></strong></p>
            <p>Last Updated: <?php echo $booking->updated_at; ?></p>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="?test=1&booking_id=<?php echo $booking->id; ?>" class="btn btn-large">
                🚀 TEST UPDATE NOW
            </a>
        </div>
        
        <div class="test-box">
            <h2>✅ What Should Happen:</h2>
            <ol>
                <li>This page will update the booking and change its status</li>
                <li>The updated_at timestamp will change</li>
                <li>Real-time sync (running in Admin and Staff tabs) will detect the change within 5 seconds</li>
                <li>You'll see console messages in both tabs</li>
                <li>Toast notifications will appear</li>
                <li>The booking row will highlight with a blue pulse</li>
            </ol>
        </div>
        
        <div class="test-box">
            <h2>🔍 Debug Info:</h2>
            <p><strong>Check if real-time sync is running:</strong></p>
            <ol>
                <li>Open Admin or Staff Portal</li>
                <li>Press Cmd+Option+I (console)</li>
                <li>Look for: <code style="background: #f4f4f4; padding: 2px 6px; border-radius: 3px;">✅ Real-time sync initialized</code></li>
                <li>Every 5 seconds you should see: <code style="background: #f4f4f4; padding: 2px 6px; border-radius: 3px;">🔍 Checking for updates</code></li>
            </ol>
        </div>
    </div>
</body>
</html>

