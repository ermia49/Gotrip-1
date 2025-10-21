<?php
/*Template Name: Tours*/

// SEO Meta Tags
function day_trips_seo_meta() {
    $page_title = 'Day Trips & Tours | Explore Amazing Destinations';
    $page_description = 'Discover unforgettable day trips and tours. Book your adventure with trusted local guides. Premium transportation, expert planning, and memorable experiences.';
    $page_url = home_url($_SERVER['REQUEST_URI']);
    $site_name = get_bloginfo('name');
    $hero_image = get_template_directory_uri() . '/assets/img/bg-img/day-trips-hero-scenic-coastal-road-mountains.webp';
    
    echo '<meta name="description" content="' . esc_attr($page_description) . '">';
    echo '<meta name="keywords" content="day trips, tours, travel, adventure, sightseeing, local tours, guided tours, day tours, scenic drives, mountain tours">';
    echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">';
    echo '<link rel="canonical" href="' . esc_url($page_url) . '">';
    
    // Preload hero image for performance
    echo '<link rel="preload" as="image" href="' . esc_url($hero_image) . '" type="image/webp">';
    
    // Open Graph
    echo '<meta property="og:locale" content="en_US">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:title" content="' . esc_attr($page_title) . '">';
    echo '<meta property="og:description" content="' . esc_attr($page_description) . '">';
    echo '<meta property="og:url" content="' . esc_url($page_url) . '">';
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">';
    echo '<meta property="og:image" content="' . esc_url($hero_image) . '">';
    echo '<meta property="og:image:width" content="1920">';
    echo '<meta property="og:image:height" content="1080">';
    echo '<meta property="og:image:alt" content="Scenic coastal road winding through mountains - Day trips destination">';
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . esc_attr($page_title) . '">';
    echo '<meta name="twitter:description" content="' . esc_attr($page_description) . '">';
    echo '<meta name="twitter:image" content="' . esc_url($hero_image) . '">';
    echo '<meta name="twitter:image:alt" content="Scenic coastal road through mountains - Day trips and tours">';
}
add_action('wp_head', 'day_trips_seo_meta');

// Schema.org Structured Data
function day_trips_schema_markup() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'TouristAttraction',
        'name' => get_bloginfo('name') . ' - Day Trips',
        'description' => 'Premium day trips and tours with expert guides and comfortable transportation',
        'url' => home_url('/day-trip'),
        'image' => get_template_directory_uri() . '/assets/img/bg-img/day-trips-hero-scenic-coastal-road-mountains.webp',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressCountry' => 'US'
        ),
        'aggregateRating' => array(
            '@type' => 'AggregateRating',
            'ratingValue' => '4.8',
            'reviewCount' => '500'
        )
    );
    echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
}
add_action('wp_head', 'day_trips_schema_markup');

get_header();
?>

<!-- Day Trips Page Responsive Optimization Styles -->
<style>
/* ========================================
   Day Trips Page - Responsive Optimization
   ======================================== */

/* Hero Section Base */
.hero-section {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: center;
    background-color: #161920;
    overflow: hidden;
}

.background-swiper1 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.background-swiper1::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.6) 100%);
    z-index: 1;
}

.tour_slide {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    filter: brightness(0.85);
}

.hero-section .container {
    position: relative;
    z-index: 2;
}

/* Search Banner */
.search_banner {
    width: 100%;
    padding: 20px 0;
}

/* Tab Navigation - Slider Style Toggle */
.forms-tabs {
    display: flex;
    justify-content: center;
    padding: 0;
    margin: 0 auto 30px;
    flex-wrap: wrap;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50px;
    padding: 6px;
    position: relative;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    width: fit-content;
}

.forms-tabs .nav-item {
    position: relative;
    z-index: 2;
}

.forms-tabs .tab-link {
    display: inline-block;
    padding: 14px 40px;
    background: transparent;
    border: none;
    border-radius: 50px;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
    position: relative;
    min-width: 140px;
    text-align: center;
}

.forms-tabs .tab-link:hover {
    color: #fff;
}

.forms-tabs .tab-link.active {
    color: #fff;
}

/* Sliding Background */
.forms-tabs::before {
    content: '';
    position: absolute;
    top: 6px;
    left: 6px;
    width: calc(50% - 6px);
    height: calc(100% - 12px);
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    border-radius: 50px;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
    box-shadow: 0 4px 15px rgba(60, 179, 113, 0.4);
}

