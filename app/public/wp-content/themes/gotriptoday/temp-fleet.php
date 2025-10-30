<?php
/*Template Name: Fleet */

// SEO & Schema Markup - Add to wp_head
add_action('wp_head', function() {
    if (!is_page_template('temp-fleet.php')) return;
    
    $page_title = 'Premium Fleet: Luxury & Economy Vehicles | Frankfurt Airport Transfers & Germany Chauffeur Service';
    $page_description = 'Browse our premium fleet of luxury sedans, executive vans, and economy vehicles for Frankfurt airport transfers and Germany chauffeur service. Mercedes S-Class, BMW 7 Series, passenger vans, and budget-friendly options. Professional drivers, 24/7 availability, instant booking.';
    $page_url = home_url($_SERVER['REQUEST_URI']);
    $site_name = get_bloginfo('name');
    ?>
    <!-- Page Title -->
    <title><?php echo esc_html($page_title); ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo esc_attr($page_description); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?php echo esc_url($page_url); ?>">
    
    <!-- Open Graph -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo esc_attr($page_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($page_description); ?>">
    <meta property="og:url" content="<?php echo esc_url($page_url); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($page_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($page_description); ?>">
    
    <!-- Schema.org - Service with Fleet -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoRental",
      "name": "<?php echo esc_js($site_name); ?> - Premium Fleet Services",
      "description": "<?php echo esc_js($page_description); ?>",
      "url": "<?php echo esc_url($page_url); ?>",
      "image": "<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Frankfurt",
        "addressRegion": "Hesse",
        "addressCountry": "DE"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "50.1109",
        "longitude": "8.6821"
      },
      "areaServed": [
        {
          "@type": "City",
          "name": "Frankfurt",
          "containedIn": {
            "@type": "Country",
            "name": "Germany"
          }
        },
        {
          "@type": "City",
          "name": "Heidelberg"
        },
        {
          "@type": "City",
          "name": "Munich"
        },
        {
          "@type": "City",
          "name": "Stuttgart"
        }
      ],
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Premium Fleet Vehicles",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Car",
              "name": "Luxury Sedans",
              "description": "Mercedes S-Class, BMW 7 Series, Audi A8 for executive airport transfers",
              "vehicleSeatingCapacity": "3-4 passengers",
              "brand": {
                "@type": "Brand",
                "name": "Mercedes-Benz, BMW, Audi"
              }
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Car",
              "name": "Executive Vans",
              "description": "Mercedes V-Class, Premium Sprinter for group transfers",
              "vehicleSeatingCapacity": "7-12 passengers",
              "brand": {
                "@type": "Brand",
                "name": "Mercedes-Benz"
              }
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Car",
              "name": "Economy Sedans",
              "description": "Volkswagen Passat, Toyota Camry for budget-friendly transfers",
              "vehicleSeatingCapacity": "3-4 passengers",
              "brand": {
                "@type": "Brand",
                "name": "Volkswagen, Toyota"
              }
            }
          }
        ]
      },
      "priceRange": "€€-€€€€",
      "telephone": "+49-XXX-XXXXXXX",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "00:00",
        "closes": "23:59"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "350",
        "bestRating": "5",
        "worstRating": "1"
      }
    }
    </script>
    
    <!-- Schema.org - Breadcrumb -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "<?php echo esc_url(home_url('/')); ?>"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Fleet Vehicles",
          "item": "<?php echo esc_url($page_url); ?>"
        }
      ]
    }
    </script>
    <?php
}, 1);

get_header(); 
?>

<!-- Fleet Page Styles -->
<style>
/* Professional Fleet Page Design */
.fleet-page {
    background: #f8f9fa;
    padding: 80px 0 60px;
}

.fleet-hero-section {
    text-align: center;
    margin-bottom: 50px;
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
    margin-top: -150px;
    padding: 210px 15px 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.fleet-hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(60, 179, 113, 0.9) 0%, rgba(46, 153, 96, 0.85) 100%);
    z-index: 1;
}

.fleet-hero-section::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    z-index: 2;
    animation: drift 20s linear infinite;
}

@keyframes drift {
    from { transform: translate(0, 0); }
    to { transform: translate(50px, 50px); }
}

.fleet-hero-section > * {
    position: relative;
    z-index: 3;
}

.fleet-hero-section h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 20px;
    line-height: 1.2;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    letter-spacing: -0.5px;
}

.fleet-hero-section p {
    font-size: clamp(1rem, 2.5vw, 1.25rem);
    color: rgba(255, 255, 255, 0.95);
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
}

