<?php
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
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

    protected function register_post_count_control() {
        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );
    }
    public function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Post Settings', 'elementor-list-widget' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
            ]
        );

        $this->register_post_count_control();

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'exclude' => [ 'custom' ],
                'default' => 'medium',
                'prefix_class' => 'elementor-portfolio--thumbnail-size-',
            ]
        );

        $this->register_title_controls();

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__( 'Excerpt', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Length', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                /** This filter is documented in wp-includes/formatting.php */
                'default' => apply_filters( 'excerpt_length', 25 ),
            ]
        );

        $this->add_control(
            'apply_to_custom_excerpt',
            [
                'label' => esc_html__( 'Apply to custom Excerpt', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'elementor-pro' ),
                'label_off' => esc_html__( 'No', 'elementor-pro' ),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_badge',
            [
                'label' => esc_html__( 'Badge', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'badge_taxonomy',
            [
                'label' => esc_html__( 'Badge Taxonomy', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => 'category',
                'options' => $this->get_taxonomies(),
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => esc_html__( 'Author', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => esc_html__( 'Post Date', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->register_query_section_controls();

        $this->register_design_layout_controls();

        $this->register_design_content_controls();
    }
    /**
     * Style Tab
     */
    public function register_design_layout_controls() {
        $this->start_controls_section(
            'section_design_layout',
            [
                'label' => esc_html__( 'Layout', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__( 'Columns Gap', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__( 'Rows Gap', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 35,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'elementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-posts--align-',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_title_controls() {
        $this->add_control(
            'show_title',
            [
                'label' => esc_html__( 'Title', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title HTML Tag', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

    }
    protected function register_design_content_controls() {
        $this->start_controls_section(
            'section_design_content',
            [
                'label' => esc_html__( 'Content', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title_style',
            [
                'label' => esc_html__( 'Title', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-post__title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => esc_html__( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
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
    function render_title_plain() {
        ?>
        <div>
        <?php
        the_title();
        ?>
        </div>
        <?php
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
        <div class="elementor-portfolio-item__img elementor-post__thumbnail">
            <?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'thumbnail_size' ); ?>
        </div>
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
        <div class="elementor-post__excerpt">
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
        echo '<p>'.do_shortcode('[read_meter id='.get_the_ID().']') . 'mins read </p>';
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
        <div class="elementor-post__badge"><?php echo wp_kses_post( $list ); ?></div>
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