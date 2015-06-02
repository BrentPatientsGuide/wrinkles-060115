<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) );
wc_print_notice( $info_message, 'notice' );
?>

<p class="checkout-opener-text"><?php echo $info_message; ?> <a href="#" class="showcoupon"><?php _e( 'Click here to enter your code', 'woocommerce' ); ?></a></p>

<form class="checkout_coupon" method="post" style="display:none">

	<div class="coupon">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php _e( 'Enter coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
		<input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />
	</div>

	<div class="clear"></div>
</form>