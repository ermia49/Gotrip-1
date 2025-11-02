<?php
/*Template Name: Transfer*/

get_header();
?>

<section class="booking-hero-section" role="banner">
    <div class="booking-hero-container">
        <div class="booking-hero-content">
            <div class="hero-text-content">
                <h1 class="hero-main-title">Book Your Comfortable Transfer</h1>
                <p class="hero-subtitle">Premium chauffeur service across Germany with luxury vehicles and professional drivers</p>
                <div class="hero-cta-button">
                    <a href="#booking-form" class="btn-hero-cta">
                        <span class="btn-text">Book Now</span>
                        <span class="btn-icon"><i class="ti ti-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="hero-decorative-elements">
            <div class="hero-gradient-orb"></div>
            <div class="hero-floating-icons">
                <div class="floating-icon icon-1"><i class="ti ti-car"></i></div>
                <div class="floating-icon icon-2"><i class="ti ti-shield-check"></i></div>
                <div class="floating-icon icon-3"><i class="ti ti-clock"></i></div>
            </div>
        </div>
    </div>
</section>

<section class="booking-section booking-form-section">
    <div class="container">
        <div class="row justify-content-center g-4 g-xl-5 align-items-start">
            <div id="booking-form" class="col-12 col-xl-10 col-xxl-8 go_trip_bookingform booking-form-wrapper" tabindex="-1">
                <?php echo do_shortcode('[chbs_booking_form booking_form_id="10007"]'); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
