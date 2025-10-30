<?php
/**
 * Test Live Sync
 * Access: http://localhost:10003/test-live-sync.php
 */

require_once('wp-load.php');

// Security check
if (!current_user_can('manage_options')) {
    die('Access denied. Please log in as administrator.');
}

// Handle test update
if (isset($_GET['update_booking'])) {
    $booking_id = intval($_GET['update_booking']);
    global $wpdb;
    $table = $wpdb->prefix . 'gtub_bookings';
    
    // Update the booking status to trigger real-time sync
    $new_status = $_GET['status'] ?? 'confirmed';
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
    
    if ($result !== false) {
        // Also trigger the real-time sync log
        if (class_exists('GTUB_Realtime_Sync')) {
            GTUB_Realtime_Sync::log_booking_update($booking_id, 'status_changed', 'pending', $new_status);
        }
        
        $message = "✅ Booking $booking_id status changed to $new_status. Check if it updates in other tabs within 5 seconds!";
    } else {
        $message = "❌ Failed to update booking $booking_id";
    }
}

// Get recent bookings
global $wpdb;
$bookings = $wpdb->get_results("
    SELECT id, booking_number, status, created_at, updated_at 
    FROM {$wpdb->prefix}gtub_bookings 
    ORDER BY id DESC 
    LIMIT 10
");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Live Sync</title>
    <style>
        body { 
            font-family: -apple-system, sans-serif; 
            max-width: 1200px; 
            margin: 40px auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #2d5f3f; }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { background: #f8f9fa; font-weight: 600; }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #2d5f3f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            margin: 2px;
        }
        .btn:hover { background: #3d7f5f; }
        .btn-warning { background: #ff9800; }
        .btn-warning:hover { background: #e68900; }
        .status { 
            padding: 4px 12px; 
            border-radius: 12px; 
            font-size: 12px; 
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .test-section {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #2d5f3f;
            border-radius: 4px;
        }
        .highlight { 
            animation: pulse 2s ease;
        }
        @keyframes pulse {
            0%, 100% { background-color: transparent; }
            50% { background-color: #e3f2fd; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Test Live Sync</h1>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="test-section">
            <h2>📋 Instructions:</h2>
            <ol>
                <li>Open <strong>2 browser tabs</strong>:
                    <ul>
                        <li>Tab 1: <a href="/wp-admin/admin.php?page=gtub-bookings" target="_blank">Admin Bookings</a></li>
                        <li>Tab 2: <a href="/staff-portal/" target="_blank">Staff Portal</a></li>
                    </ul>
                </li>
                <li>Click a <strong>"Change Status"</strong> button below</li>
                <li>Watch the other tabs - they should <strong>update within 5 seconds</strong> without refreshing!</li>
                <li>Look for:
                    <ul>
                        <li>Toast notification: "🔄 1 booking updated"</li>
                        <li>Row highlight (blue pulse)</li>
                        <li>Status badge change</li>
                    </ul>
                </li>
            </ol>
        </div>
        
        <h2>🚀 Recent Bookings - Click to Test</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Booking #</th>
                    <th>Current Status</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="bookings-table">
                <?php foreach ($bookings as $booking): ?>
                    <tr data-booking-id="<?php echo $booking->id; ?>" class="<?php echo isset($_GET['update_booking']) && $_GET['update_booking'] == $booking->id ? 'highlight' : ''; ?>">
                        <td><?php echo $booking->id; ?></td>
                        <td><strong><?php echo $booking->booking_number; ?></strong></td>
                        <td><span class="status status-<?php echo $booking->status; ?>"><?php echo $booking->status; ?></span></td>
                        <td><?php echo $booking->updated_at; ?></td>
                        <td>
                            <?php if ($booking->status !== 'confirmed'): ?>
                                <a href="?update_booking=<?php echo $booking->id; ?>&status=confirmed" class="btn">→ Confirmed</a>
                            <?php endif; ?>
                            <?php if ($booking->status !== 'completed'): ?>
                                <a href="?update_booking=<?php echo $booking->id; ?>&status=completed" class="btn">→ Completed</a>
                            <?php endif; ?>
                            <?php if ($booking->status !== 'pending'): ?>
                                <a href="?update_booking=<?php echo $booking->id; ?>&status=pending" class="btn btn-warning">→ Pending</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="test-section">
            <h2>✅ What Should Happen:</h2>
            <p><strong>When you click a status button above:</strong></p>
            <ol>
                <li>This page updates immediately ✅</li>
                <li>Within <strong>5 seconds</strong>, without refreshing:
                    <ul>
                        <li>Admin bookings page updates automatically</li>
                        <li>Staff portal updates automatically</li>
                        <li>Toast notification appears</li>
                        <li>Row highlights briefly</li>
                    </ul>
                </li>
            </ol>
            
            <p><strong>If it's not working:</strong></p>
            <ul>
                <li>Check browser console (Cmd+Option+I on Mac)</li>
                <li>Look for "Real-time sync initialized"</li>
                <li>Check for JavaScript errors</li>
            </ul>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="/wp-admin/admin.php?page=gtub-bookings" class="btn">Open Admin Bookings</a>
            <a href="/staff-portal/" class="btn">Open Staff Portal</a>
            <a href="?" class="btn">Refresh This Page</a>
        </div>
    </div>
    
    <script>
        // Auto-refresh this page every 30 seconds to show updates
        setTimeout(function() {
            if (!window.location.search.includes('update_booking')) {
                window.location.reload();
            }
        }, 30000);
    </script>
</body>
</html>

