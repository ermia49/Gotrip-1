<?php
/**
 * Pay for order form (Order Pay Page) - Customized with Trust Elements
 *
 * @package WooCommerce\Templates
 * @version 8.2.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals();
?>

<!-- SEO Meta Tags for Payment Page -->
<meta name="robots" content="noindex, nofollow">
<meta name="description" content="Secure payment processing for your <?php bloginfo('name'); ?> booking. Complete your order safely with encrypted payment.">

<!-- Schema.org JSON-LD Payment Action -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "PayAction",
  "name": "Complete Payment",
  "description": "Secure payment for chauffeur service booking",
  "provider": {
    "@type": "Organization",
    "name": "<?php bloginfo('name'); ?>",
    "url": "<?php echo esc_url( home_url('/') ); ?>"
  }
}
</script>

<div class="reservation-checkout-wrapper payment-page-wrapper container py-4">
	<!-- Payment Header with Trust Signals -->
	<div class="reservation-header text-center mb-5">
		<h1 class="display-5 fw-bold text-dark mb-3"><?php esc_html_e( 'Complete Your Payment', 'woocommerce' ); ?></h1>
		<p class="lead text-muted">
			<?php printf( esc_html__( 'Order #%d', 'woocommerce' ), absint( $order_id ) ); ?> • 
			<?php esc_html_e( 'Secure checkout • Instant confirmation', 'woocommerce' ); ?>
		</p>
		
		<!-- Payment Method Icons -->
		<div class="payment-methods-display">
			<div class="payment-method-icon" title="Visa" aria-label="Visa accepted">
				<svg viewBox="0 0 48 32" width="48" height="32"><path fill="#1434CB" d="M21.6 24.8l2.4-14.4h3.8l-2.4 14.4h-3.8zm16.3-14.1c-.7-.3-1.9-.6-3.3-.6-3.7 0-6.3 1.9-6.3 4.6 0 2 1.9 3.1 3.3 4.1 1.5.9 2 1.5 2 2.3 0 1.3-1.6 1.9-3.1 1.9-2.1 0-3.2-.3-4.9-1l-.7-.3-.7 4.3c.9.4 2.5.7 4.2.7 3.9 0 6.5-1.9 6.5-4.8 0-1.6-1-2.8-3.2-3.8-1.3-.6-2.1-1.1-2.1-1.8 0-.6.7-1.2 2.2-1.2 1.3 0 2.2.3 2.9.6l.3.2.8-4zm8.9-1.9c-.7 0-1.3.4-1.5 1.1l-5.4 12.9h3.9l.8-2.1h4.7l.4 2.1h3.4l-3-14.1h-3.3v.1zm-2.7 9.5c.1 0 1.8-4.8 1.8-4.8l1 4.8h-2.8zm-18.9-9.5l-3.7 9.8-.4-2c-.7-2.3-2.8-4.8-5.2-6l3.4 12.5h3.9l5.8-14.3h-3.8z"/><path fill="#F7921F" d="M8.5 10.3H2.6L2.5 10.8c4.6 1.2 7.7 4 9 7.4l-1.3-6.4c-.2-.8-.8-1.1-1.7-1.5z"/></svg>
			</div>
			<div class="payment-method-icon" title="Mastercard" aria-label="Mastercard accepted">
				<svg viewBox="0 0 48 32" width="48" height="32"><circle cx="16" cy="16" r="11" fill="#EB001B"/><circle cx="32" cy="16" r="11" fill="#F79E1B"/><path fill="#FF5F00" d="M24 7.6c-2.3 2.6-3.7 6-3.7 9.4s1.4 6.8 3.7 9.4c2.3-2.6 3.7-6 3.7-9.4s-1.4-6.8-3.7-9.4z"/></svg>
			</div>
			<div class="payment-method-icon" title="PayPal" aria-label="PayPal accepted">
				<svg viewBox="0 0 48 32" width="48" height="32"><path fill="#003087" d="M18.4 8.9c.7-4.5-1.3-7.7-5.7-9.1H6.3L2.1 21.3c-.1.7.4 1.3 1.1 1.3h3.2l.8-5.1c.2-1.1 1.1-1.9 2.2-1.9h1.7c3.8 0 6.8-1.5 7.3-5.7z"/><path fill="#009CDE" d="M11.7 13.6c-.1.7-.6 1.1-1.3 1.1h-.8l.6-3.6c0-.1.2-.2.3-.2h.3c.8 0 1.5 0 1.8.4.3.3.3.8.1 1.4v-.1z"/></svg>
			</div>
			<div class="payment-method-icon" title="Secure SSL" aria-label="SSL Encrypted">
				<i class="ti ti-lock-check" style="font-size:24px; color:#3cb371;"></i>
			</div>
		</div>
	</div>

	<form id="order_review" method="post">

		<div class="row g-4">
			<!-- Order Summary Column -->
			<div class="col-lg-6">
				<div class="order-summary-card card border-0 shadow-sm">
					<div class="card-body p-4">
						<h3 class="h4 fw-semibold text-dark mb-4 border-bottom border-primary pb-2">
							<?php esc_html_e( 'Order Summary', 'woocommerce' ); ?>
						</h3>

						<table class="shop_table">
							<thead>
								<tr>
									<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
									<th class="product-quantity"><?php esc_html_e( 'Qty', 'woocommerce' ); ?></th>
									<th class="product-total"><?php esc_html_e( 'Totals', 'woocommerce' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ( count( $order->get_items() ) > 0 ) : ?>
									<?php foreach ( $order->get_items() as $item_id => $item ) : ?>
										<?php
										if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
											continue;
										}
										?>
										<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
											<td class="product-name">
												<?php
													echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );
													do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
													wc_display_item_meta( $item );
													do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
												?>
											</td>
											<td class="product-quantity"><?php echo apply_filters( 'woocommerce_order_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', esc_html( $item->get_quantity() ) ) . '</strong>', $item ); ?></td><?php // @codingStandardsIgnoreLine ?>
											<td class="product-subtotal"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td><?php // @codingStandardsIgnoreLine ?>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
							<tfoot>
								<?php if ( $totals = $order->get_order_item_totals() ) : // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found ?>
									<?php foreach ( $totals as $total ) : ?>
										<tr>
											<th scope="row" colspan="2"><?php echo $total['label']; ?></th><?php // @codingStandardsIgnoreLine ?>
											<td class="product-total"><?php echo $total['value']; ?></td><?php // @codingStandardsIgnoreLine ?>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

			<!-- Payment Method Column -->
			<div class="col-lg-6">
				<div class="payment-method-card card border-0 shadow-sm">
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
						<div class="guarantee-badge mb-4">
							<div class="guarantee-badge-icon">🛡️</div>
							<h4><?php esc_html_e( 'Satisfaction Guaranteed', 'woocommerce' ); ?></h4>
							<p><?php esc_html_e( 'Premium service or your money back', 'woocommerce' ); ?></p>
						</div>

						<!-- Payment Methods -->
						<div id="payment" class="woocommerce-checkout-payment">
							<h3 class="h4 fw-semibold text-dark mb-3">
								<?php esc_html_e( 'Select Payment Method', 'woocommerce' ); ?>
							</h3>
							<?php if ( $order->needs_payment() ) : ?>
								<ul class="wc_payment_methods payment_methods methods">
									<?php
									if ( ! empty( $available_gateways = WC()->payment_gateways->get_available_payment_gateways() ) ) {
										foreach ( $available_gateways as $gateway ) {
											wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
										}
									} else {
										echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
									}
									?>
								</ul>
							<?php endif; ?>

							<div class="form-row">
								<input type="hidden" name="woocommerce_pay" value="1" />

								<?php wc_get_template( 'checkout/terms.php' ); ?>

								<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

								<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt btn btn-success btn-lg w-100" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

								<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

								<?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
							</div>
						</div>

						<!-- Footer Links -->
						<div class="checkout-footer-links border-top pt-4 mt-4">
							<div class="row g-2 text-center">
								<div class="col-6">
									<a href="<?php echo esc_url( wc_get_page_permalink( 'terms' ) ); ?>" class="text-decoration-none small" target="_blank"><?php esc_html_e( 'Terms of Service', 'woocommerce' ); ?></a>
								</div>
								<div class="col-6">
									<a href="<?php echo esc_url( wc_get_page_permalink( 'privacy' ) ); ?>" class="text-decoration-none small" target="_blank"><?php esc_html_e( 'Privacy Policy', 'woocommerce' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>

</div>
