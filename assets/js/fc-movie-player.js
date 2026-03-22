/**
 * Fanclub movie cards: custom play overlay + large fullscreen control.
 * Expects: .js-fc-movie-card > .js-fc-movie-video, .js-fc-movie-idle-overlay (optional),
 *          .js-fc-movie-play, .js-fc-movie-fullscreen
 */
(function () {
	'use strict';

	function isFullscreen() {
		return !!(document.fullscreenElement || document.webkitFullscreenElement);
	}

	function requestVideoFullscreen(video) {
		if (!video) {
			return Promise.reject();
		}
		// Standard Fullscreen API (desktop / Android Chrome)
		if (video.requestFullscreen) {
			return video.requestFullscreen();
		}
		if (video.webkitRequestFullscreen) {
			return video.webkitRequestFullscreen();
		}
		if (video.msRequestFullscreen) {
			return video.msRequestFullscreen();
		}
		// iOS Safari: native video fullscreen
		if (typeof video.webkitEnterFullscreen === 'function') {
			try {
				video.webkitEnterFullscreen();
				return Promise.resolve();
			} catch (e) {
				return Promise.reject(e);
			}
		}
		return Promise.reject();
	}

	function exitFullscreen() {
		if (document.exitFullscreen) {
			return document.exitFullscreen();
		}
		if (document.webkitExitFullscreen) {
			return document.webkitExitFullscreen();
		}
		if (document.msExitFullscreen) {
			return document.msExitFullscreen();
		}
		return Promise.resolve();
	}

	function bindCard(card) {
		var video = card.querySelector('.js-fc-movie-video');
		var playButton = card.querySelector('.js-fc-movie-play');
		var fsButton = card.querySelector('.js-fc-movie-fullscreen');
		var idleOverlay = card.querySelector('.js-fc-movie-idle-overlay');

		if (!video || !playButton) {
			return;
		}

		var setPlaying = function (playing) {
			playButton.style.display = playing ? 'none' : 'inline-flex';
			if (idleOverlay) {
				idleOverlay.style.display = playing ? 'none' : '';
			}
		};

		setPlaying(!video.paused);

		playButton.addEventListener('click', function (e) {
			e.stopPropagation();
			if (video.paused) {
				video
					.play()
					.then(function () {
						setPlaying(true);
					})
					.catch(function () {
						setPlaying(false);
					});
			} else {
				video.pause();
				setPlaying(false);
			}
		});

		video.addEventListener('click', function () {
			if (video.paused) {
				video
					.play()
					.then(function () {
						setPlaying(true);
					})
					.catch(function () {
						setPlaying(false);
					});
			} else {
				video.pause();
				setPlaying(false);
			}
		});

		video.addEventListener('play', function () {
			setPlaying(true);
		});
		video.addEventListener('pause', function () {
			setPlaying(false);
		});
		video.addEventListener('ended', function () {
			setPlaying(false);
		});

		if (fsButton) {
			fsButton.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				if (isFullscreen()) {
					exitFullscreen();
				} else {
					requestVideoFullscreen(video).catch(function () {});
				}
			});
		}
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.js-fc-movie-card').forEach(bindCard);
	});
})();
