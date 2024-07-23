<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
use ElementorPro\Modules\QueryControl\Module as Module_Query;
use ElementorPro\Plugin;
use ElementorPro\Core\Utils as ProUtils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Custom_Post_Widget extends Widget_Base {
    /**
     * @var \WP_Query
     */
    private $_query = null;

    public function get_post_name(){
        return 'posts';
    }

    public function filter_excerpt_length() {
        return $this->get_settings( 'excerpt_length' );
    }

    public function filter_excerpt_more( $more ) {
        return '';
    }

    /**
     * Get widget name.
     *
     * Retrieve list widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'custom_post';
    }
    /**
     * Get widget title.
     *
     * Retrieve list widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Custom Post', 'elementor-list-widget' );
    }
    /**
     * Get widget icon.
     *
     * Retrieve list widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-bullet-list';
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the list widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }
    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the list widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'post'];
    }

    public function register_controls() {
        /**
         * Content Tab
         */
        Post_Settings::register_post_control_settings($this);

        $this->register_query_section_controls();

        /**
         * Style Tab
         */
        Post_Style::register_design_layout_controls($this);

        Post_Style::register_design_card_controls($this);

        Post_Style::register_design_image_controls($this);

        Post_Style::register_design_content_controls($this);
    }

    protected function register_query_section_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Query', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Group_Control_Related::get_type(),
            [
                'name' => $this->get_post_name(),
                'presets' => [ 'full' ],
                'exclude' => [
                    'posts_per_page', //use the one from Layout section
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_query() {
        return $this->_query;
    }
    function get_taxonomies() {
        $taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

        $options = [ '' => '' ];

        foreach ( $taxonomies as $taxonomy ) {
            $options[ $taxonomy->name ] = $taxonomy->label;
        }

        return $options;
    }

    public function get_query_name() {
        return $this->get_post_name();
    }

    public function query_posts() {

        $query_args = [
            'posts_per_page' => $this->get_settings( 'posts_per_page' ),
        ];

        /** @var Module_Query $elementor_query */
        $elementor_query = Module_Query::instance();
        $this->_query = $elementor_query->get_query( $this, $this->get_query_name(), $query_args, [] );
    }

    function render_title() {

        if ( ! $this->get_settings('show_title') ) {
            return;
        }

        $tag = $this->get_settings('title_tag');
        ?>
        <<?php Utils::print_validated_html_tag( $tag ); ?> class="elementor-post__title">
        <a href="<?php echo esc_attr( get_permalink() ); ?>">
            <?php the_title(); ?>
        </a>
        </<?php Utils::print_validated_html_tag( $tag ); ?>>
        <?php
    }

    function render_post_header() {
        $classes = [
            'elementor-grid-item',
            'elementor-post',
        ];
        // PHPCS - `get_permalink` is safe.
        ?>
            <article <?php post_class( $classes ); ?>>
            <div class="elementor-post__card">
        <?php
    }

    function render_post_footer() {
        ?>
            </div>
            </article>
        <?php
    }
    protected function render_thumbnail() {
        $settings = $this->get_settings();

        $settings['thumbnail_size'] = [
            'id' => get_post_thumbnail_id(),
        ];
        ?>
        <a class="elementor-post__thumbnail__link" href="<?php echo esc_attr( get_permalink() ); ?>">
        <div class="elementor-post__thumbnail elementor-fit-height">
            <?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'thumbnail_size' ); ?>
        </div>
        </a>
        <?php
    }
    function render_excerpt() {
        add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
        add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

        if ( ! $this->get_settings( 'show_excerpt' ) ) {
            return;
        }

        add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
        add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

        ?>
        <div class="custom-post__excerpt">
            <?php
            global $post;
            $apply_to_custom_excerpt = $this->get_settings( 'apply_to_custom_excerpt' );

            // Force the manually-generated Excerpt length as well if the user chose to enable 'apply_to_custom_excerpt'.
            if ( 'yes' === $apply_to_custom_excerpt && ! empty( $post->post_excerpt ) ) {
                $max_length = (int) $this->get_settings( 'excerpt_length' );
                $excerpt = apply_filters( 'the_excerpt', get_the_excerpt() );
                $excerpt = ProUtils::trim_words( $excerpt, $max_length );
                echo wp_kses_post( $excerpt );
            } else {
                the_excerpt();
            }
            ?>
        </div>
        <?php

        remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
        remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
    }
    function render_read_time(){
        echo '<div class="meta-read-meter">'.do_shortcode('[read_meter id='.get_the_ID().']') . 'min read </div>';
    }
    function render_badge() {
        $taxonomy = $this->get_settings( 'badge_taxonomy' );
        if ( empty( $taxonomy ) || ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $terms = get_the_terms( get_the_ID(), $taxonomy );
        if ( empty( $terms[0] ) ) {
            return;
        }
        $list = '';
        foreach($terms as $term){
            $list .= '<span>' . $term->name . '</span>';
        }
        ?>
        <div class="custom-post__badge"><?php echo wp_kses_post( $list ); ?></div>
        <?php
    }
    protected function render_meta_data() {

        ?>
        <div class="elementor-post__meta-data">
            <span>By </span>
            <?php
            if ( $this->get_settings('show_author') ) {
                $this->render_author();
            }

            if ( $this->get_settings('show_date') ) {
                $this->render_date_by_type();
            }
            ?>
        </div>
        <?php
    }
    protected function render_author() {
        ?>
        <span class="elementor-post-author">
			<?php the_author(); ?>
		</span>
        <?php
    }
    protected function render_date_by_type( $type = 'publish' ) {
        ?>
        <span class="elementor-post-date">
			<?php
            switch ( $type ) :
                case 'modified':
                    $date = get_the_modified_date();
                    break;
                default:
                    $date = get_the_date();
            endswitch;
            /** This filter is documented in wp-includes/general-template.php */
            // PHPCS - The date is safe.
            echo apply_filters( 'the_date', $date, get_option( 'date_format' ), '', '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
		</span>
        <?php
    }
    protected function render_text_header() {
		?>
		<div class="elementor-post__text">
		<?php
	}
    protected function render_text_footer() {
        ?>
        </div>
        <?php
    }

    function render_post() {
        $this->render_post_header();
        $this->render_thumbnail();
        //$this->render_overlay_header();
        $this->render_text_header();
        $this->render_badge();
        $this->render_title();
        $this->render_meta_data();
        $this->render_excerpt();
        $this->render_read_time();
        $this->render_text_footer();
        // $this->render_categories_names();
        //$this->render_overlay_footer();
        $this->render_post_footer();
    }
    function render_loop_header(){
        ?>
        <div class="elementor-posts-container elementor-posts elementor-grid">
        <?php
    }
    function render_loop_footer(){
        ?>
        </div>
        <?php
    }

    public function render() {
        $this->query_posts();

        $wp_query = $this->get_query();

        if ( ! $wp_query->found_posts ) {
            return;
        }
        //$this->get_posts_tags();

        $this->render_loop_header();

        while ( $wp_query->have_posts() ) {
            $wp_query->the_post();

            $this->render_post();
        }

        $this->render_loop_footer();

        wp_reset_postdata();
    }

}

require_once('custom-post-settings.php');
require_once('custom-post-style.php');