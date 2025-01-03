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

    wp_enqueue_script('nyfty-script', get_stylesheet_directory_uri() . '/asset/custom-global.js', array('jquery'),
        '1.4.8', true);
    wp_enqueue_style('custom-global-style', get_stylesheet_directory_uri(). '/asset/custom-style.css', array(), '1.0.5');

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );


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
