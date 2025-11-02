<?php 
       add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 140, 140, true );
	add_image_size( 'single-post-thumbnail', 300, 9999 );
    add_image_size( 'tour-thumbnail', 300, 200, true );
    add_image_size('tour_slide', 1350, 500, true); // true = hard crop

    add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
    function mytheme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    
    include_once('inc/class-walker-touria.php');
    include_once('inc/extra.php');
    
    // Load SEO Configuration
    if (file_exists(get_template_directory() . '/inc/seo-config.php')) {
        include_once('inc/seo-config.php');
    }
    
    // Load SEO Analytics & Tracking
    if (file_exists(get_template_directory() . '/inc/seo-analytics.php')) {
        include_once('inc/seo-analytics.php');
    }

	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
		// Declare sidebar widget zone
	if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h4>',
    		'after_title'   => '</h4>'
    	));
    }

function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}

if (function_exists('register_nav_menus')) {
register_nav_menus( array(
		'main' => __( 'Main Menu', '' ),
		'footer_routes' => __( 'Footer Routes Menu', '' ),
        'footer_offer' => __( 'Footer Offer Menu', '' ),
        'footer_legal' => __( 'Footer Legaal Menu', '' ),
	) );
}


function fallbackmenu1(){ ?>
<div id="menu">
    <ul>
        <li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus
            to work.</li>
    </ul>
</div>
<?php }

function fallbackmenu2(){ ?>
<div id="menu">
    <ul>
        <li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus
            to work.</li>
    </ul>
</div>
<?php }

