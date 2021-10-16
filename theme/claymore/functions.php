<?php

// custom code
if( !is_admin() ) {
	require( TEMPLATEPATH . '/inc/shortcodes.php' );	
}

// Add RSS links to <head> section
add_theme_support( 'automatic-feed-links' );

// Correct insert Meta, Title
add_action( 'after_setup_theme', 'claymore_slug_setup' );
function claymore_slug_setup() {
    add_theme_support( 'title-tag' );
}

// logo
add_theme_support( 'custom-logo', [
	'height'      => 9999,
	'width'       => 9999,
	'flex-width'  => false,
	'flex-height' => false,
	'header-text' => '',
] );

/**
 * Enqueue scripts and styles.
 *
 * @since claymore 1.0
 */
add_action( 'wp_default_scripts', 'ds_print_jquery_in_footer' );
function ds_print_jquery_in_footer( &$scripts) {
	if ( ! is_admin() ) $scripts->add_data( 'jquery', 'group', 1 );
}
add_action('wp_enqueue_scripts', 'claymore_scripts');
function claymore_scripts() {
    //styles
    wp_enqueue_style( 'font', "https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" );
    wp_enqueue_style( 'font-avesome', "https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" );
    wp_enqueue_style( 'owl', get_template_directory_uri() . "/css/owl.carousel.css" );
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    // scripts
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'owl', get_template_directory_uri() . "/js/owl.carousel.min.js", array(), null, "in_footer" );
    wp_enqueue_script( 'scripts', get_template_directory_uri() . "/js/scripts.js", array(), null, "in_footer" );
}

add_action( 'wp_enqueue_scripts', function(){
	wp_localize_script( 'scripts', 'ajax', 
		array(
			'url' => admin_url('admin-ajax.php'),
			'directory' => get_template_directory_uri(),
			'home_url' => home_url()
		)
	);  

}, 99 );

// Clean up the <head>
add_action('init', 'removeHeadLinks');
function removeHeadLinks() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}
remove_action('wp_head', 'wp_generator');

// Declare widget zones
if (function_exists('register_sidebar')) {
	
	register_sidebar(array(
        'name' => 'Header',
        'id' => 'header',
        'description' => 'Header',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    register_sidebar(array(
        'name' => 'Footer',
        'id' => 'footer',
        'description' => 'Footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));
    register_sidebar(array(
        'name' => 'Popups',
        'id' => 'popups',
        'description' => 'Popups',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));
}
// add working shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');
add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
add_filter('use_default_gallery_style', '__return_false');/* сброс стилей для галереи */

// remove autoformat
remove_filter('the_content', 'wpautop');    // Отключаем автоформатирование в полном посте
remove_filter('the_excerpt', 'wpautop');    // Отключаем автоформатирование в кратком(анонсе) посте
remove_filter('comment_text', 'wpautop');    // Отключаем автоформатирование в комментариях

/* add custom image sizes */
add_theme_support( 'post-thumbnails' );
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'features', 240, 300, true );
	add_image_size( 'testimonials', 140, 158, true );
	add_image_size( 'carousel', 810, 394, true );
	add_image_size( 'service', 90, 85, true );
}

/* Add SVG */
add_filter( 'upload_mimes', 'svg_upload_allow' );
add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );
add_filter( 'wp_prepare_attachment_for_js', 'show_svg_in_media_library' );
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
}
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	else
		$dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );
	if( $dosvg ){
		if( current_user_can('manage_options') ){
			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		else {
			$data['ext'] = $type_and_ext['type'] = false;
		}
	}
	return $data;
}
function show_svg_in_media_library( $response ) {
	if ( $response['mime'] === 'image/svg+xml' ) {
		$response['image'] = [
			'src' => $response['url'],
		];
	}
	return $response;
}

## Отключает новый редактор блоков в WordPress (Гутенберг).
## ver: 1.0
if( 'disable_gutenberg' ){
	add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );

	// отключим подключение базовых css стилей для блоков
	// ВАЖНО! когда выйдут виджеты на блоках или что-то еще, эту строку нужно будет комментировать
	remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );

	// Move the Privacy Policy help notice back under the title field.
	add_action( 'admin_init', function(){
		remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
		add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
	} );
}

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

/* Disable updating a plugins */
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
function filter_plugin_updates( $value ) {
	if( isset( $value->response ) ) {
		unset( $value->response['advanced-custom-fields-pro/acf.php'] );
		unset( $value->response['send-pdf-for-contact-form-7/wpcf7-send-pdf.php'] );
		unset( $value->response['wordpress-seo-premium/wp-seo-premium.php'] );
		unset( $value->response['wp-fastest-cache-premium/wpFastestCachePremium.php'] );
	}
	return $value;
}

/* ACF Pro */
if( function_exists('acf_add_options_page') ) {
	// option's page
	acf_add_options_page( array(
		'page_title' 	=> 'Опции сайта',
		'menu_title'	=> 'Опции сайта',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url' => 'dashicons-forms'
	));
	// block's page
	acf_add_options_page( array(
		'page_title' 	=> 'Блоки сайта',
		'menu_title'	=> 'Блоки сайта',
		'menu_slug' 	=> 'theme-general-blocks',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url' => 'dashicons-grid-view',
		'position' => 10,
	));
}

add_filter('acf/format_value/type=text', 'root_acf_format_value', 10, 3);
add_filter('acf/format_value/type=textarea', 'root_acf_format_value', 10, 3);
function root_acf_format_value( $value, $post_id, $field ) {
	return do_shortcode($value);
}

// перевод недостающих слов без затрагивания файлов темы и перевода
add_filter( 'gettext', 'filter_addition_translate', 10, 3 );
function filter_addition_translate( $translation, $text, $domain ){

	if( $domain == 'default' ) {
		// en -> ru
		if( get_locale() == 'ru_RU' ) {
			if( $text == 'Testimonials' ) $translation = 'Отзывы';
		}
		// ru -> en
		if( get_locale() == 'en_US' ) {

		}
	}
	
	return $translation;
}

/* add testimonials post type */
add_post_type('testimonials', __( 'Testimonials', 'default' ), array(
	'supports'   => array( 'title', 'editor', 'thumbnail', 'comments' ),
	'taxonomies' => array( 'post_tag' )
));
function add_post_type($name, $label, $args = array()) {
	add_action('init', function() use($name, $label, $args) {
		$upper = ucwords($name);
		$name = strtolower(str_replace(' ', '_', $name));

		$args = array_merge(
			array(
				'public' => true,
				'label' => "$label",
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'capability_type' => 'post',
				'has_archive' => true,
				'labels' => array('add_new_item' => 'Добавить'),
				'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'taxonomies' => array('post_tag', 'category'),
				'show_in_rest' => true,
				'menu_position' => 4,
				'menu_icon' => 'dashicons-format-aside'
			),
			$args
		);
		register_post_type($name, $args);
	});
}

/* function - get icon */
function claymore_get_icon( $src ) {
	if( preg_match( '/\.svg$/', $src ) ) {
		/*return file_get_contents( $src );*/
		return '<img data-svg="'. $src .'">';
	} else {
		return '<img src="'. $src .'">';
	}
}


