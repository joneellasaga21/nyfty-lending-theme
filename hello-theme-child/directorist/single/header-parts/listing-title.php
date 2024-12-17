<?php
/**
 * @author  wpWax
 * @since   8.0
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$list_id = $listing->id;
$get_email =  get_post_meta($list_id, '_email', true);
$get_phone =  get_post_meta($list_id, '_phone', true);
$get_position = get_post_meta($list_id, '_custom-text-2', true);
$get_nmls = get_post_meta( $list_id, '_custom-text', true );

if ( $display_title ): ?>

<?php endif;

if ( $display_tagline && $listing->get_tagline() ): ?>

    <p class="directorist-listing-details__tagline"><?php echo esc_html( $listing->get_tagline() ); ?></p>
    
<?php endif; ?>

<?php do_action( 'directorist_single_listing_after_title', $listing->id ); ?>