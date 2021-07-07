<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form'));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}

add_action('wp_enqueue_scripts', 'blankslate_load_scripts');
function blankslate_load_scripts()
{
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}

add_action('wp_footer', 'blankslate_footer_scripts');
function blankslate_footer_scripts()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
    <?php
}

add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = '|';
    return $sep;
}

add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return '...';
    } else {
        return $title;
    }
}

add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">...</a>';
    }
}

add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">...</a>';
    }
}

add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    return $sizes;
}

add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

function blankslate_custom_pings($comment)
{
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
    <?php
}

add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}

if( !function_exists('products_list_in_a_product_category') ) {

    function products_list_in_a_product_category( $atts ) {

        // Shortcode Attributes
        $atts = shortcode_atts(
            array(
                'cat'       => '',
                'limit'     => '3', // default product per page
                'column'    => '3', // default columns
            ),
            $atts, 'productslist'
        );

        // The query
        $posts = get_posts( array(
            'post_type'      => 'product',
            'posts_per_page' => intval($atts['limit'])+1,
            'product_cat'    => $atts['cat'],
        ) );

        $output = '<div class="products-in-'.$atts['cat'].'">';

        // The loop
        foreach($posts as $post_obj)
            $ids_array[] = $post_obj->ID;

        $ids = implode( ',', $ids_array );

        $columns = $atts['column'];

        $output .= do_shortcode ( "[products ids=$ids columns=$columns ]" ) . '</div>';

        return $output;
    }
    add_shortcode( 'productslist', 'products_list_in_a_product_category' );
}

add_shortcode ('woo_cart_but', 'woo_cart_but' );
/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function woo_cart_but() {
    ob_start();

    $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
    $cart_url = wc_get_cart_url();  // Set Cart URL

    ?>
    <li><a class="menu-item cart-contents" href="<?php echo $cart_url; ?>" title="My Basket">
            <?php
            if ( $cart_count > 0 ) {
                ?>
                <span class="cart-contents-count"><?php echo $cart_count; ?></span>
                <?php
            }
            ?>
        </a></li>
    <?php

    return ob_get_clean();

}

add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
/**
 * Add AJAX Shortcode when cart contents update
 */
function woo_cart_but_count( $fragments ) {

    ob_start();

    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();

    ?>
    <a class="cart-contents menu-item" href="<?php echo $cart_url; ?>" title="<?php _e( 'Kosár megtekintése' ); ?>">
        <?php
        if ( $cart_count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo $cart_count; ?></span>
            <?php
        }
        ?></a>
    <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

add_filter( 'wp_nav_menu', 'woo_cart_but_icon', 10, 2 ); // Change menu to suit - example uses 'top-menu'

/**
 * Add WooCommerce Cart Menu Item Shortcode to particular menu
 */
function woo_cart_but_icon ( $items, $args ) {
    $items .= do_shortcode("[woo_cart_but]"); // Adding the created Icon via the shortcode already created

    return $items;
}

wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.6.1/css/all.css' );

function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(

        'product_grid'          => array(
            'default_rows'    => 4,
            'min_rows'        => 1,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 4,
            'max_columns'     => 5,
        ),
    ) );
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

/*
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url()
{
    global $woocommerce;

    if ($_SERVER['REQUEST_URI'] === '/') {
        $woocommerce->cart->empty_cart();
    }
}


add_filter('wc_session_expiring', 'filter_ExtendSessionExpiring' );
add_filter('wc_session_expiration' , 'filter_ExtendSessionExpired' );

function filter_ExtendSessionExpiring($seconds) {
    global $woocommerce;

    $woocommerce->session->set_customer_session_cookie(true);
    return 60 * 30;
    WC()->cart->empty_cart();
    WC()->session->destroy_session();
}

function filter_ExtendSessionExpired($seconds) {
    global $woocommerce;

    $woocommerce->session->set_customer_session_cookie(true);
    return 60 * 30;
    WC()->cart->empty_cart();
    WC()->session->destroy_session();
}



/**
 * Set session expiration.

public function set_session_expiration() {
    $this->_session_expiring   = time() + intval( apply_filters( 'wc_session_expiring', 60 * 60 * 47 ) ); // 47 Hours.
    $this->_session_expiration = time() + intval( apply_filters( 'wc_session_expiration', 60 * 60 * 48 ) ); // 48 Hours.
}

add_filter( 'wc_session_expiring', 'wc_custom_session_expiring' );
add_filter( 'wc_session_expiration', 'wc_custom_session_expiring' );

function wc_custom_session_expiring( $expiry ) {
    return 60 * 30;
}

*/
