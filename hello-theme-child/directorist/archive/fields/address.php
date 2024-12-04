<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<li class="directorist-listing-card-address">
   <i class="directorist-icon-mask" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon_address.svg)"></i>
    <?php if ( ! empty( $label ) ) : ?>
        <?php $listings->print_label( $label ); ?>
    <?php endif; ?>
    <?php echo esc_html( $value ); ?>
</li>