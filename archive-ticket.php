<?php
/**
 * Archive: ファンクラブ Ticket 一覧（全件 /ticket/）
 */
?>

<?php get_header( 'fanclub-member' ); ?>

<main id="container" class="bg-[#DDE4DE] pb-[20px] md:pb-[30px] xl:pb-[40px]">
	<div class="w-full max-w-[1130px] mx-auto px-[30px]">
		<?php
		if ( function_exists( 'evoluer_fanclub_member_period_notice_html' ) ) {
			echo evoluer_fanclub_member_period_notice_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</div>

	<section class="w-full pt-0 lg:pt-[60px] pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="mb-[16px] md:mb-[20px]">
				<?php
				if ( function_exists( 'evoluer_fanclub_back_to_hub_button_html' ) ) {
					echo evoluer_fanclub_back_to_hub_button_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
					Ticket
				</h3>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="bg-transparent overflow-hidden mt-[30px] border-t border-[#ffffff5c]">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="group block border-b border-[#ffffff5c] px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] transition-colors">
							<div class="flex flex-col gap-[6px]">
								<span class="text-[#525252] text-[14px] font-semibold"><?php echo esc_html( get_the_date( 'Y/m/d' ) ); ?></span>
								<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] leading-relaxed font-semibold group-hover:underline">
									<?php echo esc_html( get_the_title() ); ?>
								</p>
							</div>
						</a>
					<?php endwhile; ?>
				</div>

				<div class="flex justify-center mt-[32px]">
					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => '‹',
							'next_text' => '›',
						)
					);
					?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">チケット情報はまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
