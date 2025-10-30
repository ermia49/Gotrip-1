<?php
/**
 * Manual Sync Trigger
 * Visit: http://localhost:10003/manual-sync.php
 */

require_once('wp-load.php');

if (!is_user_logged_in() || !current_user_can('manage_options')) {
    die('Access denied. Please log in as admin.');
}

echo "<h1>🔄 Manual Sync Trigger</h1>";
echo "<style>body{font-family:monospace;padding:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} pre{background:#f5f5f5;padding:15px;border-radius:5px;overflow:auto;}</style>";

echo "<p>Triggering manual sync from all sources...</p>";
echo "<hr>";

// Sync CHBS
echo "<h2>🚗 Syncing CHBS Bookings...</h2>";
try {
    $chbs_result = GTUB_Sync_Manager::sync_all_chbs_bookings();
    echo "<pre class='success'>";
    print_r($chbs_result);
    echo "</pre>";
} catch (Exception $e) {
    echo "<pre class='error'>Error: " . $e->getMessage() . "</pre>";
}

// Sync JetBooking
echo "<h2>🎫 Syncing JetBooking Tours...</h2>";
try {
    $jet_result = GTUB_Sync_Manager::sync_all_jetbooking_bookings();
    echo "<pre class='success'>";
    print_r($jet_result);
    echo "</pre>";
} catch (Exception $e) {
    echo "<pre class='error'>Error: " . $e->getMessage() . "</pre>";
}

// Sync GTBM
echo "<h2>📝 Syncing GTBM Bookings...</h2>";
try {
    $gtbm_result = GTUB_Sync_Manager::sync_all_gtbm_bookings();
    echo "<pre class='success'>";
    print_r($gtbm_result);
    echo "</pre>";
} catch (Exception $e) {
    echo "<pre class='error'>Error: " . $e->getMessage() . "</pre>";
}

// Summary
echo "<hr>";
echo "<h2>📊 Sync Summary</h2>";
$total_synced = ($chbs_result['synced'] ?? 0) + ($jet_result['synced'] ?? 0) + ($gtbm_result['synced'] ?? 0);
$total_failed = ($chbs_result['failed'] ?? 0) + ($jet_result['failed'] ?? 0) + ($gtbm_result['failed'] ?? 0);

echo "<p><strong>Total Synced:</strong> <span class='success'>$total_synced</span></p>";
echo "<p><strong>Total Failed:</strong> <span class='error'>$total_failed</span></p>";

// Check unified bookings
global $wpdb;
$unified_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}gtub_bookings");
echo "<p><strong>Total in Unified System:</strong> <span class='info'>$unified_count</span></p>";

echo "<hr>";
echo "<h2>🎯 Next Steps</h2>";
echo "<ol>";
echo "<li><a href='/wp-admin/admin.php?page=gtub-bookings'>View All Bookings</a></li>";
echo "<li><a href='/staff-portal/'>Open Staff Portal</a></li>";
echo "<li><a href='/check-tables.php'>Check Database Tables</a></li>";
echo "<li><a href='/test-ajax.php'>Run Diagnostic Test</a></li>";
echo "</ol>";
?>


