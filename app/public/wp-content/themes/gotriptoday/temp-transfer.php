<?php
/*Template Name: Transfer*/

get_header();
?>

<section class="booking-trust-strip" aria-label="Service trust highlights">
    <div class="container">
        <ul class="trust-items" role="list">
            <li class="trust-item">
                <span class="trust-icon" aria-hidden="true"><i class="ti ti-shield-check"></i></span>
                <span class="trust-text"><?php esc_html_e('Licensed chauffeurs & insured fleet', 'gotriptoday'); ?></span>
            </li>
            <li class="trust-item">
                <span class="trust-icon" aria-hidden="true"><i class="ti ti-clock-check"></i></span>
                <span class="trust-text"><?php esc_html_e('On-time guarantee with live flight tracking', 'gotriptoday'); ?></span>
            </li>
            <li class="trust-item">
                <span class="trust-icon" aria-hidden="true"><i class="ti ti-star"></i></span>
                <span class="trust-text"><?php esc_html_e('5-star rated service across Europe', 'gotriptoday'); ?></span>
            </li>
            <li class="trust-item">
                <span class="trust-icon" aria-hidden="true"><i class="ti ti-headset"></i></span>
                <span class="trust-text"><?php esc_html_e('24/7 concierge support in multiple languages', 'gotriptoday'); ?></span>
            </li>
        </ul>
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