/* Fleet Service Badges */
.fleet-stats {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 40px 0;
    flex-wrap: wrap;
    padding: 0 15px;
}

.fleet-stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 24px;
    background: #fff;
    border-radius: 50px;
    border: 2px solid #e5e5e5;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    font-size: clamp(0.8rem, 2vw, 0.95rem);
}

.fleet-stat-item:hover {
    transform: translateY(-3px);
    border-color: #3cb371;
    box-shadow: 0 6px 20px rgba(60, 179, 113, 0.2);
}

.fleet-stat-icon {
    font-size: clamp(20px, 3vw, 24px);
    color: #3cb371;
    flex-shrink: 0;
}

.fleet-stat-label {
    font-size: inherit;
    color: #161920;
    font-weight: 600;
    white-space: nowrap;
}

/* Fleet Tabs */
.fleet-tabs-wrapper {
    margin-bottom: 50px;
    padding: 0 15px;
}

#fleetTabs {
    background: #fff;
    padding: 12px;
    border-radius: 50px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    display: inline-flex;
    gap: 8px;
}

#fleetTabs .nav-link {
    background: transparent;
    border: none;
    color: #161920;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: clamp(0.9rem, 2vw, 16px);
    transition: all 0.3s ease;
    white-space: nowrap;
}

#fleetTabs .nav-link:hover {
    color: #3cb371;
    background: rgba(60, 179, 113, 0.1);
}

#fleetTabs .nav-link.active {
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    color: #fff;
    box-shadow: 0 4px 15px rgba(60, 179, 113, 0.4);
}

#fleetTabs .nav-link i {
    font-size: clamp(16px, 2.5vw, 18px);
    margin-right: 6px;
}

/* Vehicle Cards - Professional Grid */
.vehicle-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(100%, 350px), 1fr));
    gap: 25px;
    margin-top: 30px;
    padding: 0 15px;
}

.vehicle-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.vehicle-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

.vehicle-image-wrapper {
    position: relative;
    width: 100%;
    height: 240px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.vehicle-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    transition: transform 0.6s ease;
    padding: 10px;
}

.vehicle-card:hover .vehicle-image {
    transform: scale(1.05);
}

.vehicle-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    color: #fff;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: clamp(11px, 2vw, 12px);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(60, 179, 113, 0.4);
}

.vehicle-card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.vehicle-title {
    font-size: clamp(1.1rem, 3vw, 1.4rem);
    font-weight: 700;
    color: #161920;
    margin-bottom: 8px;
    line-height: 1.3;
}

.vehicle-title a {
    color: #161920;
    text-decoration: none;
    transition: color 0.3s ease;
}

.vehicle-title a:hover {
    color: #3cb371;
}

.vehicle-subtitle {
    font-size: clamp(0.85rem, 2vw, 0.9rem);
    color: #767676;
    margin-bottom: 16px;
    line-height: 1.4;
}

.vehicle-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid #e5e5e5;
}

.vehicle-feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: clamp(0.8rem, 2vw, 0.9rem);
    color: #555;
}

.vehicle-feature-item i {
    font-size: clamp(18px, 3vw, 20px);
    color: #3cb371;
    flex-shrink: 0;
}

.vehicle-cta {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e5e5e5;
}

.vehicle-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    color: #fff;
    text-align: center;
    border-radius: 10px;
    font-weight: 600;
    font-size: clamp(0.9rem, 2vw, 1rem);
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(60, 179, 113, 0.3);
}

.vehicle-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(60, 179, 113, 0.4);
    color: #fff;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin: 0 15px;
}

.empty-state i {
    font-size: clamp(3rem, 8vw, 4rem);
    color: #e5e5e5;
    margin-bottom: 20px;
}

.empty-state p {
    font-size: clamp(0.95rem, 2vw, 1.1rem);
    color: #767676;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .vehicle-grid {
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr));
        gap: 20px;
    }
}

@media (max-width: 991px) {
    .fleet-page {
        padding: 60px 0 50px;
    }
    
    .fleet-hero-section {
        margin-bottom: 40px;
        margin-top: -120px;
        padding: 180px 15px 60px;
    }
    
    .fleet-stats {
        gap: 15px;
        margin: 30px 0;
    }
    
    .fleet-stat-item {
        padding: 12px 20px;
    }
    
    #fleetTabs {
        flex-direction: column;
        border-radius: 16px;
        padding: 10px;
        width: 100%;
    }
    
    #fleetTabs .nav-link {
        width: 100%;
        text-align: center;
        padding: 12px 20px;
    }
    
    .vehicle-grid {
        gap: 18px;
    }
    
    .vehicle-image-wrapper {
        height: 220px;
    }
    
    .vehicle-card-body {
        padding: 18px;
    }
}

