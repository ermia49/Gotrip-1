<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
    <?php if (is_front_page() || is_home()): 
        // Homepage SEO Optimization
        $page_title = 'GoTrip Today | Premium Transfers & Day Trips';
        $page_description = 'Book luxury daily transfers, airport rides, and private day trips with professional chauffeurs in Frankfurt and Germany. Compare trusted providers and get instant confirmation.';
        $page_keywords = 'Frankfurt airport transfer, private transfers Germany, chauffeur service Frankfurt, day trips from Frankfurt, car with driver Germany, FRA airport taxi, executive transfer Frankfurt, Germany travel marketplace, book transfer Frankfurt, licensed chauffeurs Germany, Rhine Valley tour, Heidelberg day trip';
    ?>
    <title><?php echo esc_html($page_title); ?></title>
    <meta name="description" content="<?php echo esc_attr($page_description); ?>">
    <meta name="keywords" content="<?php echo esc_attr($page_keywords); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?php echo esc_url(home_url('/')); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
    <meta property="og:title" content="<?php echo esc_attr($page_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($page_description); ?>">
    <meta property="og:site_name" content="GoTrip Today">
    
    <!-- Twitter Card -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo esc_url(home_url('/')); ?>">
    <meta property="twitter:title" content="<?php echo esc_attr($page_title); ?>">
    <meta property="twitter:description" content="<?php echo esc_attr($page_description); ?>">
    
    <?php elseif (is_page_template('temp-fleet.php')): 
        // Fleet page title is handled by template - skip duplicate
    ?>
    
    <?php elseif (is_search()): ?>
    <meta name="robots" content="noindex, nofollow" />
    <title>
        <?php
            global $page, $paged, $post;			
            wp_title( '|', true, 'right' );
            bloginfo( 'name' );
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Page %s', 'wpv' ), max( $paged, $page ) );
        ?>
    </title>
    <?php else: ?>
    <title>
        <?php
            global $page, $paged, $post;			
            wp_title( '|', true, 'right' );
            bloginfo( 'name' );
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                echo " | $site_description";
            if ( $paged >= 2 || $page >= 2 )
                echo ' | ' . sprintf( __( 'Page %s', 'wpv' ), max( $paged, $page ) );
        ?>
    </title>
    <?php endif; ?>
    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/tabler-icons.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/nice-select2.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/venobox.min.css">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>
    
    <?php 
    // Homepage Schema Markup
    if (is_front_page() || is_home()): 
    ?>
    <!-- Schema.org Markup for Homepage -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "TravelAgency",
      "name": "GoTrip Today",
      "description": "Premium private transfers and day trips marketplace connecting customers with professional chauffeur services",
      "url": "<?php echo esc_url(home_url('/')); ?>",
      "logo": "<?php echo get_template_directory_uri(); ?>/assets/images/logo.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "Customer Service",
        "availableLanguage": ["en", "de"]
      },
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Transfer & Day Trip Services",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Private Transfers",
              "description": "Premium private transfer services with professional chauffeurs"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Airport Transfers",
              "description": "Reliable airport chauffeur and taxi services"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Day Trips",
              "description": "Luxury private day trips and sightseeing tours"
            }
          }
        ]
      }
    }
    </script>
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "<?php echo esc_url(home_url('/')); ?>"
      }]
    }
    </script>
    <?php endif; ?>
    
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/custom.css">
</head>

<body <?php body_class(); ?>>
    <?php
        if ( ! is_page_template( 'temp-transfer.php' ) ) { ?>
            <div class="preloader" id="preloader">
                <div class="spinner-grow" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
    <?php } ?>
    <header class="header-area style-three">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-xl">
                <a class="navbar-brand" href="<?php bloginfo('url'); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" width="190"
                        alt="<?php bloginfo('name'); ?>">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#touriaNav"
                    aria-controls="touriaNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti ti-menu-deep"></i>
                </button>
                <!-- Navbar Nav -->
                <div class="collapse justify-content-xl-end navbar-collapse" id="touriaNav">
                    <?php wp_nav_menu([
						'theme_location' => 'main',
						'container' => false,
						'menu_class' => 'navbar-nav align-items-xl-center navbar-nav-scroll',
						'walker' => new Touria_Walker_Nav_Menu()
					]); ?>
                    <div class="header-navigation d-flex flex-wrap align-items-center gap-3 mt-4 mt-xl-0">
                        <div class="header-search-btn">
                            <a href="<?php echo is_user_logged_in() ? site_url('/my-account/orders/') : site_url('/login')  ?>"
                                class="btn">
                                <i class="ti ti-user-check"></i>
                            </a>
                        </div>
                        <a class="btn btn-success" href="<?php echo home_url('/custom-booking'); ?>">Get A Quote<i
                                class="icon-arrow-right"></i></a>
                    </div>
                </div>
            </nav>
        </div>
    </header>