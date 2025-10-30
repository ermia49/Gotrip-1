<?php
/**
 * Check Database Tables Structure
 * Visit: http://localhost:10003/check-tables.php
 */

require_once('wp-load.php');

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('Access denied. Please log in as admin.');
}

global $wpdb;

echo "<h1>📊 Database Tables Check</h1>";
echo "<style>body{font-family:monospace;padding:20px;} table{border-collapse:collapse;margin:20px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#2d5f3f;color:white;} .found{color:green;} .notfound{color:red;}</style>";

// Check CHBS tables
echo "<h2>🚗 CHBS Tables</h2>";
$chbs_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}chbs%'", ARRAY_N);

if ($chbs_tables) {
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Row Count</th><th>Columns</th></tr>";
    
    foreach ($chbs_tables as $table) {
        $table_name = $table[0];
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $columns = $wpdb->get_col("SHOW COLUMNS FROM $table_name");
        
        echo "<tr>";
        echo "<td><strong>$table_name</strong></td>";
        echo "<td>$count rows</td>";
        echo "<td>" . implode(', ', $columns) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='notfound'>❌ No CHBS tables found</p>";
}

// Check JetBooking tables
echo "<h2>🎫 JetBooking Tables</h2>";
$jet_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}jet%booking%'", ARRAY_N);

if ($jet_tables) {
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Row Count</th><th>Columns</th></tr>";
    
    foreach ($jet_tables as $table) {
        $table_name = $table[0];
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $columns = $wpdb->get_col("SHOW COLUMNS FROM $table_name");
        
        echo "<tr>";
        echo "<td><strong>$table_name</strong></td>";
        echo "<td>$count rows</td>";
        echo "<td>" . implode(', ', $columns) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='notfound'>❌ No JetBooking tables found</p>";
}

// Check GTBM (GoTrip Booking Manager) posts
echo "<h2>📝 GTBM Bookings (Custom Post Type)</h2>";
$gtbm_count = wp_count_posts('gtbm_booking');
if ($gtbm_count) {
    echo "<table>";
    echo "<tr><th>Status</th><th>Count</th></tr>";
    foreach ($gtbm_count as $status => $count) {
        if ($count > 0) {
            echo "<tr><td>$status</td><td>$count</td></tr>";
        }
    }
    echo "</table>";
    
    // Show recent bookings
    $recent = get_posts(array(
        'post_type' => 'gtbm_booking',
        'posts_per_page' => 5,
        'post_status' => 'any',
    ));
    
    if ($recent) {
        echo "<h3>Recent GTBM Bookings:</h3>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Title</th><th>Status</th><th>Date</th></tr>";
        foreach ($recent as $post) {
            echo "<tr>";
            echo "<td>{$post->ID}</td>";
            echo "<td>{$post->post_title}</td>";
            echo "<td>{$post->post_status}</td>";
            echo "<td>{$post->post_date}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "<p class='notfound'>❌ No GTBM bookings found</p>";
}

// Check Unified Bookings
echo "<h2>🔄 Unified Bookings Table</h2>";
$unified_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}gtub_bookings");
echo "<p><strong>Total Unified Bookings:</strong> $unified_count</p>";

if ($unified_count > 0) {
    $by_source = $wpdb->get_results("SELECT source, COUNT(*) as count FROM {$wpdb->prefix}gtub_bookings GROUP BY source");
    
    echo "<table>";
    echo "<tr><th>Source</th><th>Count</th></tr>";
    foreach ($by_source as $row) {
        echo "<tr><td>{$row->source}</td><td>{$row->count}</td></tr>";
    }
    echo "</table>";
    
    // Show recent unified bookings
    $recent_unified = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gtub_bookings ORDER BY id DESC LIMIT 10");
    
    if ($recent_unified) {
        echo "<h3>Recent Unified Bookings:</h3>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Booking #</th><th>Source</th><th>Customer</th><th>Date</th></tr>";
        foreach ($recent_unified as $booking) {
            echo "<tr>";
            echo "<td>{$booking->id}</td>";
            echo "<td>{$booking->booking_number}</td>";
            echo "<td>{$booking->source}</td>";
            echo "<td>{$booking->customer_name}</td>";
            echo "<td>{$booking->pickup_datetime}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Recommendations
echo "<hr>";
echo "<h2>🎯 Recommendations</h2>";
echo "<ol>";

if (empty($chbs_tables)) {
    echo "<li>⚠️ <strong>CHBS:</strong> No CHBS tables found. Make sure CHBS plugin is active and has bookings.</li>";
} else {
    echo "<li>✅ <strong>CHBS:</strong> Tables found. Check column names above for sync compatibility.</li>";
}

if (empty($jet_tables)) {
    echo "<li>⚠️ <strong>JetBooking:</strong> No JetBooking tables found. Make sure JetBooking plugin is active and has bookings.</li>";
} else {
    echo "<li>✅ <strong>JetBooking:</strong> Tables found. Check column names above for sync compatibility.</li>";
}

if ($gtbm_count && $gtbm_count->publish > 0) {
    echo "<li>✅ <strong>GTBM:</strong> {$gtbm_count->publish} bookings found. Ready to sync.</li>";
} else {
    echo "<li>⚠️ <strong>GTBM:</strong> No bookings found. Create test bookings first.</li>";
}

echo "</ol>";

echo "<hr>";
echo "<h2>🔧 Manual Sync</h2>";
echo "<p><a href='/wp-admin/admin.php?page=gtub-sync' style='background:#2d5f3f;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Sync Page</a></p>";
?>


