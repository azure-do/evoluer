<?php

/**
 * Fanclub member-only header (independent from main header.php).
 */
if (! defined('ABSPATH')) {
	exit;
}

$current_user = wp_get_current_user();
$member_name  = ($current_user && $current_user->exists()) ? $current_user->display_name : '123456 様';
?>

<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php wp_head(); ?>
</head>

<body>
	<div id="wrapper">
		<header class="fixed top-0 left-0 w-full z-50 flex bg-white justify-center items-center py-2 md:py-2">
			<div class="w-full flex justify-center md:justify-between items-center max-w-[1440px] mx-auto px-[60px]">
				<h1 class="shrink-0">
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_pc.svg'); ?>" alt="Evoluer" />
					</a>
				</h1>

				<nav class="hidden md:block">
					<ul class="flex items-center justify-center gap-[34px] text-[14px] tracking-[0.01em] text-[#333333]">
						<li><a href="<?php echo esc_url(home_url('/fanclub/')); ?>" class="no-underline text-inherit en-font">TOP</a></li>
						<li><a href="<?php echo esc_url(home_url('/news/')); ?>" class="no-underline text-inherit en-font">NEWS</a></li>
						<li><a href="<?php echo esc_url(home_url('/gallery/')); ?>" class="no-underline text-inherit en-font">GALLERY</a></li>
						<li><a href="<?php echo esc_url(home_url('/movie/')); ?>" class="no-underline text-inherit en-font">Movie</a></li>
						<li><a href="<?php echo esc_url(home_url('/ticket/')); ?>" class="no-underline text-inherit en-font">Ticket</a></li>
						<li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="no-underline text-inherit en-font">Contact US</a></li>
					</ul>
				</nav>

				<div class="flex items-center gap-8">
					<div class="hidden lg:flex items-center gap-3">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true" class="text-[#222]">
							<circle cx="12" cy="8" r="3.2"></circle>
							<path d="M5 19c.7-3.1 2.9-4.8 7-4.8s6.3 1.7 7 4.8"></path>
						</svg>
						<span class="text-[16px] text-[#222] en-font"><?php echo esc_html($member_name); ?></span>
					</div>

					<button type="button" class="p-0 bg-transparent border-0 cursor-pointer" aria-label="メニュー">
						<svg viewBox="0 0 32 32" width="28" height="28" fill="currentColor" aria-hidden="true" class="text-[#222]">
							<rect y="7" width="32" height="3" rx="1.5" />
							<rect y="14.5" width="32" height="3" rx="1.5" />
							<rect y="22" width="32" height="3" rx="1.5" />
						</svg>
					</button>
				</div>
			</div>
		</header>

		<div class="pt-[90px]"></div>
		<?php
// Page content continues in the template.
