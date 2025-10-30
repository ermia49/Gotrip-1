<?php get_header(); ?>
<?php
$bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: get_template_directory_uri() . '/assets/img/bg-img/97.jpg';
?>

<!-- Vehicle Details Styles -->
<style>
.vehicle-details-page {
    background: #f8f9fa;
    padding: 120px 0 60px;
}

.vehicle-hero-header {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 40px;
}

.vehicle-hero-header h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 800;
    color: #161920;
    margin-bottom: 15px;
    line-height: 1.2;
}

.vehicle-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    color: #fff;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(60, 179, 113, 0.3);
}

.vehicle-type-badge i {
    font-size: 24px;
}

.vehicle-equivalent {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #555;
    font-size: 1.1rem;
    padding: 8px 16px;
    background: #f8f9fa;
    border-radius: 50px;
    border: 2px solid #e5e5e5;
}

.vehicle-equivalent i {
    color: #3cb371;
    font-size: 20px;
}

.vehicle-main-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    margin-bottom: 30px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vehicle-main-image img {
    width: 100%;
    height: auto;
    object-fit: contain;
    animation: vehicleDrive 3s ease-in-out infinite;
}

@keyframes vehicleDrive {
    0%, 100% {
        transform: translateX(0) translateY(0);
    }
    25% {
        transform: translateX(15px) translateY(-3px);
    }
    50% {
        transform: translateX(0) translateY(0);
    }
    75% {
        transform: translateX(-15px) translateY(-3px);
    }
}

.vehicle-main-image:hover img {
    animation-play-state: paused;
    transform: scale(1.05);
}

.vehicle-specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.vehicle-spec-card {
    background: #fff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.vehicle-spec-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: #3cb371;
}

.vehicle-spec-card .icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, rgba(60, 179, 113, 0.1) 0%, rgba(46, 153, 96, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.vehicle-spec-card .icon i {
    font-size: 28px;
    color: #3cb371;
}

.vehicle-spec-card h6 {
    font-size: 0.9rem;
    color: #767676;
    margin-bottom: 4px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.vehicle-spec-card p {
    font-size: 1.25rem;
    font-weight: 700;
    color: #161920;
    margin: 0;
}

.vehicle-content-section {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.vehicle-content-section h2 {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700;
    color: #161920;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 3px solid #3cb371;
    display: inline-block;
}

.vehicle-content-section p {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #555;
}

.vehicle-features-list {
    list-style: none;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

.vehicle-features-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    font-size: 1rem;
    color: #161920;
    font-weight: 500;
    transition: all 0.3s ease;
}

.vehicle-features-list li:hover {
    background: rgba(60, 179, 113, 0.1);
    transform: translateX(5px);
}

.vehicle-features-list li i {
    font-size: 24px;
    color: #3cb371;
    flex-shrink: 0;
}

.vehicle-booking-sidebar {
    position: sticky;
    top: 100px;
}

.booking-card {
    background: #fff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    border: 2px solid #e5e5e5;
}

.booking-card h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #161920;
    margin-bottom: 25px;
    text-align: center;
}

.booking-card .form-control {
    padding: 14px 18px;
    border: 2px solid #e5e5e5;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.booking-card .form-control:focus {
    border-color: #3cb371;
    box-shadow: 0 0 0 3px rgba(60, 179, 113, 0.1);
    background: #fff;
    outline: none;
}

.booking-card select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%233cb371' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 40px;
    cursor: pointer;
}

.booking-card textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.booking-card small {
    display: block;
    margin-top: 5px;
}

.booking-card .form-label {
    font-weight: 600;
    color: #161920;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.booking-card .btn-book {
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%);
    color: #fff;
    padding: 16px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.1rem;
    border: none;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(60, 179, 113, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.booking-card .btn-book:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(60, 179, 113, 0.5);
}

.booking-card .btn-book i {
    font-size: 20px;
}

/* CHBS Booking Form Styling for Vehicle Page */
.booking-card .chbs-booking-form,
.booking-card .chbs-main {
    background: transparent !important;
    box-shadow: none !important;
    padding: 0 !important;
}

.booking-card .chbs-form-field label,
.booking-card .chbs-label {
    font-weight: 600 !important;
    color: #161920 !important;
    margin-bottom: 8px !important;
    font-size: 0.95rem !important;
}

.booking-card .chbs-form-field input[type="text"],
.booking-card .chbs-form-field input[type="date"],
.booking-card .chbs-form-field input[type="time"],
.booking-card .chbs-form-field select,
.booking-card .chbs-form-field textarea,
.booking-card input.chbs-date,
.booking-card input.chbs-time,
.booking-card input.chbs-location {
    padding: 14px 18px !important;
    border: 2px solid #e5e5e5 !important;
    border-radius: 12px !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
    background: #f8f9fa !important;
    width: 100% !important;
}

.booking-card .chbs-form-field input:focus,
.booking-card .chbs-form-field select:focus,
.booking-card .chbs-form-field textarea:focus,
.booking-card input.chbs-date:focus,
.booking-card input.chbs-time:focus,
.booking-card input.chbs-location:focus {
    border-color: #3cb371 !important;
    box-shadow: 0 0 0 3px rgba(60, 179, 113, 0.1) !important;
    background: #fff !important;
    outline: none !important;
}

.booking-card .chbs-button,
.booking-card .chbs-button-style-1,
.booking-card .chbs-button-style-2 {
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%) !important;
    color: #fff !important;
    padding: 16px 24px !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
    border: none !important;
    width: 100% !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 15px rgba(60, 179, 113, 0.4) !important;
    text-transform: none !important;
    margin-top: 10px !important;
}

