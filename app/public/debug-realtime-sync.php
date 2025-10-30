<?php
/**
 * Deep Debug - Real-Time Sync
 */

require_once('wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied');
}

// Force load the classes
if (!class_exists('GTUB_Realtime_Sync')) {
    require_once(WP_PLUGIN_DIR . '/gotrip-unified-booking/includes/class-realtime-sync.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Deep Debug - Real-Time Sync</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1e1e1e; color: #d4d4d4; }
        .section { margin: 20px 0; padding: 20px; border: 1px solid #444; background: #2d2d2d; }
        .success { color: #4caf50; }
        .error { color: #f44336; }
        .warning { color: #ff9800; }
        pre { background: #1e1e1e; padding: 10px; overflow: auto; }
        .button { background: #0066cc; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>🔍 Deep Debug - Real-Time Sync</h1>
    
    <div class="section">
        <h2>1. PHP Classes Check</h2>
        <?php
        echo "GTUB_Realtime_Sync exists: ";
        if (class_exists('GTUB_Realtime_Sync')) {
            echo "<span class='success'>✅ YES</span><br>";
            $methods = get_class_methods('GTUB_Realtime_Sync');
            echo "Methods: <pre>" . print_r($methods, true) . "</pre>";
        } else {
            echo "<span class='error'>❌ NO</span><br>";
        }
        
        echo "GTUB_Database_Updater exists: ";
        if (class_exists('GTUB_Database_Updater')) {
            echo "<span class='success'>✅ YES</span><br>";
        } else {
            echo "<span class='error'>❌ NO</span><br>";
        }
        ?>
    </div>
    
    <div class="section">
        <h2>2. Database Check</h2>
        <?php
        global $wpdb;
        $table = $wpdb->prefix . 'gtub_bookings';
        
        // Check table structure
        $columns = $wpdb->get_results("SHOW COLUMNS FROM $table");
        $column_names = array_column($columns, 'Field');
        
        echo "Table exists: ";
        if ($columns) {
            echo "<span class='success'>✅ YES</span><br>";
            echo "Columns: " . implode(', ', $column_names) . "<br>";
            
            // Check updated_at
            if (in_array('updated_at', $column_names)) {
                echo "updated_at column: <span class='success'>✅ EXISTS</span><br>";
                
                // Get column details
                foreach ($columns as $col) {
                    if ($col->Field === 'updated_at') {
                        echo "updated_at details: <pre>" . print_r($col, true) . "</pre>";
                        
                        // Check if ON UPDATE CURRENT_TIMESTAMP is set
                        if (strpos($col->Extra, 'UPDATE CURRENT_TIMESTAMP') !== false) {
                            echo "Auto-update timestamp: <span class='success'>✅ YES</span><br>";
                        } else {
                            echo "Auto-update timestamp: <span class='error'>❌ NO</span><br>";
                            echo "<span class='warning'>⚠️ Need to fix column definition</span><br>";
                        }
                    }
                }
            } else {
                echo "updated_at column: <span class='error'>❌ MISSING</span><br>";
            }
        } else {
            echo "<span class='error'>❌ NO</span><br>";
        }
        ?>
    </div>
    
    <div class="section">
        <h2>3. WordPress Actions Check</h2>
        <?php
        global $wp_filter;
        
        // Check if AJAX actions are registered
        $ajax_actions = array(
            'wp_ajax_gtub_get_updates',
            'wp_ajax_gtub_broadcast_update',
            'wp_ajax_gtub_quick_change_status',
            'wp_ajax_gtub_quick_assign_driver'
        );
        
        foreach ($ajax_actions as $action) {
            echo "$action: ";
            if (isset($wp_filter[$action])) {
                echo "<span class='success'>✅ Registered</span><br>";
                foreach ($wp_filter[$action]->callbacks as $priority => $callbacks) {
                    foreach ($callbacks as $callback) {
                        if (is_array($callback['function'])) {
                            echo "  - Priority $priority: " . $callback['function'][0] . '::' . $callback['function'][1] . "<br>";
                        }
                    }
                }
            } else {
                echo "<span class='error'>❌ NOT registered</span><br>";
            }
        }
        
        // Check script enqueue hooks
        echo "<br>Script enqueue hooks:<br>";
        if (isset($wp_filter['admin_enqueue_scripts'])) {
            foreach ($wp_filter['admin_enqueue_scripts']->callbacks as $priority => $callbacks) {
                foreach ($callbacks as $callback) {
                    if (is_array($callback['function']) && 
                        (strpos($callback['function'][0], 'GTUB') !== false || 
                         strpos($callback['function'][1], 'realtime') !== false)) {
                        echo "  - " . $callback['function'][0] . '::' . $callback['function'][1] . " (priority: $priority)<br>";
                    }
                }
            }
        }
        ?>
    </div>
    
    <div class="section">
        <h2>4. Test AJAX Endpoint</h2>
        <button onclick="testAjax()">Test AJAX Endpoint</button>
        <div id="ajax-result"></div>
        <script>
        function testAjax() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('ajax-result').innerHTML = 
                    '<pre>Status: ' + xhr.status + '\n' +
                    'Response: ' + xhr.responseText + '</pre>';
            };
            xhr.send('action=gtub_get_updates&nonce=<?php echo wp_create_nonce('gtub_realtime_sync'); ?>&last_check=2025-01-01 00:00:00');
        }
        </script>
    </div>
    
    <div class="section">
        <h2>5. Script Files Check</h2>
        <?php
        $plugin_dir = WP_PLUGIN_DIR . '/gotrip-unified-booking/';
        $files_to_check = array(
            'assets/js/realtime-sync.js',
            'assets/css/admin.css',
            'includes/class-realtime-sync.php',
            'includes/class-database-updater.php'
        );
        
        foreach ($files_to_check as $file) {
            echo $file . ": ";
            if (file_exists($plugin_dir . $file)) {
                $size = filesize($plugin_dir . $file);
                echo "<span class='success'>✅ EXISTS</span> (size: " . number_format($size) . " bytes)<br>";
            } else {
                echo "<span class='error'>❌ MISSING</span><br>";
            }
        }
        ?>
    </div>
    
    <div class="section">
        <h2>6. Admin Page Hook Test</h2>
        <?php
        // Simulate admin page hook
        $test_hooks = array(
            'toplevel_page_gtub-bookings',
            'unified-bookings_page_gtub-dashboard',
            'admin_page_gtub-bookings',
            'gtub-bookings'
        );
        
        echo "Testing hook matching:<br>";
        foreach ($test_hooks as $hook) {
            echo "Hook '$hook': ";
            
            // Old check
            if (strpos($hook, 'gtub-') === false) {
                echo "<span class='error'>❌ FAILS old check</span> ";
            } else {
                echo "<span class='success'>✅ PASSES old check</span> ";
            }
            
            // New check
            $allowed_pages = array(
                'toplevel_page_gtub-bookings',
                'unified-bookings_page_gtub-dashboard',
                'unified-bookings_page_gtub-calendar',
                'unified-bookings_page_gtub-reports',
                'unified-bookings_page_gtub-settings',
                'unified-bookings_page_gtub-sync'
            );
            
            if (in_array($hook, $allowed_pages)) {
                echo "<span class='success'>✅ PASSES new check</span>";
            } else {
                echo "<span class='error'>❌ FAILS new check</span>";
            }
            echo "<br>";
        }
        ?>
    </div>
    
    <div class="section">
        <h2>7. Direct Script Test</h2>
        <p>Loading script directly to test:</p>
        <?php
        // Force enqueue the script
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'gtub-realtime-sync-test',
            plugins_url('assets/js/realtime-sync.js', WP_PLUGIN_DIR . '/gotrip-unified-booking/gotrip-unified-booking.php'),
            array('jquery'),
            '1.0.0',
            true
        );
        
        wp_localize_script('gtub-realtime-sync-test', 'gtubRealtime', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gtub_realtime_sync'),
            'interval' => 5000,
            'user_id' => get_current_user_id(),
            'is_admin' => true,
        ));
        
        wp_print_scripts('gtub-realtime-sync-test');
        ?>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== Direct Script Test ===');
            console.log('jQuery loaded:', typeof jQuery !== 'undefined');
            console.log('gtubRealtime loaded:', typeof gtubRealtime !== 'undefined');
            console.log('GTUBRealtimeSync loaded:', typeof GTUBRealtimeSync !== 'undefined');
            
            if (typeof GTUBRealtimeSync !== 'undefined') {
                console.log('GTUBRealtimeSync methods:', Object.keys(GTUBRealtimeSync));
            }
            
            if (typeof gtubRealtime !== 'undefined') {
                console.log('gtubRealtime config:', gtubRealtime);
            }
        });
        </script>
    </div>
    
    <div class="section">
        <h2>8. Manual Update Test</h2>
        <?php
        // Get a test booking
        $test_booking = $wpdb->get_row("SELECT * FROM $table ORDER BY id DESC LIMIT 1");
        if ($test_booking) {
            echo "Test booking: #" . $test_booking->booking_number . " (ID: " . $test_booking->id . ")<br>";
            echo "Current updated_at: " . $test_booking->updated_at . "<br>";
            
            if (isset($_GET['test_update'])) {
                // Test update
                $result = $wpdb->query($wpdb->prepare(
                    "UPDATE $table SET status = %s WHERE id = %d",
                    $test_booking->status,
                    $test_booking->id
                ));
                
                $new_booking = $wpdb->get_row("SELECT * FROM $table WHERE id = " . $test_booking->id);
                echo "After update: " . $new_booking->updated_at . "<br>";
                
                if ($test_booking->updated_at !== $new_booking->updated_at) {
                    echo "<span class='success'>✅ Timestamp auto-updated!</span><br>";
                } else {
                    echo "<span class='error'>❌ Timestamp NOT auto-updated</span><br>";
                }
            }
            ?>
            <br>
            <a href="?test_update=1" class="button">Test Database Update</a>
        <?php } ?>
    </div>
    
    <div class="section">
        <h2>9. Summary</h2>
        <div id="summary"></div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var issues = [];
            
            // Check everything
            if (typeof jQuery === 'undefined') {
                issues.push('❌ jQuery not loaded');
            }
            if (typeof gtubRealtime === 'undefined') {
                issues.push('❌ gtubRealtime config not loaded');
            }
            if (typeof GTUBRealtimeSync === 'undefined') {
                issues.push('❌ GTUBRealtimeSync object not loaded');
            }
            
            var summary = document.getElementById('summary');
            if (issues.length === 0) {
                summary.innerHTML = '<span class="success">✅ All JavaScript components loaded successfully!</span>';
            } else {
                summary.innerHTML = '<span class="error">Issues found:</span><br>' + issues.join('<br>');
            }
        });
        </script>
    </div>
</body>
</html>

