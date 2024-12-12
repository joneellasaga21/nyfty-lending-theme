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
            '<div class="custom-single-image flex-col-3"><img src="%1$s" alt="%2$s" title="%2$s"></div>',
            esc_url( $image['src'] ),
            esc_attr( $image['alt'] )
        );
    }
endif;
?>