/* Move slider when Day Trip is active */
.forms-tabs:has(.tab-link.active[href*="day-trip"])::before {
    transform: translateX(calc(100% + 6px));
}

/* Hero Heading */
.heading_nav {
    color: #fff;
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin: 0 0 30px;
    padding-top: 0 !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    line-height: 1.3;
}

/* Search Form */
.hero-search-form {
    max-width: 850px;
    margin: 0 auto;
    width: 100%;
}

.search-form {
    background: transparent;
    padding: 0;
    border-radius: 0;
    box-shadow: none;
    width: 100%;
}

.search-item {
    background: rgba(255, 255, 255, 0.95);
    padding: 0 20px;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    width: 100%;
    height: 62px;
    display: flex;
    align-items: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(20px);
}

.search-item:hover {
    background: rgba(255, 255, 255, 1);
    border-color: rgba(60, 179, 113, 0.4);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
    transform: translateY(-2px);
}

.search-item:focus-within {
    background: rgba(255, 255, 255, 1);
    border-color: #3cb371;
    box-shadow: 0 0 0 4px rgba(60, 179, 113, 0.15), 0 12px 40px rgba(0, 0, 0, 0.3);
    border-width: 2px;
    padding: 0 19px;
    transform: translateY(-2px);
}

.search-item .icon {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    margin-right: 14px;
}

.search-item .icon svg {
    width: 22px;
    height: 22px;
}

.search-item .icon svg path {
    fill: #3cb371;
}

.search-item .form-group {
    flex: 1;
    margin: 0;
    width: 100%;
}

.search-item .form-control {
    border: none;
    background: transparent;
    padding: 0;
    font-size: 16px;
    color: #161920;
    height: auto;
    width: 100%;
    line-height: 1.5;
    font-weight: 500;
}

.search-item .form-control:focus {
    outline: none;
    box-shadow: none;
    border: none;
}

.search-item .form-control::placeholder {
    color: #999;
    font-weight: 400;
}

.search-form .btn-success {
    padding: 0 32px;
    font-weight: 600;
    font-size: 16px;
    border-radius: 50px;
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    border: none;
    transition: all 0.3s ease;
    height: 62px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(60, 179, 113, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 15px;
}

.search-form .btn-success:hover {
    background: linear-gradient(135deg, #2e9960 0%, #27824f 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(60, 179, 113, 0.5);
}

.search-form .btn-success:active {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(60, 179, 113, 0.4);
}

.search-form .row {
    gap: 12px;
}

/* Tour List Section */
.tour-list-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.tour-list-section .container {
    max-width: 1320px;
    margin: 0 auto;
    padding-left: 15px;
    padding-right: 15px;
}

.tour-list-content {
    width: 100%;
}

/* Responsive Grid for Tours */
#tour-results {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none;
    width: 100%;
}

#tour-results > * {
    margin: 0 !important;
    padding: 0 !important;
    width: 100%;
}

.no-tours-message {
    width: 100%;
}

/* Tour Cards Enhancement */
.trip-box {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    width: 100%;
    max-width: 100%;
}

.trip-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

/* Image Wrapper */
.trip-box-image-wrapper {
    position: relative;
    overflow: hidden;
    width: 100%;
}

.trip-box-image-wrapper > a {
    display: block;
    position: relative;
}

/* Overlay for badge and wishlist */
.trip-box-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 12px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    z-index: 2;
    pointer-events: none;
}

.trip-box-overlay > * {
    pointer-events: auto;
}

.trip-box .badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    background: #3cb371 !important;
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    margin: 0;
}

.trip-box .wishlist_btn {
    background: rgba(255, 255, 255, 0.95);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    flex-shrink: 0;
}

.trip-box .wishlist_btn:hover {
    background: #fff;
    transform: scale(1.1);
}

.trip-box .wishlist_btn .icon {
    font-size: 18px;
    color: #3cb371;
}

.trip-box .tour_feature {
    width: 100%;
    height: 220px;
    min-height: 220px;
    max-height: 220px;
    object-fit: cover;
    display: block;
}

.trip-box a:focus {
    outline: 2px solid #3cb371;
    outline-offset: 2px;
}

.trip-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: auto !important;
    min-height: 200px;
    margin-top: 0 !important;
}

.trip-body .rating-info {
    font-size: 14px;
    color: #161920;
    font-weight: 500;
    margin-bottom: 8px;
}

