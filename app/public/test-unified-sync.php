<?php
/**
 * Test Unified Sync - All Sources
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

global $wpdb;
$bookings_table = $wpdb->prefix . 'gtub_bookings';

// Test update
if (isset($_GET['test_update'])) {
    $booking_id = intval($_GET['test_update']);
    $test_source = $_GET['source'] ?? 'manual';
    
    $result = GTUB_Booking::update($booking_id, array(
        'status' => 'confirmed',
        'notes' => 'Test update from ' . $test_source . ' at ' . current_time('mysql')
    ));
    
    $message = $result ? "✅ Booking #$booking_id updated! Check if it appears in other tabs." : "❌ Failed to update booking";
}

// Get recent bookings from all sources
$bookings = $wpdb->get_results("
    SELECT * FROM $bookings_table 
    ORDER BY updated_at DESC 
    LIMIT 20
");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Unified Sync</title>
    <style>
        body { font-family: -apple-system, sans-serif; padding: 20px; max-width: 1400px; margin: 0 auto; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2d5f3f; }
        .message { padding: 15px; margin: 20px 0; border-radius: 4px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; position: sticky; top: 0; }
        .btn { display: inline-block; padding: 6px 12px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 4px; font-size: 12px; margin: 2px; }
        .btn:hover { background: #3d7f5f; }
        .btn-sm { padding: 4px 8px; font-size: 11px; }
        .source { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .source-woocommerce { background: #96588a; color: white; }
        .source-chbs { background: #0073aa; color: white; }
        .source-manual { background: #28a745; color: white; }
        .source-jetbooking { background: #ff6b6b; color: white; }
        .status { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .highlight { animation: pulse 2s ease; }
        @keyframes pulse {
            0%, 100% { background-color: transparent; }
            50% { background-color: #e3f2fd; }
        }
        .section { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2d5f3f; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .stat-card { background: linear-gradient(135deg, #2d5f3f 0%, #3d7f5f 100%); color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 32px; font-weight: bold; margin: 10px 0; }
        .stat-label { font-size: 12px; opacity: 0.9; text-transform: uppercase; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>🔄 Test Unified Sync - All Sources</h1>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="section">
            <h2>📊 Statistics by Source</h2>
            <?php
            $stats = array(
                'total' => $wpdb->get_var("SELECT COUNT(*) FROM $bookings_table"),
                'woocommerce' => $wpdb->get_var("SELECT COUNT(*) FROM $bookings_table WHERE source = 'woocommerce'"),
                'chbs' => $wpdb->get_var("SELECT COUNT(*) FROM $bookings_table WHERE source = 'chbs'"),
                'manual' => $wpdb->get_var("SELECT COUNT(*) FROM $bookings_table WHERE source = 'manual'"),
                'jetbooking' => $wpdb->get_var("SELECT COUNT(*) FROM $bookings_table WHERE source = 'jetbooking'"),
            );
            ?>
            <div class="grid">
                <div class="stat-card">
                    <div class="stat-label">Total Bookings</div>
                    <div class="stat-number"><?php echo $stats['total']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">WooCommerce</div>
                    <div class="stat-number"><?php echo $stats['woocommerce']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">CHBS</div>
                    <div class="stat-number"><?php echo $stats['chbs']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Manual</div>
                    <div class="stat-number"><?php echo $stats['manual']; ?></div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h2>📋 How to Test:</h2>
            <ol>
                <li>Open <strong>2 browser tabs</strong>:
                    <ul>
                        <li>Tab 1: <a href="/wp-admin/admin.php?page=gtub-bookings" target="_blank">Admin Bookings</a></li>
                        <li>Tab 2: <a href="/staff-portal/" target="_blank">Staff Portal</a></li>
                    </ul>
                </li>
                <li>Click "Test Update" button below on any booking</li>
                <li>Watch the other tabs - they should update within <strong>5 seconds</strong> without refreshing</li>
                <li>Look for:
                    <ul>
                        <li>Toast notification: "🔄 1 booking updated"</li>
                        <li>Row highlight (blue pulse)</li>
                        <li>Status/notes update</li>
                    </ul>
                </li>
            </ol>
        </div>
        
        <h2>📝 Recent Bookings (All Sources)</h2>
        
        <table id="bookings-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Booking #</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr data-booking-id="<?php echo $booking->id; ?>" class="<?php echo isset($_GET['test_update']) && $_GET['test_update'] == $booking->id ? 'highlight' : ''; ?>">
                        <td><?php echo $booking->id; ?></td>
                        <td><strong><?php echo $booking->booking_number; ?></strong></td>
                        <td><span class="source source-<?php echo $booking->source; ?>"><?php echo strtoupper($booking->source); ?></span></td>
                        <td><span class="status status-<?php echo $booking->status; ?>"><?php echo ucfirst($booking->status); ?></span></td>
                        <td><?php echo $booking->customer_name ?: '-'; ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($booking->created_at)); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($booking->updated_at)); ?></td>
                        <td>
                            <a href="?test_update=<?php echo $booking->id; ?>&source=<?php echo $booking->source; ?>" class="btn btn-sm">Test Update</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="/wp-admin/admin.php?page=gtub-bookings" class="btn">Open Admin Bookings</a>
            <a href="/staff-portal/" class="btn">Open Staff Portal</a>
            <a href="?" class="btn">Refresh This Page</a>
        </div>
    </div>
    
    <script>
    // Auto-refresh table every 10 seconds to show updates
    setInterval(function() {
        if (!window.location.search.includes('test_update')) {
            $('#bookings-table tbody').load(window.location.href + ' #bookings-table tbody>*');
        }
    }, 10000);
    </script>
</body>
</html>