.booking-card .chbs-button:hover,
.booking-card .chbs-button-style-1:hover,
.booking-card .chbs-button-style-2:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 25px rgba(60, 179, 113, 0.5) !important;
}

.booking-card .chbs-meta-icon-plus,
.booking-card .chbs-location-add {
    color: #3cb371 !important;
    background: rgba(60, 179, 113, 0.1) !important;
    border-radius: 8px !important;
    padding: 8px !important;
    transition: all 0.3s ease !important;
}

.booking-card .chbs-location-add:hover {
    background: rgba(60, 179, 113, 0.2) !important;
}

.booking-card .chbs-form-field {
    margin-bottom: 20px !important;
}

.booking-card .chbs-clear-fix {
    margin-bottom: 15px !important;
}

.booking-card .chbs-layout-50x50,
.booking-card .chbs-layout-100 {
    background: transparent !important;
}

.booking-card .chbs-tab,
.booking-card .chbs-main-navigation {
    background: transparent !important;
}

.booking-card .chbs-main-navigation-default > ul > li > a {
    border-radius: 12px !important;
    transition: all 0.3s ease !important;
}

.booking-card .chbs-main-navigation-default > ul > li.chbs-state-selected > a {
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%) !important;
    color: #fff !important;
}

/* Date and time picker styling */
.booking-card .ui-datepicker {
    border-radius: 12px !important;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15) !important;
    border: 2px solid #3cb371 !important;
}

