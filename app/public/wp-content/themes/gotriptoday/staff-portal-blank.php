<?php
/**
 * Template Name: Staff Portal (Blank)
 * Template Post Type: page
 * 
 * Clean template for Staff Portal - No header, footer, or hero section
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Check permissions
if (!is_user_logged_in() || !current_user_can('edit_posts')) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo get_bloginfo('name'); ?> - Staff Portal</title>
    <?php wp_head(); ?>
    <style>
        /* Remove all theme styling */
        body {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
            background: #f5f7fa;
        }
        
        /* Hide WordPress admin bar */
        #wpadminbar {
            display: none !important;
        }
        
        html {
            margin-top: 0 !important;
        }
        
        /* Ensure staff portal takes full viewport */
        .gtub-staff-portal {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        /* Hide ALL theme elements */
        .site-header,
        .site-footer,
        .hero-section,
        .fleet-hero-section,
        header:not(.gtub-sidebar-header),
        footer:not(.gtub-sidebar-footer),
        nav.main-nav,
        .breadcrumb,
        .page-header,
        .site-branding,
        .main-navigation,
        .site-info,
        .widget-area,
        #masthead,
        #colophon,
        .entry-header,
        .entry-footer {
            display: none !important;
        }
        
        /* Remove any container padding */
        .container,
        .site-content,
        #content,
        #primary,
        .content-area {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
    </style>
</head>
<body <?php body_class('staff-portal-blank-template'); ?>>

<?php
// Output only the staff portal content
while (have_posts()) : the_post();
    the_content();
endwhile;
?>

<?php wp_footer(); ?>
</body>
</html>


