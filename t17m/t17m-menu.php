<nav id="site-navigation" class="main-navigation" aria-label="Top Menu">
<button type="button" class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
<svg class="icon icon-bars" aria-hidden="true" role="img"><use href="#icon-bars" xlink:href="#icon-bars"></use></svg>
<svg class="icon icon-close" aria-hidden="true" role="img"><use href="#icon-close" xlink:href="#icon-close"></use></svg>
Menu
</button>
<?php
	wp_nav_menu(array(
		'theme_location' => 'header',
		'menu_id'        => 'top-menu',
		'menu_class'     => 'menu',
		'depth'          => 0,
		'fallback_cb'    => false			# Stops WP attempting anything if header location is not set
	));
	error_log("t17m-menu.php executed");
?>
</nav>
