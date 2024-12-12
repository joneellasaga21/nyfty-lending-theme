<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.7.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="directorist-single-map__location">

    <?php if( ! empty( $display_direction_map ) && ! empty( $manual_lat ) && ! empty( $manual_lng ) ) : ?>
        <div class='directorist-single-map__direction'>
            <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-grow" href='http://www.google.com/maps?daddr=<?php echo esc_attr( $manual_lat ); ?>, <?php echo esc_attr( $manual_lng ); ?>' target='_blank'>
                 <span class="elementor-button-content-wrapper">
                    <span class="elementor-button-text"><?php esc_html_e('Get Directions', 'directorist'); ?></span>
                </span>
            </a>
        </div>
    <?php endif; ?>
</div>
