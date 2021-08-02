<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Superio_Elementor_Job_Board_Pro_Jobs_Tabs extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_job_board_pro_jobs_tabs';
    }

	public function get_title() {
        return esc_html__( 'Apus Jobs Tabs', 'superio' );
    }
    
	public function get_categories() {
        return [ 'superio-elements' ];
    }

	protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Jobs', 'superio' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Tab Title', 'superio' ),
                'type' => Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'category_slugs',
            [
                'label' => esc_html__( 'Categories Slug', 'superio' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'superio' ),
            ]
        );

        $repeater->add_control(
            'type_slugs',
            [
                'label' => esc_html__( 'Types Slug', 'superio' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'superio' ),
            ]
        );

        $repeater->add_control(
            'location_slugs',
            [
                'label' => esc_html__( 'Location Slug', 'superio' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'superio' ),
            ]
        );

        $repeater->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'superio'),
                    'date' => esc_html__('Date', 'superio'),
                    'ID' => esc_html__('ID', 'superio'),
                    'author' => esc_html__('Author', 'superio'),
                    'title' => esc_html__('Title', 'superio'),
                    'modified' => esc_html__('Modified', 'superio'),
                    'rand' => esc_html__('Random', 'superio'),
                    'comment_count' => esc_html__('Comment count', 'superio'),
                    'menu_order' => esc_html__('Menu order', 'superio'),
                ),
                'default' => ''
            ]
        );

        $repeater->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'superio'),
                    'ASC' => esc_html__('Ascending', 'superio'),
                    'DESC' => esc_html__('Descending', 'superio'),
                ),
                'default' => ''
            ]
        );

        $repeater->add_control(
            'get_jobs_by',
            [
                'label' => esc_html__( 'Get Jobs By', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'featured' => esc_html__('Featured Jobs', 'superio'),
                    'urgent' => esc_html__('Urgent Jobs', 'superio'),
                    'recent' => esc_html__('Recent Jobs', 'superio'),
                ),
                'default' => 'recent'
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs', 'superio' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'placeholder' => esc_html__( 'Enter your job tabs here', 'superio' ),
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'superio' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Limit jobs to display', 'superio' ),
                'default' => 4
            ]
        );
        
        

        $this->add_control(
            'job_item_style',
            [
                'label' => esc_html__( 'Job Item Style', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'list' => esc_html__('List Default', 'superio'),
                    'list-v1' => esc_html__('List V1', 'superio'),
                    'list-v2' => esc_html__('List V2', 'superio'),
                    'list-v3' => esc_html__('List V3', 'superio'),
                    'grid' => esc_html__('Grid Default', 'superio'),
                    'grid-v1' => esc_html__('Grid V1', 'superio'),
                ),
                'default' => 'list'
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'superio'),
                    'carousel' => esc_html__('Carousel', 'superio'),
                    'list' => esc_html__('List', 'superio'),
                ),
                'default' => 'list'
            ]
        );

        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'superio' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'superio' ),
                'options' => $columns,
                'condition' => [
                    'columns!' => '1',
                    'layout_type' => 'carousel',
                ],
                'frontend_available' => true,
                'default' => 1,
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'superio' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'superio' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'superio' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'superio' ),
                'label_off'     => esc_html__( 'Hide', 'superio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'superio' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'superio' ),
                'label_off'     => esc_html__( 'Hide', 'superio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'superio' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'superio' ),
                'label_off'     => esc_html__( 'No', 'superio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'superio' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'superio' ),
                'label_off'     => esc_html__( 'No', 'superio' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );
        
   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'superio' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'superio' ),
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $_id = superio_random_key();

        $columns = !empty($columns) ? $columns : 3;
        $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
        $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
        
        $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
        $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
        $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
        ?>
        <div class="widget-jobs-tabs <?php echo esc_attr($layout_type); ?> <?php echo esc_attr($el_class); ?>">

            <ul role="tablist" class="nav nav-tabs tabs-jobs">
                <?php $tab_count = 0; foreach ($tabs as $tab) : ?>
                    <li class="<?php echo esc_attr($tab_count == 0 ? 'active' : '');?>">
                        <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($tab_count); ?>" data-toggle="tab">
                            <?php if ( !empty($tab['title']) ) { ?>
                                <?php echo trim($tab['title']); ?>
                            <?php } ?>
                        </a>
                    </li>
                <?php $tab_count++; endforeach; ?>
            </ul>
            <div class="tab-content">
                <?php $tab_count = 0; foreach ($tabs as $tab) : ?>
                    <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($tab_count); ?>" class="tab-pane <?php echo esc_attr($tab_count == 0 ? 'active' : ''); ?>">
                        <?php

                        $category_slugs = !empty($tab['category_slugs']) ? array_map('trim', explode(',', $tab['category_slugs'])) : array();
                        $type_slugs = !empty($tab['type_slugs']) ? array_map('trim', explode(',', $tab['type_slugs'])) : array();
                        $location_slugs = !empty($tab['location_slugs']) ? array_map('trim', explode(',', $tab['location_slugs'])) : array();

                        $args = array(
                            'limit' => $limit,
                            'get_jobs_by' => !empty($tab['get_jobs_by']) ? $tab['get_jobs_by'] : 'recent',
                            'orderby' => !empty($tab['orderby']) ? $tab['orderby'] : '',
                            'order' => !empty($tab['order']) ? $tab['order'] : '',
                            'categories' => $category_slugs,
                            'types' => $type_slugs,
                            'locations' => $location_slugs,
                        );
                        $loop = superio_get_jobs($args);
                        if ( $loop->have_posts() ) {
                            ?>
                            <?php if ( $layout_type == 'carousel' ): ?>
                                <div class="slick-carousel"
                                    data-items="<?php echo esc_attr($columns); ?>"
                                    data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                                    data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                                    data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                                    data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                                    data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                                    data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>"
                                    data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>"
                                    data-rows="<?php echo esc_attr( $rows ); ?>"
                                    data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>"
                                    data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                                    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                        <div class="cl-inner">
                                            <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php elseif( $layout_type == 'grid' ): ?>
                                <?php
                                    $mdcol = 12/$columns;
                                    $smcol = 12/$columns_tablet;
                                    $xscol = 12/$columns_mobile;
                                ?>
                                <div class="row">
                                    <?php $i = 1; while ( $loop->have_posts() ) : $loop->the_post();
                                        $classes = '';
                                        if ( $i%$columns == 1 ) {
                                            $classes .= ' md-clearfix lg-clearfix';
                                        }
                                        if ( $i%$columns_tablet == 1 ) {
                                            $classes .= ' sm-clearfix';
                                        }
                                        if ( $i%$columns_mobile == 1 ) {
                                            $classes .= ' xs-clearfix';
                                        }
                                    ?>
                                        <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr( $xscol ); ?> list-item <?php echo esc_attr($classes); ?>">
                                            <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style ); ?>
                                        </div>
                                    <?php $i++; endwhile; ?>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                        <div class="col-xs-12">
                                            <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style ); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php } ?>
                    </div>
                <?php $tab_count++; endforeach; ?>
            </div>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Superio_Elementor_Job_Board_Pro_Jobs_Tabs );