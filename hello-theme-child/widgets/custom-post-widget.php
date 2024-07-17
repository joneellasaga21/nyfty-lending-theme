<?php
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Box_Shadow;
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

        $this->register_design_card_controls();

        $this->register_design_image_controls();

        $this->register_design_content_controls();
    }
    /**
     * Style Tab
     */
    protected function register_design_image_controls() {
        $this->start_controls_section(
            'section_design_image',
            [
                'label' => esc_html__( 'Image', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_spacing',
            [
                'label' => esc_html__( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__text' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'size' => 20,
                ],
            ]
        );

        $this->start_controls_tabs( 'thumbnail_effects_tabs' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'elementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_filters',
                'selector' => '{{WRAPPER}} .elementor-post__thumbnail img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'elementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_hover_filters',
                'selector' => '{{WRAPPER}} .elementor-post:hover .elementor-post__thumbnail img',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Image Width', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 10,
                        'max' => 600,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__thumbnail__link' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
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

        $this->add_control(
            'heading_badge_style',
            [
                'label' => esc_html__( 'Badge', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'badge_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge span' => 'background-color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
            ]
        );

        $this->add_control(
            'badge_color',
            [
                'label' => esc_html__( 'Text Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'badge_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge span' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-post__card .custom-post__badge span',
            ]
        );
        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => esc_html__( 'Padding', 'elementor-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'badge_margin',
            [
                'label' => esc_html__( 'Margin', 'elementor-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'badge_size',
            [
                'label' => esc_html__( 'Size', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'badge_spacing',
            [
                'label' => esc_html__( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .elementor-post__card .custom-post__badge',
                'exclude' => [ 'font_size', 'line-height' ],
            ]
        );

        $this->add_control(
            'heading_meta_style',
            [
                'label' => esc_html__( 'Meta', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__meta-data' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-post__meta-data',
            ]
        );
        $this->add_responsive_control(
            'meta_padding',
            [
                'label' => esc_html__( 'Padding', 'elementor-pro' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__meta-data' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'meta_spacing',
            [
                'label' => esc_html__( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__meta-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'heading_excerpt_style',
            [
                'label' => esc_html__( 'Excerpt', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-post__excerpt p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .meta-read-meter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-post__excerpt p',
                    '{{WRAPPER}} .meta-read-meter',
                ]
            ]
        );
        $this->add_responsive_control(
            'excerpt_spacing',
            [
                'label' => esc_html__( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-post__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meter_spacing',
            [
                'label' => esc_html__( 'Read Timer Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .meta-read-meter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    public function register_design_card_controls() {
        $this->start_controls_section(
            'section_design_card',
            [
                'label' => esc_html__( 'Card', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_border_color',
            [
                'label' => esc_html__( 'Border Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'card_border_width',
            [
                'label' => esc_html__( 'Border Width', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 15,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'border: {{SIZE}}{{UNIT}} solid',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-post__card',
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => esc_html__( 'Horizontal Padding', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__text' => 'padding: 0 {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-post__meta-data' => 'padding: 10px {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-post__avatar' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'card_vertical_padding',
            [
                'label' => esc_html__( 'Vertical Padding', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'hover_effect',
            [
                'label' => esc_html__( 'Hover Effect', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'none' => esc_html__( 'None', 'elementor-pro' ),
                    'gradient' => esc_html__( 'Gradient', 'elementor-pro' ),
                    //'zoom-in' => esc_html__( 'Zoom In', 'elementor-pro' ),
                    //'zoom-out' => esc_html__( 'Zoom Out', 'elementor-pro' ),
                ],
                'default' => 'gradient',
                'separator' => 'before',
                'prefix_class' => 'elementor-posts__hover-',
            ]
        );

        $this->add_control(
            'meta_border_color',
            [
                'label' => esc_html__( 'Meta Border Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .elementor-post__meta-data' => 'border-top-color: {{VALUE}}',
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