<?php
/**
 * Test Real-Time Sync
 * Access: http://localhost:10003/test-realtime-sync.php
 */

require_once('wp-load.php');

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url($_SERVER['REQUEST_URI']));
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Real-Time Sync</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
        h1 {
            color: #2d5f3f;
            border-bottom: 3px solid #2d5f3f;
            padding-bottom: 10px;
        }
        .test-section {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #2d5f3f;
            border-radius: 4px;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .status.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .code {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        button {
            background: #2d5f3f;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }
        button:hover {
            background: #3d7f5f;
        }
        #console-output {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 4px;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.5;
        }
        .log-entry {
            margin: 5px 0;
            padding: 5px;
            border-left: 3px solid #4caf50;
            padding-left: 10px;
        }
        .log-error {
            border-left-color: #f44336;
        }
        .log-warning {
            border-left-color: #ff9800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Real-Time Sync Test</h1>
        
        <div class="test-section">
            <h2>1. Check if Scripts are Loaded</h2>
            <div id="script-check"></div>
            <button onclick="checkScripts()">Check Scripts</button>
        </div>
        
        <div class="test-section">
            <h2>2. Test AJAX Endpoint</h2>
            <div id="ajax-test"></div>
            <button onclick="testAjax()">Test AJAX</button>
        </div>
        
        <div class="test-section">
            <h2>3. Test Database</h2>
            <div id="db-test"></div>
            <button onclick="testDatabase()">Check Database</button>
        </div>
        
        <div class="test-section">
            <h2>4. Start Real-Time Sync</h2>
            <div id="sync-status"></div>
            <button onclick="startSync()">Start Sync</button>
            <button onclick="stopSync()">Stop Sync</button>
            <button onclick="clearConsole()">Clear Console</button>
        </div>
        
        <div class="test-section">
            <h2>5. Console Output</h2>
            <div id="console-output"></div>
        </div>
        
        <div class="test-section">
            <h2>6. Quick Actions</h2>
            <button onclick="window.location.href='/wp-admin/admin.php?page=gtub-bookings'">Go to Admin Bookings</button>
            <button onclick="window.location.href='/staff-portal/'">Go to Staff Portal</button>
            <button onclick="window.location.href='/check-and-fix-db.php'">Fix Database</button>
        </div>
    </div>
    
    <?php wp_footer(); ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let syncInterval;
        let lastCheck = getCurrentTimestamp();
        
        function log(message, type = 'info') {
            const output = document.getElementById('console-output');
            const entry = document.createElement('div');
            entry.className = 'log-entry' + (type === 'error' ? ' log-error' : type === 'warning' ? ' log-warning' : '');
            entry.textContent = '[' + new Date().toLocaleTimeString() + '] ' + message;
            output.appendChild(entry);
            output.scrollTop = output.scrollHeight;
        }
        
        function clearConsole() {
            document.getElementById('console-output').innerHTML = '';
            log('Console cleared');
        }
        
        function checkScripts() {
            const output = document.getElementById('script-check');
            let html = '';
            
            // Check if jQuery is loaded
            if (typeof jQuery !== 'undefined') {
                html += '<div class="status success">✅ jQuery is loaded (v' + jQuery.fn.jquery + ')</div>';
                log('✅ jQuery loaded');
            } else {
                html += '<div class="status error">❌ jQuery is NOT loaded</div>';
                log('❌ jQuery NOT loaded', 'error');
            }
            
            // Check if realtime sync script is loaded
            const scripts = document.querySelectorAll('script[src*="realtime-sync"]');
            if (scripts.length > 0) {
                html += '<div class="status success">✅ realtime-sync.js is loaded</div>';
                log('✅ realtime-sync.js loaded');
            } else {
                html += '<div class="status error">❌ realtime-sync.js is NOT loaded</div>';
                log('❌ realtime-sync.js NOT loaded', 'error');
            }
            
            // Check if GTUBRealtimeSync object exists
            if (typeof GTUBRealtimeSync !== 'undefined') {
                html += '<div class="status success">✅ GTUBRealtimeSync object exists</div>';
                log('✅ GTUBRealtimeSync object exists');
            } else {
                html += '<div class="status error">❌ GTUBRealtimeSync object does NOT exist</div>';
                log('❌ GTUBRealtimeSync NOT defined', 'error');
            }
            
            // Check if gtubRealtime config exists
            if (typeof gtubRealtime !== 'undefined') {
                html += '<div class="status success">✅ gtubRealtime config exists</div>';
                html += '<div class="code">ajaxurl: ' + gtubRealtime.ajaxurl + '<br>';
                html += 'nonce: ' + gtubRealtime.nonce + '<br>';
                html += 'interval: ' + gtubRealtime.interval + 'ms</div>';
                log('✅ gtubRealtime config exists');
            } else {
                html += '<div class="status error">❌ gtubRealtime config does NOT exist</div>';
                log('❌ gtubRealtime NOT defined', 'error');
            }
            
            output.innerHTML = html;
        }
        
        function testAjax() {
            const output = document.getElementById('ajax-test');
            output.innerHTML = '<div class="status info">🔄 Testing AJAX endpoint...</div>';
            log('Testing AJAX endpoint...');
            
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'gtub_get_updates',
                    nonce: '<?php echo wp_create_nonce('gtub_realtime_sync'); ?>',
                    last_check: '2025-01-01 00:00:00'
                },
                success: function(response) {
                    log('✅ AJAX Success: ' + JSON.stringify(response).substring(0, 100) + '...');
                    output.innerHTML = '<div class="status success">✅ AJAX endpoint is working!</div>';
                    output.innerHTML += '<div class="code">' + JSON.stringify(response, null, 2) + '</div>';
                },
                error: function(xhr, status, error) {
                    log('❌ AJAX Error: ' + error, 'error');
                    output.innerHTML = '<div class="status error">❌ AJAX Error: ' + error + '</div>';
                    output.innerHTML += '<div class="code">Status: ' + xhr.status + '<br>Response: ' + xhr.responseText + '</div>';
                }
            });
        }
        
        function testDatabase() {
            const output = document.getElementById('db-test');
            output.innerHTML = '<div class="status info">🔄 Checking database...</div>';
            log('Checking database...');
            
            jQuery.ajax({
                url: '/check-and-fix-db.php',
                type: 'GET',
                success: function(response) {
                    log('✅ Database check complete');
                    output.innerHTML = '<div class="status success">✅ Database check complete</div>';
                    output.innerHTML += '<div class="status info">Open <a href="/check-and-fix-db.php" target="_blank">check-and-fix-db.php</a> in new tab for details</div>';
                },
                error: function() {
                    log('❌ Database check failed', 'error');
                    output.innerHTML = '<div class="status error">❌ Could not check database</div>';
                }
            });
        }
        
        function startSync() {
            const output = document.getElementById('sync-status');
            output.innerHTML = '<div class="status success">✅ Sync started - checking every 5 seconds</div>';
            log('🔄 Starting real-time sync...');
            
            if (syncInterval) {
                clearInterval(syncInterval);
            }
            
            // Start polling
            syncInterval = setInterval(function() {
                checkForUpdates();
            }, 5000);
            
            // First check immediately
            checkForUpdates();
        }
        
        function stopSync() {
            if (syncInterval) {
                clearInterval(syncInterval);
                syncInterval = null;
            }
            const output = document.getElementById('sync-status');
            output.innerHTML = '<div class="status info">⏸️ Sync stopped</div>';
            log('⏸️ Sync stopped');
        }
        
        function checkForUpdates() {
            log('🔍 Checking for updates since: ' + lastCheck);
            
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'gtub_get_updates',
                    nonce: '<?php echo wp_create_nonce('gtub_realtime_sync'); ?>',
                    last_check: lastCheck
                },
                success: function(response) {
                    if (response.success) {
                        if (response.data.has_updates) {
                            log('📥 Updates found: ' + response.data.bookings.length + ' bookings, ' + response.data.activities.length + ' activities', 'warning');
                        } else {
                            log('✓ No updates');
                        }
                        
                        if (response.data.timestamp) {
                            lastCheck = response.data.timestamp;
                        }
                    } else {
                        log('❌ Error: ' + response.data.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    log('❌ AJAX Error: ' + error, 'error');
                }
            });
        }
        
        function getCurrentTimestamp() {
            const now = new Date();
            return now.getFullYear() + '-' +
                   ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
                   ('0' + now.getDate()).slice(-2) + ' ' +
                   ('0' + now.getHours()).slice(-2) + ':' +
                   ('0' + now.getMinutes()).slice(-2) + ':' +
                   ('0' + now.getSeconds()).slice(-2);
        }
        
        // Auto-check scripts on load
        window.addEventListener('load', function() {
            log('🚀 Test page loaded');
            setTimeout(checkScripts, 500);
        });
    </script>
</body>
</html>


