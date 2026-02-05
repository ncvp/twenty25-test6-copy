<?php
# t17m.php
# require from theme functions.php

# https://youtu.be/VE_3wI65EIc good   
# https://www.youtube.com/watch?v=elQNpFYgNK4 good

function t17m_enqueue() {
	$version = time();			# For cache busting
	$version = 42;
	wp_enqueue_script('t17m', get_stylesheet_directory_uri() . '/t17m/t17m_02.js', [], $version);
	wp_enqueue_style('t17m', get_stylesheet_directory_uri() . '/t17m/t17m_05.css', [], $version);
}
add_action('wp_enqueue_scripts', 't17m_enqueue');

# Add down arrow icon to menu items with children. Just needed for desktop menu
function t17m_add_down_arrow($item_output, $item, $depth, $args) {
	if (in_array('menu-item-has-children', $item->classes, true)) {
		$icon = '<svg class="icon icon-angle-down" aria-hidden="true" role="img">
			<use href="#icon-angle-down" xlink:href="#icon-angle-down"></use></svg>';
		$item_output = str_replace('</a>', $icon . '</a>', $item_output);
	}
	return $item_output;
}
add_filter('walker_nav_menu_start_el', 't17m_add_down_arrow', 10, 4);

# All we need are icon-bars, icon-close and icon-angle-down. Other angles are achieved by rotations
function t17m_include_svg_icons() {
	require get_theme_file_path('/t17m/t17m-icons.svg');
}
add_action('wp_body_open', 't17m_include_svg_icons');

# Render callback for custom dynamic navigation block
function tt5tn_render_navigation() {
	ob_start();
	$res = get_template_part('t17m/t17m-menu');
#	error_log("render_navigation: " . ($res === false ? 'not found' : 'found'));
	return ob_get_clean();
}

# Register dynamic navigation block
function t17m_register_navigation() {
	$res = register_block_type(
		get_stylesheet_directory() . '/t17m',
#		array('render_callback' => 'tt5tn_render_navigation')
	);
	error_log("register_navigation: " . print_r($res, 1));
}
add_action('init', 't17m_register_navigation');

# Enqueue menu block editor script
function t17m_enqueue_editor_script() {
	wp_enqueue_script(
		't17m-block-editor',
		get_stylesheet_directory_uri() . '/t17m/editor.js',
		array('wp-blocks', 'wp-element'),
		filemtime(get_stylesheet_directory() . '/t17m/editor.js')
	);
#	error_log("enqueue_editor_script");
}
add_action('init', 't17m_enqueue_editor_script');

# Enable classic menus and register locations, so user doesn't have to mess with the theme editor
function t17m_menus_init() {
	add_theme_support('menus');											# Shows Menus link under Appearance and 'Edit Menus' tab
	register_nav_menus(['header'=>'Header menu location']);		# Shows Manage Locations tab
}
add_action('after_setup_theme', 't17m_menus_init');