.booking-card .ui-datepicker-header {
    background: linear-gradient(135deg, #3cb371 0%, #2e9960 100%) !important;
    color: #fff !important;
    border-radius: 10px 10px 0 0 !important;
}

.booking-card .ui-state-active,
.booking-card .ui-state-highlight {
    background: #3cb371 !important;
    color: #fff !important;
    border-radius: 8px !important;
}

@media (max-width: 991px) {
    .vehicle-hero-header {
        padding: 30px 25px;
    }
    
    .vehicle-content-section {
        padding: 30px 25px;
    }
    
    .booking-card {
        padding: 30px 25px;
        margin-top: 40px;
    }
    
    .vehicle-booking-sidebar {
        position: static;
    }
}

@media (max-width: 767px) {
    .vehicle-details-page {
        padding: 100px 0 40px;
    }
    
    .vehicle-hero-header {
        padding: 25px 20px;
        margin-bottom: 30px;
    }
    
    .vehicle-specs-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .vehicle-content-section {
        padding: 25px 20px;
        margin-bottom: 25px;
    }
    
    .vehicle-features-list {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .booking-card {
        padding: 25px 20px;
    }
}
</style>

<!-- Vehicle Details Section -->
<section class="vehicle-details-page">
    <div class="container">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>

                <div class="vehicle-hero-header">
                    <div class="row g-4 align-items-center">
                        <div class="col-12 col-lg-8">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="d-flex justify-content-lg-end">
                                <span class="vehicle-type-badge">
                                    <i class="ti ti-users-group"></i>
                                    Book Your Group Trip
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <!-- Vehicle Image -->
                        <div class="vehicle-main-image">
                            <img src="<?php echo esc_url($bg_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                        </div>

                        <!-- Vehicle Specifications -->
                        <div class="vehicle-specs-grid">
                            <div class="vehicle-spec-card">
                                            <div class="icon">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <div>
                                    <h6>Passengers</h6>
                                    <p><?php echo esc_html(get_post_meta($post->ID, "passengers", true) ?: '4'); ?></p>
                                        </div>
                                    </div>

                            <div class="vehicle-spec-card">
                                            <div class="icon">
                                                <i class="ti ti-luggage"></i>
                                            </div>
                                            <div>
                                                <h6>Luggage</h6>
                                    <p><?php echo esc_html(get_post_meta($post->ID, "large_bag", true) ?: '2'); ?> Bags</p>
                                        </div>
                                    </div>

                            <div class="vehicle-spec-card">
                                            <div class="icon">
                                                <i class="ti ti-car"></i>
                                            </div>
                                            <div>
                                    <h6>Vehicle Class</h6>
                                    <p><?php 
                                    $term = wp_get_post_terms(get_the_ID(), 'vehicle-type', array('fields' => 'all'));
                                    if (!empty($term) && !is_wp_error($term)) {
                                        echo esc_html($term[0]->name);
                                    } else {
                                        echo 'Premium';
                                    }
                                    ?></p>
                                            </div>
                                        </div>
                                    </div>

                        <!-- Overview Section -->
                        <div class="vehicle-content-section">
                            <h2>Overview</h2>
                            <div>
                                <?php 
                                $passengers = get_post_meta($post->ID, "passengers", true) ?: '8';
                                $luggage = get_post_meta($post->ID, "large_bag", true) ?: '6';
                                $vehicle_name = get_the_title();
                                
                                // Get vehicle type to determine content
                                $vehicle_type_terms = wp_get_post_terms(get_the_ID(), 'vehicle-type', array('fields' => 'names'));
                                $vehicle_type = !empty($vehicle_type_terms) ? strtolower($vehicle_type_terms[0]) : 'standard';
                                
                                // Determine vehicle category with comprehensive classification
                                $title_lower = strtolower($vehicle_name);
                                
                                // Check if it's a van/bus (7+ passengers or contains van/bus keywords)
                                $is_van = (strpos($title_lower, 'van') !== false || 
                                          strpos($title_lower, 'bus') !== false || 
                                          strpos($title_lower, 'minibus') !== false ||
                                          strpos($title_lower, 'sprinter') !== false ||
                                          strpos($title_lower, 'vito') !== false ||
                                          $passengers >= 7);
                                
                                // Luxury/Premium indicators
                                $luxury_keywords = (strpos($title_lower, 'premium sedan') !== false || 
                                                   strpos($title_lower, 'luxury') !== false || 
                                                   strpos($title_lower, 'first class') !== false ||
                                                   strpos($title_lower, 'first-class') !== false ||
                                                   strpos($title_lower, 'executive') !== false ||
                                                   strpos($title_lower, 'business class') !== false);
                                
                                // Luxury car models
                                $luxury_models = (strpos($title_lower, 's-class') !== false || 
                                                 strpos($title_lower, 's class') !== false ||
                                                 strpos($title_lower, 'e-class') !== false || 
                                                 strpos($title_lower, 'e class') !== false ||
                                                 strpos($title_lower, 'v-class') !== false ||
                                                 strpos($title_lower, 'bmw 5') !== false ||
                                                 strpos($title_lower, 'bmw 7') !== false ||
                                                 strpos($title_lower, 'bmw 8') !== false ||
                                                 strpos($title_lower, 'audi a6') !== false ||
                                                 strpos($title_lower, 'audi a7') !== false ||
                                                 strpos($title_lower, 'audi a8') !== false ||
                                                 strpos($title_lower, 'mercedes s') !== false ||
                                                 strpos($title_lower, 'mercedes e') !== false ||
                                                 strpos($title_lower, 'mercedes v') !== false ||
                                                 strpos($title_lower, 'lexus') !== false ||
                                                 strpos($title_lower, 'porsche') !== false ||
                                                 strpos($title_lower, 'bentley') !== false ||
                                                 strpos($title_lower, 'rolls') !== false);
                                
                                // Economy/Budget brands and models
                                $economy_brand = (strpos($title_lower, 'volkswagen') !== false || 
                                                 strpos($title_lower, 'vw passat') !== false ||
                                                 strpos($title_lower, 'vw golf') !== false ||
                                                 strpos($title_lower, 'toyota') !== false ||
                                                 strpos($title_lower, 'honda') !== false ||
                                                 strpos($title_lower, 'ford') !== false ||
                                                 strpos($title_lower, 'opel') !== false ||
                                                 strpos($title_lower, 'skoda') !== false ||
                                                 strpos($title_lower, 'seat') !== false ||
                                                 strpos($title_lower, 'hyundai') !== false ||
                                                 strpos($title_lower, 'kia') !== false ||
                                                 strpos($title_lower, 'nissan') !== false ||
                                                 strpos($title_lower, 'mazda') !== false ||
                                                 strpos($title_lower, 'peugeot') !== false ||
                                                 strpos($title_lower, 'renault') !== false ||
                                                 strpos($title_lower, 'citroen') !== false ||
                                                 strpos($title_lower, 'dacia') !== false ||
                                                 strpos($title_lower, 'fiat') !== false);
                                
                                // Standard brands (mid-range, not economy, not luxury)
                                $standard_brand = (strpos($title_lower, 'volvo') !== false ||
                                                  strpos($title_lower, 'alfa romeo') !== false ||
                                                  strpos($title_lower, 'infiniti') !== false ||
                                                  strpos($title_lower, 'acura') !== false ||
                                                  strpos($title_lower, 'buick') !== false ||
                                                  strpos($title_lower, 'chrysler') !== false);
                                
                                // Determine if luxury (keywords OR luxury models, but NOT economy/standard brands)
                                $is_luxury = ($luxury_keywords || $luxury_models) && !$economy_brand && !$standard_brand;
                                
                                // Set category for content
                                if ($is_van && $is_luxury) {
                                    $category = 'luxury-van'; // First Class Van, V-Class, Premium Sprinter
                                } elseif ($is_luxury && !$is_van) {
                                    $category = 'luxury'; // S-Class, E-Class, BMW 5/7, Audi A6/A8
                                } elseif ($is_van) {
                                    $category = 'van'; // Standard Passenger Van, Minibus
                                } elseif ($economy_brand) {
                                    $category = 'economy'; // VW Passat, Toyota Camry, etc.
                                } else {
                                    $category = 'standard'; // Volvo, Alfa Romeo, etc.
                                }
                                ?>
                                
                                <?php if ($category === 'luxury-van'): ?>
                                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #161920; margin-bottom: 15px;"><?php echo esc_html($vehicle_name); ?> – Premium Executive Group Transportation for Frankfurt and Germany</h3>
                                    
                                    <p>The <?php echo esc_html($vehicle_name); ?> represents the pinnacle of luxury group transportation in Frankfurt and Germany. Accommodating up to <?php echo esc_html($passengers); ?> passengers with <?php echo esc_html($luggage); ?> pieces of premium luggage, this executive van combines spacious comfort with sophisticated elegance for corporate groups, VIP delegations, family celebrations, and luxury tours requiring the highest standards of service.</p>

                                    <p>Experience first-class group travel with handcrafted leather seating, individual climate controls, premium entertainment systems, and whisper-quiet cabin acoustics. The <?php echo esc_html($vehicle_name); ?> features executive-grade amenities including ambient lighting, privacy glass, wireless connectivity, and ergonomic captain's chairs designed for maximum comfort during extended journeys throughout Germany.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Executive Features and Luxury Amenities</h4>
                                    <p>Premium vans are equipped with first-class amenities including individual USB charging ports, premium sound systems, adjustable ambient lighting, and spacious legroom exceeding standard configurations. Climate-controlled interiors with multi-zone temperature settings ensure optimal comfort for every passenger. Generous luggage capacity accommodates golf equipment, ski gear, and business materials without compromising passenger space.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Ideal Applications for Premium Group Service</h4>
                                    <ul style="list-style: disc; padding-left: 25px; line-height: 1.8; color: #555;">
                                        <li><strong>Frankfurt Airport VIP Transfers:</strong> First-class group transportation with meet-and-greet service at Frankfurt Airport (FRA)</li>
                                        <li><strong>Corporate Executive Travel:</strong> Premium chauffeur service for board members, executive teams, and business delegations</li>
                                        <li><strong>Luxury Tours:</strong> Elegant sightseeing experiences exploring Frankfurt, Heidelberg, Rhine Valley, and German cultural landmarks</li>
                                        <li><strong>Special Events:</strong> Premium transportation for weddings, galas, exclusive celebrations, and VIP occasions</li>
                                        <li><strong>Family Luxury Travel:</strong> First-class comfort for multi-generational family trips and milestone celebrations</li>
                                        <li><strong>Golf & Leisure Groups:</strong> Spacious transportation for golf outings, wine tours, and premium leisure activities</li>
                                    </ul>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Professional Chauffeur Excellence</h4>
                                    <p>Every <?php echo esc_html($vehicle_name); ?> journey includes a professionally trained chauffeur with extensive local knowledge, impeccable driving records, and commitment to discretion and excellence. Chauffeurs are fluent in English and German, ensuring seamless communication for international groups. Expect punctuality, professionalism, and personalized service tailored to executive and luxury standards.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Premium Value for Group Travel</h4>
                                    <p>Booking a <?php echo esc_html($vehicle_name); ?> for <?php echo esc_html($passengers); ?> passengers delivers exceptional value compared to multiple luxury sedans or standard transportation. Group travel in a single premium vehicle reduces costs while elevating the experience. Transparent pricing with no hidden fees ensures predictable budgeting for corporate travel departments and event planners.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Why Choose This Premium Van</h4>
                                    <p>The <?php echo esc_html($vehicle_name); ?> represents the optimal choice for luxury group transportation in Frankfurt and Germany. Its combination of spacious capacity, first-class amenities, sophisticated design, and professional service makes it ideal for corporate executives, VIP groups, and travelers who demand excellence. Whether navigating Frankfurt's business district, traveling to Rhine Valley vineyards, or transferring groups to Munich, this premium van delivers uncompromising luxury, reliability, and prestige.</p>

                                    <p>Reserve your <?php echo esc_html($vehicle_name); ?> today and experience first-class group transportation with professional chauffeur service, guaranteed punctuality, and uncompromising attention to detail throughout Frankfurt and Germany.</p>
                                
                                <?php elseif ($category === 'van'): ?>
                                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #161920; margin-bottom: 15px;"><?php echo esc_html($vehicle_name); ?> – Premium Group Transportation for Frankfurt and Germany</h3>
                                
                                <p>The <?php echo esc_html($vehicle_name); ?> provides exceptional comfort and reliability for group travel throughout Frankfurt, Germany, and surrounding regions. Designed to accommodate up to <?php echo esc_html($passengers); ?> passengers with <?php echo esc_html($luggage); ?> large suitcases, this passenger van delivers the perfect balance of spaciousness, efficiency, and modern amenities for business trips, family vacations, airport transfers, and corporate events.</p>

                                <p>Whether you require transportation for a business delegation, family outing, or group tour, this passenger van ensures every journey is comfortable and stress-free. The spacious interior features ergonomic seating, ample legroom, and climate control to maintain optimal comfort throughout your trip. Large panoramic windows provide excellent visibility, allowing passengers to enjoy scenic routes across Germany while traveling in style.</p>

                                <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Comfort and Convenience Features</h4>
                                <p>Modern passenger vans are equipped with premium amenities designed for long-distance comfort. Air conditioning ensures a pleasant cabin temperature regardless of weather conditions, while adjustable seating allows passengers to customize their comfort level. Entertainment systems, USB charging ports, and Wi-Fi connectivity keep passengers connected and entertained during extended journeys. The generous luggage capacity accommodates business equipment, sports gear, or vacation luggage without compromising passenger space.</p>

                                <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Ideal Applications for Passenger Van Service</h4>
                                <ul style="list-style: disc; padding-left: 25px; line-height: 1.8; color: #555;">
                                    <li><strong>Frankfurt Airport Transfers:</strong> Reliable group transportation to and from Frankfurt Airport (FRA) with meet-and-greet service</li>
                                    <li><strong>Corporate Transportation:</strong> Professional chauffeur service for business meetings, conferences, and executive travel</li>
                                    <li><strong>City Tours:</strong> Comfortable sightseeing transportation for exploring Frankfurt, Heidelberg, Rhine Valley, and German landmarks</li>
                                    <li><strong>Event Transportation:</strong> Group shuttle service for weddings, conferences, trade shows, and special occasions</li>
                                    <li><strong>Family Vacations:</strong> Spacious travel solution for multi-generational trips with luggage and equipment</li>
                                    <li><strong>Sports Teams:</strong> Reliable transportation for teams traveling to competitions and training sessions</li>
                                </ul>

                                <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Safety and Reliability</h4>
                                <p>Safety is paramount in passenger van transportation. This vehicle features advanced safety systems including electronic stability control, anti-lock braking systems (ABS), multiple airbags, and modern driver assistance technologies. Professional chauffeurs undergo comprehensive training and maintain impeccable driving records, ensuring secure transportation for every passenger. Regular maintenance schedules and rigorous safety inspections guarantee optimal vehicle performance and reliability.</p>

                                <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Cost-Effective Group Travel Solution</h4>
                                <p>Booking a passenger van for <?php echo esc_html($passengers); ?> passengers proves significantly more economical than coordinating multiple taxis or rental cars. Group travel in a single vehicle reduces transportation costs, simplifies logistics, and minimizes environmental impact. Transparent pricing with no hidden fees ensures budget-friendly travel for families, businesses, and organizations throughout Germany.</p>

                                <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Why Choose This Passenger Van</h4>
                                <p>The <?php echo esc_html($vehicle_name); ?> represents the optimal choice for group transportation in Frankfurt and Germany. Its combination of passenger capacity, luggage space, comfort features, and professional service makes it ideal for diverse travel needs. Whether navigating Frankfurt's business district, traveling to Rhine Valley vineyards, or transferring groups to Munich, this passenger van delivers exceptional service, reliability, and value.</p>

                                <p>Book your <?php echo esc_html($vehicle_name); ?> today and experience premium group transportation with professional chauffeur service, guaranteed punctuality, and comprehensive travel support throughout Germany.</p>
                                
                                <?php elseif ($category === 'luxury'): ?>
                                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #161920; margin-bottom: 15px;"><?php echo esc_html($vehicle_name); ?> – Executive Luxury Transportation in Frankfurt and Germany</h3>
                                    
                                    <p>The <?php echo esc_html($vehicle_name); ?> represents the pinnacle of luxury chauffeur service in Frankfurt and Germany. Accommodating up to <?php echo esc_html($passengers); ?> passengers with <?php echo esc_html($luggage); ?> pieces of luggage, this premium sedan combines sophisticated elegance with cutting-edge technology for discerning business executives, VIP clients, and luxury travelers.</p>

                                    <p>Experience unparalleled comfort with handcrafted leather interiors, advanced climate control, and whisper-quiet cabin acoustics. The <?php echo esc_html($vehicle_name); ?> features state-of-the-art entertainment systems, ambient lighting, and ergonomic seating designed for maximum relaxation during airport transfers, business meetings, and executive travel throughout Germany.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Premium Features and Amenities</h4>
                                    <p>Luxury sedans are equipped with executive-class amenities including premium sound systems, wireless connectivity, USB charging ports, and privacy glass. Climate-controlled interiors ensure optimal comfort regardless of weather conditions. Spacious trunk capacity accommodates business equipment and luggage without compromising passenger comfort.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Ideal for Executive Transportation</h4>
                                    <ul style="list-style: disc; padding-left: 25px; line-height: 1.8; color: #555;">
                                        <li><strong>Frankfurt Airport VIP Transfers:</strong> First-class chauffeur service with meet-and-greet at Frankfurt Airport (FRA)</li>
                                        <li><strong>Business Meetings:</strong> Professional transportation for executives, board members, and corporate clients</li>
                                        <li><strong>Luxury City Tours:</strong> Elegant sightseeing experiences in Frankfurt, Heidelberg, and Rhine Valley</li>
                                        <li><strong>Special Occasions:</strong> Premium transportation for weddings, galas, and exclusive events</li>
                                        <li><strong>Point-to-Point Service:</strong> Discreet, reliable transfers between hotels, offices, and venues</li>
                                    </ul>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Professional Chauffeur Excellence</h4>
                                    <p>Every <?php echo esc_html($vehicle_name); ?> journey includes a professionally trained chauffeur with extensive local knowledge, impeccable driving records, and commitment to discretion. Chauffeurs are fluent in English and German, ensuring seamless communication for international clients. Expect punctuality, professionalism, and personalized service tailored to executive standards.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Why Choose Luxury Sedan Service</h4>
                                    <p>The <?php echo esc_html($vehicle_name); ?> delivers superior comfort, prestige, and reliability for business and luxury travel. Its combination of elegant design, advanced features, and professional service makes it the preferred choice for executives, VIPs, and travelers who demand excellence. Whether traveling to business meetings in Frankfurt's financial district or exploring Germany's cultural landmarks, this luxury sedan ensures every journey reflects your standards.</p>

                                    <p>Reserve your <?php echo esc_html($vehicle_name); ?> today and experience first-class chauffeur service with guaranteed punctuality, discretion, and uncompromising attention to detail throughout Frankfurt and Germany.</p>
                                
                                <?php elseif ($category === 'economy'): ?>
                                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #161920; margin-bottom: 15px;"><?php echo esc_html($vehicle_name); ?> – Affordable, Reliable Transportation for Frankfurt and Germany</h3>
                                    
                                    <p>The <?php echo esc_html($vehicle_name); ?> delivers budget-friendly, dependable transportation for travelers seeking excellent value throughout Frankfurt, Germany, and surrounding regions. Accommodating up to <?php echo esc_html($passengers); ?> passengers with <?php echo esc_html($luggage); ?> suitcases, this economy sedan provides comfortable, efficient travel for airport transfers, city transportation, and day trips at competitive rates.</p>

                                    <p>Perfect for budget-conscious travelers, students, business trips, and families, the <?php echo esc_html($vehicle_name); ?> offers practical transportation without compromising on safety or reliability. Clean, well-maintained vehicles with comfortable seating, air conditioning, and essential amenities ensure pleasant journeys across Germany at affordable prices.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Essential Comfort and Features</h4>
                                    <p>Economy vehicles include air conditioning, comfortable seating, and adequate trunk space for luggage and personal items. Modern safety features including airbags and stability control ensure secure travel. Clean interiors and regular maintenance guarantee reliable, comfortable transportation for every journey. Professional chauffeurs provide courteous service with local knowledge of Frankfurt and German routes.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Ideal for Budget-Friendly Travel</h4>
                                    <ul style="list-style: disc; padding-left: 25px; line-height: 1.8; color: #555;">
                                        <li><strong>Frankfurt Airport Transfers:</strong> Affordable transportation to and from Frankfurt Airport (FRA) with reliable service</li>
                                        <li><strong>Business Travel:</strong> Cost-effective chauffeur service for meetings, conferences, and corporate travel on a budget</li>
                                        <li><strong>City Transportation:</strong> Economical travel within Frankfurt, Heidelberg, and German cities</li>
                                        <li><strong>Student & Youth Travel:</strong> Budget-friendly transportation for students, backpackers, and young travelers</li>
                                        <li><strong>Short Trips:</strong> Efficient point-to-point transfers between hotels, train stations, and local destinations</li>
                                        <li><strong>Daily Commutes:</strong> Affordable regular transportation for work, shopping, and local errands</li>
                                    </ul>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Safety and Reliability</h4>
                                    <p>Despite competitive pricing, safety remains a top priority. All vehicles undergo regular maintenance and safety inspections. Professional chauffeurs are licensed, experienced, and familiar with Frankfurt and German roads. Modern safety systems including anti-lock brakes, stability control, and airbags ensure secure travel. Transparent pricing with no hidden fees makes budgeting simple and predictable.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Best Value for Money</h4>
                                    <p>The <?php echo esc_html($vehicle_name); ?> represents the most economical choice for travelers seeking reliable transportation at the lowest rates. Competitive pricing makes professional chauffeur service accessible to budget travelers, students, and cost-conscious businesses. Save money without sacrificing safety, reliability, or professional service. Ideal for travelers who prioritize affordability while still requiring dependable, comfortable transportation.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Why Choose Economy Transportation</h4>
                                    <p>Economy vehicles offer the perfect solution for travelers who need reliable transportation at the most affordable rates. Whether you're a student exploring Germany, a business traveler managing expenses, or a family seeking budget-friendly airport transfers, the <?php echo esc_html($vehicle_name); ?> delivers dependable service without breaking the bank. Enjoy professional chauffeur service, clean vehicles, and safe travel at prices that fit any budget.</p>

                                    <p>Book your <?php echo esc_html($vehicle_name); ?> today and experience affordable, reliable chauffeur service with professional drivers, comfortable travel, and unbeatable value throughout Frankfurt and Germany.</p>
                                
                                <?php else: // Standard sedan (mid-range like Volvo, Alfa Romeo) ?>
                                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #161920; margin-bottom: 15px;"><?php echo esc_html($vehicle_name); ?> – Reliable Comfort for Frankfurt and Germany Travel</h3>
                                    
                                    <p>The <?php echo esc_html($vehicle_name); ?> offers dependable, comfortable transportation for business and leisure travel throughout Frankfurt, Germany, and surrounding regions. Designed to accommodate up to <?php echo esc_html($passengers); ?> passengers with <?php echo esc_html($luggage); ?> suitcases, this sedan provides excellent value, modern amenities, and professional chauffeur service for airport transfers, city travel, and day trips.</p>

                                    <p>Whether traveling for business meetings, family vacations, or exploring German cities, the <?php echo esc_html($vehicle_name); ?> ensures comfortable, stress-free journeys. The well-appointed interior features comfortable seating, climate control, and ample legroom for relaxed travel. Modern safety systems and professional chauffeurs guarantee secure, reliable transportation across Germany.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Comfort and Convenience</h4>
                                    <p>Standard sedans feature air conditioning, comfortable seating, and modern entertainment systems. USB charging ports keep devices powered during travel. Spacious trunk capacity accommodates luggage, business equipment, and travel essentials. Quiet, smooth rides ensure passengers arrive refreshed and ready for their destination.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Perfect for Various Travel Needs</h4>
                                    <ul style="list-style: disc; padding-left: 25px; line-height: 1.8; color: #555;">
                                        <li><strong>Frankfurt Airport Transfers:</strong> Reliable transportation to and from Frankfurt Airport (FRA) with flight monitoring</li>
                                        <li><strong>Business Travel:</strong> Professional chauffeur service for meetings, conferences, and corporate appointments</li>
                                        <li><strong>City Transportation:</strong> Convenient travel within Frankfurt, Heidelberg, and German cities</li>
                                        <li><strong>Day Trips:</strong> Comfortable transportation for sightseeing and exploring Rhine Valley, castles, and landmarks</li>
                                        <li><strong>Hotel Transfers:</strong> Point-to-point service between hotels, train stations, and destinations</li>
                                    </ul>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Professional Service and Safety</h4>
                                    <p>Professional chauffeurs provide courteous, reliable service with local knowledge and language skills. Vehicles undergo regular maintenance and safety inspections. Modern safety features including airbags, stability control, and anti-lock braking ensure secure travel. Transparent pricing with no hidden fees makes budgeting simple for families and businesses.</p>

                                    <h4 style="font-size: 1.15rem; font-weight: 600; color: #161920; margin: 25px 0 15px;">Excellent Value for Money</h4>
                                    <p>The <?php echo esc_html($vehicle_name); ?> delivers outstanding value for travelers seeking reliable, comfortable transportation without premium pricing. Its combination of comfort, safety, and professional service makes it ideal for business travelers, families, and tourists exploring Frankfurt and Germany. Competitive rates and flexible booking options ensure accessible, quality transportation for every journey.</p>

                                    <p>Book your <?php echo esc_html($vehicle_name); ?> today and enjoy reliable chauffeur service with professional drivers, comfortable travel, and excellent value throughout Frankfurt and Germany.</p>
                                <?php endif; ?>

                                <?php if (get_the_content()): ?>
                                    <div style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #e5e5e5;">
                                        <?php the_content(); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="vehicle-booking-sidebar">
                            <!-- Booking Form -->
                            <div class="booking-card">
                                <h4><i class="ti ti-calendar-check" style="margin-right: 8px; color: #3cb371;"></i>Book This Vehicle</h4>
                                
                                <?php 
                                $booking_url = esc_url( home_url( '/booking-page/' ) );
                                $vehicle_passengers = get_post_meta($post->ID, "passengers", true) ?: '12';
                                $vehicle_luggage = get_post_meta($post->ID, "large_bag", true) ?: '10';
                                ?>
                                
                                <div style="background: rgba(60, 179, 113, 0.1); padding: 15px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #3cb371;">
                                    <p style="margin: 0; font-size: 0.95rem; color: #161920;">
                                        <i class="ti ti-info-circle" style="color: #3cb371; margin-right: 5px;"></i>
                                        <strong>Capacity:</strong> <?php echo esc_html($vehicle_passengers); ?> passengers • <?php echo esc_html($vehicle_luggage); ?> bags
                                    </p>
                                        </div>
                                
                                <form id="custom-vehicle-booking" method="get" action="<?php echo esc_url($booking_url); ?>">
                                    <!-- Hidden parameters for CHBS -->
                                    <input type="hidden" name="widget_second_step" value="1">
                                    <input type="hidden" name="vehicle_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="vehicle_passengers" value="<?php echo esc_attr($vehicle_passengers); ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label" for="booking-pickup-date">
                                            <i class="ti ti-calendar" style="color: #3cb371; margin-right: 5px;"></i>
                                            Pickup Date
                                        </label>
                                        <input type="date" id="booking-pickup-date" name="pickup_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label" for="booking-pickup-time">
                                            <i class="ti ti-clock" style="color: #3cb371; margin-right: 5px;"></i>
                                            Pickup Time
                                        </label>
                                        <input type="time" id="booking-pickup-time" name="pickup_time" class="form-control" required value="10:00">
                                        </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label" for="booking-pickup-location">
                                            <i class="ti ti-map-pin" style="color: #3cb371; margin-right: 5px;"></i>
                                            Pickup Location
                                        </label>
                                        <input type="text" id="booking-pickup-location" name="pickup_location" class="form-control" placeholder="Frankfurt Airport, Terminal 1..." required>
                                        <small style="color: #767676; font-size: 0.85rem; display: block; margin-top: 5px;">Enter full address or landmark</small>
                                        </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label" for="booking-dropoff-location">
                                            <i class="ti ti-flag" style="color: #3cb371; margin-right: 5px;"></i>
                                            Drop-off Location
                                        </label>
                                        <input type="text" id="booking-dropoff-location" name="dropoff_location" class="form-control" placeholder="Hotel, City center..." required>
                                        <small style="color: #767676; font-size: 0.85rem; display: block; margin-top: 5px;">Enter destination address</small>
                                        </div>
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <label class="form-label" for="booking-passengers">
                                                <i class="ti ti-users" style="color: #3cb371; margin-right: 5px;"></i>
                                                Passengers
                                            </label>
                                            <select id="booking-passengers" name="passengers" class="form-control" required>
                                                <?php for ($i = 1; $i <= $vehicle_passengers; $i++): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $vehicle_passengers) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="booking-luggage">
                                                <i class="ti ti-luggage" style="color: #3cb371; margin-right: 5px;"></i>
                                                Luggage
                                            </label>
                                            <select id="booking-luggage" name="luggage" class="form-control" required>
                                                <?php for ($i = 0; $i <= $vehicle_luggage; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn-book">
                                        <i class="ti ti-arrow-right"></i>
                                        Continue to Booking
                                    </button>
                                    
                                    <p style="text-align: center; margin-top: 15px; font-size: 0.85rem; color: #767676;">
                                        <i class="ti ti-shield-check" style="color: #3cb371;"></i>
                                        Secure booking • Free cancellation
                                    </p>
                                </form>
                                
                                <script>
                                jQuery(document).ready(function($) {
                                    $('#custom-vehicle-booking').on('submit', function() {
                                        // Store vehicle info for auto-selection on booking page
                                        sessionStorage.setItem('chbs_preselected_vehicle', JSON.stringify({
                                            id: <?php echo get_the_ID(); ?>,
                                            passengers: <?php echo $vehicle_passengers; ?>,
                                            luggage: <?php echo $vehicle_luggage; ?>,
                                            name: '<?php echo esc_js(get_the_title()); ?>'
                                        }));
                                        sessionStorage.setItem('chbs_force_step_2', '1');
                                    });
                                });
                                </script>
                            </div>

                            <!-- Features Section -->
                            <div class="vehicle-content-section" style="margin-top: 30px;">
                                <h2>Features & Amenities</h2>
                                <ul class="vehicle-features-list">
                                    <li><i class="ti ti-rosette-discount-check"></i> Meet & Greet Included</li>
                                    <li><i class="ti ti-rosette-discount-check"></i> Free Cancellation</li>
                                    <li><i class="ti ti-rosette-discount-check"></i> Free Waiting Time</li>
                                    <li><i class="ti ti-rosette-discount-check"></i> Safe & Secure Travel</li>
                                    <li><i class="ti ti-rosette-discount-check"></i> Professional Chauffeur</li>
                                    <li><i class="ti ti-rosette-discount-check"></i> 24/7 Customer Support</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; endif; ?>
    </div>

    <!-- Divider -->
    <div class="divider-sm"></div>
</section>



<?php get_template_part('partials/related', 'tours'); ?>




<?php get_footer(); ?>