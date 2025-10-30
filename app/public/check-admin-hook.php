<?php
/**
 * Check Admin Hook
 */

require_once('wp-load.php');

if (!is_admin() || !current_user_can('manage_options')) {
    wp_redirect(admin_url('admin.php?page=gtub-bookings'));
    exit;
}

// Hook into admin_enqueue_scripts to see what hook is passed
add_action('admin_enqueue_scripts', function($hook) {
    ?>
    <script>
    console.log('=== ADMIN HOOK DEBUG ===');
    console.log('Current hook:', '<?php echo esc_js($hook); ?>');
    console.log('Page:', '<?php echo esc_js($_GET['page'] ?? ''); ?>');
    </script>
    <?php
    
    // Test if scripts should load
    $allowed_pages = array(
        'toplevel_page_gtub-bookings',
        'unified-bookings_page_gtub-dashboard',
        'unified-bookings_page_gtub-calendar',
        'unified-bookings_page_gtub-reports',
        'unified-bookings_page_gtub-settings',
        'unified-bookings_page_gtub-sync'
    );
    
    ?>
    <script>
    console.log('Should load scripts:', <?php echo in_array($hook, $allowed_pages) ? 'true' : 'false'; ?>);
    console.log('Allowed pages:', <?php echo json_encode($allowed_pages); ?>);
    </script>
    <?php
});

// Redirect to bookings page
wp_redirect(admin_url('admin.php?page=gtub-bookings'));
exit;

