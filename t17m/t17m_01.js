document.addEventListener('DOMContentLoaded', function () {

	console.log('t17m_nn.js loaded');

	const siteNavigation = document.getElementById('site-navigation');
	if (!siteNavigation) {
		return;
	}

	const button = siteNavigation.querySelector('.menu-toggle');
	const menu = siteNavigation.querySelector('ul');
	if (!button || !menu) {
		return;
	}

	console.log('navigation.js bound');

	/* Main menu toggle */
	button.addEventListener('click', function () {
		siteNavigation.classList.toggle('toggled-on');

		const expanded =
			button.getAttribute('aria-expanded') === 'true';

		button.setAttribute('aria-expanded', String(!expanded));
	});

	/* --------------------------
	 * Submenu (mobile only)
	 * -------------------------- */

	const mobileQuery = window.matchMedia('(max-width: 768px)');

	function enableSubmenus() {
		console.log('enable mobile submenus');

		const parentLinks = siteNavigation.querySelectorAll(
			'.menu-item-has-children > a'
		);

		parentLinks.forEach(function (link) {
			// Don’t add twice
			if (link.nextElementSibling &&
			    link.nextElementSibling.classList.contains('submenu-toggle')) {
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

		const toggles = siteNavigation.querySelectorAll('.submenu-toggle');
		toggles.forEach(function (toggle) {
			toggle.remove();
		});

		const openItems = siteNavigation.querySelectorAll('.submenu-open');
		openItems.forEach(function (item) {
			item.classList.remove('submenu-open');
		});
	}

	siteNavigation.addEventListener('click', function (event) {
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
