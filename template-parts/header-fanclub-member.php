<?php
/**
 * Fanclub member-only header.
 * Usage: get_template_part('template-parts/header', 'fanclub-member');
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$member_name = function_exists( 'evoluer_fanclub_member_display_sama' )
	? evoluer_fanclub_member_display_sama()
	: ( ( $current_user = wp_get_current_user() ) && $current_user->exists() ? $current_user->display_name : 'Member' );
?>

<header class="w-full bg-white border-b border-[#EAEAEA]">
	<div class="w-full max-w-[1440px] mx-auto px-6 md:px-10 lg:px-14">
		<div class="h-[72px] flex items-center justify-between">
			<div class="shrink-0">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block">
					<img
						src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo_pc.svg' ); ?>"
						alt="Evoluer"
						class="w-[165px] h-auto"
					/>
				</a>
			</div>

			<nav class="hidden md:block">
				<ul class="flex items-center gap-8 lg:gap-10 text-[18px] tracking-[0.01em] text-[#333333]">
					<li><a href="<?php echo esc_url( home_url( '/fanclub/' ) ); ?>" class="no-underline text-inherit">TOP</a></li>
					<li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcnews_archive_url' ) ? evoluer_fanclub_fcnews_archive_url() : home_url( '/fcnews/' ) ); ?>" class="no-underline text-inherit">NEWS</a></li>
					<li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcgallery_archive_url' ) ? evoluer_fanclub_fcgallery_archive_url() : home_url( '/fc-gallery/' ) ); ?>" class="no-underline text-inherit">GALLERY</a></li>
					<li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fc_movie_archive_url' ) ? evoluer_fanclub_fc_movie_archive_url() : home_url( '/fc-movie/' ) ); ?>" class="no-underline text-inherit">Movie</a></li>
					<li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_ticket_archive_url' ) ? evoluer_fanclub_ticket_archive_url() : home_url( '/ticket/' ) ); ?>" class="no-underline text-inherit">Ticket</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="no-underline text-inherit">Contact US</a></li>
				</ul>
			</nav>

			<div class="flex items-center gap-4 lg:gap-6 text-[#222]">
				<a href="<?php echo esc_url( home_url( '/mypage/' ) ); ?>" class="hidden md:flex items-center gap-2 no-underline text-inherit">
					<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
						<circle cx="12" cy="8" r="3.2"></circle>
						<path d="M5 19c.7-3.1 2.9-4.8 7-4.8s6.3 1.7 7 4.8"></path>
					</svg>
					<span class="text-[16px]"><?php echo esc_html( $member_name ); ?></span>
				</a>

				<button type="button" class="inline-flex items-center justify-center p-1 bg-transparent border-0 text-inherit cursor-pointer" aria-label="メニューを開く">
					<svg viewBox="0 0 28 28" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<line x1="5" y1="7" x2="23" y2="7"></line>
						<line x1="5" y1="14" x2="23" y2="14"></line>
						<line x1="5" y1="21" x2="23" y2="21"></line>
					</svg>
				</button>
			</div>
		</div>
	</div>
</header>

