<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.1
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-archive-items directorist-archive-list-view <?php echo esc_attr( $listings->pagination_infinite_scroll_class() ) ?>">
	<div class="<?php Helper::directorist_container_fluid(); ?>">

		<?php do_action( 'directorist_before_list_listings_loop' ); ?>

			<?php if ( $listings->have_posts() ): ?>

				<div class="<?php Helper::directorist_row(); ?>">
					<?php $listings->render_list_view( $listings->post_ids() ) ?>
					</div>
				<div/>
				
				<?php
				if ( $listings->show_pagination && 'numbered' === $listings->options['pagination_type'] ) {

					do_action( 'directorist_before_listings_pagination' );

					$listings->pagination();

					do_action( 'directorist_after_listings_pagination' );
				}
				?>

				<?php do_action('directorist_after_grid_listings_loop'); ?>

			<?php else: ?>

			<div class="directorist-archive-notfound"><?php esc_html_e( 'No listings found.', 'directorist' ); ?></div>

		<?php endif; ?>
	</div>
    <script>
        // Add a click event listener to all elements with the class 'contact-me'
        jQuery(document).ready(function ($) {
            $('.contact-me').on('click', function() {
                // Get the email and image from data attributes
                var email = $(this).data('email');
                var image = $(this).data('img');

                // Ensure email and image exist before updating
                if (email && image) {
                    setTimeout(function() {
                        // Set the email value in the input field
                        var $inputField = $('#input_15_9');
                        if ($inputField.length) {
                            $inputField.val(email);
                        }

                        // Set the image source
                        var $imageElement = $('#elementor-popup-modal-9253 img');
                        if ($imageElement.length) {
                            $imageElement.attr('src', image);
                        }
                    }, 300);
                } else {
                    console.error('Email or image data is missing from the clicked element.');
                }
            });
        });
    </script>
</div>