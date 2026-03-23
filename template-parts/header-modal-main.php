<?php

/**
 * Main site off-canvas menu (slide from right).
 *
 * @package evoluer
 */

if (! defined('ABSPATH')) {
	exit;
}
?>
<div
	id="evoluer-offcanvas-backdrop-main"
	class="js-evoluer-offcanvas-backdrop fixed inset-0 z-[100] opacity-0 pointer-events-none transition-opacity duration-300 ease-out"
	data-evoluer-offcanvas-backdrop="main"
	aria-hidden="true"
	hidden></div>
<div
	id="evoluer-offcanvas-main"
	class="js-evoluer-offcanvas-panel fixed top-0 right-0 z-[101] flex h-[100dvh] w-full max-w-none translate-x-full flex-col transition-transform duration-300 ease-out lg:w-[60vw] lg:max-w-[60vw]"
	role="dialog"
	aria-modal="true"
	aria-labelledby="evoluer-offcanvas-main-title"
	aria-hidden="true"
	tabindex="-1"
	hidden>
	<div class="flex shrink-0 items-center justify-center bg-white px-4 md:px-6 pt-[20px]">
		<span id="evoluer-offcanvas-main-title" class="xl:text-[120px] text-[60px] lg:text-[80px] font-bold text-[#000]">Evoluer</span>
		<button
			type="button"
			class="js-evoluer-offcanvas-close absolute top-4 right-4 md:top-6 md:right-6 lg:top-8 lg:right-8 inline-flex h-10 w-10 items-center justify-center rounded-full text-[#333] hover:bg-black/5"
			data-evoluer-offcanvas-close="main"
			aria-label="<?php echo esc_attr__('メニューを閉じる', 'evoluer'); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
				<path d="M6 6l12 12M18 6L6 18" />
			</svg>
		</button>
	</div>
	<nav class="flex-1 overflow-y-auto overscroll-contain px-[40px] py-6 md:px-[40px] xl:px-[80px] lg:py-12 xl:py-20 bg-white" aria-label="<?php echo esc_attr__('サイトメニュー', 'evoluer'); ?>">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-16 lg:gap-[20px] xl:gap-[60px] text-sm text-[#555]">
			<!-- Official contents -->
			<div class="!space-y-14">
				<h3 class="text-[24px] lg:text-[28px] xl:text-[32px] font-medium tracking-[-1px] text-[#676767] h-[24px] md:h-[60px] lg:h-[110px] xl:h-[100px]">
					OFFICIAL CONTENTS
				</h3>
				<ul class="space-y-5 lg:space-y-6 xl:space-y-[20px] text-[18px] lg:text-[22px] xl:text-[24px]">
					<li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
					<li><a href="<?php echo esc_url(home_url('#news')); ?>">NEWS</a></li>
					<li>
						<span>FAN CLUB</span>
						<div class="!text-[14px] xl:!text-[16px] pl-[12px] space-y-5 lg:space-y-6 xl:space-y-[20px] mt-2 xl:mt-6 mb-4">
							<a href="<?php echo esc_url(home_url('/fanclub/yonekichi/')); ?>">
								<span class="jp-point-font block">中村米吉official fan club</span>
							</a>
							<a href="<?php echo esc_url(home_url('/fanclub/shibuki/')); ?>">
								<span class="jp-point-font block">紫吹official fan club</span>
							</a>
						</div>
					</li>
					<li><a href="<?php echo esc_url(home_url('/shop/')); ?>">SHOPPING</a></li>
				</ul>
			</div>

			<!-- Fan club 1（中村米吉） -->
			<div class="!space-y-14">
				<h3 class="text-[24px] lg:text-[28px] xl:text-[32px] font-medium tracking-[-1px] text-[#676767] h-[24px] md:h-[60px] lg:h-[110px] xl:h-[100px]">
					中村米吉<br class="hidden lg:block">official fan club
				</h3>
				<ul class="space-y-5 lg:space-y-6 xl:space-y-[20px] text-[18px] lg:text-[22px] xl:text-[24px]">
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('yonekichi', 'news') : home_url('/fanclub/yonekichi/news/')); ?>">NEWS</a>
					</li>
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('yonekichi', 'gallery') : home_url('/fanclub/yonekichi/gallery/')); ?>">GALLERY</a>
					</li>
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('yonekichi', 'movie') : home_url('/fanclub/yonekichi/movie/')); ?>">Movie</a>
					</li>
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('yonekichi', 'ticket') : home_url('/fanclub/yonekichi/ticket/')); ?>">Ticket</a>
					</li>
					<li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact US</a></li>
				</ul>
			</div>

			<!-- Fan club 2（紫吹） -->
			<div class="!space-y-14">
				<h3 class="text-[24px] lg:text-[28px] xl:text-[32px] font-medium tracking-[-1px] text-[#676767] h-[24px] md:h-[60px] lg:h-[110px] xl:h-[100px]">
					紫吹<br class="hidden lg:block">official fan club
				</h3>
				<ul class="space-y-5 lg:space-y-6 xl:space-y-[20px] text-[18px] lg:text-[22px] xl:text-[24px]">
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('shibuki', 'news') : home_url('/fanclub/shibuki/news/')); ?>">NEWS</a>
					</li>
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('shibuki', 'gallery') : home_url('/fanclub/shibuki/gallery/')); ?>">GALLERY</a>
					</li>
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('shibuki', 'movie') : home_url('/fanclub/shibuki/movie/')); ?>">Movie</a>
					</li>
					<li>
						<a href="<?php echo esc_url(function_exists('evoluer_fanclub_hub_section_url') ? evoluer_fanclub_hub_section_url('shibuki', 'ticket') : home_url('/fanclub/shibuki/ticket/')); ?>">Ticket</a>
					</li>
					<li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact US</a></li>
				</ul>
			</div>
		</div>

		<!-- Login/Register buttons -->
		<div class="mt-8 flex flex-col sm:flex-row justify-center gap-3 sm:gap-4 md:gap-6 lg:gap-8 xl:gap-10">
			<a
				href="<?php echo esc_url(home_url('/fanclub/login/')); ?>"
				class="inline-flex items-center justify-center rounded-[10px] w-full max-w-[400px] text-center px-6 py-3 border border-[#13AA05] !text-[#13AA05] text-[20px] lg:text-[24px] xl:text-[28px] font-medium bg-white hover:bg-[#F5FFF5]">
				ログイン
			</a>
			<a
				href="<?php echo esc_url(home_url('/fanclub/register/')); ?>"
				class="inline-flex items-center justify-center rounded-[10px] w-full max-w-[400px] text-center px-6 py-3 border border-[#13AA05] bg-[#13AA05] !text-white text-[20px] lg:text-[24px] xl:text-[28px] font-medium hover:bg-[#0F9105]">
				新規入会
			</a>
		</div>
	</nav>
</div>