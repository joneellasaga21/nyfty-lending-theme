<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 8.0
 */

 use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<section class="directorist-single-listing-header">
	<?php
	$args = [
		'listing' => $listing,
		'display_title' => $display_title,
		'display_tagline' => $display_tagline,
	];
    $socials = $listing->get_socials();

	foreach ( $listing->header_data as $data ) {
		if ( empty( $data['placeholderKey'] ) ) {
			continue;
		}
		$template = str_replace( "-placeholder", "", $data['placeholderKey'] );
		Helper::get_template( 'single/header-parts/'. $template, $args );
	} ?>

    <div class="accordion-mobile-container accordion-container">
        <?php echo do_shortcode('[officer_tab_menu]'); ?>
    </div>
    <?php if ( !empty( $socials ) ): ?>
        <div class="directorist-single-info directorist-single-info-socials">

            <div class="directorist-social-links">
                <?php  foreach ( $socials as $social ): ?>
                    <?php $icon = 'lab la-' . $social['id']; ?>
                    <?php if($social['id'] === 'facebook'): ?>
                        <a target='_blank' href="<?php echo esc_url( $social['url'] ); ?>" class="<?php echo esc_attr( $social['id'] ); ?>">
                            <i class="directorist-icon-mask tumbler" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon-fb.svg)"></i>
                        </a>
                    <?php elseif($social['id'] === 'linkedin'): ?>
                        <a target='_blank' href="<?php echo esc_url( $social['url'] ); ?>" class="<?php echo esc_attr( $social['id'] ); ?>">
                            <i class="directorist-icon-mask tumbler" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon-linkedin.svg)"></i>
                        </a>
                    <?php elseif($social['id'] === 'tumblr'): ?>
                        <a target='_blank' href="<?php echo esc_url( $social['url'] ); ?>" class="<?php echo esc_attr( $social['id'] ); ?>">
                            <i class="directorist-icon-mask tumbler" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon-tumblr.svg)"></i>
                        </a>
                    <?php elseif($social['id'] === 'instagram'): ?>
                        <a target='_blank' href="<?php echo esc_url( $social['url'] ); ?>" class="<?php echo esc_attr( $social['id'] ); ?>">
                            <i class="directorist-icon-mask tumbler" aria-hidden="true" style="--directorist-icon: url(https://nyftylending.com/wp-content/uploads/2024/12/icon-insta.svg)"></i>
                        </a>
                    <?php else: ?>
                        <a target='_blank' href="<?php echo esc_url( $social['url'] ); ?>" class="<?php echo esc_attr( $social['id'] ); ?>">
                            <?php directorist_icon( $icon ); ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        </div>
    <?php endif; ?>
</section>