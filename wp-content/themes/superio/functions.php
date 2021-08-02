<?php
/**
 * superio functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Superio
 * @since Superio 1.1.4
 */

define( 'SUPERIO_THEME_VERSION', '1.1.4' );
define( 'SUPERIO_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'superio_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Superio 1.0
 */
function superio_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on superio, use a find and replace
	 * to change 'superio' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'superio', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'superio' ),
		'mobile-primary' => esc_html__( 'Mobile Primary Menu', 'superio' ),
		'employer-menu' => esc_html__( 'Employer Menu', 'superio' ),
		'candidate-menu' => esc_html__( 'Candidate Menu', 'superio' ),
		'employee-menu' => esc_html__( 'Employee Menu', 'superio' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 410) );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = superio_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'superio_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Enqueue editor styles.
	add_editor_style( array( 'css/style-editor.css' ) );

	superio_get_load_plugins();
}
endif; // superio_setup
add_action( 'after_setup_theme', 'superio_setup' );


function superio_admin_enqueue_styles() {
	$main_font = superio_get_config('main_font');
	$main_font = !empty($main_font['font-family']) ? $main_font['font-family'] : 'SofiaPro';

	$heading_font = superio_get_config('heading_font');
	$heading_font = !empty($heading_font['font-family']) ? $heading_font['font-family'] : 'SofiaPro';

	if ( $main_font == 'SofiaPro' || $heading_font == 'SofiaPro' ) {
		wp_enqueue_style( 'superio-webfont', get_template_directory_uri() . '/css/webfonts.css', array(), '1.0.0' );
	}

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	//load font flaticon
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );

	// load font themify icon
	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'superio_admin_enqueue_styles' );

/**
 * Enqueue styles.
 *
 * @since Superio 1.0
 */
function superio_enqueue_styles() {
	
	$main_font = superio_get_config('main_font');
	$main_font = !empty($main_font['font-family']) ? $main_font['font-family'] : 'SofiaPro';

	$heading_font = superio_get_config('heading_font');
	$heading_font = !empty($heading_font['font-family']) ? $heading_font['font-family'] : 'SofiaPro';

	if ( $main_font == 'SofiaPro' || $heading_font == 'SofiaPro' ) {
		wp_enqueue_style( 'superio-webfont', get_template_directory_uri() . '/css/webfonts.css', array(), '1.0.0' );
	}

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	//load font flaticon
	wp_enqueue_style( 'superio-flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );

	// load font themify icon
	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
	
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '3.2.0' );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );
	// mobile menu
	wp_enqueue_style( 'sliding-menu', get_template_directory_uri() . '/css/sliding-menu.min.css', array(), '0.3.0' );
	// main style
	wp_enqueue_style( 'superio-template', get_template_directory_uri() . '/css/template.css', array(), '1.0' );
	
	$custom_style = superio_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'superio-template', $custom_style );
	}
	wp_enqueue_style( 'superio-style', get_template_directory_uri() . '/style.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'superio_enqueue_styles', 100 );


function superio_login_enqueue_styles() {
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );
	wp_enqueue_style( 'superio-login-style', get_template_directory_uri() . '/css/login-style.css', array(), '1.0' );
}
add_action( 'login_enqueue_scripts', 'superio_login_enqueue_styles', 10 );
/**
 * Enqueue scripts.
 *
 * @since Superio 1.0
 */
