// t17m_02.js 

let site_nav, menu_button, menu;

// Menu button callback
function t17m_menu_toggle() {
	console.log('t17m_menu_toggle() called 2');
	site_nav.classList.toggle('toggled-on');
	const expanded = menu_button.getAttribute('aria-expanded') === 'true';
	menu_button.setAttribute('aria-expanded', String(!expanded));
}

document.addEventListener('DOMContentLoaded', function () {

	console.log('t17m_nn.js loaded');

	site_nav = document.getElementById('site-navigation');
	if (!site_nav) {
		return;
	}

	menu_button = site_nav.querySelector('.menu-toggle');
	menu = site_nav.querySelector('ul');
	if (!menu_button || !menu) {
		return;
	}

	console.log('t17m_nn.js bound');

	/* Main menu toggle */
	menu_button.addEventListener('click', t17m_menu_toggle);

	/* --------------------------
	 * Submenu (mobile only)
	 * -------------------------- */

	const mobileQuery = window.matchMedia('(max-width: 768px)');

	function enableSubmenus() {
		console.log('enable mobile submenus');

		const parentLinks = site_nav.querySelectorAll(
			'.menu-item-has-children > a'
		);

		parentLinks.forEach(function (link) {
			// Don’t add twice
			if (link.nextElementSibling && link.nextElementSibling.classList.contains('submenu-toggle')) {
				return;
			}

			const toggle = document.createElement('button');
			toggle.className = 'submenu-toggle';
			toggle.setAttribute('aria-expanded', 'false');

			toggle.innerHTML =
				'<span class="screen-reader-text">Expand submenu</span>' +
				'<svg class="icon icon-angle-down" aria-hidden="true">' +
				'<use href="#icon-angle-down"></use>' +
				'</svg>';

			link.after(toggle);
		});
	}

	function disableSubmenus() {
		console.log('disable mobile submenus');

		const toggles = site_nav.querySelectorAll('.submenu-toggle');
		toggles.forEach(function (toggle) {
			toggle.remove();
		});

		const openItems = site_nav.querySelectorAll('.submenu-open');
		openItems.forEach(function (item) {
			item.classList.remove('submenu-open');
		});
	}

	site_nav.addEventListener('click', function (event) {
		const toggle = event.target.closest('.submenu-toggle');
		if (!toggle) {
			return;
		}

		event.preventDefault();

		const menuItem = toggle.parentElement;
		const expanded =
			toggle.getAttribute('aria-expanded') === 'true';

		toggle.setAttribute('aria-expanded', String(!expanded));
		menuItem.classList.toggle('submenu-open', !expanded);
	});

	/* Initial state */
	if (mobileQuery.matches) {
		enableSubmenus();
	}

	/* Respond to breakpoint changes */
	mobileQuery.addEventListener('change', function (e) {
		if (e.matches) {
			enableSubmenus();
		} else {
			disableSubmenus();
		}
	});
});
