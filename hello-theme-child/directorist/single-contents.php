<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 8.0
 */

use \Directorist\Directorist_Single_Listing;
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

$listing = Directorist_Single_Listing::instance();
?>

<div class="directorist-single-contents-area directorist-w-100" data-id="<?php echo esc_attr( $listing->id ?? ''); ?>">
	<div class="<?php Helper::directorist_container_fluid(); ?>">
		<?php $listing->notice_template(); ?>

		<div class="<?php Helper::directorist_row(); ?>">

			<div class="<?php Helper::directorist_single_column(); ?>">

				<?php 
				
				$disable_single_listing = get_directorist_option( 'disable_single_listing') ? true : false;

				if( !$disable_single_listing ){ ?>

					<?php if ( $listing->single_page_enabled() ): ?>

						<div class="directorist-single-wrapper">

							<?php
							// Output already filtered
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo $listing->single_page_content();
							?>

						</div>

					<?php else: ?>

						<div class="directorist-single-wrapper">

							<?php
							$listing->header_template();

							foreach ( $listing->content_data as $section ) {
								$listing->section_template( $section );
							}
							?>

						</div>

					<?php endif; ?>
				<?php } else { ?>
					<div class="directorist-alert directorist-alert-warning directorist-single-listing-notice">

						<div class="directorist-alert__content">

							<span><?php esc_html_e( 'Single listing view is disabled', 'directorist' ); ?></span>

						</div>

					</div>
				<?php } ?>

			</div>

			<?php Helper::get_template( 'single-sidebar' ); ?>

		</div>
	</div>
</div>
<div class="directorist-single-contents-area directorist-w-50">
    <div class="elementor-widget-container">
        <div class="e-n-accordion" aria-label="Accordion. Open links with Enter or Space, close with Escape, and navigate with Arrow Keys">
            <details id="e-n-accordion-item-2030" class="e-n-accordion-item">
                <summary class="e-n-accordion-item-title" data-accordion-index="1" tabindex="0" aria-expanded="true" aria-controls="e-n-accordion-item-2030">
                    <span class="e-n-accordion-item-title-header">
                        <div class="e-n-accordion-item-title-text"> Get Started </div>
                    </span>
                    <span class="e-n-accordion-item-title-icon">
                        <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-up" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"></path></svg></span>
                        <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-chevron-down" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg></span>
                    </span>

                </summary>
                <div class="accordion-desc-container">
                    <div class="accordion-desc-wrapper">
                        <div class="accordion-desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                        </div>
                    </div>
                </div>
            </details>
        </div>
    </div>
</div>

