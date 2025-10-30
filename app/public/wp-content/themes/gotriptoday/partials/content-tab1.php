<?php 
$booking_url = esc_url( home_url( '/booking-page/' ) );
echo do_shortcode('[chbs_booking_form booking_form_id="10007" widget_mode="1" widget_style="4" widget_second_step=1 widget_booking_form_url="' . $booking_url . '"]');
?>
     