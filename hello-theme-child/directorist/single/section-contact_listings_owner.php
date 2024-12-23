<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if( $listing->contact_owner_form_disabled() ) {
	return;
}

$fields = $listing->contact_owner_fields( $section_data['fields'] );
$list_id = $listing->id;
$get_email =  get_post_meta($list_id, '_email', true);
?>

<section class="directorist-card directorist-card-contact-owner <?php echo esc_attr( $class );?>" <?php $listing->section_id( $id ); ?>>

	<div class="directorist-card__body">

		<?php echo do_shortcode('[gravityform id="9" title="true" ajax="true" field_values="officer_email='.$get_email.'"]') ?>

	</div>

</section>