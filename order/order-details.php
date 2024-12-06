<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $order = wc_get_order( $order_id ) ) {
	return;
}
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>

<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
			<?php
				foreach ( $order->get_items() as $item_id => $item ) {
					$product = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );

					wc_get_template( 'order/order-details-item.php', array(
						'order'			     => $order,
						'item_id'		     => $item_id,
						'item'			     => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'	     => $product ? $product->get_purchase_note() : '',
						'product'	         => $product,
					) );
				}
			?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	</tbody>
	<tfoot>
		<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
				<tr>
					<th scope="row"><?php echo $total['label']; ?></th>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>

<!-- Autoresponder Max Tracking -->
<div style="display:none;">
  <!-- Order -->
    <!-- Required -->
    <div id="__atrspmx_order_id"><?php echo $order->id; ?></div>
    <div id="__atrspmx_total"><?php echo '$'; echo $total = $order->get_total(); ?></div>
    <!-- -->
  
    <!-- Optional -->
    <div id="__atrspmx_email_address"><?php echo $order->billing_email; ?></div>
    <div id="__atrspmx_first_name"><?php echo $order->billing_first_name; ?></div>
    <div id="__atrspmx_last_name"><?php echo $order->billing_last_name; ?></div>
    <!-- -->
  <!-- -->
</div>
<script type="text/javascript">
(function(){
  var am = document.createElement('script'); am.type = 'text/javascript'; am.async = true; am.src = 'https://atrsp.mx/c4a5fa2610ccfd0f36b696d7802a9ad2/v5/roi.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(am, s);
})();
</script>
<noscript><img src="https://atrsp.mx/convert/c4a5fa2610ccfd0f36b696d7802a9ad2/<!--[Order ID]-->/<!--[Order Total]-->.gif" alt="" /></noscript>
<!-- -->
