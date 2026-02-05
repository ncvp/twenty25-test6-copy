<?php
# Twenty25 child test6
# 6th in a series of tests

##############################
# Enqueue scripts and styles #
##############################

function tt5tn_enqueue() {
	$version = time();			# For cache busting
	$version = 42;
	wp_enqueue_script('twenty25-test4',	get_stylesheet_directory_uri() . 'xxxx.js', [], $version);
	# style.css has to define the theme, but doesn't need to be enqueued
	wp_enqueue_style('twenty25-test4',	get_stylesheet_directory_uri() . 'style.css', [], $version);
}
#add_action( 'wp_enqueue_scripts', 'tt5tn_enqueue' );

###################
# 2017-style menu #
###################

require get_stylesheet_directory() . '/t17m/t17m.php';

########
# Misc #
########

# Fix special strings in header and footer
# Only footer needs to be changed, but leave header in array to show how it works
function twenty25_test1_fix_header_footer($block_content, $block) {
	if (empty($block['blockName']) || 'core/template-part' !== $block['blockName']) {
		return $block_content;
	}
	$slug = $block['attrs']['slug'] ?? '';
	if (! in_array($slug, ['footer', 'header'], true)) {				# No special strings in header yet
		return $block_content;
	}
	if (strpos($block_content, '__NCVP_SITE_URL__') !== false) {
		$block_content = str_replace('__NCVP_SITE_URL__', esc_url(get_site_url()), $block_content);
	}
	if (strpos($block_content, '__NCVP_SITE_NAME__') !== false) {
		$block_content = str_replace('__NCVP_SITE_NAME__', rawurlencode(get_bloginfo('name')), $block_content);
	}
	return $block_content;
}
add_filter('render_block', 'twenty25_test1_fix_header_footer', 10, 2);

#################
# wp-admin page #
#################

function tt5tn_make_options_page() {
?>
<style>
table { border-collapse: collapse }
td { padding: 1px 6px; border: #888 solid 1px; vertical-align: top; }
.hdr td { font-weight: bolder }
td.rj { text-align: right }
ul { list-style-type: disc; list-style-position: outside; padding-left: 20px }
li { margin: 0 }
ul.tree { list-style: none; margin-left: 0; padding-left: 0; margin: 0; }
ul.tree li { padding-left: 2em; }
code { background-color: #aaa; border-radius: 5px; padding: 1px 5px }
</style>	
<h2>Twenty25 child test 6</h2>
Copied from twenty25-test2 when implementation of twentyseventeen menus was proving problematic in twenty25-test4
<p>Changes:<ul>
<li>tt5t2_ function name prefix to tt5tn_. We can only have one theme loaded at a time.</li>
<li>Function name prefix to t17m_ in twentyseventeen menus section</li>
<li>Move navigation.css, navigation,js and svg-icons.svg to /t17m</li>
<li>Changed title in blocks/custom-navigation/block.json to "NCVP 2017-style header menu. 
This name appears in Appearance > Editor > Parts >Header"</li>
<li>Changed name in block.json and BlockType in editor.js from twenty25-test2/custom-navigation to ncvp/header-menu.
Must match this &lt;!-- wp:ncvp/header-menu /--> in parts/header.html</li>
<li>Move parts/site-navigation to t17m/ncvp-2017-menu with change in tt5tn_render_navigation()</li>
<li>Move blocks/custom-navigation/block.json and editor.js to t17m/block. All menu files are now in t17m</li>
</ul>
Above tweaks copied over to twenty25-test4. We now have two similar themes with working 2017
menus - twenty25-test4 and twenty25-test6 - and a working theme, twenty25-test2, which hasn't been tweaked.
<p>Changes continue:<ul>
<li>Invoke with <code>require get_stylesheet_directory() . '/t17m/t17m.php';</code></li>
<li>Move files currently in t17m/block into t17m</li>
<li>Clarify custom block label in editor</li>
<li>Remove all reference to twenty25-test2 in code</li>
<li>Institute _nn scheme for CSS and JS</li>
<li>Started JS comprehension in t17m_02.js</li>
<li>Started CSS reduction in t17m_05.css</li>
</ul>
<p>Changes to come:<ul>
<li>Make JS intelligible</li>
<li>Reduce CSS</li>
</ul>
<p>Issues:<ul>
<li>WP has just started issuing this warning in Dev Tools console: 
'Block with API version 2 or lower is deprecated since version 6.9'. I asked Claude about it but they wanted me to use npm,
and died in the middle of our consultation. Ignore for the moment.</li>
</ul>
<?php
}
function tt5tn_add_to_menu() {
	add_options_page('2025-test6 options', 	# Page title on browser tab
		'2025-test6 theme',							# Menu title. Under Settings
		'manage_options', 							# Capability. Affects which class of users can use page
		'2025-test6-info',							# Just appears in page url .../wp-admin/options-general.php?page=2017-test1-info
		'tt5tn_make_options_page');				# Callback to display the options page
}
add_action('admin_menu', 'tt5tn_add_to_menu');

