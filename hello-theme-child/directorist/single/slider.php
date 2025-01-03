<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$list_id = $listing->id;
$get_email =  get_post_meta($list_id, '_email', true);
$get_phone =  get_post_meta($list_id, '_phone', true);
$get_position = get_post_meta($list_id, '_custom-text-2', true);
$get_nmls = get_post_meta( $list_id, '_custom-text', true );

echo "<div class='custom-listing-header'>";
if ( ! empty( $data['images'] )  ) {
    $src = $data['images'][0]['src'] . '.webp';
    $alt = $data['images'][0]['alt'];
    if(!empty($src)){
      echo "<div class='custom-single-image' style='background-image: url($src)'>";
      echo "</div>";
    }
}
if ( $list_id ) {
    ?>
    <div class='custom-single-profile'>
        <h2 class="directorist-listing-details__listing-title"><?php echo esc_html( $listing->get_title() ); ?></h2>
        <h3 class="position"><?php echo $get_position; ?></h3>
        <h4 class="nmls"><span class="label">NMLS# </span><?php echo $get_nmls; ?></h4>
        <span class="custom-icon-list phone"><a href="tel:<?php echo $get_phone; ?>" alt="Call Me"><i class="directorist-icon-mask" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon_phone_single.svg)"></i> <span class="text"><?php echo $get_phone; ?></span></a></span>
        <span class="custom-icon-list email"><a href="mailto:<?php echo $get_email; ?>" alt="Contact Me"><i class="directorist-icon-mask" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon_mail_single.svg)"></i> <span class="text"><?php echo $get_email; ?></span></a></span>
        <div class="custom-button-wrap">
            <div class="custom-button-inner">
                <a href="mailto:<?php echo $get_email; ?>" class="elementor-button elementor-button-link elementor-size-sm">
                    Contact Me
                </a>
            </div>
            <div class="custom-button-inner">
                <a href="#start-application" class="elementor-button elementor-button-link elementor-size-sm">
                    Apply Now
                </a>
            </div>
            
        </div>
    </div>
    <?php
}

echo "</div>";