.trip-title {
    font-size: 18px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 12px;
    min-height: 50px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.trip-title a {
    color: #161920;
    text-decoration: none;
    transition: color 0.3s ease;
}

.trip-title a:hover {
    color: #3cb371;
}

.trip-meta {
    margin-top: auto;
}

.trip-meta ul {
    margin: 0 0 12px;
    padding: 0;
    list-style: none;
}

.trip-meta ul li {
    font-size: 14px;
    color: #767676;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

.trip-meta ul li i {
    color: #3cb371;
    font-size: 16px;
}

.trip-price {
    color: #3cb371;
    font-weight: 700;
    font-size: 24px;
    margin: 0;
}

/* ========================================
   RESPONSIVE MEDIA QUERIES
   ======================================== */

/* Large Desktop (1400px and up) */
@media (min-width: 1400px) {
    #tour-results {
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }
    
    .hero-section {
        min-height: 550px;
    }
}

/* Desktop (1200px - 1399px) */
@media (max-width: 1399px) {
    #tour-results {
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }
}

/* Large Tablet / Small Desktop (992px - 1199px) */
@media (max-width: 1199px) {
    #tour-results {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .tour-list-section .container {
        max-width: 960px;
    }
    
    .hero-section {
        min-height: 450px;
    }
    
    .heading_nav {
        font-size: 2rem;
    }
}

/* Tablet (768px - 991px) */
@media (max-width: 991px) {
    #tour-results {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .tour-list-section .container {
        max-width: 720px;
    }
    
    .hero-section {
        min-height: 420px;
    }
    
    .heading_nav {
        font-size: 1.75rem;
        margin-bottom: 25px;
    }
    
    .forms-tabs {
        margin-bottom: 25px;
        padding: 5px;
    }
    
    .forms-tabs .tab-link {
        padding: 12px 32px;
        font-size: 15px;
        min-width: 130px;
    }
    
    .forms-tabs::before {
        top: 5px;
        left: 5px;
        width: calc(50% - 5px);
        height: calc(100% - 10px);
    }
    
    .forms-tabs:has(.tab-link.active[href*="day-trip"])::before {
        transform: translateX(calc(100% + 5px));
    }
    
    .hero-search-form {
        max-width: 700px;
    }
    
    .search-form {
        padding: 0;
        background: transparent;
        border-radius: 0;
        box-shadow: none;
    }
    
    .search-item {
        height: 58px;
        padding: 0 18px;
        border-radius: 40px;
    }
    
    .search-item:focus-within {
        padding: 0 17px;
    }
    
    .search-item .form-control {
        font-size: 15px;
    }
    
    .search-form .btn-success {
        height: 58px;
        font-size: 14px;
        padding: 0 28px;
        border-radius: 40px;
    }
    
    .search-form .row {
        gap: 10px;
    }
    
    .tour-list-section {
        padding: 60px 0;
    }
}

/* Mobile Landscape / Small Tablet (576px - 767px) */
@media (max-width: 767px) {
    #tour-results {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .tour-list-section .container {
        max-width: 540px;
        padding-left: 12px;
        padding-right: 12px;
    }
    
    .hero-section {
        min-height: 380px;
    }
    
    .heading_nav {
        font-size: 1.5rem;
        padding: 0 20px;
        margin-bottom: 20px;
    }
    
    .forms-tabs {
        margin-bottom: 20px;
        padding: 4px;
    }
    
    .forms-tabs .tab-link {
        padding: 10px 24px;
        font-size: 14px;
        min-width: 120px;
    }
    
    .forms-tabs::before {
        top: 4px;
        left: 4px;
        width: calc(50% - 4px);
        height: calc(100% - 8px);
    }
    
    .forms-tabs:has(.tab-link.active[href*="day-trip"])::before {
        transform: translateX(calc(100% + 4px));
    }
    
    .hero-search-form {
        max-width: 90%;
        margin: 0 auto;
    }
    
    .search-form {
        padding: 16px;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        border-radius: 30px;
        box-shadow: 0 6px 28px rgba(0, 0, 0, 0.15);
    }
    
    .search-item {
        height: 48px;
        padding: 0 14px;
        border-radius: 30px;
    }
    
    .search-item:focus-within {
        padding: 0 13px;
    }
    
    .search-item .icon {
        margin-right: 12px;
    }
    
    .search-item .form-control {
        font-size: 14px;
    }
    
    .search-form .btn-success {
        height: 48px;
        font-size: 13px;
        padding: 0 20px;
        border-radius: 30px;
    }
    
    .search-form .row {
        gap: 10px;
        flex-direction: column;
    }
    
    .search-item,
    .search-form .btn-success {
        width: 100%;
    }
    
    .tour-list-section {
        padding: 50px 0;
    }
    
    .trip-box .tour_feature {
        height: 180px !important;
        min-height: 180px !important;
        max-height: 180px !important;
    }
    
    .trip-box-overlay {
        padding: 10px;
    }
    
    .trip-box .wishlist_btn {
        width: 36px;
        height: 36px;
    }
    
    .trip-box .wishlist_btn .icon {
        font-size: 16px;
    }
    
    .trip-body {
        padding: 18px;
    }
    
    .trip-title {
        font-size: 16px;
        min-height: auto;
    }
    
    .trip-price {
        font-size: 20px;
    }
}

