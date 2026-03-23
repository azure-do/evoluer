<?php

/**
 * Archive: ファンクラブ NEWS 一覧（全件 /fcnews/）
 */
?>

<?php get_header('fanclub-member'); ?>

<main id="container" class="bg-[#DDE4DE]">
	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] pb-[80px]">
		<?php
		if (function_exists('evoluer_fanclub_member_period_notice_html')) {
			echo evoluer_fanclub_member_period_notice_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
		<div class="mb-[16px] md:mb-[20px]">
			<?php
			if ( function_exists( 'evoluer_fanclub_back_to_hub_button_html' ) ) {
				echo evoluer_fanclub_back_to_hub_button_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>

		<div class="relative mb-[32px] xl:mb-[60px]" bis_skin_checked="1">
			<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
				NEWS
			</h3>
		</div>

		<?php if (have_posts()) : ?>
			<div class="bg-transparent border-t border-[#ffffff5c] overflow-hidden">
				<?php
				while (have_posts()) :
					the_post();
					$post_id   = get_the_ID();
					$tag_names = wp_get_post_tags($post_id, array('fields' => 'names'));
					$all_meta  = get_post_meta($post_id);
					$is_out    = false;
					foreach ($all_meta as $meta_values) {
						foreach ((array) $meta_values as $meta_value) {
							$meta_value = (string) $meta_value;
							if ('fc_out_news' === $meta_value) {
								$is_out = true;
								break 2;
							}
						}
					}
					$out_link = trim((string) get_post_meta($post_id, 'out_link', true));
					$url      = $is_out && $out_link !== '' ? $out_link : get_permalink($post_id);
				?>
					<a
						href="<?php echo esc_url($url); ?>"
						<?php echo $is_out && $out_link !== '' ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
						class="group block transition-colors">
						<div class="flex items-center justify-between px-[22px] py-[18px] border-b border-[#ffffff5c]">
							<div class="flex flex-col gap-[6px]">
								<div class="flex items-center gap-[8px]">
									<span class="text-[#6F6F6F] text-[14px] font-semibold"><?php echo esc_html(get_the_date('Y/m/d')); ?></span>
									<?php if (! empty($tag_names) && is_array($tag_names)) : ?>
										<?php foreach ($tag_names as $tag) : ?>
											<?php if ('NEW' === $tag) : ?>
												<span class="inline-flex items-center px-[10px] py-[3px] bg-[#13AA05] text-white text-[12px] rounded-[3px] font-bold">
													<?php echo esc_html($tag); ?>
												</span>
											<?php else : ?>
												<span class="inline-flex items-center px-[10px] py-[3px] bg-[#C7C7C7] text-[#333] text-[12px] rounded-[3px] font-bold">
													<?php echo esc_html($tag); ?>
												</span>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<p class="text-[#222] text-[15px] md:text-[16px] leading-relaxed">
									<?php echo esc_html(get_the_title()); ?>
								</p>
							</div>
							<span class="text-[#9DB03F] text-[20px] leading-none group-hover:translate-x-[2px] transition-transform">›</span>
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
			<p class="text-center text-[#666] text-[14px] md:text-[16px]">お知らせはまだありません。</p>
		<?php endif; ?>
	</section>
</main>

<?php get_footer(); ?>