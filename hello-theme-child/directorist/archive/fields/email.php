<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<li class="directorist-listing-card-email">
    <span class="label">E:</span>
    <a target="_top" href="mailto:<?php echo esc_attr( $value );?>">
    <?php echo esc_html( $value ) ;?>
    </a>
</li>