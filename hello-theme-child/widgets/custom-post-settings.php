<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Post_Settings {
    public static function register_post_control_settings($widget) {
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Post Settings', 'elementor-list-widget' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_responsive_control(
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
        $widget->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );
        $widget->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'exclude' => [ 'custom' ],
                'default' => 'medium',
                'prefix_class' => 'elementor-portfolio--thumbnail-size-',
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
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
        $widget->add_control(
            'show_excerpt',
            [
                'label' => esc_html__( 'Excerpt', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'excerpt_length',
            [
                'label' => esc_html__( 'Excerpt Length', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                /** This filter is documented in wp-includes/formatting.php */
                'default' => apply_filters( 'excerpt_length', 25 ),
            ]
        );

        $widget->add_control(
            'apply_to_custom_excerpt',
            [
                'label' => esc_html__( 'Apply to custom Excerpt', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'elementor-pro' ),
                'label_off' => esc_html__( 'No', 'elementor-pro' ),
                'default' => 'no',
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
            'badge_taxonomy',
            [
                'label' => esc_html__( 'Badge Taxonomy', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default' => 'category',
                'options' => $widget->get_taxonomies(),
            ]
        );

        $widget->add_control(
            'show_author',
            [
                'label' => esc_html__( 'Author', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'show_date',
            [
                'label' => esc_html__( 'Post Date', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elementor-pro' ),
                'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
            ]
        );

        $widget->end_controls_section();
    }
}