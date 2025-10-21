<?php
/*Template Name: Fleet */

// SEO & Schema Markup - Add to wp_head
add_action('wp_head', function() {
    if (!is_page_template('temp-fleet.php')) return;
    
    $page_title = 'Marketplace | Compare Frankfurt Transfers & Germany Day Trips';
    $page_description = 'Discover and book premium transfers and day trips across Frankfurt and Germany. Choose from licensed chauffeurs, executive cars, and curated experiences from trusted providers.';
    $page_url = home_url($_SERVER['REQUEST_URI']);
    $site_name = get_bloginfo('name');
    ?>
    <!-- Page Title -->
    <title><?php echo esc_html($page_title); ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo esc_attr($page_description); ?>">
    <meta name="keywords" content="transfer marketplace, day trip marketplace, book transfers Frankfurt, chauffeur marketplace Germany, private driver Frankfurt, Frankfurt airport transfer, Germany day trips, licensed chauffeurs Germany, executive cars Frankfurt, private transfers Germany, book chauffeur online, compare transfer prices">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
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
    
    <!-- Schema.org - Service Marketplace -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Service",
      "serviceType": "Private Transfer & Chauffeur Service Marketplace",
      "name": "<?php echo esc_js($site_name); ?> Fleet",
      "description": "<?php echo esc_js($page_description); ?>",
      "url": "<?php echo esc_url($page_url); ?>",
      "provider": {
        "@type": "Organization",
        "name": "<?php echo esc_js($site_name); ?>",
        "description": "Luxury travel marketplace connecting customers with licensed chauffeurs and premium vehicles for private transfers and day trips"
      },
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Premium Fleet Vehicles",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "Luxury Sedans",
              "description": "Executive sedans for airport transfers and private chauffeur service"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "Executive Vans",
              "description": "Premium vans for group transfers and day trips"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "Group Transport",
              "description": "Luxury buses for large group transfers and excursions"
            }
          }
        ]
      },
      "areaServed": {
        "@type": "GeoCircle",
        "geoMidpoint": {
          "@type": "GeoCoordinates",
          "latitude": "37.7749",
          "longitude": "-122.4194"
        }
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
    padding: 60px 15px;
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
        padding-top: 30px;
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
        padding: 0 20px;
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
        padding: 0 15px;
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
</style>

<section class="fleet-page">
    <div class="container">
        <!-- Fleet Hero Section -->
        <div class="fleet-hero-section">
            <h1>Frankfurt & Germany Transfer Marketplace</h1>
            <p>Compare and book premium transfers and day trips from trusted providers across Frankfurt and Germany. Check real-time availability, compare prices from licensed chauffeurs, and book directly for airport transfers, city rides, and curated day trip experiences. All providers are verified for your peace of mind.</p>
            
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
                    <button class="nav-link active" id="luxury-tab" data-bs-toggle="pill" data-bs-target="#luxury" type="button" role="tab">
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
            <!-- Luxury Tab -->
            <div class="tab-pane fade show active" id="luxury" role="tabpanel">
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
    </div>
</section>

<?php get_footer(); ?>