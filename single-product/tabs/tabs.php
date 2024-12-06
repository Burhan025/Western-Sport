<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri() ?>/css/easy-responsive-tabs.css " />
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>-->

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri() ?>/js/easyResponsiveTabs.js"></script>
<style>
.related {clear:both;}
.resp-tabs-container .addtoany_content_bottom{ display:none !important;}
</style>
<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates 2.1.0
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

    <div id="parentVerticalTab">
        <ul class="resp-tabs-list hor_1" style="clear: both;">
            <?php foreach ( $tabs as $key => $tab ) : ?>
                <li class="<?php echo esc_attr( $key ); ?>_tab">
                    <a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="resp-tabs-container hor_1">
        <?php foreach ( $tabs as $key => $tab ) : ?>
            <div>
                <?php
                    if ( isset( $tab['callback'] ) ) { 
                        call_user_func( $tab['callback'], $key, $tab ); 
                    }
                ?>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