@media (max-width: 767px) {
    .fleet-page {
        padding: 35px 0;
    }
    
    .fleet-hero-section {
        margin-bottom: 30px;
        margin-top: -100px;
        padding: 150px 20px 50px;
    }
    
    .fleet-stats {
        gap: 10px;
        margin: 25px 0;
        padding: 0 20px;
    }
    
    .fleet-stat-item {
        width: 100%;
        padding: 12px 16px;
        justify-content: flex-start;
    }
    
    .fleet-stat-label {
        white-space: normal;
        text-align: left;
    }
    
    .fleet-tabs-wrapper {
        margin-bottom: 35px;
        padding: 0 20px;
    }
    
    #fleetTabs {
        padding: 8px;
        gap: 6px;
    }
    
    #fleetTabs .nav-link {
        padding: 10px 16px;
    }
    
    .vehicle-grid {
        grid-template-columns: 1fr;
        gap: 16px;
        padding: 0 20px;
    }
    
    .vehicle-image-wrapper {
        height: 200px;
    }
    
    .vehicle-card-body {
        padding: 16px;
    }
    
    .vehicle-features {
        gap: 10px;
        padding-top: 12px;
    }
    
    .vehicle-cta {
        margin-top: 12px;
        padding-top: 12px;
    }
    
    .vehicle-btn {
        padding: 11px;
    }
}

