<?php

/**
 * Fanclub member-only header — matches main site header.php desktop tone:
 * white bar, logo_pc.svg, #menu + header_list, 16px en-font links, #13AA05 buttons.
 */
if (! defined('ABSPATH')) {
	exit;
}

$member_name = function_exists( 'evoluer_fanclub_member_display_sama' )
	? evoluer_fanclub_member_display_sama()
	: ( ( $current_user = wp_get_current_user() ) && $current_user->exists() ? $current_user->display_name : 'Member' );

$logout_url = wp_logout_url(home_url('/fanclub/login/'));
?>

<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php wp_head(); ?>
</head>

<body>
	<div id="wrapper">
		<header class="fixed top-0 left-0 w-full z-50 flex bg-white justify-center items-center py-1 md:py-2 lg:py-2 xl:py-8">
			<div class="w-full flex justify-between items-center max-w-[1440px] mx-auto px-4 sm:px-8 md:px-12 lg:px-[100px]">
				<h1 class="shrink-0">
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_pc.svg'); ?>" alt="Evoluer" />
					</a>
				</h1>
				<nav class="hidden md:block" id="menu">
					<ul class="header_list flex items-center justify-center gap-[10px] text-[16px] flex-wrap lg:flex-nowrap">
						<li>
							<a href="<?php echo esc_url(home_url('/fanclub/')); ?>" class="header_list_item text-center en-font px-[8px] xl:px-[16px] text-[16px] no-underline text-inherit inline-block">TOP</a>
						</li>
						<li>
							<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcnews_archive_url' ) ? evoluer_fanclub_fcnews_archive_url() : home_url( '/fcnews/' ) ); ?>" class="header_list_item text-center en-font px-[8px] xl:px-[16px] text-[16px] underline text-inherit inline-block">News</a>
						</li>
						<li>
							<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcgallery_archive_url' ) ? evoluer_fanclub_fcgallery_archive_url() : home_url( '/fc-gallery/' ) ); ?>" class="header_list_item text-center en-font px-[8px] xl:px-[16px] text-[16px] underline text-inherit inline-block">Gallery</a>
						</li>
						<li>
							<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fc_movie_archive_url' ) ? evoluer_fanclub_fc_movie_archive_url() : home_url( '/fc-movie/' ) ); ?>" class="header_list_item text-center en-font px-[8px] xl:px-[16px] text-[16px] underline text-inherit inline-block">Movie</a>
						</li>
						<li>
							<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_ticket_archive_url' ) ? evoluer_fanclub_ticket_archive_url() : home_url( '/ticket/' ) ); ?>" class="header_list_item text-center en-font px-[8px] xl:px-[16px] text-[16px] underline text-inherit inline-block">Ticket</a>
						</li>
						<li>
							<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="header_list_item text-center en-font px-[8px] xl:px-[16px] text-[16px] underline text-inherit inline-block">Contact US</a>
						</li>
						<li class="flex items-center shrink-0 ml-1">
							<span class="inline-flex items-center gap-2 px-[8px] xl:px-[12px]">
								<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true" class="text-[#333] shrink-0">
									<circle cx="12" cy="8" r="3.2"></circle>
									<path d="M5 19c.7-3.1 2.9-4.8 7-4.8s6.3 1.7 7 4.8"></path>
								</svg>
								<span class="en-font text-[16px] text-[#333] leading-none max-w-[min(200px,22vw)] truncate"><?php echo esc_html( $member_name ); ?></span>
							</span>
						</li>
						<li class="flex items-center">
							<span class="inline-block cursor-pointer" role="presentation" aria-hidden="true">
								<svg viewBox="0 0 32 32" width="28" height="28" fill="currentColor" class="text-[#333]">
									<rect y="7" width="32" height="3" rx="1.5" />
									<rect y="14.5" width="32" height="3" rx="1.5" />
									<rect y="22" width="32" height="3" rx="1.5" />
								</svg>
							</span>
						</li>
					</ul>
				</nav>
			</div>
		</header>

		<?php
		// Offset for fixed header — mirrors main #container padding-top (60px mobile / 80px lg+).
		?>
		<div class="pt-[60px] md:pt-[72px] lg:pt-[80px]"></div>
		<?php
// Page content continues in the template.
