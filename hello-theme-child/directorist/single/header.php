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
        <div class="e-n-accordion accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details class="accordion-item">
                <summary class="accordion-tab" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2030">
                    <span class="accordion-header">
                        <span class="accordion-title">Get Started </span>
                    </span>
                    <span class="accordion-drop-icon">
                        <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
                        <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
                    </span>
                </summary>
            </details>
            <div class="accordion-desc">
                <ul>
                    <li><a href="#start-application">Start Application</a></li>
                    <li><a href="#">My Account</a></li>
                </ul>
            </div>
        </div>
        <div class="e-n-accordion accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details class="accordion-item">
                <summary class="accordion-tab" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2031">
                <span class="accordion-header">
                    <span class="accordion-title">Mortgage Tools </span>
                </span>
                    <span class="accordion-drop-icon">
                    <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
                    <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
                </span>
                </summary>
            </details>
            <div class="accordion-desc">
                <ul>
                    <li><a href="https://nyftylending.com/loan-calculators/">Mortgage Calculator</a></li>
                    <li><a href="#">Learning Center</a></li>
                    <li><a href="#">Application Checklist</a></li>
                    <li><a href="#">FAQ's</a></li>
                </ul>
            </div>
        </div>
        <div class="e-n-accordion accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details class="accordion-item">
                <summary class="accordion-tab" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2032">
                <span class="accordion-header">
                    <span class="accordion-title">About Us </span>
                </span>
                    <span class="accordion-drop-icon">
                    <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
                    <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
                </span>
                </summary>
            </details>
            <div class="accordion-desc">
                <ul>
                    <li><a href="https://nyftylending.com/about-us/">About NYFTY Lending</a></li>
                    <li><a href="">Licensing</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
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