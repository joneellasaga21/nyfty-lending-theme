<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Stroke;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Post_Style {
    public static function register_design_layout_controls($widget) {
        $widget->start_controls_section(
            'section_design_layout',
            [
                'label' => esc_html__( 'Layout', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
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

        $widget->add_responsive_control(
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

        $widget->add_control(
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

        $widget->end_controls_section();
    }
    
    public static function register_design_card_controls($widget) {
        $widget->start_controls_section(
            'section_design_card',
            [
                'label' => esc_html__( 'Card', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'card_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $widget->add_control(
            'card_border_color',
            [
                'label' => esc_html__( 'Border Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-post__card',
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->end_controls_section();
    }

    public static function register_design_image_controls($widget) {
        $widget->start_controls_section(
            'section_design_image',
            [
                'label' => esc_html__( 'Image', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $widget->add_responsive_control(
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

        $widget->start_controls_tabs( 'thumbnail_effects_tabs' );

        $widget->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'elementor-pro' ),
            ]
        );

        $widget->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_filters',
                'selector' => '{{WRAPPER}} .elementor-post__thumbnail img',
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'elementor-pro' ),
            ]
        );

        $widget->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_hover_filters',
                'selector' => '{{WRAPPER}} .elementor-post:hover .elementor-post__thumbnail img',
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->add_responsive_control(
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

        $widget->end_controls_section();
    }
    
    public static function register_design_content_controls($widget) {
        $widget->start_controls_section(
            'section_design_content',
            [
                'label' => esc_html__( 'Content', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'heading_title_style',
            [
                'label' => esc_html__( 'Title', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $widget->add_control(
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

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a',
            ]
        );

        $widget->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-post__title',
            ]
        );

        $widget->add_responsive_control(
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

        $widget->add_control(
            'heading_badge_style',
            [
                'label' => esc_html__( 'Badge', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
            'badge_color',
            [
                'label' => esc_html__( 'Text Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__card .custom-post__badge' => 'color: {{VALUE}};',
                ]
            ]
        );

        $widget->add_control(
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
        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-post__card .custom-post__badge span',
            ]
        );
        $widget->add_responsive_control(
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
        $widget->add_responsive_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_group_control(
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

        $widget->add_control(
            'heading_meta_style',
            [
                'label' => esc_html__( 'Meta', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $widget->add_control(
            'meta_color',
            [
                'label' => esc_html__( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__meta-data' => 'color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-post__meta-data',
            ]
        );
        $widget->add_responsive_control(
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
        $widget->add_responsive_control(
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
        $widget->add_control(
            'heading_excerpt_style',
            [
                'label' => esc_html__( 'Excerpt', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $widget->add_control(
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

        $widget->add_group_control(
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
        $widget->add_responsive_control(
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

        $widget->add_responsive_control(
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


        $widget->end_controls_section();
    }
}