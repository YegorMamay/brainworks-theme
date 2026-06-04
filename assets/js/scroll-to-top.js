/**
 * Кнопка «Наверх»: показ/скрытие при скролле, плавный скролл к верху.
 */
(function() {
	'use strict';

	var btn = document.getElementById('scroll-to-top');
	if (!btn) return;

	var scrollThreshold = 300;
	var ticking = false;

	function updateVisibility() {
		var show = window.pageYOffset > scrollThreshold;
		btn.classList.toggle('scroll-to-top--visible', show);
		btn.setAttribute('aria-hidden', show ? 'false' : 'true');
	}

	function onScroll() {
		if (!ticking) {
			window.requestAnimationFrame(function() {
				updateVisibility();
				ticking = false;
			});
			ticking = true;
		}
	}

	btn.addEventListener('click', function(e) {
		e.preventDefault();
		window.scrollTo({ top: 0, behavior: 'smooth' });
	});

	window.addEventListener('scroll', onScroll, { passive: true });
	updateVisibility();
})();