function add_more_buttons($buttons) {
 $buttons[] = 'hr';
 $buttons[] = 'del';
 $buttons[] = 'sub';
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 $buttons[] = 'lineheight';
 return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");

function add_first_and_last($items) {
    $items[1]->classes[] = 'first-menu-item';
    $items[count($items)]->classes[] = 'last-menu-item';
    return $items;
}
 
add_filter('wp_nav_menu_objects', 'add_first_and_last');

function enqueue_ajax_contact_form_script() {
    wp_enqueue_script('ajax-contact', get_stylesheet_directory_uri() . '/assets/js/ajax.js', array('jquery'), null, true);
    wp_localize_script('ajax-contact', 'ajaxContact', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ajax-contact-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_contact_form_script');

// Enqueue Home Page Contact Form Assets
function enqueue_home_contact_form_assets() {
    // Only load on homepage
    if (is_front_page() || is_page_template('home.php')) {
        // Enqueue contact form CSS
        wp_enqueue_style(
            'home-contact-form',
            get_stylesheet_directory_uri() . '/assets/css/home-contact.css',
            array(),
            '1.0.0'
        );
        
        // Get reCAPTCHA site key from wp-config.php or options
        $recaptcha_site_key = defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : get_option('recaptcha_site_key', 'YOUR_RECAPTCHA_SITE_KEY_HERE');
        
        // Enqueue reCAPTCHA v3 script
        if ($recaptcha_site_key && $recaptcha_site_key !== 'YOUR_RECAPTCHA_SITE_KEY_HERE') {
            wp_enqueue_script(
                'google-recaptcha',
                'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_site_key,
                array(),
                null,
                false
            );
        }
        
        // Enqueue contact form JavaScript
        wp_enqueue_script(
            'home-contact-form',
            get_stylesheet_directory_uri() . '/assets/js/home-contact.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        // Localize script with AJAX URL and reCAPTCHA key
        wp_localize_script('home-contact-form', 'homeContactVars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'recaptcha_key' => $recaptcha_site_key
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_home_contact_form_assets');

// Preload hero image for LCP optimization
add_action('wp_head', function () {
    if (is_front_page() || is_page_template('home.php')) {
        $hero = get_template_directory_uri() . '/assets/img/bg-img/slide1.webp';
        echo '<link rel="preload" as="image" href="' . esc_url($hero) . '" imagesizes="100vw" fetchpriority="high">' . "\n";
    }
}, 1);

// Enqueue booking page assets with maximum priority
function enqueue_booking_page_assets() {
    if (is_page('booking-page') || is_page_template('temp-transfer.php')) {
        wp_enqueue_style(
            'booking-page',
            get_stylesheet_directory_uri() . '/assets/css/booking-page.css',
            array(),
            '2.0.' . time()
        );

        wp_enqueue_script(
            'booking-page',
            get_stylesheet_directory_uri() . '/assets/js/booking-page.js',
            array(),
            '2.0.' . time(),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_booking_page_assets', 9999);





// Enqueue checkout page assets
function enqueue_checkout_page_assets() {
    if (is_checkout() || is_wc_endpoint_url('order-pay')) {
        wp_enqueue_style(
            'checkout-page',
            get_stylesheet_directory_uri() . '/assets/css/checkout-page.css',
            array(),
            '1.0.' . time()
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_checkout_page_assets');

// Enqueue global page gradient background
function enqueue_page_gradient_assets() {
    wp_enqueue_style(
        'page-gradient',
        get_stylesheet_directory_uri() . '/assets/css/page-gradient.css',
        array(),
        '1.0.' . time()
    );
}
add_action('wp_enqueue_scripts', 'enqueue_page_gradient_assets', 5);


function enqueue_wishlist_script() {
    if (is_singular('tours') || is_page_template('wishlist.php')) { 
        // enqueue on single tour AND wishlist page
        wp_enqueue_script(
            'wishlist-script',
            get_stylesheet_directory_uri() . '/assets/js/wishlist.js',
            array('jquery'),
            null,
            true
        );
        wp_localize_script('wishlist-script', 'wpvars', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_wishlist_script');



function get_tour_details_ajax() {
    if (isset($_GET['tour_id'])) {
        $tour_id = intval($_GET['tour_id']);
        $tour = get_post($tour_id);

        // ✅ Correct post type check
        if ($tour && $tour->post_type === 'tours') {
            wp_send_json(array(
                'title'     => get_the_title($tour_id),
                'permalink' => get_permalink($tour_id),
                'thumbnail' => get_the_post_thumbnail_url($tour_id, 'thumbnail') // optional
            ));
        }
    }
    wp_send_json_error('Invalid tour ID');
}
add_action('wp_ajax_get_tour_details', 'get_tour_details_ajax');
add_action('wp_ajax_nopriv_get_tour_details', 'get_tour_details_ajax');



function get_tour_comments($post_id) {
    $args = array(
        'post_id' => $post_id,
        'status'  => 'approve', // only approved comments
        'order'   => 'DESC',    // newest first
    );

    $comments = get_comments($args);
    $data = array();

    foreach ($comments as $comment) {
        $rating = get_comment_meta($comment->comment_ID, 'rating', true);

        $data[] = array(
            'comment_ID' => $comment->comment_ID,
            'author'     => $comment->comment_author,
            'content'    => $comment->comment_content,
            'date'       => get_comment_date('', $comment),
            'rating'     => $rating ? intval($rating) : null,
        );
    }

    return $data;
}


// Hide admin bar for non-admins
add_filter('show_admin_bar', function($show) {
    return current_user_can('manage_options') ? $show : false;
});



add_filter('woocommerce_get_checkout_order_received_url', 'mufaqar_custom_thankyou_redirect', 10, 2);
function mufaqar_custom_thankyou_redirect($order_received_url, $order) {
    // Redirect after successful checkout
    return home_url('/thank-you/?order_id=' . $order->get_id());
}

// SEO Enhancements - Image Optimization & Lazy Loading
add_filter('wp_get_attachment_image_attributes', 'add_lazy_loading_and_alt_text', 10, 3);
function add_lazy_loading_and_alt_text($attr, $attachment, $size) {
    // Add lazy loading
    $attr['loading'] = 'lazy';
    
    // Improve alt text if empty
    if (empty($attr['alt'])) {
        $post_title = get_the_title($attachment->ID);
        $attr['alt'] = $post_title ? $post_title . ' - Frankfurt transfers & Germany day trips' : 'Premium vehicle for private transfer service';
    }
    
    return $attr;
}

// Add width and height attributes to images for better SEO
add_filter('wp_get_attachment_image_src', 'add_image_dimensions', 10, 4);
function add_image_dimensions($image, $attachment_id, $size, $icon) {
    if ($image) {
        $metadata = wp_get_attachment_metadata($attachment_id);
        if ($metadata && isset($metadata['width']) && isset($metadata['height'])) {
            return array(
                $image[0],
                $metadata['width'],
                $metadata['height'],
                $image[3]
            );
        }
    }
    return $image;
}

// SEO-friendly permalink structure
add_action('init', 'setup_seo_permalinks');
function setup_seo_permalinks() {
    // Ensure pretty permalinks are enabled
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    flush_rewrite_rules();
}

// Add Open Graph images
add_action('wp_head', 'add_open_graph_images', 5);
function add_open_graph_images() {
    if (is_singular() && has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        echo '<meta property="og:image" content="' . esc_url($image_url) . '">' . "\n";
        echo '<meta property="twitter:image" content="' . esc_url($image_url) . '">' . "\n";
    } elseif (is_front_page() || is_home()) {
        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
        echo '<meta property="og:image" content="' . esc_url($logo_url) . '">' . "\n";
        echo '<meta property="twitter:image" content="' . esc_url($logo_url) . '">' . "\n";
    }
}

// Optimize WordPress Head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Enable WebP support
add_filter('mime_types', 'enable_webp_upload');
function enable_webp_upload($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}

// Add async/defer to scripts for better page speed
add_filter('script_loader_tag', 'add_async_defer_attributes', 10, 3);
function add_async_defer_attributes($tag, $handle, $src) {
    // Don't add async/defer to jQuery or critical scripts
    $async_scripts = array('bootstrap', 'swiper', 'nice-select');
    $defer_scripts = array('venobox', 'flatpickr');
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}

// Contact Form Handler
add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');

function handle_contact_form_submission() {
    // Verify nonce for security
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'contact_form_nonce')) {
        wp_send_json_error(array('message' => 'Security verification failed'));
        return;
    }
    
    // Verify reCAPTCHA token
    if (isset($_POST['recaptcha_token'])) {
        $recaptcha_token = sanitize_text_field($_POST['recaptcha_token']);
        $recaptcha_secret = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : get_option('recaptcha_secret_key', '');
        
        if (!empty($recaptcha_secret) && $recaptcha_secret !== 'YOUR_RECAPTCHA_SECRET_KEY_HERE') {
            // Verify reCAPTCHA with Google
            $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
            $response = wp_remote_post($verify_url, array(
                'body' => array(
                    'secret' => $recaptcha_secret,
                    'response' => $recaptcha_token,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                )
            ));
            
            if (!is_wp_error($response)) {
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                
                // Check if reCAPTCHA verification failed or score is too low
                if (!$response_body['success'] || (isset($response_body['score']) && $response_body['score'] < 0.5)) {
                    wp_send_json_error(array('message' => 'reCAPTCHA verification failed. Please try again.'));
                    return;
                }
            }
        }
    }
    
    // Sanitize input
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields'));
        return;
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address'));
        return;
    }
    
    // Admin email
    $admin_email = get_option('admin_email');
    
    // Email subject
    $email_subject = 'Contact Form: ' . $subject;
    
    // Email body
    $email_body = "You have received a new message from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    if (!empty($phone)) {
        $email_body .= "Phone: $phone\n";
    }
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";
    
    // Email headers
    $headers = array(
        'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
        'Content-Type: text/plain; charset=UTF-8'
    );
    
    // Send email
    $sent = wp_mail($admin_email, $email_subject, $email_body, $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Thank you! Your message has been sent successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to send email. Please try again or contact us directly.'));
    }
}