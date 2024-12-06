<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'parallax', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'parallax' ) );

//* Add Image upload to WordPress Theme Customizer
add_action( 'customize_register', 'parallax_customizer' );
function parallax_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );
	
}

//* Include Section Image CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Parallax Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/parallax/' );
define( 'CHILD_THEME_VERSION', '1.2' );


	//wp_deregister_script('jquery');( 'jquery-ui-core' );
    //wp_deregister_script('jquery');( 'jquery-ui-datepicker' );
	//wp_deregister_script('jquery');( 'jquery-ui-datepicker-local' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'parallax_enqueue_scripts_styles' );
function parallax_enqueue_scripts_styles() {

	
	wp_enqueue_style( 'dashicons' );
	wp_register_style ( 'customfonts', get_bloginfo( 'stylesheet_directory' ) . '/customfonts.css', array(), true );
	
	//wp_enqueue_style( 'Roboto-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic', array(), CHILD_THEME_VERSION );
	//wp_enqueue_style( 'Roboto-Condensed-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic', array(), CHILD_THEME_VERSION );
	
}

//* Home Page Specific - Enqueue scripts and styles 
function mytheme_enqueue_front_page_scripts() {
    if ( is_front_page() )
    {
        wp_register_style( 'homepage-styles', get_bloginfo( 'stylesheet_directory' ) . '/css/westernsport-home.css', array(), true);
		wp_register_script( 'homepage-owlcarousel', get_bloginfo( 'stylesheet_directory' ) . '/css/owl.carousel.min.js', array(), true);
		wp_register_script( 'homepage-scripts', get_bloginfo( 'stylesheet_directory' ) . '/css/westernsport-home-js.js', array('jquery'), true);
    }
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_front_page_scripts' );

/*Site optimizations*/
function remove_home_assets() {
  if (is_front_page()) { // allow widget style only in front page
	  wp_dequeue_style('pac-styles');
	  wp_dequeue_style('pac-layout-styles');
	  wp_dequeue_style('wp-pagenavi');
	  wp_dequeue_style('woocommerce-general');
	  wp_dequeue_style('woocommerce-layout');
	  wp_dequeue_style('woocommerce-smallscreen');
	  wp_dequeue_style('follow-up-emails');
	  wp_dequeue_style('magnific-popup');
	  wp_dequeue_script('fue-account-subscriptions');
	  wp_dequeue_script('fue-front-script');
	  wp_deregister_script( 'wp-embed' );
	  wp_dequeue_script( 'devicepx' );
	  
	  wp_dequeue_script( 'facetwp-woocommerce' );
	  wp_dequeue_script( 'query-string' );
	  wp_dequeue_style ('threesixty');
	  wp_dequeue_style ('magnific-popup');
	  wp_dequeue_script( 'magnific-popup' );
	  wp_dequeue_script( 'smart-product' );
	  
	  
  }
};
add_action( 'wp_enqueue_scripts', 'remove_home_assets', 99 );

// remove dashicons and admin-bar-css in frontend to non-admin 
function wpdocs_dequeue_dashicon() {
	if (current_user_can( 'update_core' )) {
		return;
	}
	wp_deregister_style('dashicons');
	wp_dequeue_script('admin-bar');
	// Remove from header on all pages and apply ADD it again in footer funtion below
	wp_dequeue_style('WCISPlugin-plugin-styles');
	
	wp_dequeue_style('ubermenu');
	wp_dequeue_style('ubermenu-black-white-2');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon', 99 );

// Woocommerce
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
function child_manage_woocommerce_styles() {
 //remove generator meta tag
 remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
 
 //first check that woo exists to prevent fatal errors
 if ( function_exists( 'is_woocommerce' ) ) {
 //dequeue scripts and styles
 if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
	wp_dequeue_script( 'wc-add-to-cart' );
 	wp_dequeue_script( 'wc-cart-fragments' );
	
	 wp_dequeue_style( 'woocommerce_frontend_styles' );
	 wp_dequeue_style( 'woocommerce_fancybox_styles' );
	 wp_dequeue_style( 'woocommerce_chosen_styles' );
	 wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	 wp_dequeue_script( 'wc_price_slider' );
	 wp_dequeue_script( 'wc-single-product' );
	 wp_dequeue_script( 'wc-add-to-cart' );
	 wp_dequeue_script( 'wc-cart-fragments' );
	 wp_dequeue_script( 'wc-checkout' );
	 wp_dequeue_script( 'wc-add-to-cart-variation' );
	 wp_dequeue_script( 'wc-single-product' );
	 wp_dequeue_script( 'wc-cart' );
	 wp_dequeue_script( 'wc-chosen' );
	 wp_dequeue_script( 'woocommerce' );
	 wp_dequeue_script( 'prettyPhoto' );
	 wp_dequeue_script( 'prettyPhoto-init' );
	 wp_dequeue_script( 'jquery-blockui' );
	 wp_dequeue_script( 'jquery-placeholder' );
	 wp_dequeue_script( 'fancybox' );
	 wp_dequeue_script( 'jqueryui' );
	
 }
 }
 
}

// remove jetpack.css from frontend
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


// This would help REMOVE RENDER BLOCKING, First register the styles and script and enqueue them under below function.
// Below Function would output styles and scripts under Footer.
function prefix_add_footer_styles() {

	$stylesheet_dir_uri = get_stylesheet_directory_uri() . '/';
	$stylesheet_dir_path = get_stylesheet_directory() . '/';

	wp_enqueue_style( 'customfonts' );
	
	$relative_file_path = 'customcss.css';
	wp_enqueue_style( 'customcss', $stylesheet_dir_uri . $relative_file_path, array(), filemtime( $stylesheet_dir_path . $relative_file_path ) );
	
	wp_enqueue_style('WCISPlugin-plugin-styles');
	wp_enqueue_style('ubermenu');
	wp_enqueue_style('ubermenu-black-white-2');
	wp_enqueue_style('woocommerce-general');
	wp_enqueue_style('woocommerce-layout');
	wp_enqueue_style('woocommerce-smallscreen');
	wp_enqueue_style('homepage-styles');
	wp_enqueue_script('homepage-owlcarousel');
	wp_enqueue_script('homepage-scripts');
	
	if ( function_exists( 'is_product' ) && is_product() ) {
		$relative_file_path = 'js/product.js';
		wp_enqueue_script( 'ws-product-scripts', $stylesheet_dir_uri . $relative_file_path, array( 'jquery' ), filemtime( $stylesheet_dir_path . $relative_file_path ) );
	}
};
add_action( 'get_footer', 'prefix_add_footer_styles', 9999 );


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'parallax_secondary_menu_args' );
function parallax_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

