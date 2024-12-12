<?php
/**
 * Comment and review template for single view.
 *
 * @since   7.1.0
 * @version 8.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Directorist\Review\Bootstrap;
use Directorist\Review\Builder;
use Directorist\Review\Markup;
use Directorist\Review\Walker as Review_Walker;
use Directorist\Review\Comment_Form_Renderer;
use Directorist\Directorist_Single_Listing;

$review_rating = directorist_get_listing_rating( get_the_ID() );
$review_count  = directorist_get_listing_review_count( get_the_ID() );
$review_text   = sprintf( _n( '%s review', '%s reviews', $review_count, 'directorist' ), number_format_i18n( $review_count ) );

// Load walker class
Bootstrap::load_walker();

$listing       = Directorist_Single_Listing::instance( get_the_ID() );
$section_data  = $listing->get_review_section_data();
$builder       = Builder::get( $section_data['section_data'] );
$section_id    = isset( $section_data['id'] ) ? $section_data['id'] : '';
$section_class = isset( $section_data['class'] ) ? $section_data['class'] : '';
$section_icon  = isset( $section_data['icon'] ) ? $section_data['icon'] : '';
$section_label = isset( $section_data['label'] ) ? $section_data['label'] : '';
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="directorist-review-container <?php echo esc_attr( $section_class ); ?>">
	<div class="directorist-card directorist-review-content">
		<div class="directorist-card__header directorist-review-content__header <?php if ( ! have_comments() ) : ?>directorist-review-content__header--noreviews<?php endif;?>">
			<?php if ( ! have_comments() ) : ?><?php endif;?>
			<h3 class="directorist-card__header__title">
				<?php if ( ! empty( $section_icon ) ) : ?>
					<span class="directorist-card__header-icon"><?php directorist_icon( $section_icon ); ?> </span>
				<?php endif; ?>
				<span class="directorist-card__header-text"><?php echo esc_html( $section_label ); ?></span>
			</h3>
		</div><!-- ends: .directorist-review-content__header -->

		<?php if ( have_comments() ): ?>

			<ul class="commentlist directorist-review-content__reviews">
                <?php
                wp_list_comments( [
                    'type'     => 'comment',
                    'callback' => 'custom_comment',
                ] );
                ?>
			</ul>
		<?php endif;?>
	</div><!-- ends: .directorist-review-content -->

	<?php if ( get_comment_pages_count() > 1 ) : ?>
		<nav class="directorist-review-content__pagination directorist-pagination" aria-label="Review Pagination">
			<?php
			$prev_text = directorist_icon( 'las la-arrow-left', false );
			$next_text = directorist_icon( 'las la-arrow-right', false );
			paginate_comments_links( array(
				'prev_text'    => $prev_text,
				'next_text'    => $next_text,
				'type'         => 'plain',
				'add_fragment' => '#' . $section_id,
			) );
			?>
		</nav>
	<?php endif;?>

</section>