@media (max-width: 480px) {
    .fleet-page {
        padding: 30px 0;
    }
    
    .fleet-hero-section {
        margin-top: -90px;
        padding: 140px 15px 45px;
    }
    
    .fleet-stats {
        padding: 0 15px;
    }
    
    .fleet-stat-item {
        padding: 10px 14px;
        gap: 8px;
    }
    
    .fleet-tabs-wrapper {
        padding: 0 15px;
        margin-bottom: 30px;
    }
    
    .vehicle-grid {
        padding: 0 15px;
        gap: 15px;
    }
    
    .vehicle-image-wrapper {
        height: 180px;
    }
    
    .vehicle-card-body {
        padding: 14px;
    }
    
    .vehicle-features {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    
    .empty-state {
        padding: 40px 15px;
        margin: 0;
    }
}

/* Image Optimization */
.vehicle-image {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
}

/* Loading Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.vehicle-card {
    animation: fadeInUp 0.6s ease-out;
}

/* SEO Content Sections Responsive */
@media (max-width: 991px) {
    .fleet-content-sections {
        margin-top: 60px !important;
    }
    
    .fleet-info-section {
        padding: 30px 25px !important;
    }
    
    .fleet-cta-section {
        padding: 40px 30px !important;
    }
}

@media (max-width: 767px) {
    .fleet-content-sections {
        margin-top: 50px !important;
    }
    
    .fleet-info-section {
        padding: 25px 20px !important;
    }
    
    .fleet-cta-section {
        padding: 35px 25px !important;
    }
}

@media (max-width: 480px) {
    .fleet-content-sections {
        margin-top: 40px !important;
        padding: 0 !important;
    }
    
    .fleet-info-section {
        padding: 20px 15px !important;
        border-radius: 12px !important;
    }
    
    .fleet-cta-section {
        padding: 30px 20px !important;
        border-radius: 12px !important;
    }
}
</style>

<section class="fleet-page">
    <div class="container">
        <!-- Fleet Hero Section -->
        <div class="fleet-hero-section">
            <h1>Premium Fleet for Frankfurt Airport Transfers & Germany Chauffeur Service</h1>
            <p>Discover our diverse fleet of luxury sedans, executive vans, and economy vehicles for Frankfurt airport transfers and Germany-wide chauffeur service. From Mercedes S-Class to budget-friendly options, all vehicles feature professional drivers, 24/7 availability, and instant booking confirmation.</p>
            
            <!-- Fleet Service Badges -->
            <div class="fleet-stats">
                <div class="fleet-stat-item">
                    <i class="ti ti-shield-check-filled fleet-stat-icon"></i>
                    <span class="fleet-stat-label">Fully Licensed & Insured</span>
                </div>
                <div class="fleet-stat-item">
                    <i class="ti ti-clock-hour-4 fleet-stat-icon"></i>
                    <span class="fleet-stat-label">24/7 Availability</span>
                </div>
                <div class="fleet-stat-item">
                    <i class="ti ti-user-check fleet-stat-icon"></i>
                    <span class="fleet-stat-label">Professional Chauffeurs</span>
                </div>
                <div class="fleet-stat-item">
                    <i class="ti ti-shield-star fleet-stat-icon"></i>
                    <span class="fleet-stat-label">Premium Service</span>
                </div>
            </div>
        </div>

        <!-- Fleet Category Tabs -->
        <div class="fleet-tabs-wrapper text-center">
            <ul class="nav nav-pills" id="fleetTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                        <i class="ti ti-layout-grid"></i>All Vehicles
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="luxury-tab" data-bs-toggle="pill" data-bs-target="#luxury" type="button" role="tab">
                        <i class="ti ti-crown"></i>Luxury
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="standard-tab" data-bs-toggle="pill" data-bs-target="#standard" type="button" role="tab">
                        <i class="ti ti-car"></i>Standard
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vans-tab" data-bs-toggle="pill" data-bs-target="#vans" type="button" role="tab">
                        <i class="ti ti-bus"></i>Vans & Buses
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="fleetTabsContent">
            <!-- All Vehicles Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="vehicle-grid">
                    <?php
                    $all_args = array(
                        'post_type' => 'cars',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    );
                    $all_query = new WP_Query($all_args);

                    if ($all_query->have_posts()):
                        while ($all_query->have_posts()):
                            $all_query->the_post();
                            $title = strtolower(get_the_title());
                            $passengers = get_post_meta(get_the_ID(), 'passengers', true);
                            $luggage = get_post_meta(get_the_ID(), 'large_bag', true);
                            $equivalent = get_post_meta(get_the_ID(), 'car_equivalent', true);
                            
                            // Determine category badge
                            $badge = 'Standard';
                            if (strpos($title, 'premium sedan') !== false || 
                                strpos($title, 'luxury') !== false ||
                                strpos($title, 's-class') !== false ||
                                strpos($title, 'e-class') !== false ||
                                strpos($title, 'bmw 5') !== false ||
                                strpos($title, 'bmw 7') !== false ||
                                strpos($title, 'audi a6') !== false ||
                                strpos($title, 'audi a8') !== false) {
                                $badge = 'Luxury';
                            } elseif (strpos($title, 'van') !== false || 
                                      strpos($title, 'bus') !== false || 
                                      strpos($title, 'minibus') !== false ||
                                      strpos($title, 'vito') !== false ||
                                      strpos($title, 'sprinter') !== false ||
                                      ($passengers && intval($passengers) >= 7)) {
                                $badge = 'Van';
                            }
                            ?>
                            <div class="vehicle-card">
                                <div class="vehicle-image-wrapper">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" 
                                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                                             class="vehicle-image"
                                             loading="lazy"
                                             width="600"
                                             height="400">
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tour.jpg" 
                                             alt="<?php echo esc_attr(get_the_title()); ?>" 
                                             class="vehicle-image"
                                             loading="lazy">
                                    <?php endif; ?>
                                    <div class="vehicle-badge"><?php echo esc_html($badge); ?></div>
                                </div>
                                <div class="vehicle-card-body">
                                    <h3 class="vehicle-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php if ($equivalent): ?>
                                        <p class="vehicle-subtitle"><?php echo esc_html($equivalent); ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="vehicle-features">
                                        <div class="vehicle-feature-item">
                                            <i class="ti ti-users"></i>
                                            <span><?php echo esc_html($passengers ?: '4'); ?> Passengers</span>
                                        </div>
                                        <div class="vehicle-feature-item">
                                            <i class="ti ti-luggage"></i>
                                            <span><?php echo esc_html($luggage ?: '2'); ?> Luggage</span>
                                        </div>
                                    </div>
                                    
                                    <div class="vehicle-cta">
                                        <a href="<?php the_permalink(); ?>" class="vehicle-btn">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<div class="empty-state"><i class="ti ti-car-off"></i><p>No vehicles available at the moment.</p></div>';
                    endif;
                    ?>
                </div>
            </div>

            <!-- Luxury Tab -->
            <div class="tab-pane fade" id="luxury" role="tabpanel">
                <div class="vehicle-grid">
                    <?php
                    $luxury_args = array(
                        'post_type' => 'cars',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    );
                    $luxury_query = new WP_Query($luxury_args);
                    $luxury_count = 0;

                    if ($luxury_query->have_posts()):
                        while ($luxury_query->have_posts()):
                            $luxury_query->the_post();
                            $title = strtolower(get_the_title());
                            $passengers = get_post_meta(get_the_ID(), 'passengers', true);
                            $luggage = get_post_meta(get_the_ID(), 'large_bag', true);
                            $equivalent = get_post_meta(get_the_ID(), 'car_equivalent', true);
                            
                            if (strpos($title, 'premium sedan') !== false || 
                                strpos($title, 'luxury') !== false ||
                                strpos($title, 's-class') !== false ||
                                strpos($title, 'e-class') !== false ||
                                strpos($title, 'bmw 5') !== false ||
                                strpos($title, 'bmw 7') !== false ||
                                strpos($title, 'audi a6') !== false ||
                                strpos($title, 'audi a8') !== false) {
                                ?>
                                <div class="vehicle-card">
                                    <div class="vehicle-image-wrapper">
                                        <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="vehicle-image"
                                                 loading="lazy"
                                                 width="600"
                                                 height="400">
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tour.jpg" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="vehicle-image"
                                                 loading="lazy">
                                        <?php endif; ?>
                                        <div class="vehicle-badge">Luxury</div>
                                    </div>
                                    <div class="vehicle-card-body">
                                        <h3 class="vehicle-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php if ($equivalent): ?>
                                            <p class="vehicle-subtitle"><?php echo esc_html($equivalent); ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="vehicle-features">
                                            <div class="vehicle-feature-item">
                                                <i class="ti ti-users"></i>
                                                <span><?php echo esc_html($passengers ?: '3'); ?> Passengers</span>
                                            </div>
                                            <div class="vehicle-feature-item">
                                                <i class="ti ti-luggage"></i>
                                                <span><?php echo esc_html($luggage ?: '2'); ?> Luggage</span>
                                            </div>
                                        </div>
                                        
                                        <div class="vehicle-cta">
                                            <a href="<?php the_permalink(); ?>" class="vehicle-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $luxury_count++;
                            }
                        endwhile;
                        wp_reset_postdata();
                    endif;

                    if ($luxury_count == 0):
                        echo '<div class="empty-state"><i class="ti ti-car-off"></i><p>No luxury vehicles available at the moment.</p></div>';
                    endif;
                    ?>
                </div>
            </div>

            <!-- Standard Tab -->
            <div class="tab-pane fade" id="standard" role="tabpanel">
                <div class="vehicle-grid">
                    <?php
                    $standard_args = array(
                        'post_type' => 'cars',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    );
                    $standard_query = new WP_Query($standard_args);
                    $standard_count = 0;

                    if ($standard_query->have_posts()):
                        while ($standard_query->have_posts()):
                            $standard_query->the_post();
                            $title = strtolower(get_the_title());
                            $passengers = get_post_meta(get_the_ID(), 'passengers', true);
                            $luggage = get_post_meta(get_the_ID(), 'large_bag', true);
                            $equivalent = get_post_meta(get_the_ID(), 'car_equivalent', true);
                            
                            $is_luxury = (strpos($title, 'premium sedan') !== false || 
                                         strpos($title, 'luxury') !== false ||
                                         strpos($title, 's-class') !== false ||
                                         strpos($title, 'e-class') !== false ||
                                         strpos($title, 'bmw 5') !== false ||
                                         strpos($title, 'bmw 7') !== false ||
                                         strpos($title, 'audi a6') !== false ||
                                         strpos($title, 'audi a8') !== false);
                            
                            $is_van = (strpos($title, 'van') !== false || 
                                      strpos($title, 'bus') !== false || 
                                      strpos($title, 'minibus') !== false ||
                                      ($passengers && intval($passengers) >= 7));
                            
                            if (!$is_luxury && !$is_van) {
                                ?>
                                <div class="vehicle-card">
                                    <div class="vehicle-image-wrapper">
                                        <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="vehicle-image"
                                                 loading="lazy"
                                                 width="600"
                                                 height="400">
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tour.jpg" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="vehicle-image"
                                                 loading="lazy">
                                        <?php endif; ?>
                                        <div class="vehicle-badge">Standard</div>
                                    </div>
                                    <div class="vehicle-card-body">
                                        <h3 class="vehicle-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php if ($equivalent): ?>
                                            <p class="vehicle-subtitle"><?php echo esc_html($equivalent); ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="vehicle-features">
                                            <div class="vehicle-feature-item">
                                                <i class="ti ti-users"></i>
                                                <span><?php echo esc_html($passengers ?: '4'); ?> Passengers</span>
                                            </div>
                                            <div class="vehicle-feature-item">
                                                <i class="ti ti-luggage"></i>
                                                <span><?php echo esc_html($luggage ?: '2'); ?> Luggage</span>
                                            </div>
                                        </div>
                                        
                                        <div class="vehicle-cta">
                                            <a href="<?php the_permalink(); ?>" class="vehicle-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $standard_count++;
                            }
                        endwhile;
                        wp_reset_postdata();
                    endif;

                    if ($standard_count == 0):
                        echo '<div class="empty-state"><i class="ti ti-car-off"></i><p>No standard vehicles available at the moment.</p></div>';
                    endif;
                    ?>
                </div>
            </div>

            <!-- Vans & Buses Tab -->
            <div class="tab-pane fade" id="vans" role="tabpanel">
                <div class="vehicle-grid">
                    <?php
                    $vans_args = array(
                        'post_type' => 'cars',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    );
                    $vans_query = new WP_Query($vans_args);
                    $vans_count = 0;

                    if ($vans_query->have_posts()):
                        while ($vans_query->have_posts()):
                            $vans_query->the_post();
                            $title = strtolower(get_the_title());
                            $passengers = get_post_meta(get_the_ID(), 'passengers', true);
                            $luggage = get_post_meta(get_the_ID(), 'large_bag', true);
                            $equivalent = get_post_meta(get_the_ID(), 'car_equivalent', true);
                            
                            if (strpos($title, 'van') !== false || 
                                strpos($title, 'bus') !== false || 
                                strpos($title, 'minibus') !== false ||
                                strpos($title, 'vito') !== false ||
                                strpos($title, 'sprinter') !== false ||
                                ($passengers && intval($passengers) >= 7)) {
                                ?>
                                <div class="vehicle-card">
                                    <div class="vehicle-image-wrapper">
                                        <?php if (has_post_thumbnail()): ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="vehicle-image"
                                                 loading="lazy"
                                                 width="600"
                                                 height="400">
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tour.jpg" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="vehicle-image"
                                                 loading="lazy">
                                        <?php endif; ?>
                                        <div class="vehicle-badge">Van</div>
                                    </div>
                                    <div class="vehicle-card-body">
                                        <h3 class="vehicle-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php if ($equivalent): ?>
                                            <p class="vehicle-subtitle"><?php echo esc_html($equivalent); ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="vehicle-features">
                                            <div class="vehicle-feature-item">
                                                <i class="ti ti-users"></i>
                                                <span><?php echo esc_html($passengers ?: '7'); ?> Passengers</span>
                                            </div>
                                            <div class="vehicle-feature-item">
                                                <i class="ti ti-luggage"></i>
                                                <span><?php echo esc_html($luggage ?: '4'); ?> Luggage</span>
                                            </div>
                                        </div>
                                        
                                        <div class="vehicle-cta">
                                            <a href="<?php the_permalink(); ?>" class="vehicle-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $vans_count++;
                            }
                        endwhile;
                        wp_reset_postdata();
                    endif;

                    if ($vans_count == 0):
                        echo '<div class="empty-state"><i class="ti ti-car-off"></i><p>No vans or buses available at the moment.</p></div>';
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <!-- SEO Content Sections -->
        <div class="fleet-content-sections" style="margin-top: 80px; padding: 0 15px;">
            <!-- Why Choose Our Fleet -->
            <div class="fleet-info-section" style="background: #fff; border-radius: 16px; padding: 40px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <h2 style="font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 700; color: #161920; margin-bottom: 20px; border-left: 4px solid #3cb371; padding-left: 20px;">
                    <i class="ti ti-award" style="color: #3cb371; margin-right: 10px;"></i>
                    Why Choose Our Premium Fleet for Frankfurt Transfers
                </h2>
                <p style="font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.8; color: #555; margin-bottom: 20px;">
                    Our carefully curated fleet offers the perfect vehicle for every travel need in Frankfurt and Germany. Whether you require a luxury Mercedes S-Class for executive airport transfers, a spacious passenger van for group travel, or an economy sedan for budget-friendly transportation, we provide professional chauffeur service with vehicles that meet the highest standards of comfort, safety, and reliability.
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 250px), 1fr)); gap: 20px; margin-top: 25px;">
                    <div style="padding: 20px; background: rgba(60, 179, 113, 0.05); border-radius: 12px; border-left: 3px solid #3cb371;">
                        <h3 style="font-size: clamp(1rem, 2.5vw, 1.1rem); font-weight: 600; color: #161920; margin-bottom: 10px;">
                            <i class="ti ti-shield-check" style="color: #3cb371;"></i> Fully Licensed & Insured
                        </h3>
                        <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #555; line-height: 1.6; margin: 0;">
                            All vehicles are professionally maintained, fully licensed, and comprehensively insured for your safety and peace of mind.
                        </p>
                    </div>
                    <div style="padding: 20px; background: rgba(60, 179, 113, 0.05); border-radius: 12px; border-left: 3px solid #3cb371;">
                        <h3 style="font-size: clamp(1rem, 2.5vw, 1.1rem); font-weight: 600; color: #161920; margin-bottom: 10px;">
                            <i class="ti ti-user-star" style="color: #3cb371;"></i> Professional Chauffeurs
                        </h3>
                        <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #555; line-height: 1.6; margin: 0;">
                            Experienced, multilingual drivers with extensive local knowledge ensure punctual, courteous service for every journey.
                        </p>
                    </div>
                    <div style="padding: 20px; background: rgba(60, 179, 113, 0.05); border-radius: 12px; border-left: 3px solid #3cb371;">
                        <h3 style="font-size: clamp(1rem, 2.5vw, 1.1rem); font-weight: 600; color: #161920; margin-bottom: 10px;">
                            <i class="ti ti-clock-24" style="color: #3cb371;"></i> 24/7 Availability
                        </h3>
                        <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #555; line-height: 1.6; margin: 0;">
                            Round-the-clock service for early morning flights, late-night arrivals, and urgent transportation needs across Germany.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Fleet Categories Explained -->
            <div class="fleet-info-section" style="background: #fff; border-radius: 16px; padding: 40px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <h2 style="font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 700; color: #161920; margin-bottom: 20px; border-left: 4px solid #3cb371; padding-left: 20px;">
                    <i class="ti ti-car-garage" style="color: #3cb371; margin-right: 10px;"></i>
                    Our Fleet Categories: From Luxury to Economy
                </h2>
                
                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: clamp(1.15rem, 3vw, 1.35rem); font-weight: 600; color: #161920; margin-bottom: 12px;">
                        <i class="ti ti-crown" style="color: #3cb371; margin-right: 8px;"></i>
                        Luxury Sedans – Executive Airport Transfers
                    </h3>
                    <p style="font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.8; color: #555; margin-bottom: 15px;">
                        Experience first-class travel with our premium fleet of <strong>Mercedes S-Class, BMW 7 Series, and Audi A8</strong> vehicles. Perfect for business executives, VIP clients, and luxury travelers requiring Frankfurt airport transfers or point-to-point chauffeur service. Features include handcrafted leather interiors, advanced climate control, privacy glass, and whisper-quiet cabins for maximum comfort and discretion.
                    </p>
                    <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #767676; font-style: italic;">
                        <strong>Ideal for:</strong> Executive airport transfers, business meetings, VIP events, luxury city tours
                    </p>
                </div>

                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: clamp(1.15rem, 3vw, 1.35rem); font-weight: 600; color: #161920; margin-bottom: 12px;">
                        <i class="ti ti-bus" style="color: #3cb371; margin-right: 8px;"></i>
                        Executive Vans – Premium Group Transportation
                    </h3>
                    <p style="font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.8; color: #555; margin-bottom: 15px;">
                        Travel together in style with our <strong>Mercedes V-Class, First Class Van, and Premium Sprinter</strong> vehicles. Accommodating 7-12 passengers with ample luggage space, these executive vans feature individual climate controls, premium entertainment systems, and captain's chairs for corporate groups, family celebrations, and luxury tours across Germany.
                    </p>
                    <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #767676; font-style: italic;">
                        <strong>Ideal for:</strong> Corporate delegations, family vacations, group airport transfers, wedding parties, golf outings
                    </p>
                </div>

                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: clamp(1.15rem, 3vw, 1.35rem); font-weight: 600; color: #161920; margin-bottom: 12px;">
                        <i class="ti ti-users" style="color: #3cb371; margin-right: 8px;"></i>
                        Standard Vans – Reliable Group Travel
                    </h3>
                    <p style="font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.8; color: #555; margin-bottom: 15px;">
                        Cost-effective group transportation with our comfortable <strong>passenger vans and minibuses</strong>. Perfect for families, sports teams, and corporate groups requiring spacious, reliable transportation for Frankfurt airport transfers, city tours, or day trips. Modern amenities include air conditioning, USB charging, and generous luggage capacity.
                    </p>
                    <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #767676; font-style: italic;">
                        <strong>Ideal for:</strong> Family trips, team travel, conference shuttles, multi-generational vacations, budget-conscious groups
                    </p>
                </div>

                <div style="margin-bottom: 0;">
                    <h3 style="font-size: clamp(1.15rem, 3vw, 1.35rem); font-weight: 600; color: #161920; margin-bottom: 12px;">
                        <i class="ti ti-currency-euro" style="color: #3cb371; margin-right: 8px;"></i>
                        Economy Sedans – Budget-Friendly Excellence
                    </h3>
                    <p style="font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.8; color: #555; margin-bottom: 15px;">
                        Affordable, reliable transportation with our <strong>Volkswagen Passat, Toyota Camry, and economy sedan</strong> fleet. Ideal for budget-conscious travelers, students, and business trips requiring dependable Frankfurt airport transfers or city transportation without compromising on safety, cleanliness, or professional service.
                    </p>
                    <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: #767676; font-style: italic;">
                        <strong>Ideal for:</strong> Budget travelers, students, solo business trips, short city transfers, daily commutes
                    </p>
                </div>
            </div>

            <!-- Service Areas -->
            <div class="fleet-info-section" style="background: linear-gradient(135deg, rgba(60, 179, 113, 0.05) 0%, rgba(46, 153, 96, 0.05) 100%); border-radius: 16px; padding: 40px; margin-bottom: 30px; border: 2px solid rgba(60, 179, 113, 0.2);">
                <h2 style="font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 700; color: #161920; margin-bottom: 20px; border-left: 4px solid #3cb371; padding-left: 20px;">
                    <i class="ti ti-map-pin" style="color: #3cb371; margin-right: 10px;"></i>
                    Service Areas: Frankfurt & Germany-Wide Coverage
                </h2>
                <p style="font-size: clamp(0.95rem, 2vw, 1.05rem); line-height: 1.8; color: #555; margin-bottom: 25px;">
                    Our premium fleet serves Frankfurt and all major German cities with professional chauffeur service. Whether you need Frankfurt airport transfers (FRA), intercity travel, or day trips to Germany's most beautiful destinations, our vehicles and drivers are ready to serve you 24/7.
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr)); gap: 15px;">
                    <div style="background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 12px;">
                        <i class="ti ti-plane-departure" style="font-size: 24px; color: #3cb371;"></i>
                        <span style="font-weight: 600; color: #161920; font-size: clamp(0.9rem, 2vw, 1rem);">Frankfurt Airport (FRA)</span>
                    </div>
                    <div style="background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 12px;">
                        <i class="ti ti-building-skyscraper" style="font-size: 24px; color: #3cb371;"></i>
                        <span style="font-weight: 600; color: #161920; font-size: clamp(0.9rem, 2vw, 1rem);">Frankfurt City Center</span>
                    </div>
                    <div style="background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 12px;">
                        <i class="ti ti-castle" style="font-size: 24px; color: #3cb371;"></i>
                        <span style="font-weight: 600; color: #161920; font-size: clamp(0.9rem, 2vw, 1rem);">Heidelberg</span>
                    </div>
                    <div style="background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 12px;">
                        <i class="ti ti-building-community" style="font-size: 24px; color: #3cb371;"></i>
                        <span style="font-weight: 600; color: #161920; font-size: clamp(0.9rem, 2vw, 1rem);">Munich</span>
                    </div>
                    <div style="background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 12px;">
                        <i class="ti ti-building-factory" style="font-size: 24px; color: #3cb371;"></i>
                        <span style="font-weight: 600; color: #161920; font-size: clamp(0.9rem, 2vw, 1rem);">Stuttgart</span>
                    </div>
                    <div style="background: #fff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 12px;">
                        <i class="ti ti-mountain" style="font-size: 24px; color: #3cb371;"></i>
                        <span style="font-weight: 600; color: #161920; font-size: clamp(0.9rem, 2vw, 1rem);">Rhine Valley</span>
                    </div>
                </div>
            </div>

            <!-- Booking CTA -->
            <div class="fleet-cta-section" style="background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%); border-radius: 16px; padding: 50px 40px; text-align: center; box-shadow: 0 8px 30px rgba(60, 179, 113, 0.3); margin-bottom: 30px;">
                <h2 style="font-size: clamp(1.5rem, 4vw, 2.2rem); font-weight: 700; color: #fff; margin-bottom: 15px;">
                    Ready to Book Your Frankfurt Transfer?
                </h2>
                <p style="font-size: clamp(1rem, 2.5vw, 1.15rem); color: rgba(255, 255, 255, 0.95); margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.7;">
                    Choose from our premium fleet and enjoy professional chauffeur service with instant confirmation, transparent pricing, and 24/7 customer support.
                </p>
                <a href="<?php echo esc_url(home_url('/booking-page/')); ?>" style="display: inline-block; background: #fff; color: #3cb371; padding: 16px 40px; border-radius: 50px; font-weight: 700; font-size: clamp(1rem, 2.5vw, 1.1rem); text-decoration: none; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
                    <i class="ti ti-calendar-check" style="margin-right: 8px;"></i>
                    Book Your Transfer Now
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>