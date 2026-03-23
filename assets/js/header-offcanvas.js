/**
 * Off-canvas menus: hamburger opens slide-in panel from the right.
 * data-evoluer-offcanvas="main|fanclub" on open buttons; matching panel/backdrop ids.
 */
(function () {
	'use strict';

	var OPEN = 'js-evoluer-offcanvas-open';
	var activeId = null;
	var lastFocus = null;

	function getEls(id) {
		return {
			panel: document.getElementById('evoluer-offcanvas-' + id),
			backdrop: document.getElementById('evoluer-offcanvas-backdrop-' + id),
		};
	}

	function isOpen(id) {
		return activeId === id;
	}

	function open(id) {
		var els = getEls(id);
		if (!els.panel || !els.backdrop) {
			return;
		}
		if (activeId && activeId !== id) {
			close(activeId);
		}
		activeId = id;
		lastFocus = document.activeElement;
		els.backdrop.removeAttribute('hidden');
		els.panel.removeAttribute('hidden');
		requestAnimationFrame(function () {
			els.backdrop.classList.remove('opacity-0', 'pointer-events-none');
			els.backdrop.setAttribute('aria-hidden', 'false');
			els.panel.classList.remove('translate-x-full');
			els.panel.setAttribute('aria-hidden', 'false');
		});
		document.querySelectorAll('.' + OPEN + '[data-evoluer-offcanvas="' + id + '"]').forEach(function (btn) {
			btn.setAttribute('aria-expanded', 'true');
		});
		if (id === 'main') {
			document.querySelectorAll('.header_nav_button').forEach(function (hb) {
				hb.classList.add('active');
			});
		}
		var closeBtn = els.panel.querySelector('.js-evoluer-offcanvas-close');
		if (closeBtn) {
			closeBtn.focus();
		}
	}

	function close(id) {
		var els = getEls(id);
		if (!els.panel || !els.backdrop) {
			return;
		}
		els.backdrop.classList.add('opacity-0', 'pointer-events-none');
		els.backdrop.setAttribute('aria-hidden', 'true');
		els.panel.classList.add('translate-x-full');
		els.panel.setAttribute('aria-hidden', 'true');
		document.querySelectorAll('.' + OPEN + '[data-evoluer-offcanvas="' + id + '"]').forEach(function (btn) {
			btn.setAttribute('aria-expanded', 'false');
		});
		document.querySelectorAll('.header_nav_button').forEach(function (hb) {
			hb.classList.remove('active');
		});
		var hdr = document.getElementById('header');
		if (hdr) {
			hdr.classList.remove('on', 'anime');
		}
		window.setTimeout(function () {
			els.backdrop.setAttribute('hidden', '');
			els.panel.setAttribute('hidden', '');
		}, 320);
		activeId = null;
		if (lastFocus && typeof lastFocus.focus === 'function') {
			lastFocus.focus();
		}
		lastFocus = null;
	}

	document.addEventListener('keydown', function (e) {
		if (e.key !== 'Enter' && e.key !== ' ') {
			return;
		}
		var hb = e.target.closest('.header_nav_button.js-evoluer-offcanvas-open');
		if (!hb) {
			return;
		}
		e.preventDefault();
		hb.click();
	});

	document.addEventListener('click', function (e) {
		var openBtn = e.target.closest('.' + OPEN);
		if (openBtn && openBtn.getAttribute('data-evoluer-offcanvas')) {
			e.preventDefault();
			var id = openBtn.getAttribute('data-evoluer-offcanvas');
			if (isOpen(id)) {
				close(id);
			} else {
				open(id);
			}
			return;
		}
		var closeBtn = e.target.closest('.js-evoluer-offcanvas-close');
		if (closeBtn && closeBtn.getAttribute('data-evoluer-offcanvas-close')) {
			e.preventDefault();
			close(closeBtn.getAttribute('data-evoluer-offcanvas-close'));
			return;
		}
		var bd = e.target.closest('.js-evoluer-offcanvas-backdrop');
		if (bd && bd.getAttribute('data-evoluer-offcanvas-backdrop')) {
			close(bd.getAttribute('data-evoluer-offcanvas-backdrop'));
			return;
		}
		var navLink = e.target.closest('.js-evoluer-offcanvas-panel a[href]');
		if (navLink && !navLink.closest('.js-evoluer-offcanvas-close')) {
			var href = navLink.getAttribute('href') || '';
			if (href.indexOf('#') === 0 || navLink.getAttribute('target') === '_blank') {
				return;
			}
			var pan = navLink.closest('.js-evoluer-offcanvas-panel');
			if (pan && pan.id) {
				var mid = pan.id.match(/^evoluer-offcanvas-(main|fanclub)$/);
				if (mid && activeId === mid[1]) {
					close(mid[1]);
				}
			}
		}
	});

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && activeId) {
			close(activeId);
		}
	});

	window.evoluerOffcanvasOpen = open;
	window.evoluerOffcanvasClose = close;
})();
