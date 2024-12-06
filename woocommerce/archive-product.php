<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>



	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<div class="facetwp-template">
                
				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>
                
                </div>

			<?php 

			woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );

			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */

		// vars
		$queried_object = get_queried_object(); 
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;  

		$term = get_term( $term_id, $taxonomy );

		$secondary_description = get_field( "secondary_description", $term );

		if( $secondary_description ) {
		   	echo '<div class="sub-term-description">';
			    echo $secondary_description;
			echo '</div>';
		} else {
    		echo '<div class="sub-term-description">';
			    //echo "Empty";
			echo '</div>';
		}

		do_action( 'woocommerce_after_main_content' );

	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>
    
    
<script>
//$(document).ready(function(){
	//$("<div class='redBox'>Iron man</div>").insertAfter('.products li.last');
	//$('.products .facetwp-template li:nth-child(4n)').after('<div>This is what I want to add</div>');
	//$('.products li:nth-child(4n)').after('<hr/>');
//});
</script>
<style>
.sub-term-description {
    display: inline-block;
    width: 100%;
    margin-top: 15px;
}
.products li:after {
   /* content: "";
    display: block;
    height: 1px;
    width: 100%;
	 background: #ccc; */
    margin: 20px 0px 30px 10px;
}
.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
    margin: 0 0 1.5em 0 !important;
}
.woocommerce.product-columns-3 ul.products li.product, .woocommerce-page.product-columns-3 ul.products li.product {
    width: 33%;
}
</style>

<?php get_footer( 'shop' ); ?>
