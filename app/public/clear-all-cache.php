<?php
/**
 * Clear All Cache - GoTrip
 * 
 * Access this file directly in browser to clear all caches
 * URL: http://localhost:10003/clear-all-cache.php
 */

// Clear WordPress object cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo "✅ WordPress object cache cleared<br>";
}

// Clear opcache (PHP cache)
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✅ PHP OPcache cleared<br>";
}

// Clear browser cache headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Clear WordPress transients
require_once('wp-load.php');

global $wpdb;

// Delete all transients
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");

echo "✅ WordPress transients cleared<br>";

// Clear rewrite rules
flush_rewrite_rules();
echo "✅ Rewrite rules flushed<br>";

// Clear plugin cache
if (function_exists('wp_cache_delete')) {
    wp_cache_delete('plugins', 'plugins');
    echo "✅ Plugin cache cleared<br>";
}

// Clear theme cache
if (function_exists('wp_cache_delete')) {
    wp_cache_delete('themes', 'themes');
    echo "✅ Theme cache cleared<br>";
}

echo "<br><strong>🎉 All caches cleared successfully!</strong><br><br>";
echo "<a href='" . admin_url('admin.php?page=gtub-bookings') . "'>→ Go to Unified Bookings</a><br>";
echo "<a href='" . admin_url() . "'>→ Go to Dashboard</a><br>";
echo "<a href='javascript:history.back()'>← Go Back</a>";


