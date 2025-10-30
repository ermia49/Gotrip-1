<?php
/**
 * Checkout Form - Customized for Reservation/Booking with Bootstrap 5
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$booking_data = [];
foreach ( WC()->cart->get_cart() as $cart_item ) {
    if ( isset( $cart_item['booking_data'] ) ) {
        $booking_data = $cart_item['booking_data'];
        break; // Only one booking item
    }
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<!-- SEO Meta Tags for Checkout Page -->
<?php if ( is_checkout() && ! is_order_received_page() ) : ?>
<meta name="robots" content="noindex, nofollow">
<meta name="description" content="Secure checkout for your <?php bloginfo('name'); ?> booking. Complete your reservation with confidence using our encrypted payment system.">
<link rel="canonical" href="<?php echo esc_url( wc_get_checkout_url() ); ?>">

<!-- Schema.org JSON-LD Checkout Action -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CheckoutPage",
  "name": "Secure Booking Checkout",
  "description": "Complete your chauffeur service booking with secure payment processing",
  "provider": {
    "@type": "Organization",
    "name": "<?php bloginfo('name'); ?>",
    "url": "<?php echo esc_url( home_url('/') ); ?>",
    "logo": "<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>",
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+49-69-2713-0740",
      "contactType": "Customer Service",
      "availableLanguage": ["English", "German"],
      "areaServed": "DE"
    }
  },
  "potentialAction": {
    "@type": "OrderAction",
    "target": "<?php echo esc_url( wc_get_checkout_url() ); ?>",
    "name": "Complete Booking"
  },
  "hasPart": [
    {
      "@type": "PaymentMethod",
      "name": "Credit Card",
      "acceptedPaymentMethod": ["Visa", "Mastercard", "American Express"]
    },
    {
      "@type": "PaymentMethod",
      "name": "PayPal"
    }
  ]
}
</script>
<?php endif; ?>

<div class="reservation-checkout-wrapper container py-4">
    <!-- Reservation Header with Trust Signals -->
    <div class="reservation-header text-center mb-5">
        <h1 class="display-5 fw-bold text-dark mb-3"><?php esc_html_e( 'Complete Your Booking', 'woocommerce' ); ?></h1>
        <p class="lead text-muted">
            <?php esc_html_e( 'Secure checkout • Instant confirmation • 24/7 support', 'woocommerce' ); ?></p>
        
        <!-- Payment Method Icons -->
        <div class="payment-methods-display">
            <div class="payment-method-icon" title="Visa">
                <svg viewBox="0 0 48 32" width="48" height="32"><path fill="#1434CB" d="M21.6 24.8l2.4-14.4h3.8l-2.4 14.4h-3.8zm16.3-14.1c-.7-.3-1.9-.6-3.3-.6-3.7 0-6.3 1.9-6.3 4.6 0 2 1.9 3.1 3.3 4.1 1.5.9 2 1.5 2 2.3 0 1.3-1.6 1.9-3.1 1.9-2.1 0-3.2-.3-4.9-1l-.7-.3-.7 4.3c.9.4 2.5.7 4.2.7 3.9 0 6.5-1.9 6.5-4.8 0-1.6-1-2.8-3.2-3.8-1.3-.6-2.1-1.1-2.1-1.8 0-.6.7-1.2 2.2-1.2 1.3 0 2.2.3 2.9.6l.3.2.8-4zm8.9-1.9c-.7 0-1.3.4-1.5 1.1l-5.4 12.9h3.9l.8-2.1h4.7l.4 2.1h3.4l-3-14.1h-3.3v.1zm-2.7 9.5c.1 0 1.8-4.8 1.8-4.8l1 4.8h-2.8zm-18.9-9.5l-3.7 9.8-.4-2c-.7-2.3-2.8-4.8-5.2-6l3.4 12.5h3.9l5.8-14.3h-3.8z"/><path fill="#F7921F" d="M8.5 10.3H2.6L2.5 10.8c4.6 1.2 7.7 4 9 7.4l-1.3-6.4c-.2-.8-.8-1.1-1.7-1.5z"/></svg>
            </div>
            <div class="payment-method-icon" title="Mastercard">
                <svg viewBox="0 0 48 32" width="48" height="32"><circle cx="16" cy="16" r="11" fill="#EB001B"/><circle cx="32" cy="16" r="11" fill="#F79E1B"/><path fill="#FF5F00" d="M24 7.6c-2.3 2.6-3.7 6-3.7 9.4s1.4 6.8 3.7 9.4c2.3-2.6 3.7-6 3.7-9.4s-1.4-6.8-3.7-9.4z"/></svg>
            </div>
            <div class="payment-method-icon" title="PayPal">
                <svg viewBox="0 0 48 32" width="48" height="32"><path fill="#003087" d="M18.4 8.9c.7-4.5-1.3-7.7-5.7-9.1H6.3L2.1 21.3c-.1.7.4 1.3 1.1 1.3h3.2l.8-5.1c.2-1.1 1.1-1.9 2.2-1.9h1.7c3.8 0 6.8-1.5 7.3-5.7zm-5.5 4.9c-.3 1.9-1.7 1.9-3.1 1.9h-.8l.5-3.4c0-.1.2-.2.3-.2h.3c.7 0 1.4 0 1.7.4.2.2.3.6.1 1.3z"/><path fill="#009CDE" d="M11.7 13.6c-.1.7-.6 1.1-1.3 1.1h-.8l.6-3.6c0-.1.2-.2.3-.2h.3c.8 0 1.5 0 1.8.4.3.3.3.8.1 1.4v-.1zm-.4-5.4H6c-.7 0-1.3.5-1.4 1.2l-2.1 13.2c-.1.6.3 1.1.9 1.1h2.7c.5 0 .9-.3 1-.8l.6-3.6c.1-.7.6-1.2 1.4-1.2h1.7c3.5 0 6.3-1.4 6.9-5.4.3-1.8 0-3.1-.8-4-.9-.9-2.4-1.5-4.4-1.5z"/><path fill="#012169" d="M14.5 13.6c-.3 1.8-1.7 1.8-3.1 1.8h-.8l.5-3.4c0-.1.2-.2.3-.2h.3c.7 0 1.4 0 1.7.4.2.2.3.7.1 1.4zm-.4-5.5h-5.3c-.7 0-1.3.5-1.4 1.2L5.3 22.5c-.1.6.3 1.1.9 1.1h2.9c.5 0 .9-.3 1-.8l.6-3.6c.1-.7.6-1.2 1.4-1.2h1.7c3.5 0 6.3-1.4 6.9-5.4.3-1.8 0-3.1-.8-4-.9-.9-2.4-1.5-4.4-1.5z"/></svg>
            </div>
            <div class="payment-method-icon" title="Secure SSL">
                <i class="ti ti-lock-check" style="font-size:24px; color:#3cb371;"></i>
            </div>
        </div>
    </div>


    <!-- Reservation Details -->
    <div class="reservation-details card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <!-- Journey Information -->
            <div class="journey-info mb-4">
                <h4 class="h5 fw-semibold text-dark border-bottom border-primary pb-2 mb-3"><?php esc_html_e( 'JOURNEY INFORMATION', 'woocommerce' ); ?>  
                <span class="d-inline-flex ms-5">
                <?php                 
                    $tour_id  =  esc_html( $booking_data['Tour ID'] ?? '' );               
                    $tour_title = get_the_title($tour_id);
                    echo $tour_title;
                ?>
                </span>
                </h4>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong class="text-muted"><?php esc_html_e( 'Pickup Location', 'woocommerce' ); ?></strong>
                            <span
                                class="fw-semibold"><?php echo esc_html( $booking_data['Pickup Address'] ?? '' ); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong
                                class="text-muted"><?php esc_html_e( 'Drop-off Location', 'woocommerce' ); ?></strong>
                            <span
                                class="fw-semibold"><?php echo esc_html( $booking_data['Dropoff Address'] ?? '' ); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong class="text-muted"><?php esc_html_e( 'Date & Time', 'woocommerce' ); ?></strong>
                            <span
                                class="fw-semibold"><?php echo esc_html( $booking_data['Pickup DateTime'] ?? '' ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passenger & Vehicle Details -->
            <div class="passenger-vehicle-info mb-4">
                <h4 class="h5 fw-semibold text-dark border-bottom border-primary pb-2 mb-3">
                    <?php esc_html_e( 'PASSENGER & VEHICLE DETAILS', 'woocommerce' ); ?></h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong class="text-muted"><?php esc_html_e( 'Adults', 'woocommerce' ); ?></strong>
                            <span class="fw-semibold"><?php echo esc_html( $booking_data['Adults'] ?? '0' ); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong class="text-muted"><?php esc_html_e( 'Children', 'woocommerce' ); ?></strong>
                            <span class="fw-semibold"><?php echo esc_html( $booking_data['Children'] ?? '0' ); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong class="text-muted"><?php esc_html_e( 'Passenger Name', 'woocommerce' ); ?></strong>
                            <span
                                class="fw-semibold"><?php echo esc_html( $booking_data['Passenger Name'] ?? '' ); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <strong class="text-muted"><?php esc_html_e( 'Vehicle Type', 'woocommerce' ); ?></strong>
                            <span
                                class="fw-semibold"><?php echo esc_html( $booking_data['Vehicle Type'] ?? '' ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Instructions -->
            <?php if ( ! empty( $booking_data['Driver Notes'] ) ) : ?>
            <div class="special-instructions">
                <h4 class="h5 fw-semibold text-dark border-bottom border-primary pb-2 mb-3">
                    <?php esc_html_e( 'SPECIAL INSTRUCTIONS', 'woocommerce' ); ?></h4>
                <div class="alert alert-light border mt-3 mb-0">
                    <p class="mb-0"><?php echo esc_html( $booking_data['Driver Notes'] ); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>


    <form name="checkout" method="post" class="checkout woocommerce-checkout"
        action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data"
        aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

        <div class="row g-4">
            <!-- Customer Details Column -->
            <div class="col-lg-6">
                <div class="customer-details-column card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <?php if ( $checkout->get_checkout_fields() ) : ?>
                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <div class="customer-details-section">
                            <h3 class="h4 fw-semibold text-dark mb-4">
                                <?php esc_html_e( 'Contact & Billing Details', 'woocommerce' ); ?></h3>
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order Review Column -->
            <div class="col-lg-6">
                <div class="order-review-column card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <!-- Trust Badges -->
                        <div class="checkout-trust-badges mb-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="trust-badge-item">
                                        <div class="trust-badge-icon">
                                            <i class="ti ti-shield-lock"></i>
                                        </div>
                                        <div class="trust-badge-text">
                                            <h5><?php esc_html_e( 'SSL Encrypted Payment', 'woocommerce' ); ?></h5>
                                            <p><?php esc_html_e( 'Your information is protected with 256-bit encryption', 'woocommerce' ); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="trust-badge-item">
                                        <div class="trust-badge-icon">
                                            <i class="ti ti-check-circle"></i>
                                        </div>
                                        <div class="trust-badge-text">
                                            <h5><?php esc_html_e( 'Instant Confirmation', 'woocommerce' ); ?></h5>
                                            <p><?php esc_html_e( 'Receive booking details within seconds', 'woocommerce' ); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="trust-badge-item">
                                        <div class="trust-badge-icon">
                                            <i class="ti ti-phone"></i>
                                        </div>
                                        <div class="trust-badge-text">
                                            <h5><?php esc_html_e( '24/7 Customer Support', 'woocommerce' ); ?></h5>
                                            <p><?php esc_html_e( 'Our team is always here to help you', 'woocommerce' ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Money-Back Guarantee Badge -->
                        <div class="guarantee-badge">
                            <div class="guarantee-badge-icon">🛡️</div>
                            <h4><?php esc_html_e( 'Satisfaction Guaranteed', 'woocommerce' ); ?></h4>
                            <p><?php esc_html_e( 'Premium service or your money back. We stand behind every transfer.', 'woocommerce' ); ?></p>
                        </div>

                        <!-- Customer Testimonial -->
                        <div class="checkout-testimonial">
                            <div class="checkout-testimonial-stars">★★★★★</div>
                            <div class="checkout-testimonial-text">
                                "<?php esc_html_e( 'Professional service from booking to drop-off. The driver was punctual, courteous, and the vehicle was immaculate. Highly recommend!', 'woocommerce' ); ?>"
                            </div>
                            <div class="checkout-testimonial-author">— <?php esc_html_e( 'Michael S., Frankfurt', 'woocommerce' ); ?></div>
                        </div>

                        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                        <!-- Payment Method -->
                        <div id="order_review" class="woocommerce-checkout-review-order custom-order-review mb-4">
                            <h3 class="h4 fw-semibold text-dark mb-3">
                                <?php esc_html_e( 'Payment Method', 'woocommerce' ); ?></h3>
                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>



                        <!-- Footer Links -->
                        <div class="checkout-footer-links border-top pt-4 mt-4">
                            <div class="row g-2 text-center">
                                <div class="col-6 col-sm-3">
                                    <a href="<?php echo esc_url( wc_get_page_permalink( 'terms' ) ); ?>"
                                        class="text-decoration-none small"><?php esc_html_e( 'Terms of Service', 'woocommerce' ); ?></a>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <a href="<?php echo esc_url( wc_get_page_permalink( 'privacy' ) ); ?>"
                                        class="text-decoration-none small"><?php esc_html_e( 'Privacy Policy', 'woocommerce' ); ?></a>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <a href="<?php echo esc_url( wc_get_page_permalink( 'cancellation' ) ); ?>"
                                        class="text-decoration-none small"><?php esc_html_e( 'Cancellation Policy', 'woocommerce' ); ?></a>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <a href="<?php echo esc_url( wc_get_page_permalink( 'contact' ) ); ?>"
                                        class="text-decoration-none small"><?php esc_html_e( 'Contact Support', 'woocommerce' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>