/* Mobile Portrait (up to 575px) */
@media (max-width: 575px) {
    #tour-results {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .tour-list-section .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .hero-section {
        min-height: 350px;
    }
    
    .heading_nav {
        font-size: 1.35rem;
        padding: 0 15px;
    }
    
    .forms-tabs {
        margin-bottom: 20px;
        padding: 4px;
    }
    
    .forms-tabs .tab-link {
        padding: 9px 20px;
        font-size: 13px;
        min-width: 110px;
    }
    
    .forms-tabs::before {
        top: 4px;
        left: 4px;
        width: calc(50% - 4px);
        height: calc(100% - 8px);
    }
    
    .forms-tabs:has(.tab-link.active[href*="day-trip"])::before {
        transform: translateX(calc(100% + 4px));
    }
    
    .hero-search-form {
        max-width: 95%;
    }
    
    .search-banner {
        padding: 15px 0;
    }
    
    .search-form {
        padding: 0;
        background: transparent;
        border-radius: 0;
        box-shadow: none;
    }
    
    .search-item {
        height: 54px;
        padding: 0 14px;
        border-radius: 35px;
    }
    
    .search-item:focus-within {
        padding: 0 13px;
    }
    
    .search-item .icon {
        margin-right: 10px;
    }
    
    .search-item .icon svg {
        width: 20px;
        height: 20px;
    }
    
    .search-item .form-control {
        font-size: 14px;
    }
    
    .search-form .btn-success {
        height: 54px;
        font-size: 13px;
        padding: 0 20px;
        letter-spacing: 0.3px;
        border-radius: 35px;
    }
    
    .search-form .row {
        gap: 10px;
        flex-direction: column;
    }
    
    .search-item,
    .search-form .btn-success {
        width: 100%;
    }
    
    .tour-list-section {
        padding: 40px 0;
    }
    
    .trip-box .tour_feature {
        height: 200px !important;
        min-height: 200px !important;
        max-height: 200px !important;
    }
    
    .trip-box-overlay {
        padding: 10px;
    }
    
    .trip-box .wishlist_btn {
        width: 36px;
        height: 36px;
    }
    
    .trip-box .wishlist_btn .icon {
        font-size: 16px;
    }
    
    .trip-body {
        padding: 16px;
        min-height: 180px;
    }
    
    .trip-title {
        font-size: 16px;
        min-height: auto;
    }
    
    .trip-meta ul li {
        font-size: 13px;
    }
    
    .trip-price {
        font-size: 20px;
    }
}

/* Extra Small Mobile (up to 375px) */
@media (max-width: 375px) {
    .heading_nav {
        font-size: 1.2rem;
    }
    
    .forms-tabs {
        padding: 4px;
    }
    
    .forms-tabs .tab-link {
        padding: 8px 18px;
        font-size: 12px;
        min-width: 100px;
    }
    
    .forms-tabs::before {
        top: 4px;
        left: 4px;
        width: calc(50% - 4px);
        height: calc(100% - 8px);
    }
    
    .forms-tabs:has(.tab-link.active[href*="day-trip"])::before {
        transform: translateX(calc(100% + 4px));
    }
    
    .hero-search-form {
        max-width: 98%;
    }
    
    .search-form {
        padding: 0;
        background: transparent;
        border-radius: 0;
        box-shadow: none;
    }
    
    .search-item {
        height: 54px;
        padding: 0 14px;
        border-radius: 35px;
    }
    
    .search-item:focus-within {
        padding: 0 13px;
    }
    
    .search-form .btn-success {
        height: 52px;
        font-size: 12px;
        padding: 0 16px;
        border-radius: 30px;
    }
    
    .search-form .row {
        gap: 8px;
        flex-direction: column;
    }
    
    .search-item,
    .search-form .btn-success {
        width: 100%;
    }
    
    .trip-box .tour_feature {
        height: 180px !important;
        min-height: 180px !important;
        max-height: 180px !important;
    }
    
    .trip-body {
        min-height: 160px;
    }
}

