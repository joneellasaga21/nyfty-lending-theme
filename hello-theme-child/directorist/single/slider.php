<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>
<?php
if ( ! empty( $data['images'] )  ):
    foreach ( $data['images'] as $image ) {
        if ( empty( $image['src'] ) ) {
            continue;
        }
        printf(
            '<div class="swiper-slide"><img src="%1$s" alt="%2$s"></div>',
            esc_url( $image['src'] ),
            esc_attr( $image['alt'] )
        );
    }
endif;
?>