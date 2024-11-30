<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['card_fields']['template_data']['grid_view_with_thumbnail'];
$list_id = $listings->loop['id'];
$img_url = get_post_meta( $list_id, '_custom-file', true );
$profile_thumb = str_replace( '|', '', $img_url );
$get_email =  get_post_meta($list_id, '_email', true);
$get_phone =  get_post_meta($list_id, '_phone', true);
?>

<article class="directorist-listing-single directorist-listing-single--bg directorist-listing-card directorist-listing-has-thumb <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>" data-pid="<?php echo $list_id; ?>">

    <div class="directorist-listing-single__thumb">
        <?php if($img_url): ?>
        <div class="directorist-thumnail-card directorist-card-cover">
            <a href="<?php echo $listings->loop['permalink'];?>">
                <figure>
                    <img src="<?php echo $profile_thumb; ?>" alt="" title=""/>
                </figure>
            </a>
        </div>
        <?php else: $listings->loop_thumb_card_template(); ?>
        <?php endif;
        $listings->render_loop_fields($loop_fields['thumbnail']['avatar']);
        ?>

        <div class="directorist-thumb-top-left"><?php $listings->render_loop_fields($loop_fields['thumbnail']['top_left']); ?></div>
        <div class="directorist-thumb-top-right"><?php $listings->render_loop_fields($loop_fields['thumbnail']['top_right']); ?></div>
        <div class="directorist-thumb-bottom-left"><?php $listings->render_loop_fields($loop_fields['thumbnail']['bottom_left']); ?></div>
        <div class="directorist-thumb-bottom-right"><?php $listings->render_loop_fields($loop_fields['thumbnail']['bottom_right']); ?></div>

    </div>

    <div class="directorist-listing-single__content">
        <section class="directorist-listing-single__info">
            <header class="directorist-listing-single__info__top">
                <?php $listings->render_loop_fields( $loop_fields['body']['top'], 'div', 'div' ); ?>
                <span class="position"><?php echo get_post_meta( $list_id, '_custom-text-2', true ); ?></span>
            </header>

            <ul class="directorist-listing-single__info__list">
                <li><span class="label">NMLS# </span><?php echo get_post_meta( $list_id, '_custom-text', true ); ?></li>
                <?php $listings->render_loop_fields( $loop_fields['body']['bottom'], 'li', 'li' ); ?>
            </ul>

            <?php if ( ! empty( $loop_fields['body']['excerpt'] ) ) : ?>
                <?php $listings->render_loop_fields( $loop_fields['body']['excerpt'] ) ?>
            <?php endif; ?>
        </section>

        <footer class="directorist-listing-single__meta">
            <div class="directorist-listing-single__meta__left">
                <a href="mailto:<?php echo $get_email; ?>"><img class="icon" src="https://nyftylending.com/wp-content/uploads/2024/11/icon_email_envelope.svg" alt="Email" /></a>
            </div>
            <div class="directorist-listing-single__meta__middle">
                <a href="<?php echo $listings->loop['permalink']; ?>" alt="Apply Now" class="btn apply">Apply Now</a>
            </div>
            <div class="directorist-listing-single__meta__right">
                <a href="tel:<?php echo $get_phone; ?>"><img class="icon" src="https://nyftylending.com/wp-content/uploads/2024/11/icon_mobile.svg" alt="Phone" /></a>
            </div>

        </footer>

    </div>

</article>