/* Touch Device Optimizations */
@media (hover: none) and (pointer: coarse) {
    .forms-tabs .tab-link {
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .search-form .btn-success {
        min-height: 48px;
    }
    
    .trip-box .wishlist_btn {
        min-width: 44px;
        min-height: 44px;
    }
    
    .search-item {
        min-height: 48px;
    }
}

/* Animation Enhancement */
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

.wow.fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

/* Loading State */
.trip-box img {
    transition: opacity 0.3s ease;
}

.trip-box img[loading="lazy"] {
    background: #f0f0f0;
}

/* Accessibility Improvements */
.trip-box:focus-within {
    outline: 3px solid #3cb371;
    outline-offset: 3px;
}

button:focus-visible,
a:focus-visible {
    outline: 2px solid #3cb371;
    outline-offset: 2px;
}

/* Print Styles */
@media print {
    .hero-section,
    .search-form,
    .forms-tabs {
        display: none;
    }
    
    #tour-results {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .trip-box {
        break-inside: avoid;
    }
}

/* Trust Badges Responsive */
.trust-badges-section .trust-badge {
    transition: transform 0.3s ease;
}

.trust-badges-section .trust-badge:hover {
    transform: translateY(-5px);
}

@media (max-width: 767px) {
    .trust-badges-section {
        padding: 30px 0 !important;
    }
    
    .trust-badges-section .badge-icon {
        font-size: 2rem !important;
    }
    
    .trust-badges-section h6 {
        font-size: 13px !important;
    }
    
    .trust-badges-section p {
        font-size: 11px !important;
    }
    
    .seo-content-section {
        padding: 30px 0 !important;
    }
    
    .seo-content-section .seo-content {
        padding: 20px !important;
    }
    
    .seo-content-section h1 {
        font-size: 22px !important;
    }
    
    .seo-content-section h2 {
        font-size: 18px !important;
    }
    
    .seo-content-section p,
    .seo-content-section li {
        font-size: 14px !important;
    }
}

/* SEO Links Hover */
.seo-content a:hover {
    color: #2e9960 !important;
    text-decoration: underline !important;
}
</style>

<section class="hero-section bg-dark">
     <?php gotriptoday_social_icons(); ?>
    <!-- Background Slider -->
    <div class="background-swiper1">
        <div class="h-100">
            <div class="h-100 tour_slide"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/day-trips-hero-scenic-coastal-road-mountains.webp?v=<?php echo time(); ?>')"
                role="img"
                aria-label="Scenic coastal road winding through mountains - Day trips and tours destination">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="search_banner tour_banner ">
                <ul class="nav forms-tabs mb-3 mx-auto " id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="tab-link" href="<?php echo home_url('/booking-page'); ?>" type="button">Transfer</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="tab-link active" href="<?php echo home_url('/day-trip'); ?>" type="button">Day
                            Trip</a>
                    </li>
                </ul>
                <h2 class="heading_nav">Explore around, wherever you are, in one day.</h2>
                <div class="hero-search-form wow fadeInUp w-full mt-3" data-wow-delay="900ms"
                    data-wow-duration="1000ms">
                    <form class="row align-items-center g-3 g-xxl-2 search-form" role="search" method="get" class=""
                        action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="col-12 col-md-8">
                            <div class="search-item d-flex align-items-center gap-3">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.38467 18.4463C9.38467 18.4463 3.33301 13.3496 3.33301 8.33464C3.33301 6.56653 4.03539 4.87083 5.28563 3.62059C6.53587 2.37035 8.23156 1.66797 9.99967 1.66797C11.7678 1.66797 13.4635 2.37035 14.7137 3.62059C15.964 4.87083 16.6663 6.56653 16.6663 8.33464C16.6663 13.3496 10.6147 18.4463 10.6147 18.4463C10.278 18.7563 9.72384 18.753 9.38467 18.4463ZM9.99967 11.2513C10.3827 11.2513 10.762 11.1759 11.1158 11.0293C11.4697 10.8827 11.7912 10.6679 12.0621 10.397C12.3329 10.1262 12.5477 9.80466 12.6943 9.4508C12.8409 9.09693 12.9163 8.71766 12.9163 8.33464C12.9163 7.95161 12.8409 7.57234 12.6943 7.21848C12.5477 6.86461 12.3329 6.54308 12.0621 6.27224C11.7912 6.0014 11.4697 5.78656 11.1158 5.63999C10.762 5.49341 10.3827 5.41797 9.99967 5.41797C9.22613 5.41797 8.48426 5.72526 7.93728 6.27224C7.3903 6.81922 7.08301 7.56109 7.08301 8.33464C7.08301 9.10818 7.3903 9.85005 7.93728 10.397C8.48426 10.944 9.22613 11.2513 9.99967 11.2513Z"
                                            fill="#767676" />
                                    </svg>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="name" class="form-control" placeholder="Explore from"
                                        value="<?php echo get_search_query(); ?>" name="s">
                                    <input type="hidden" name="post_type" value="tours" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-success w-100">Search Now</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</section>

