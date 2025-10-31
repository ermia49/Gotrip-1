<?php
/*Template Name: Transfer*/

get_header(); ?>


<section class="hero-section bg-dark booking-hero">
     <?php gotriptoday_social_icons(); ?>
    <!-- Background Slider -->
    <div class="background-swiper1">
        <div class="h-100">
            <div class="h-100 tour_slide"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/slide1.webp')">
            </div>            
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="search_banner tour_banner ">
                <div class="hero-header-group">
                    <ul class="nav forms-tabs booking-tabs mx-auto" id="myTab" role="tablist" aria-label="<?php esc_attr_e('Booking navigation', 'gotriptoday'); ?>">
                        <li class="nav-item" role="presentation">
                            <a class="tab-link active" href="<?php echo home_url('/booking-page'); ?>" type="button" aria-current="page"><?php esc_html_e('Transfer', 'gotriptoday'); ?></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="tab-link" href="<?php echo home_url('/day-trip'); ?>" type="button"><?php esc_html_e('Day Trip', 'gotriptoday'); ?></a>
                        </li>
                    </ul>
                    <h1 class="heading_nav"><?php the_title(); ?></h1>
                </div>
                <div class="hero-content">
                    <p class="hero-description mb-4"><?php esc_html_e('Reserve your Frankfurt airport transfer or Germany-wide chauffeur service in seconds. Choose your vehicle, tailor your journey, and confirm instantly.', 'gotriptoday'); ?></p>
                    <div class="hero-cta">
                        <a class="btn btn-success btn-lg" href="#booking-form"><?php esc_html_e('Start Your Booking', 'gotriptoday'); ?></a>
                        <a class="btn btn-outline-light btn-lg" href="<?php echo home_url('/contact'); ?>"><?php esc_html_e('Talk to our team', 'gotriptoday'); ?></a>
                    </div>
                    <ul class="hero-meta" aria-label="<?php esc_attr_e('Service highlights', 'gotriptoday'); ?>">
                        <li><i class="ti ti-plane-departure" aria-hidden="true"></i><span class="visually-hidden"><?php esc_html_e('Real-time flight monitoring', 'gotriptoday'); ?></span></li>
                        <li><i class="ti ti-shield-check" aria-hidden="true"></i><span class="visually-hidden"><?php esc_html_e('Fully licensed chauffeurs', 'gotriptoday'); ?></span></li>
                        <li><i class="ti ti-stars" aria-hidden="true"></i><span class="visually-hidden"><?php esc_html_e('5-star traveler reviews', 'gotriptoday'); ?></span></li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="booking-section booking-form-section">
    <!-- Divider -->
    <div class="divider-sm"></div>

    <div class="container">
        <div class="booking-steps" aria-label="<?php esc_attr_e('How online booking works', 'gotriptoday'); ?>">
            <article class="booking-step">
                <span class="booking-step-number" aria-hidden="true">1</span>
                <div>
                    <h3><?php esc_html_e('Plan your transfer', 'gotriptoday'); ?></h3>
                    <p><?php esc_html_e('Enter pickup, drop-off, and travel date to generate live availability.', 'gotriptoday'); ?></p>
                </div>
            </article>
            <article class="booking-step">
                <span class="booking-step-number" aria-hidden="true">2</span>
                <div>
                    <h3><?php esc_html_e('Customize every detail', 'gotriptoday'); ?></h3>
                    <p><?php esc_html_e('Select vehicle class, add extras, and share any flight or passenger notes.', 'gotriptoday'); ?></p>
                </div>
            </article>
            <article class="booking-step">
                <span class="booking-step-number" aria-hidden="true">3</span>
                <div>
                    <h3><?php esc_html_e('Confirm & get instant updates', 'gotriptoday'); ?></h3>
                    <p><?php esc_html_e('Secure payment, automated confirmation, and concierge support 24/7.', 'gotriptoday'); ?></p>
                </div>
            </article>
        </div>
        <div class="row justify-content-center g-4 g-xl-5 align-items-start">
            <div id="booking-form" class="col-12 col-xl-10 col-xxl-8 go_trip_bookingform booking-form-wrapper" tabindex="-1">
                <?php echo do_shortcode('[chbs_booking_form booking_form_id="10007"]'); ?>
            </div>
        </div>
        <div class="booking-benefits-shell">
            <div class="booking-benefits-card">
                <div class="booking-benefits-content">
                    <span class="booking-benefits-eyebrow text-success"><?php esc_html_e('Why book with GoTripToday', 'gotriptoday'); ?></span>
                    <h2 class="booking-benefits-title"><?php esc_html_e('Premium transfers tailored to you', 'gotriptoday'); ?></h2>
                    <p class="booking-benefits-copy mb-0"><?php esc_html_e('Every reservation receives concierge-level support so your journey stays seamless from airport pickup to final drop-off.', 'gotriptoday'); ?></p>
                    <div class="booking-benefits-cta">
                        <a class="btn btn-success" href="<?php echo home_url('/contact'); ?>"><?php esc_html_e('Schedule a concierge call', 'gotriptoday'); ?></a>
                    </div>
                </div>
                <ul class="transfer_features booking-benefits-list" aria-label="<?php esc_attr_e('Key benefits of booking your transfer with GoTripToday', 'gotriptoday'); ?>">
                    <li title="<?php esc_attr_e('Secure booking', 'gotriptoday'); ?>">
                        <span class="booking-benefits-icon" aria-hidden="true"><i class="ti ti-lock-check"></i></span>
                        <span class="visually-hidden"><?php esc_html_e('Secure booking', 'gotriptoday'); ?></span>
                    </li>
                    <li title="<?php esc_attr_e('Satisfaction guarantee', 'gotriptoday'); ?>">
                        <span class="booking-benefits-icon" aria-hidden="true"><i class="ti ti-rosette-discount-check"></i></span>
                        <span class="visually-hidden"><?php esc_html_e('Satisfaction guarantee', 'gotriptoday'); ?></span>
                    </li>
                    <li title="<?php esc_attr_e('Flexible scheduling', 'gotriptoday'); ?>">
                        <span class="booking-benefits-icon" aria-hidden="true"><i class="ti ti-heart-check"></i></span>
                        <span class="visually-hidden"><?php esc_html_e('Flexible scheduling', 'gotriptoday'); ?></span>
                    </li>
                    <li title="<?php esc_attr_e('24/7 customer support', 'gotriptoday'); ?>">
                        <span class="booking-benefits-icon" aria-hidden="true"><i class="ti ti-help"></i></span>
                        <span class="visually-hidden"><?php esc_html_e('24/7 customer support', 'gotriptoday'); ?></span>
                    </li>
                    <li title="<?php esc_attr_e('5-star rated service', 'gotriptoday'); ?>">
                        <span class="booking-benefits-icon" aria-hidden="true"><i class="ti ti-star"></i></span>
                        <span class="visually-hidden"><?php esc_html_e('5-star rated service', 'gotriptoday'); ?></span>
                    </li>
                    <li title="<?php esc_attr_e('Airport pickup guaranteed', 'gotriptoday'); ?>">
                        <span class="booking-benefits-icon" aria-hidden="true"><i class="ti ti-plane-arrival"></i></span>
                        <span class="visually-hidden"><?php esc_html_e('Airport pickup guaranteed', 'gotriptoday'); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Divider -->
    <div class="divider"></div>
