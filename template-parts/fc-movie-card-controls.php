<?php

/**
 * Overlay controls for fc-movie cards (custom play + fullscreen).
 *
 * @package evoluer
 */

if (! defined('ABSPATH')) {
	exit;
}
?>
<div class="js-fc-movie-idle-overlay pointer-events-none w-full h-full absolute top-0 left-0 z-10 bg-black/20 transition-opacity duration-200" aria-hidden="true"></div>
<button
	type="button"
	class="js-fc-movie-play absolute left-1/2 top-1/2 z-10 -translate-x-1/2 -translate-y-1/2 inline-flex items-center justify-center rounded-full w-[88px] h-[88px] md:w-[96px] md:h-[96px] group-hover:bg-black/55 transition-colors"
	aria-label="<?php echo esc_attr__('動画を再生', 'evoluer'); ?>">
	<svg class="w-[30px] md:w-[80px] aspect-[1]" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M20 12V52L52 32L20 12Z" fill="#fff" />
	</svg>
</button>
<button
	type="button"
	class="js-fc-movie-fullscreen absolute bottom-2 right-2 z-20 inline-flex items-center justify-center w-[72px] h-[72px] md:w-[40px] md:h-[40px] rounded-full hover:bg-black/55 transition-colors text-white"
	aria-label="<?php echo esc_attr__('全画面表示', 'evoluer'); ?>">
	<svg class="w-9 h-9 md:w-10 md:h-10" width="40" height="40" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
	</svg>
</button>