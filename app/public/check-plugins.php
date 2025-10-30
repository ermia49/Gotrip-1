<?php
/**
 * Check Active Plugins
 * Visit: http://localhost:10003/check-plugins.php
 */

require_once('wp-load.php');

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('Access denied. Please log in as admin.');
}

echo "<h1>🔌 Active Plugins Check</h1>";
echo "<style>body{font-family:monospace;padding:20px;} .active{color:green;} .inactive{color:red;} table{border-collapse:collapse;margin:20px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#2d5f3f;color:white;}</style>";

// Get all plugins
$all_plugins = get_plugins();
$active_plugins = get_option('active_plugins');

// Check specific plugins we need
$required_plugins = array(
    'chauffeur-booking-system' => 'CHBS (Chauffeur Booking System)',
    'jet-booking' => 'JetBooking (DayTrip/Tours)',
    'woocommerce' => 'WooCommerce',
    'gotrip-unified-booking' => 'GoTrip Unified Booking',
);

echo "<h2>🎯 Required Plugins Status</h2>";
echo "<table>";
echo "<tr><th>Plugin</th><th>Status</th><th>Action</th></tr>";

foreach ($required_plugins as $slug => $name) {
    $found = false;
    $plugin_file = '';
    $is_active = false;
    
    foreach ($all_plugins as $file => $plugin_data) {
        if (strpos($file, $slug) !== false) {
            $found = true;
            $plugin_file = $file;
            $is_active = in_array($file, $active_plugins);
            break;
        }
    }
    
    echo "<tr>";
    echo "<td><strong>$name</strong></td>";
    
    if (!$found) {
        echo "<td class='inactive'>❌ Not Installed</td>";
        echo "<td>Install from WordPress.org or upload</td>";
    } elseif ($is_active) {
        echo "<td class='active'>✅ Active</td>";
        echo "<td>-</td>";
    } else {
        echo "<td class='inactive'>⚠️ Installed but Inactive</td>";
        echo "<td><a href='/wp-admin/plugins.php'>Activate Now</a></td>";
    }
    
    echo "</tr>";
}

echo "</table>";

// Show all active plugins
echo "<hr>";
echo "<h2>📋 All Active Plugins</h2>";
echo "<table>";
echo "<tr><th>#</th><th>Plugin Name</th><th>Version</th></tr>";

$count = 0;
foreach ($all_plugins as $file => $plugin_data) {
    if (in_array($file, $active_plugins)) {
        $count++;
        echo "<tr>";
        echo "<td>$count</td>";
        echo "<td>{$plugin_data['Name']}</td>";
        echo "<td>{$plugin_data['Version']}</td>";
        echo "</tr>";
    }
}

echo "</table>";

// Check if CHBS has created tables
echo "<hr>";
echo "<h2>🔍 CHBS Status</h2>";

$chbs_active = false;
foreach ($all_plugins as $file => $plugin_data) {
    if (strpos($file, 'chauffeur-booking-system') !== false && in_array($file, $active_plugins)) {
        $chbs_active = true;
        echo "<p class='active'>✅ CHBS Plugin is ACTIVE</p>";
        echo "<p><strong>Version:</strong> {$plugin_data['Version']}</p>";
        break;
    }
}

if (!$chbs_active) {
    echo "<p class='inactive'>❌ CHBS Plugin is NOT ACTIVE</p>";
    echo "<p><strong>Action:</strong> <a href='/wp-admin/plugins.php'>Go activate it now</a></p>";
} else {
    // Check for CHBS tables
    global $wpdb;
    $chbs_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}chbs%'", ARRAY_N);
    
    if (empty($chbs_tables)) {
        echo "<p class='inactive'>⚠️ CHBS is active but NO TABLES found</p>";
        echo "<p><strong>Reason:</strong> CHBS creates tables only after first booking</p>";
        echo "<p><strong>Action:</strong> Create a test booking in CHBS form</p>";
    } else {
        echo "<p class='active'>✅ CHBS tables found: " . count($chbs_tables) . "</p>";
        
        // Count bookings in main table
        foreach ($chbs_tables as $table) {
            $table_name = $table[0];
            if (strpos($table_name, 'booking') !== false) {
                $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
                echo "<p>📊 <strong>$table_name:</strong> $count bookings</p>";
            }
        }
    }
}

// Check JetBooking
echo "<hr>";
echo "<h2>🎫 JetBooking Status</h2>";

$jet_active = false;
foreach ($all_plugins as $file => $plugin_data) {
    if (strpos($file, 'jet-booking') !== false && in_array($file, $active_plugins)) {
        $jet_active = true;
        echo "<p class='active'>✅ JetBooking Plugin is ACTIVE</p>";
        echo "<p><strong>Version:</strong> {$plugin_data['Version']}</p>";
        break;
    }
}

if (!$jet_active) {
    echo "<p class='inactive'>❌ JetBooking Plugin is NOT ACTIVE</p>";
} else {
    // Check for JetBooking tables
    $jet_tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}jet%booking%'", ARRAY_N);
    
    if (empty($jet_tables)) {
        echo "<p class='inactive'>⚠️ JetBooking is active but NO TABLES found</p>";
        echo "<p><strong>Action:</strong> Create a test tour booking</p>";
    } else {
        echo "<p class='active'>✅ JetBooking tables found: " . count($jet_tables) . "</p>";
        
        foreach ($jet_tables as $table) {
            $table_name = $table[0];
            $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
            echo "<p>📊 <strong>$table_name:</strong> $count bookings</p>";
        }
    }
}

echo "<hr>";
echo "<h2>🎯 Next Steps</h2>";
echo "<ol>";

if (!$chbs_active) {
    echo "<li><strong>Activate CHBS:</strong> <a href='/wp-admin/plugins.php'>Go to Plugins</a> → Find 'Chauffeur Booking System' → Click 'Activate'</li>";
} else {
    if (empty($chbs_tables)) {
        echo "<li><strong>Create CHBS Booking:</strong> Go to your CHBS booking form and create a test booking</li>";
    } else {
        echo "<li>✅ CHBS is ready for sync</li>";
    }
}

if (!$jet_active) {
    echo "<li><strong>Activate JetBooking:</strong> <a href='/wp-admin/plugins.php'>Go to Plugins</a> → Find 'JetBooking' → Click 'Activate'</li>";
} else {
    if (empty($jet_tables)) {
        echo "<li><strong>Create JetBooking:</strong> Go to your tour booking form and create a test booking</li>";
    } else {
        echo "<li>✅ JetBooking is ready for sync</li>";
    }
}

echo "<li><strong>Run Manual Sync:</strong> <a href='/manual-sync.php'>Click here to sync all bookings</a></li>";
echo "<li><strong>View Results:</strong> <a href='/wp-admin/admin.php?page=gtub-bookings'>Check Unified Bookings</a></li>";
echo "</ol>";
?>