function superio_enqueue_scripts() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20150330', true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );
	wp_localize_script( 'countdown', 'superio_countdown_opts', array(
		'days' => esc_html__('Days', 'superio'),
		'hours' => esc_html__('Hrs', 'superio'),
		'mins' => esc_html__('Mins', 'superio'),
		'secs' => esc_html__('Secs', 'superio'),
	));
	
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.6.12', true );
	
	if ( superio_get_config('keep_header') ) {
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/sticky.min.js', array( 'jquery', 'elementor-waypoints' ), '4.0.1', true );
	}

	// mobile menu script
	wp_enqueue_script( 'sliding-menu', get_template_directory_uri() . '/js/sliding-menu.min.js', array( 'jquery' ), '0.3.0', true );
	
	// main script
	wp_register_script( 'superio-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'superio-functions', 'superio_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'previous' => esc_html__('Previous', 'superio'),
		'next' => esc_html__('Next', 'superio')
	));
	wp_enqueue_script( 'superio-functions' );
	
	wp_add_inline_script( 'superio-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'superio_enqueue_scripts', 1 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Superio 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function superio_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'superio_search_form_modify' );

/**
 * Function get opt_name
 *
 */
function superio_get_opt_name() {
	return 'superio_theme_options';
}
add_filter( 'apus_framework_get_opt_name', 'superio_get_opt_name' );


function superio_register_demo_mode() {
	if ( defined('SUPERIO_DEMO_MODE') && SUPERIO_DEMO_MODE ) {
		return true;
	}
	return false;
}
add_filter( 'apus_framework_register_demo_mode', 'superio_register_demo_mode' );

function superio_get_demo_preset() {
	$preset = '';
    if ( defined('SUPERIO_DEMO_MODE') && SUPERIO_DEMO_MODE ) {
        if ( isset($_REQUEST['_preset']) && $_REQUEST['_preset'] ) {
            $presets = get_option( 'apus_framework_presets' );
            if ( is_array($presets) && isset($presets[$_REQUEST['_preset']]) ) {
                $preset = $_REQUEST['_preset'];
            }
        } else {
            $preset = get_option( 'apus_framework_preset_default' );
        }
    }
    return $preset;
}

function superio_get_config($name, $default = '') {
	global $superio_options;
    if ( isset($superio_options[$name]) ) {
        return $superio_options[$name];
    }
    return $default;
}

function superio_set_exporter_settings_option_keys($option_keys) {
	return array(
		'elementor_disable_color_schemes',
		'elementor_disable_typography_schemes',
		'elementor_allow_tracking',
		'elementor_cpt_support',
		'wp_job_board_pro_settings',
		'wp_job_board_pro__job__fields_data',
		'wp_job_board_pro__employer__fields_data',
		'wp_job_board_pro__candidate__fields_data',
	);
}
add_filter( 'apus_exporter_ocdi_settings_option_keys', 'superio_set_exporter_settings_option_keys' );

function superio_disable_one_click_import() {
	return false;
}
add_filter('apus_frammework_enable_one_click_import', 'superio_disable_one_click_import');

function superio_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'superio' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter sidebar', 'superio' ),
		'id'            => 'jobs-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter 2 sidebar', 'superio' ),
		'id'            => 'jobs-filter2-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter top sidebar', 'superio' ),
		'id'            => 'jobs-filter-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter top 2 sidebar', 'superio' ),
		'id'            => 'jobs-filter-top2-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Jobs filter top maps sidebar', 'superio' ),
		'id'            => 'jobs-filter-top-maps-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Job single sidebar', 'superio' ),
		'id'            => 'job-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Job single 2 sidebar', 'superio' ),
		'id'            => 'job-single2-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Job single 3 sidebar', 'superio' ),
		'id'            => 'job-single3-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employers filter sidebar', 'superio' ),
		'id'            => 'employers-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employers filter top sidebar', 'superio' ),
		'id'            => 'employers-filter-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employers filter top maps sidebar', 'superio' ),
		'id'            => 'employers-filter-top-maps-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employer single sidebar', 'superio' ),
		'id'            => 'employer-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Employer single sidebar 2', 'superio' ),
		'id'            => 'employer-single-sidebar2',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Candidates filter sidebar', 'superio' ),
		'id'            => 'candidates-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Candidates filter top sidebar', 'superio' ),
		'id'            => 'candidates-filter-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Candidate single sidebar', 'superio' ),
		'id'            => 'candidate-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'User Profile sidebar', 'superio' ),
		'id'            => 'user-profile-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'superio' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'superio' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name' 				=> esc_html__( 'Header Mobile Bottom', 'superio' ),
		'id' 				=> 'header-mobile-bottom',
		'description'   => esc_html__( 'Add widgets here to appear in your header mobile.', 'superio' ),
		'before_widget' => '<aside class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="title"><span>',
		'after_title'   => '</span></h2>',
	));

}
add_action( 'widgets_init', 'superio_widgets_init' );

function superio_get_load_plugins() {

	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'superio' ),
        'slug'                     => 'apus-framework',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-framework.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Elementor Page Builder', 'superio' ),
	    'slug'                     => 'elementor',
	    'required'                 => true,
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'superio' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'superio' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'superio' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'superio' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	// woocommerce plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'Woocommerce', 'superio' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	);
	
	// Job plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'WP Job Board Pro', 'superio' ),
        'slug'                     => 'wp-job-board-pro',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-job-board-pro.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP Job Board Pro - WooCommerce Paid Listings', 'superio' ),
        'slug'                     => 'wp-job-board-pro-wc-paid-listings',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-job-board-pro-wc-paid-listings.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP Private Message', 'superio' ),
        'slug'                     => 'wp-private-message',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-private-message.zip'
	);
	
	$plugins[] = array(
        'name'                  => esc_html__( 'One Click Demo Import', 'superio' ),
        'slug'                  => 'one-click-demo-import',
        'required'              => false,
        'force_activation'      => false,
        'force_deactivation'    => false,
        'external_url'          => '',
    );

	tgmpa( $plugins );
}

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/functions-helper.php';
require get_template_directory() . '/inc/functions-frontend.php';

