<?php
/**
 * Test AJAX Handlers
 */

require_once('wp-load.php');

if (!is_user_logged_in()) {
    die('Please log in first');
}

echo "<h1>🔍 AJAX Handler Test</h1>";

// Check if AJAX actions are registered
global $wp_filter;

$ajax_actions = array(
    'gtub_quick_assign_driver',
    'gtub_quick_change_status',
    'gtub_quick_view',
    'gtub_quick_send_email',
);

echo "<h2>Registered AJAX Handlers:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Action</th><th>Status</th><th>Callbacks</th></tr>";

foreach ($ajax_actions as $action) {
    $hook_name = 'wp_ajax_' . $action;
    $registered = isset($wp_filter[$hook_name]) && !empty($wp_filter[$hook_name]);
    
    echo "<tr>";
    echo "<td><code>$action</code></td>";
    echo "<td>" . ($registered ? "✅ Registered" : "❌ Not Registered") . "</td>";
    echo "<td>";
    
    if ($registered) {
        foreach ($wp_filter[$hook_name]->callbacks as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                if (is_array($callback['function'])) {
                    echo "<code>" . get_class($callback['function'][0]) . "::" . $callback['function'][1] . "</code><br>";
                } else {
                    echo "<code>" . $callback['function'] . "</code><br>";
                }
            }
        }
    } else {
        echo "None";
    }
    
    echo "</td>";
    echo "</tr>";
}

echo "</table>";

// Check if classes are loaded
echo "<h2>Plugin Classes:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Class</th><th>Status</th></tr>";

$classes = array(
    'GoTrip_Unified_Booking',
    'GTUB_Booking_List',
    'GTUB_Calendar',
    'GTUB_Bulk_Actions',
    'GTUB_Admin_Menu',
);

foreach ($classes as $class) {
    $exists = class_exists($class);
    echo "<tr>";
    echo "<td><code>$class</code></td>";
    echo "<td>" . ($exists ? "✅ Loaded" : "❌ Not Loaded") . "</td>";
    echo "</tr>";
}

echo "</table>";

// Check if plugin is active
echo "<h2>Plugin Status:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Check</th><th>Status</th></tr>";

$plugin_file = 'gotrip-unified-booking/gotrip-unified-booking.php';
$is_active = is_plugin_active($plugin_file);

echo "<tr>";
echo "<td>Plugin Active</td>";
echo "<td>" . ($is_active ? "✅ Yes" : "❌ No") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Current User Can Manage Options</td>";
echo "<td>" . (current_user_can('manage_options') ? "✅ Yes" : "❌ No") . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>AJAX URL</td>";
echo "<td><code>" . admin_url('admin-ajax.php') . "</code></td>";
echo "</tr>";

echo "</table>";

// Test nonce generation
echo "<h2>Nonce Test:</h2>";
$nonce = wp_create_nonce('gtub_quick_actions');
echo "<p>Generated Nonce: <code>$nonce</code></p>";
echo "<p>Nonce Verification: " . (wp_verify_nonce($nonce, 'gtub_quick_actions') ? "✅ Valid" : "❌ Invalid") . "</p>";

echo "<hr>";
echo "<p><a href='" . admin_url('admin.php?page=gtub-bookings') . "'>← Back to Bookings</a></p>";