<!-- Trust Badges Section -->
<section class="trust-badges-section" style="background: #fff; padding: 40px 0; border-bottom: 1px solid #e5e5e5;">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center g-4">
            <div class="col-6 col-md-3">
                <div class="trust-badge">
                    <div class="badge-icon" style="font-size: 2.5rem; color: #3cb371; margin-bottom: 10px;">
                        <i class="ti ti-shield-check"></i>
                    </div>
                    <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 5px;">Secure Booking</h6>
                    <p style="font-size: 12px; color: #767676; margin: 0;">SSL Encrypted</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge">
                    <div class="badge-icon" style="font-size: 2.5rem; color: #3cb371; margin-bottom: 10px;">
                        <i class="ti ti-award"></i>
                    </div>
                    <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 5px;">Best Price Guarantee</h6>
                    <p style="font-size: 12px; color: #767676; margin: 0;">Lowest Rates</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge">
                    <div class="badge-icon" style="font-size: 2.5rem; color: #3cb371; margin-bottom: 10px;">
                        <i class="ti ti-users"></i>
                    </div>
                    <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 5px;">500+ Happy Clients</h6>
                    <p style="font-size: 12px; color: #767676; margin: 0;">Trusted Reviews</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge">
                    <div class="badge-icon" style="font-size: 2.5rem; color: #3cb371; margin-bottom: 10px;">
                        <i class="ti ti-headset"></i>
                    </div>
                    <h6 style="font-size: 14px; font-weight: 600; margin-bottom: 5px;">24/7 Support</h6>
                    <p style="font-size: 12px; color: #767676; margin: 0;">Always Available</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tour List Section -->
