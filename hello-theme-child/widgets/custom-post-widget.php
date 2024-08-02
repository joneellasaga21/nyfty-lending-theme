<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
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

        $this->register_pagination_section_controls();
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
            'paged' => $this->get_current_page(),
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
        if ( '' === $this->get_settings_for_display('pagination_type') ) {
            return;
        }

        $page_limit = $this->get_query()->max_num_pages;

        //var_dump($page_limit);
        $current_page = $this->get_current_page();

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'pagination', 'class', 'elementor-pagination' );
        $has_numbers = in_array( $settings['pagination_type'], [ 'numbers', 'numbers_and_prev_next' ] );
        $has_prev_next = in_array( $settings['pagination_type'], [ 'prev_next', 'numbers_and_prev_next' ] );

        $links = [];
        if ( $has_numbers ) {
            $paginate_args = [
                'type' => 'array',
                'current' => $current_page,
                'total' => $page_limit,
                'prev_next' => false,
                'show_all' => 'yes' !== $settings['pagination_numbers_shorten'],
                'before_page_number' => '<span class="elementor-screen-only">' . esc_html__( 'Page', 'elementor-pro' ) . '</span>',
            ];

            if ( is_singular() && ! is_front_page() ) {
                global $wp_rewrite;
                if ( $wp_rewrite->using_permalinks() ) {
                    $paginate_args['base'] = trailingslashit( get_permalink() ) . '%_%';
                    $paginate_args['format'] = user_trailingslashit( '%#%', 'single_paged' );
                } else {
                    $paginate_args['format'] = '?page=%#%';
                }
            }

            $links = paginate_links( $paginate_args );
        }

        if ( $has_prev_next ) {
            $prev_next = $this->get_posts_nav_link($page_limit);
            array_unshift( $links, $prev_next['prev'] );
            $links[] = $prev_next['next'];
        }

        // PHPCS - Seems that `$links` is safe.
        ?>
        <nav class="elementor-pagination" aria-label="<?php esc_attr_e( 'Pagination', 'elementor-pro' ); ?>">
            <?php echo implode( PHP_EOL, $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </nav>
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

        wp_reset_postdata();

        $this->render_loop_footer();
    }

    public function register_pagination_section_controls() {
        $this->start_controls_section(
            'section_pagination',
            [
                'label' => esc_html__( 'Pagination', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label' => esc_html__( 'Pagination', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => $this->get_pagination_type_options(),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pagination_page_limit',
            [
                'label' => esc_html__( 'Page Limit', 'elementor-pro' ),
                'default' => '5',
                'condition' => [
                    'pagination_type!' => [
                        'load_more_on_click',
                        'load_more_infinite_scroll',
                        '',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_numbers_shorten',
            [
                'label' => esc_html__( 'Shorten', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'condition' => [
                    'pagination_type' => [
                        'numbers',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_prev_label',
            [
                'label' => esc_html__( 'Previous Label', 'elementor-pro' ),
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( '&laquo; Previous', 'elementor-pro' ),
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_next_label',
            [
                'label' => esc_html__( 'Next Label', 'elementor-pro' ),
                'default' => esc_html__( 'Next &raquo;', 'elementor-pro' ),
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'pagination_align',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_type!' => [
                        'load_more_on_click',
                        'load_more_infinite_scroll',
                        '',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Pagination style controls for prev/next and numbers pagination.
        $this->start_controls_section(
            'section_pagination_style',
            [
                'label' => esc_html__( 'Pagination', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_type!' => [
                        'load_more_on_click',
                        'load_more_infinite_scroll',
                        '',
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'selector' => '{{WRAPPER}} .elementor-pagination',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_control(
            'pagination_color_heading',
            [
                'label' => esc_html__( 'Colors', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'pagination_colors' );

        $this->start_controls_tab(
            'pagination_color_normal',
            [
                'label' => esc_html__( 'Normal', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_color_hover',
            [
                'label' => esc_html__( 'Hover', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_hover_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_color_active',
            [
                'label' => esc_html__( 'Active', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label' => esc_html__( 'Space Between', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_spacing_top',
            [
                'label' => esc_html__( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Pagination style controls for on-load pagination with type on-click/infinity-scroll.
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Pagination', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_type' => [
                        'load_more_on_click',
                        'load_more_infinite_scroll',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_current_page() {
        if ( '' === $this->get_settings_for_display( 'pagination_type' ) ) {
            return 1;
        }

        return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
    }

    public function get_wp_link_page( $i ) {
        if ( ! is_singular() || is_front_page() ) {
            return get_pagenum_link( $i );
        }

        // Based on wp-includes/post-template.php:957 `_wp_link_page`.
        global $wp_rewrite;
        $post = get_post();
        $query_args = [];
        $url = get_permalink();

        if ( $i > 1 ) {
            if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
                $url = add_query_arg( 'page', $i, $url );
            } elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
                $url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
            } else {
                $url = trailingslashit( $url ) . user_trailingslashit( $i, 'single_paged' );
            }
        }

        if ( is_preview() ) {
            if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
                $query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
                $query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
            }

            $url = get_preview_post_link( $post, $query_args, $url );
        }

        return $url;
    }

    public function get_posts_nav_link( $page_limit = null ) {
        if ( ! $page_limit ) {
            $page_limit = $this->get_query()->max_num_pages;

        }

        $return = [];

        $paged = $this->get_current_page();

        $link_template = '<a class="page-numbers %s" href="%s">%s</a>';
        $disabled_template = '<span class="page-numbers %s">%s</span>';

        if ( $paged > 1 ) {
            $next_page = intval( $paged ) - 1;
            if ( $next_page < 1 ) {
                $next_page = 1;
            }

            $return['prev'] = sprintf( $link_template, 'prev', $this->get_wp_link_page( $next_page ), $this->get_settings_for_display( 'pagination_prev_label' ) );
        } else {
            $return['prev'] = sprintf( $disabled_template, 'prev', $this->get_settings_for_display( 'pagination_prev_label' ) );
        }

        $next_page = intval( $paged ) + 1;

        if ( $next_page <= $page_limit ) {
            $return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), $this->get_settings_for_display( 'pagination_next_label' ) );
        } else {
            $return['next'] = sprintf( $disabled_template, 'next', $this->get_settings_for_display( 'pagination_next_label' ) );
        }

        return $return;
    }

    protected function get_pagination_type_options() {
        return [
            '' => esc_html__( 'None', 'elementor-pro' ),
            'numbers' => esc_html__( 'Numbers', 'elementor-pro' ),
            'prev_next' => esc_html__( 'Previous/Next', 'elementor-pro' ),
            'numbers_and_prev_next' => esc_html__( 'Numbers', 'elementor-pro' ) . ' + ' . esc_html__( 'Previous/Next', 'elementor-pro' ),
        ];
    }

}

require_once('custom-post-settings.php');
require_once('custom-post-style.php');