</section>
<section class="booking-fleet-section">
    <!-- Divider -->
    <div class="divider-sm"></div>
    <div class="container">
        <div class="vehicle-grid booking-fleet-grid" aria-live="polite">
            <?php
            $args = array(
                'post_type'      => 'cars',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            );

            $vehicle_query = new WP_Query($args);

            if ($vehicle_query->have_posts()):
                while ($vehicle_query->have_posts()):
                    $vehicle_query->the_post();

                    $title      = strtolower(get_the_title());
                    $passengers = get_post_meta(get_the_ID(), 'passengers', true);
                    $luggage    = get_post_meta(get_the_ID(), 'large_bag', true);
                    $equivalent = get_post_meta(get_the_ID(), 'car_equivalent', true);

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
                    <article class="vehicle-card" data-vehicle-category="<?php echo esc_attr(strtolower($badge)); ?>">
                        <div class="vehicle-image-wrapper">
                            <?php if (has_post_thumbnail()): ?>
                                <img
                                    src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                                    alt="<?php echo esc_attr(get_the_title()); ?>"
                                    class="vehicle-image"
                                    loading="lazy"
                                    width="600"
                                    height="400"
                                >
                            <?php else: ?>
                                <img
                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tour.jpg"
                                    alt="<?php echo esc_attr(get_the_title()); ?>"
                                    class="vehicle-image"
                                    loading="lazy"
                                    width="600"
                                    height="400"
                                >
                            <?php endif; ?>
                            <span class="vehicle-badge"><?php echo esc_html($badge); ?></span>
                        </div>
                        <div class="vehicle-card-body">
                            <h3 class="vehicle-title">
                                <a href="<?php the_permalink(); ?>" class="vehicle-title-link"><?php the_title(); ?></a>
                            </h3>
                            <?php if ($equivalent): ?>
                                <p class="vehicle-subtitle"><?php echo esc_html($equivalent); ?></p>
                            <?php endif; ?>
                            <div class="vehicle-features">
                                <div class="vehicle-feature-item">
                                    <i class="ti ti-users" aria-hidden="true"></i>
                                    <span><?php echo esc_html($passengers ?: '4'); ?> <?php esc_html_e('Passengers', 'gotriptoday'); ?></span>
                                </div>
                                <div class="vehicle-feature-item">
                                    <i class="ti ti-luggage" aria-hidden="true"></i>
                                    <span><?php echo esc_html($luggage ?: '2'); ?> <?php esc_html_e('Luggage', 'gotriptoday'); ?></span>
                                </div>
                            </div>
                            <div class="vehicle-cta">
                                <a class="vehicle-btn" href="<?php the_permalink(); ?>"><?php esc_html_e('View details', 'gotriptoday'); ?></a>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<div class="empty-state"><i class="ti ti-car-off" aria-hidden="true"></i><p>' . esc_html__('No vehicles available at the moment.', 'gotriptoday') . '</p></div>';
            endif;
            ?>
        </div>
    </div>
    <div class="divider"></div>
</section>
<?php get_footer(); ?>