<section class="tour-list-section">
    <div class="divider-sm"></div>
    <div class="container">
        <div class="tour-list-content">
            <div id="tour-results">
                <?php
                $args = array(
                    'post_type' => 'tours',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                );

                $tours_query = new WP_Query($args);
                if ($tours_query->have_posts()):
                    while ($tours_query->have_posts()):
                        $tours_query->the_post();
                        $tour_comments = get_tour_comments(get_the_ID());
                        $review_count = count($tour_comments);
                        get_template_part('partials/tour', 'box', array('review_count' => $review_count));
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<div class="no-tours-message" style="grid-column: 1 / -1;"><div class="alert alert-info text-center p-4"><i class="ti ti-info-circle me-2"></i>No tours found. Please check back later for exciting day trip options!</div></div>';
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Professional Links Section - Above Footer -->
<section class="professional-links-section" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 60px 0; border-top: 1px solid #e9ecef;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 style="font-size: 32px; font-weight: 700; color: #161920; margin-bottom: 12px;">Explore More with GoTrip Today</h2>
                    <p style="font-size: 17px; color: #767676; margin: 0;">Your trusted platform for seamless travel experiences across Germany</p>
                </div>
                
                <div class="row g-4">
                    <!-- Quick Links Column -->
                    <div class="col-md-6">
                        <div class="links-card" style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%; transition: all 0.3s ease;">
                            <div class="d-flex align-items-center mb-4">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                    <i class="ti ti-route" style="font-size: 26px; color: #fff;"></i>
                                </div>
                                <h3 style="font-size: 22px; font-weight: 700; color: #161920; margin: 0;">Our Services</h3>
                            </div>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li style="margin-bottom: 16px;">
                                    <a href="<?php echo home_url('/'); ?>" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-home" style="color: #3cb371; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Home</span>
                                    </a>
                                </li>
                                <li style="margin-bottom: 16px;">
                                    <a href="<?php echo home_url('/booking-page'); ?>" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-car" style="color: #3cb371; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Airport Transfers</span>
                                    </a>
                                </li>
                                <li style="margin-bottom: 16px;">
                                    <a href="<?php echo home_url('/fleet'); ?>" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-steering-wheel" style="color: #3cb371; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Fleet Marketplace</span>
                                    </a>
                                </li>
                                <li style="margin-bottom: 16px;">
                                    <a href="<?php echo home_url('/about'); ?>" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-info-circle" style="color: #3cb371; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">About Us</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo home_url('/contact'); ?>" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-mail" style="color: #3cb371; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- External Resources Column -->
                    <div class="col-md-6">
                        <div class="links-card" style="background: #fff; padding: 35px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); height: 100%; transition: all 0.3s ease;">
                            <div class="d-flex align-items-center mb-4">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                    <i class="ti ti-world" style="font-size: 26px; color: #fff;"></i>
                                </div>
                                <h3 style="font-size: 22px; font-weight: 700; color: #161920; margin: 0;">Travel Resources</h3>
                            </div>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li style="margin-bottom: 16px;">
                                    <a href="https://www.tripadvisor.com" target="_blank" rel="nofollow noopener" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-star" style="color: #667eea; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">TripAdvisor Reviews</span>
                                        <i class="ti ti-external-link" style="margin-left: auto; font-size: 16px; color: #999;"></i>
                                    </a>
                                </li>
                                <li style="margin-bottom: 16px;">
                                    <a href="https://www.lonelyplanet.com" target="_blank" rel="nofollow noopener" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-book" style="color: #667eea; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Lonely Planet Guides</span>
                                        <i class="ti ti-external-link" style="margin-left: auto; font-size: 16px; color: #999;"></i>
                                    </a>
                                </li>
                                <li style="margin-bottom: 16px;">
                                    <a href="https://www.google.com/travel" target="_blank" rel="nofollow noopener" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-plane" style="color: #667eea; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Google Travel</span>
                                        <i class="ti ti-external-link" style="margin-left: auto; font-size: 16px; color: #999;"></i>
                                    </a>
                                </li>
                                <li style="margin-bottom: 16px;">
                                    <a href="https://www.germany.travel" target="_blank" rel="nofollow noopener" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-map-pin" style="color: #667eea; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Germany Tourism</span>
                                        <i class="ti ti-external-link" style="margin-left: auto; font-size: 16px; color: #999;"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.frankfurt-tourismus.de/en" target="_blank" rel="nofollow noopener" style="color: #555; text-decoration: none; font-size: 16px; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f8f9fa'; this.style.paddingLeft='20px';" onmouseout="this.style.background='transparent'; this.style.paddingLeft='10px';">
                                        <i class="ti ti-building-skyscraper" style="color: #667eea; margin-right: 12px; font-size: 20px;"></i>
                                        <span style="font-weight: 500;">Frankfurt Tourism</span>
                                        <i class="ti ti-external-link" style="margin-left: auto; font-size: 16px; color: #999;"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom CTA -->
                <div class="text-center mt-5">
                    <div style="background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%); padding: 30px 40px; border-radius: 16px; box-shadow: 0 8px 30px rgba(60, 179, 113, 0.25);">
                        <h3 style="font-size: 24px; font-weight: 700; color: #fff; margin-bottom: 10px;">Ready to Start Your Journey?</h3>
                        <p style="font-size: 16px; color: rgba(255,255,255,0.9); margin-bottom: 20px;">Book your next adventure with trusted providers on our platform</p>
                        <a href="<?php echo home_url('/booking-page'); ?>" class="btn btn-light" style="padding: 14px 40px; font-weight: 600; font-size: 16px; border-radius: 50px; color: #3cb371; background: #fff; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; text-decoration: none; display: inline-block;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)';">
                            Book Now <i class="ti ti-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/isotope.pkgd.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/flatpickr.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/nice-select2.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/nouislider.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/active.js"></script>
<?php get_footer(); ?>