/**
 * Implement the Custom Header feature.
 *
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/classes/megamenu.php';
require get_template_directory() . '/inc/classes/mobilemenu.php';

/**
 * Custom template tags for this theme.
 *
 */
require get_template_directory() . '/inc/template-tags.php';

if ( defined( 'APUS_FRAMEWORK_REDUX_ACTIVED' ) ) {
	require get_template_directory() . '/inc/vendors/redux-framework/redux-config.php';
	define( 'SUPERIO_REDUX_FRAMEWORK_ACTIVED', true );
}
if( superio_is_cmb2_activated() ) {
	require get_template_directory() . '/inc/vendors/cmb2/page.php';
	define( 'SUPERIO_CMB2_ACTIVED', true );
}
if( superio_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/vendors/woocommerce/functions.php';
	require get_template_directory() . '/inc/vendors/woocommerce/functions-redux-configs.php';
	define( 'SUPERIO_WOOCOMMERCE_ACTIVED', true );
}

if( superio_is_wp_job_board_pro_activated() ) {
	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions-redux-configs.php';
	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions.php';
	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions-employer.php';
	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions-candidate.php';

	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions-job-display.php';
	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions-employer-display.php';
	require get_template_directory() . '/inc/vendors/wp-job-board-pro/functions-candidate-display.php';
}

if ( superio_is_wp_job_board_pro_wc_paid_listings_activated() ) {
	require get_template_directory() . '/inc/vendors/wp-job-board-pro-wc-paid-listings/functions.php';
}

if( superio_is_apus_framework_activated() ) {
	require get_template_directory() . '/inc/widgets/custom_menu.php';
	require get_template_directory() . '/inc/widgets/recent_post.php';
	require get_template_directory() . '/inc/widgets/search.php';
	require get_template_directory() . '/inc/widgets/socials.php';
	
	if ( did_action( 'elementor/loaded' ) ) {
		require get_template_directory() . '/inc/widgets/elementor-template.php';
	}
	
	if ( superio_is_wp_job_board_pro_activated() ) {
		require get_template_directory() . '/inc/widgets/candidate-contact-form.php';
		require get_template_directory() . '/inc/widgets/candidate-info.php';
		require get_template_directory() . '/inc/widgets/candidate-cv.php';
		require get_template_directory() . '/inc/widgets/candidate-buttons.php';
		require get_template_directory() . '/inc/widgets/candidate-socials.php';
		require get_template_directory() . '/inc/widgets/candidate-tags.php';

		require get_template_directory() . '/inc/widgets/employer-contact-form.php';
		require get_template_directory() . '/inc/widgets/employer-info.php';
		require get_template_directory() . '/inc/widgets/employer-maps.php';
		
		require get_template_directory() . '/inc/widgets/job-info.php';
		require get_template_directory() . '/inc/widgets/job-maps.php';
		require get_template_directory() . '/inc/widgets/job-tags.php';
		require get_template_directory() . '/inc/widgets/job-statistics.php';
		require get_template_directory() . '/inc/widgets/job-also-viewed.php';
		require get_template_directory() . '/inc/widgets/job-buttons.php';
		require get_template_directory() . '/inc/widgets/job-social-share.php';
		require get_template_directory() . '/inc/widgets/job-employer-info.php';
		
		require get_template_directory() . '/inc/widgets/job-contact-form.php';
		
		require get_template_directory() . '/inc/widgets/user-short-profile.php';
	}
	define( 'SUPERIO_FRAMEWORK_ACTIVED', true );
}
if ( superio_is_wp_private_message() ) {
	require get_template_directory() . '/inc/vendors/wp-private-message/functions.php';
}

require get_template_directory() . '/inc/vendors/elementor/functions.php';
require get_template_directory() . '/inc/vendors/one-click-demo-import/functions.php';

function superio_register_post_types($post_types) {
	foreach ($post_types as $key => $post_type) {
		if ( $post_type == 'brand' || $post_type == 'testimonial' ) {
			unset($post_types[$key]);
		}
	}
	if ( !in_array('header', $post_types) ) {
		$post_types[] = 'header';
	}
	return $post_types;
}
add_filter( 'apus_framework_register_post_types', 'superio_register_post_types' );


/**
 * Customizer additions.
 *
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Styles
 *
 */
require get_template_directory() . '/inc/custom-styles.php';