/*
// Removes Query Strings from scripts and styles
function remove_script_version( $src ){
  if ( strpos( $src, 'uploads/bb-plugin' ) !== false || strpos( $src, 'uploads/bb-theme' ) !== false ) {
    return $src;
  }
  else {
    $parts = explode( '?ver', $src );
    return $parts[0];
  }
}
add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );
*/

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Add support for additional color styles
add_theme_support( 'genesis-style-selector', array(
	'parallax-pro-blue'   => __( 'Parallax Pro Blue', 'parallax' ),
	'parallax-pro-green'  => __( 'Parallax Pro Green', 'parallax' ),
	'parallax-pro-orange' => __( 'Parallax Pro Orange', 'parallax' ),
	'parallax-pro-pink'   => __( 'Parallax Pro Pink', 'parallax' ),
) );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 360,
	'height'          => 70,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'footer-widgets',
	'footer',
) );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'parallax_author_box_gravatar' );
function parallax_author_box_gravatar( $size ) {

	return 176;

}


//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'parallax_comments_gravatar' );
function parallax_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}


//* Include Custom banner for home and subpages
add_action( 'genesis_after_header', 'banner' );

function banner() {

 if (is_front_page()) {  
		require(CHILD_DIR.'/home-banner.php');
	 }
  // If it's the About page, display subpage banner
	elseif ( is_page()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif ( is_single()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif ( is_archive()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif(is_home()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif(is_404()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	elseif(is_search()) {
		require(CHILD_DIR.'/subpage-banner.php');
	}
	

}

// Add Section above footer
add_action( 'genesis_before_footer', 'section_before_footer' );
function section_before_footer() {
	
	if (is_front_page()) {  
		require(CHILD_DIR.'/before-footer.php');
	 }
	elseif ( is_home() ) {
		require(CHILD_DIR.'/before-footer.php');
	}
	elseif ( is_page() ) {
		require(CHILD_DIR.'/before-footer.php');
	}
	elseif ( is_single() ) {
		require(CHILD_DIR.'/before-footer.php');
	}
	elseif ( is_archive() ) {
		require(CHILD_DIR.'/before-footer.php');
	}
	elseif ( is_search() ) {
		require(CHILD_DIR.'/before-footer.php');
	}	
}

// Home Post Featured Image
add_image_size( 'home-post-featured', 417, 144, true );
add_image_size( 'featured-image-blog', 870, 300, true );
add_image_size( 'page-featured-image', 870, 300, true );

// Add Read More Link to Excerpts

add_filter('excerpt_more', 'get_read_more_link');

add_filter( 'the_content_more_link', 'get_read_more_link' );

function get_read_more_link() {

   return '...&nbsp;<a class="readmore" href="' . get_permalink() . '">[Read&nbsp;More]</a>';

}

// Customize the post info function
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
	$post_info = 'Posted on: [post_date]';
	return $post_info;
}


/** Force full width layout */
add_filter( 'genesis_pre_get_option_site_layout', 'child_do_layout' );
function child_do_layout( $opt ) {
    if ( is_single() || is_archive() ) { // Modify the conditions to apply the layout to here
        $opt = 'content-sidebar'; // You can change this to any Genesis layout
        return $opt;
    }
}


// Button Shortcode
function download_button($atts, $content = null) {
 extract( shortcode_atts( array(
          'url' => '#'
), $atts ) );
return '<a href="'.$url.'" class="wpbutton"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('download', 'download_button');

// remove default sorting dropdown in StoreFront Theme
add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
 

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_footer', 'genesis_footer_widget_areas', 5 );

/* Genesis - Remove breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//Changing the Copyright text
function genesischild_footer_creds_text () {
 echo '<div class="clearboth copy-line"><p class="copyright one-half ls">Copyright © 2015 - All rights reserved  |  <a href="/site-map/">Site Map</a>  |  <a href="/privacy-policy/">Privacy Policy</a>  |  <a href="/terms-of-use/">Terms</a>  |  <a href="/return-policy/">Return Policy</a></p><p class="one-sixth credits"><span style="margin-right:4px;">Site by</span><a target="_blank" href="https://thriveagency.com"><img class="svg" src="https://www.westernsport.com/wp-content/themes/western-sport/images/thrive-logo.png"></a></p></div>';
}
add_filter( 'genesis_footer_creds_text', 'genesischild_footer_creds_text' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Widget - Latest News on home page
genesis_register_sidebar( array(
	'id'			=> 'genesis-featured-posts',
	'name'			=> __( 'Latest News on Home Page', 'timothy' ),
	'description'	=> __( 'This is home page widget', 'timothy' ),
) );

// Widget - Testimonials on home page
genesis_register_sidebar( array(
	'id'			=> 'testimonials-home',
	'name'			=> __( 'Latest Testimonials on Home Page', 'timothy' ),
	'description'	=> __( 'This is home page widget', 'timothy' ),
) );

// Widget - Product Instant Search Woocommerce Widget
genesis_register_sidebar( array(
	'id'			=> 'genesis-product-search',
	'name'			=> __( 'Product Instant Search Woocommerce Widget', 'timothy' ),
	'description'	=> __( 'This is Product Instant Search', 'timothy' ),
) );

// Widget - Product Instant Search Woocommerce Widget
genesis_register_sidebar( array(
	'id'			=> 'genesis-mobile-product-search',
	'name'			=> __( 'Mobile Display Product Instant Search Woocommerce Widget', 'timothy' ),
	'description'	=> __( 'This is Product Instant Search', 'timothy' ),
) );


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20 );


add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Description' );		// Rename the description tab
	$tabs['reviews']['title'] = __( 'Reviews' );				// Rename the reviews tab
	$tabs['additional_information']['title'] = __( 'Additional Info' );	// Rename the additional information tab

	return $tabs;

}

// Set priority of Woo tabs
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

if( isset( $tabs['description'] ) ) {
  $tabs['description']['priority'] = 5;
}
if( isset( $tabs['common_tab'] ) ) {
  $tabs['common_tab']['priority'] = 10;
}
if( isset( $tabs['reviews'] ) ) {
  $tabs['reviews']['priority'] = 15;
}
//if( isset( $tabs['additional_information'] ) ) {
  //$tabs['additional_information']['priority'] = 20;
//}
return $tabs;
}

//display category image on category archive
add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
		    echo '<img src="' . $image . '" alt="" class="cat-arc-img" />';
		}
	}
}



//* Rotate image using Sub Tag
function random_hero_img($tag) { 

	$args = array( 'post_type' => 'attachment', 
				// 'post_status' => 'publish',
				'orderby' => 'rand',
				'post_mime_type' => 'image',
				'post_status' => 'inherit',
				'tax_query' => array(
					array(
						'taxonomy' => 'media_tag',
						'field' => 'slug',
						'terms' => $tag
					)
				
						));
    $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
		  $image = wp_get_attachment_image_src('', $size, false);
		  
		endwhile; 
		wp_reset_query();
		$header_url = $image[0];
  return $header_url;
  
}

// Previous / Next Post Navigation Filter For Genesis Pagination
add_filter( 'genesis_prev_link_text', 'gt_review_prev_link_text' );
function gt_review_prev_link_text() {
        $prevlink = '&laquo;';
        return $prevlink;
}
add_filter( 'genesis_next_link_text', 'gt_review_next_link_text' );
function gt_review_next_link_text() {
        $nextlink = '&raquo;';
        return $nextlink;
}

/* Disable searchwp_missing_integration_notices */
add_filter( 'searchwp_missing_integration_notices', '__return_false' );

/* Show pagination on the top of shop page */
add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 10 );

/**
  * Genesis Custom Header
  *
*/
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_header_markup_close', 15);
function custom_header() {
  ?>
  		
        <section id="utility-bar" class="display-mobile">
        	<div class="assistance">Need Assistance?: <strong>Call</strong> <a href="tel:817-393-4000">(817) 393-4000</a></div>
            <ul class="share-buttons-top">
                <li>
                	<a href="https://www.facebook.com/WesternSport" class="header-fb" title="Facebook" target="_blank"></a>
                </li>
                <li>
                	<a href="https://instagram.com/westernsport" class="header-ig" target="_blank" title="Instagram"></a>
                </li>
                <li>
                	<a href="https://www.linkedin.com/company/western-sport-llc" class="header-li" target="_blank" title="LinkedIn"></a>
                </li>
                <li>
                	<a href="https://twitter.com/westernsport" target="_blank" class="header-tw" title="Tweet"></a>
                </li>
                <li>
                	<a href="https://www.youtube.com/user/WesternSport" target="_blank" class="header-yt" title="YouTube"></a>
                </li>
            </ul>
            <div class="assistance"><a href="/my-account/">Account</a> &nbsp; | &nbsp; <a href="/my-account/">Login</a></div>
            <br/>
            <div class="search-form-plugin display-mobile">
              <?php dynamic_sidebar( 'genesis-mobile-product-search' ); ?>
            </div>
            <div class="woocoomerce-cart-widget show-me">
                	<span class="mh1">YOUR CART</span><br />
                	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d ITEM', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
                </div>
        </section>
        
  		
        <header class="site-header" itemscope="" itemtype="http://schema.org/WPHeader">
  
  <div id="pixelLeft">&nbsp;</div>
   
  <div class="wrap">
  	
    <?php
		if (is_front_page()) { 
	?>
    
    <div class="title-area">
      <h1 class="site-title" itemprop="headline"><a href="<?=get_bloginfo('home'); ?>" alt="<?php print get_bloginfo('name'); ?>"><?php print get_bloginfo('name'); ?></a></h1>
      <p class="site-description" itemprop="description"><?php print get_bloginfo('description'); ?></p>
    </div>
    
    <?php } else { ?>
    	
     <div class="title-area">
      <p class="site-title" itemprop="headline"><a href="<?=get_bloginfo('home'); ?>" alt="<?php print get_bloginfo('name'); ?>"><?php print get_bloginfo('name'); ?></a></p>
      <p class="site-description" itemprop="description"><?php print get_bloginfo('description'); ?></p>
    </div>
    
    <?php } ?>
    
    <aside class="widget-area header-widget-area">
    	<section id="utility-bar" class="display-desktop">
        	<div class="assistance">Need Assistance?: <strong>Call</strong> <a href="tel:817-393-4000">(817) 393-4000</a></div>
            <ul class="share-buttons-top">
                <li>
                	<a href="https://www.facebook.com/WesternSport" class="header-fb" title="Facebook" target="_blank"></a>
                </li>
                <li>
                	<a href="https://instagram.com/westernsport" class="header-ig" target="_blank" title="Instagram"></a>
                </li>
                <li>
                	<a href="https://www.linkedin.com/company/western-sport-llc" class="header-li" target="_blank" title="LinkedIn"></a>
                </li>
                <li>
                	<a href="https://twitter.com/westernsport" target="_blank" class="header-tw" title="Tweet"></a>
                </li>
                <li>
                	<a href="https://www.youtube.com/user/WesternSport" target="_blank" class="header-yt" title="YouTube"></a>
                </li>
            </ul>
            <div class="assistance"><a href="/my-account/">Account</a> &nbsp; | &nbsp; <a href="/my-account/">Login</a></div>
        </section>
        <section id="search-bar">
            <div class="search-widget"><div class="search-heading"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/search-heading.jpg" width="197" height="44" />
                </div><div class="search-form-plugin">
                	<?php dynamic_sidebar( 'genesis-product-search' ); ?>
                </div><div class="cart-cross">
                	<img src="<?php echo get_stylesheet_directory_uri() ?>/images/cart-cross-bg.jpg" width="47" height="44" />
                </div><div class="woocoomerce-cart-widget hide-me">
                	<span class="mh1">YOUR CART</span><br />
                	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d ITEM', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
                </div></div>
        </section>
        <section id="navigation-bar">
        	<?php ubermenu( 'main' , array( 'menu' => 6 ) ); ?>
        </section>
        
        <div class="bullet-img"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/gun-bullets.png" /></div>
    </aside>
    
  </div>
  
   <div id="pixelRight">&nbsp;</div>
   
</header>
        
  <?php }
add_action('genesis_header', 'custom_header');

// Add the img wrap
add_action( 'woocommerce_before_shop_loop_item_title', function () {
    echo '<div class="img-wrap">';
}, 5 );

add_action( 'woocommerce_after_shop_loop_item_title', function () {
    echo '</div>';
}, 10 );


add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
 

function woocommerce_header_add_to_cart_fragment( $fragments ) {
                global $woocommerce; 
                ob_start(); 
                ?>
                <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
                <?php 
                $fragments['a.cart-contents'] = ob_get_clean();
                return $fragments; 
}


// display an 'Out of Stock' label on archive pages
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_stock', 20 );
function woocommerce_template_loop_stock() {
    global $product;
    if ( !$product->is_in_stock() ) {
        echo '<img class="out-of-stock" src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/icon-sold-out.jpg" />';
    }
}


/* Function which remove Plugin Update Notices – Product Customiser and Product Search */
function disable_plugin_updates( $value ) {
   unset( $value->response['woocommerce-product-archive-customiser/archive-customiser.php'] );
   unset( $value->response['woocommerce-product-search/woocommerce-product-search.php'] );
   return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );


add_filter( 'wc_password_strength_meter_params', 'mr_strength_meter_custom_strings' );
function mr_strength_meter_custom_strings( $data ) {
    $data_new = array(
        'min_password_strength' => apply_filters( 'woocommerce_min_password_strength', 0 ),
        //'i18n_password_error'   => esc_attr__( '<span class="mr-red">Please enter a stronger password.</span>', 'woocommerce' ),
        'i18n_password_hint'    => esc_attr__( 'We recommend your password be <strong>at least 7 characters</strong> and contain a mix of <strong>UPPER</strong> and <strong>lowercase</strong> letters, <strong>numbers</strong>, and <strong>symbols</strong> (e.g., <strong> ! " ? $ % ^ & </strong>). Try to create a password stronger than WEAK.', 'woocommerce' )
    );

    return array_merge( $data, $data_new );
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

function translate_woocommerce($translation, $text, $domain) {
    if ($domain == 'woocommerce') {
        switch ($text) {
            case 'SKU':
                $translation = 'Product Code';
                break;
            case 'SKU:':
                $translation = 'Product Code:';
                break;
        }
    }
    return $translation;
}

add_filter('gettext', 'translate_woocommerce', 10, 3);

add_filter( 'woocommerce_admin_stock_html', 'tmt_show_variation_stock_level', 10, 2 );

function tmt_show_variation_stock_level( $stock_html, $the_product ) {

    if( sizeof( $the_product->get_children() ) ) {

        $stock_html .= ' (' . $the_product->get_total_stock() . ')';

    }

    return $stock_html;

}

add_filter( 'genesis_pre_get_sitemap', 'wsp_genesis_pre_get_sitemap', 10 );
/**
 * @return string sitemap html
 */
function wsp_genesis_pre_get_sitemap() {

	$heading = 'h2';

	$sitemap  = sprintf( '<%2$s>%1$s</%2$s>', __( 'Pages:', 'genesis' ), $heading );
	$sitemap .= sprintf( '<ul>%s</ul>', wp_list_pages( array(
		'title_li' => null,
		'echo' => false,
		'depth' => 1,
		'sort_column' => 'post_title',
	)));

	$sitemap .= sprintf( '<%2$s>%1$s</%2$s>', __( 'Categories:', 'genesis' ), $heading );
	$sitemap .= sprintf( '<ul>%s</ul>', wp_list_categories( array(
		'sort_column' => 'name',
		'title_li' => null,
		'echo' => false,
		'depth' => 1,
	)));

	$users = get_users( array(
		'number' => 10,
		'who' => 'authors',
		'has_published_posts' => true,
		'exclude' => array(
			19278, // Developer
			1, // ThriveAdmin
		),
	));

	ob_start();
	foreach ( $users as $user ) {
		$author_url = get_author_posts_url( $user->ID );
		?>
		<li>
			<a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $user->display_name ); ?></a>
		</li>
		<?php
	}
	$user_li_html = ob_get_clean();

	$sitemap .= sprintf( '<%2$s>%1$s</%2$s>', __( 'Authors:', 'genesis' ), $heading );
	$sitemap .= sprintf( '<ul>%s</ul>', $user_li_html );

	$sitemap .= sprintf( '<%2$s>%1$s</%2$s>', __( 'Monthly:', 'genesis' ), $heading );
	$sitemap .= sprintf( '<ul>%s</ul>', wp_get_archives( array(
		'type' => 'monthly',
		'echo' => false,
		'limit' => 12,
	)));

	$sitemap .= sprintf( '<%2$s>%1$s</%2$s>', __( 'Recent Posts:', 'genesis' ), $heading );
	$sitemap .= sprintf( '<ul>%s</ul>', wp_get_archives( array(
		'type' => 'postbypost',
		'limit' => 10,
		'echo' => false,
	)));


	return $sitemap;
}
function create_customer(){
	global $wpdb;
	$profile_id = '4c1f024b-768c-4a89-9e6f-ee9ba8d7f490';
	$token = '788b8a2976c2456aa7766eea75a78d0b';
	$secret = 'fd20234231d84f3880b6889281f25ba9';
	$URL = 'https://www.grade.us/api/v1';
	

	$date_5_daysAgo = date('Y-m-d', strtotime('-5 days', time()));
	//$date_from = '2018-04-20';
	//$date_to = '2018-05-30';
	$post_status = implode("','", array('wc-completed') );
	
	
	$result = $wpdb->get_results( "SELECT * FROM $wpdb->posts 
		WHERE post_type = 'shop_order'
		AND post_status IN ('{$post_status}')
		AND post_date BETWEEN '{$date_5_daysAgo} 00:00:00' AND '{$date_5_daysAgo} 23:59:59'
	");
	
	// iterating through a stdClass object and get IDs of all the completed ORDERS
	$response;
	foreach($result as $value) {

		$order_id = $value->ID;

		// Pass the order IDS to "WC_Order" function to get the Customer details of all the COMPLETED orders.
		$order = new WC_Order( $order_id );
		
		// push Woocommmerce customer info data to ureview me API POST Request:
		$response = doRequest('customers/create', $URL, $profile_id, $token, $secret, array(
		'email_address' => get_post_meta( $order_id, '_billing_email', true ),
		'first_name' => get_post_meta( $order_id, '_billing_first_name', true ),
		'last_name' => get_post_meta( $order_id, '_billing_last_name', true )
		),'POST', false);


	}// End foreach loop

	
	// Show output as needed
	if ($response) { 
		//echo "<pre>";
		//	print_r($response);  
		//echo "</pre>";
	}

}
//add_shortcode('create_customer_cron', 'create_customer');

//add_action('create_customer_cron','create_customer');


function doRequest($endpoint, $URL, $profile_id, $token, $secret, $data, $method, $signRequest = false) {
	// Use this profile ID:
	$data['profile_id'] = $profile_id;

	// Init CURL:
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Add auth token:
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Authorization: Token token='.$token));

	// Sign request if necessary:
	if ($signRequest) {
	  /* -------------------------------------------------------
		Sign a request by including a hash of the request data
		serialized, encoded and in key order
	  ------------------------------------------------------- */
	  ksort($data);
	  $request_data = array();
	  foreach ($data as $key => $value) {
		$key = str_replace("%7E", "~", urlencode($key));
		$value = str_replace("%7E", "~", urlencode($value));
		$request_data[] = $key . '=' . $value;
	  }
	  $signed_str = implode('&', $request_data);
	  $signature = base64_encode(hash_hmac('sha256', $signed_str, $secret, true));
	  $data['hash'] = $signature;
	}

	// Build the query:
	$query = '';
	switch($method) {
	  case 'GET':
		$query = '/' . $endpoint . '?' . http_build_query($data);
		break;
	  case 'POST':
		$query = '/' . $endpoint;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		break;
	}
	// Strip double slashes and setup URL:
	while (strpos($query, '//') > -1) {
	  $query = str_replace('//', '/', $query);
	}
	curl_setopt($ch, CURLOPT_URL, $URL.$query);

	// Execute CURL and close:
	$response = curl_exec($ch);
	curl_close($ch);

	// Decode JSON and return:
	return json_decode($response, true);

}


function add_customer_to_reviewshake(){
	global $wpdb;

	$date_5_daysAgo = date('Y-m-d', strtotime('-5 days', time()));
	//$date_from = '2018-04-20';
	//$date_to = '2018-05-30';
	$post_status = implode("','", array('wc-completed') );
	
	
	$result = $wpdb->get_results( "SELECT * FROM $wpdb->posts 
		WHERE post_type = 'shop_order'
		AND post_status IN ('{$post_status}')
		AND post_date BETWEEN '{$date_5_daysAgo} 00:00:00' AND '{$date_5_daysAgo} 23:59:59'
	");

	$response;
	$data;
	foreach($result as $value) {

		$order_id = $value->ID;
		
		$order = new WC_Order( $order_id );
		
		$email = get_post_meta( $order_id, '_billing_email', true );
		
		$first_name = get_post_meta( $order_id, '_billing_first_name', true );
		
		$last_name = get_post_meta( $order_id, '_billing_last_name', true );
		
		$phone_no = get_post_meta( $order_id, '_billing_phone', true );
		
		//echo $email . " " . $first_name . " " . $last_name;
		
		if($phone_no){
			
			$phone_no = "+1" . $phone_no;
		
			$data = array("campaign_name" => "Thrive default campaign", "customer" => array("first_name" => $first_name, "last_name" => $last_name, "email" => $email, "phone" => $phone_no, "client" => "Western Sport"));
			
		} else {
			$data = array("campaign_name" => "Thrive default campaign", "customer" => array("first_name" => $first_name, "last_name" => $last_name, "email" => $email, "client" => "Western Sport"));
		}
	
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "www.rize.reviews/api/v1/customer/subscribe",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($data),
		  CURLOPT_HTTPHEADER => array(
		    "X-Spree-Token: 502f6838791ba3f5478b6d398f53fa2883b48c0c3cf8fb35",
		    "Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		$response = json_decode($response);
		
		if($response){
			/* echo "<pre>";
			print_r($response);
			echo "</pre>"; */
		}
		
	}
}
//add_shortcode('custom_reviewshake_shortcode', 'add_customer_to_reviewshake');
add_action('create_customer_cron','add_customer_to_reviewshake');


// Add Backorder Text to add to cart button for back ordered items
add_filter( 'woocommerce_product_add_to_cart_text', 'create_backorder_button', 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'create_backorder_button', 10, 2 );
function create_backorder_button( $text, $product ){
	if ( $product->is_on_backorder( 1 ) ) {
		$text = __( 'Available on Backorder', 'woocommerce' );
	}
	return $text;
}

function ws_sort_by_stock_amount( $args ) {
	$args['orderby'] = 'meta_value';
	$args['order'] = 'ASC';
	$args['meta_key'] = '_stock_status';
	return $args;
 }
add_filter( 'woocommerce_get_catalog_ordering_args', 'ws_sort_by_stock_amount', 9999 );

function ws_add_custom_sorting_options( $options ){
	$options['in-stock'] = 'Show In Stock Products First';
	return $options;
}
add_filter( 'woocommerce_catalog_orderby', 'ws_add_custom_sorting_options' );

function ws_custom_product_sorting( $args ) {
	// Sort alphabetically
	if ( isset( $_GET['orderby'] ) && 'title' === $_GET['orderby'] ) {
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
	}

	// Show products in stock first
	if( isset( $_GET['orderby'] ) && 'in-stock' === $_GET['orderby'] ) {
		$args['meta_key'] = '_stock_status';
		$args['orderby'] = array( 'meta_value' => 'ASC' );
	}
	return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'ws_custom_product_sorting' );

function ws_change_sorting_options_order( $options ){
	$options = array(
		'menu_order' 	=> __( 'Default sorting', 'woocommerce' ),
		'in-stock' 		=> __( 'Show In Stock Products First', 'woocommerce' ),
		'popularity' 	=> __( 'Sort by popularity', 'woocommerce' ),
		'rating'     	=> 'Sort by average rating',
		'date'       	=> __( 'Sort by latest', 'woocommerce' ),
		'price'      	=> __( 'Sort by price: low to high', 'woocommerce' ),
		'price-desc' 	=> __( 'Sort by price: high to low', 'woocommerce' ),
	);
	return $options;
}
add_filter( 'woocommerce_catalog_orderby', 'ws_change_sorting_options_order', 5 );

function ws_cart_has_product_with_shipping_class( $slug ) {
	global $woocommerce;
	$product_in_cart = false;
	foreach( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
		$terms = get_the_terms( $_product->id, 'product_shipping_class' );
		if( $terms ) {
			foreach( $terms as $term ) {
				$_shippingclass = $term->slug;
				if( $slug === $_shippingclass ) {
					$product_in_cart = true;
				}
			}
		}
	}
	return $product_in_cart;
}

function latest_edited_products_shortcode($atts) {
    ob_start();

    $atts = shortcode_atts(array(
        'per_page' => 6,
        'columns' => 1,
    ), $atts, 'latest_edited_products');

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $atts['per_page'],
        'orderby' => 'modified',
        'order' => 'DESC'
    );

    $loop = new WP_Query($args);

    if ($loop->have_posts()) : 
        echo '<ul class="products">';
        while ($loop->have_posts()) : $loop->the_post();
            echo '<li>' . get_the_title() . ' - Last Modified: ' . get_the_modified_date() . '</li>';
            wc_get_template_part('content', 'product');
        endwhile;
        echo '</ul>';
    else :
        echo '<p>No products found</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('latest_edited_products', 'latest_edited_products_shortcode');


function top_selling_products_shortcode($atts) {
    ob_start();

    $atts = shortcode_atts(array(
        'per_page' => 6,
        'columns' => 1,
    ), $atts, 'top_selling_products');

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $atts['per_page'],
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );

    $loop = new WP_Query($args);

    if ($loop->have_posts()) : 
        echo '<ul class="products">';
        while ($loop->have_posts()) : $loop->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
        echo '</ul>';
    else :
        echo '<p>No products found</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('top_selling_products', 'top_selling_products_shortcode');



function remove_usps_shipping_select_products( $rates, $package ) {
	if( 
		ws_cart_has_product_with_shipping_class( 'free-shipping' ) || 
		ws_cart_has_product_with_shipping_class( '15-shipping-fixed' ) ||
		ws_cart_has_product_with_shipping_class( 'daniel-defense-upper' ) ||
		ws_cart_has_product_with_shipping_class( '20-gun-broker-flat-rate-shipping' ) ||
		ws_cart_has_product_with_shipping_class( 'local-pickup' ) ||
		ws_cart_has_product_with_shipping_class( '50-rifle-shipping-rate' ) ||
		ws_cart_has_product_with_shipping_class( '50-suppressor-ship' ) ) {
		foreach( $rates as $rate_key => $rate ) {
			if ( isset( $rate->method_id ) && 'usps' === $rate->method_id ) {
				unset( $rates[ $rate_key ] );
			}
		}
	}
   return $rates;
}
add_filter( 'woocommerce_package_rates', 'remove_usps_shipping_select_products', 10, 2 );

function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


