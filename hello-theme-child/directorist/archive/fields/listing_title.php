<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.0.4
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<h3 class="directorist-listing-title"><?php echo wp_kses_post( $listings->loop_get_title() );?></h3>

<?php if( !empty( $data['show_tagline'] ) && !empty( $listings->loop_get_tagline() ) ){ ?>
    
<p class="directorist-listing-tagline"><?php echo wp_kses_post( $listings->loop_get_tagline() );?></p>

<?php }?>