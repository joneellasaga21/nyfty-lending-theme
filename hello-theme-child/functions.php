<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

    $db_officers = get_directory_listing_names();

    wp_enqueue_script('nyfty-script', get_stylesheet_directory_uri() . '/asset/custom-global.js', array('jquery'),
        '1.7.7', true);

    wp_add_inline_script( 'nyfty-script', 'const NYFTYDB = ' . json_encode( array(
            'officers' => $db_officers,
        ) ), 'before' );

    wp_enqueue_style('custom-global-style', get_stylesheet_directory_uri(). '/asset/custom-style.css', array(), '1.1.3');

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

function get_directory_listing_names(){
    $directory_listing = get_posts(array('post_type' => 'at_biz_dir', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1));
    $data = array();
    foreach($directory_listing as $item){
        $data[] = $item->post_title;
    }
    return $data;
}

/**
 * Register List Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_custom_post_widget( $widgets_manager ) {

    require_once(__DIR__ . '/widgets/custom-post-widget.php');

    $widgets_manager->register( new \Elementor_Custom_Post_Widget() );

}
add_action( 'elementor/widgets/register', 'register_custom_post_widget' );

add_shortcode( 'officer_tab_menu', 'custom_officer_tab_navigation' );

function custom_officer_tab_navigation($atts){
    global $post;
    $pid = $post->ID;
    $get_email =  get_post_meta($pid, '_email', true);
    $sonar_email = urlencode($get_email);

    ob_start();?>
    <div class="elementor-widget-container accordion-container">
        <div class="e-n-accordion accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details class="accordion-item">
                <summary class="accordion-tab" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2030">
            <span class="accordion-header">
                <span class="accordion-title">Get Started </span>
            </span>
                    <span class="accordion-drop-icon">
                <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
                <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
            </span>
                </summary>
            </details>
            <div class="accordion-desc">
                <ul>
                    <li><a href="<?php echo 'https://nyftylending.pos.yoursonar.com/?originator=' . $sonar_email ?>" target="_blank">Start Application</a></li>
                </ul>
            </div>
        </div>
        <div class="e-n-accordion accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details class="accordion-item">
                <summary class="accordion-tab" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2031">
        <span class="accordion-header">
            <span class="accordion-title">Mortgage Tools </span>
        </span>
                    <span class="accordion-drop-icon">
            <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
            <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
        </span>
                </summary>
            </details>
            <div class="accordion-desc">
                <ul>
                    <li><a href="https://nyftylending.com/loan-calculators/">Mortgage Calculator</a></li>
                </ul>
            </div>
        </div>
        <div class="e-n-accordion accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details class="accordion-item">
                <summary class="accordion-tab" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2032">
        <span class="accordion-header">
            <span class="accordion-title">About Us </span>
        </span>
                    <span class="accordion-drop-icon">
            <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
            <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
        </span>
                </summary>
            </details>
            <div class="accordion-desc">
                <ul>
                    <li><a href="https://nyftylending.com/about-us/">About NYFTY Lending</a></li>
                    <li><a href="">Licensing</a></li>
                    <li><a href="https://nyftylending.com/privacy-policy-us/">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function custom_comment( $comment, $args, $depth ) {

    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    }
    else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }

    $classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
    ?>

    <<?= $tag . $classes; ?> id="comment-<?php comment_ID() ?>">

    <?php if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>

    <?php if ( $comment->comment_approved == '0' ) { ?>
        <em class="comment-awaiting-moderation">
            <?php _e( 'Your comment is awaiting moderation.' ); ?>
        </em><br/>
    <?php } ?>

    <div class="comment-meta commentmetadata">
        <?php
        printf(
            __( '%1$s' ),
            get_comment_date('F Y')
        ); ?>
    </div>

    <?php comment_text(); ?>

    <div class="comment-author vcard">
        <?php
        if ( $args['avatar_size'] != 0 ) {
            echo get_avatar( $comment, $args['avatar_size'] );
        }
        printf(
            __( '<p class="author">-%s</p>' ),
            get_comment_author()
        );
        ?>
    </div>

    <?php if ( 'div' != $args['style'] ) { ?>
        </div>
    <?php }
}
