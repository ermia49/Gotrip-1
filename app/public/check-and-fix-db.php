<?php
/**
 * Quick Database Check and Fix
 */

require_once('wp-load.php');

global $wpdb;

echo "<h1>Database Check and Fix</h1>";

$table = $wpdb->prefix . 'gtub_bookings';

// Check if table exists
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table'");

if (!$table_exists) {
    echo "<p style='color: red;'>❌ Table $table does not exist!</p>";
    echo "<p>Activating plugin...</p>";
    
    // Try to activate plugin
    if (file_exists(WP_PLUGIN_DIR . '/gotrip-unified-booking/gotrip-unified-booking.php')) {
        require_once(WP_PLUGIN_DIR . '/gotrip-unified-booking/gotrip-unified-booking.php');
        require_once(WP_PLUGIN_DIR . '/gotrip-unified-booking/includes/class-database.php');
        GTUB_Database::create_tables();
        echo "<p style='color: green;'>✅ Tables created!</p>";
    }
    exit;
}

echo "<p style='color: green;'>✅ Table exists: $table</p>";

// Get current columns
$columns = $wpdb->get_results("SHOW COLUMNS FROM $table");
$column_names = array_column($columns, 'Field');

echo "<h2>Current Columns:</h2>";
echo "<ul>";
foreach ($column_names as $col) {
    echo "<li>$col</li>";
}
echo "</ul>";

// Check for updated_at
if (!in_array('updated_at', $column_names)) {
    echo "<p style='color: orange;'>⚠️ Missing updated_at column. Adding it now...</p>";
    
    $result = $wpdb->query("
        ALTER TABLE $table 
        ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at
    ");
    
    if ($result !== false) {
        echo "<p style='color: green;'>✅ Added updated_at column!</p>";
        
        // Initialize with created_at
        $wpdb->query("UPDATE $table SET updated_at = created_at WHERE updated_at IS NULL");
        echo "<p style='color: green;'>✅ Initialized updated_at for existing records!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . $wpdb->last_error . "</p>";
    }
} else {
    echo "<p style='color: green;'>✅ updated_at column exists!</p>";
}

// Check for index
$indexes = $wpdb->get_results("SHOW INDEX FROM $table WHERE Key_name = 'idx_updated_at'");
if (empty($indexes)) {
    echo "<p style='color: orange;'>⚠️ Missing index on updated_at. Adding it now...</p>";
    
    $result = $wpdb->query("ALTER TABLE $table ADD INDEX idx_updated_at (updated_at)");
    
    if ($result !== false) {
        echo "<p style='color: green;'>✅ Added index on updated_at!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . $wpdb->last_error . "</p>";
    }
} else {
    echo "<p style='color: green;'>✅ Index on updated_at exists!</p>";
}

// Show sample data
echo "<h2>Sample Bookings (Last 5):</h2>";
$bookings = $wpdb->get_results("
    SELECT id, booking_number, status, created_at, updated_at 
    FROM $table 
    ORDER BY id DESC 
    LIMIT 5
");

if ($bookings) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Booking #</th><th>Status</th><th>Created</th><th>Updated</th></tr>";
    foreach ($bookings as $booking) {
        echo "<tr>";
        echo "<td>{$booking->id}</td>";
        echo "<td>{$booking->booking_number}</td>";
        echo "<td>{$booking->status}</td>";
        echo "<td>{$booking->created_at}</td>";
        echo "<td>" . ($booking->updated_at ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}

// Test update
echo "<h2>Test Update:</h2>";
if ($bookings && count($bookings) > 0) {
    $test_id = $bookings[0]->id;
    echo "<p>Testing update on booking ID: $test_id</p>";
    
    $before = $wpdb->get_row("SELECT updated_at FROM $table WHERE id = $test_id");
    echo "<p>Before: " . ($before->updated_at ?? 'NULL') . "</p>";
    
    // Update the booking
    $wpdb->query("UPDATE $table SET status = status WHERE id = $test_id");
    
    sleep(1); // Wait a second
    
    $after = $wpdb->get_row("SELECT updated_at FROM $table WHERE id = $test_id");
    echo "<p>After: " . ($after->updated_at ?? 'NULL') . "</p>";
    
    if ($before->updated_at !== $after->updated_at) {
        echo "<p style='color: green;'>✅ updated_at is working! Timestamp changed.</p>";
    } else {
        echo "<p style='color: red;'>❌ updated_at not updating automatically. Checking MySQL version...</p>";
        $version = $wpdb->get_var("SELECT VERSION()");
        echo "<p>MySQL Version: $version</p>";
    }
}

echo "<hr>";
echo "<h2>✅ Database is ready for real-time sync!</h2>";
echo "<p><a href='/wp-admin/admin.php?page=gtub-bookings' style='padding: 10px 20px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 5px;'>Go to Bookings</a></p>";
echo "<p><a href='/staff-portal/' style='padding: 10px 20px; background: #2d5f3f; color: white; text-decoration: none; border-radius: 5px;'>Go to Staff Portal</a></p>";


