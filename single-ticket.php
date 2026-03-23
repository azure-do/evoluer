<?php

/**
 * Single template: ticket（ファンクラブチケット詳細）
 */
?>

<?php
get_header('fanclub-member');

$post_id     = get_the_ID();
$tags        = get_the_tags($post_id);
$scf_content = (string) get_post_meta($post_id, 'fc_ticket_content', true);
$detail_body = $scf_content !== '' ? $scf_content : get_post_field('post_content', $post_id);
?>

<main id="container" class="bg-[#DDE4DE] pb-[20px] md:pb-[30px] xl:pb-[40px]">
	<div class="w-full max-w-[1130px] mx-auto px-[30px]">
		<?php
		if (function_exists('evoluer_fanclub_member_period_notice_html')) {
			echo evoluer_fanclub_member_period_notice_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</div>

	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] pb-[60px]">
		<div class="mb-[16px] md:mb-[20px]">
			<?php
			if ( function_exists( 'evoluer_fanclub_back_to_hub_button_html' ) ) {
				echo evoluer_fanclub_back_to_hub_button_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
		<div class="relative mb-[32px] xl:mb-[60px]" bis_skin_checked="1">
			<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
				Ticket
			</h3>
		</div>

		<article class="bg-transparent border border-[#E5E5E5] rounded-[6px] overflow-hidden">
			<div class="px-[22px] py-[18px] border-b border-[#E5E5E5]">
				<div class="flex items-center gap-[10px] flex-wrap">
					<span class="text-[#6F6F6F] text-[14px] font-semibold">
						<?php echo esc_html(get_the_date('Y/m/d')); ?>
					</span>

					<?php if ($tags) : ?>
						<?php foreach ($tags as $tag) : ?>
							<?php $label = $tag->name; ?>
							<?php if ('NEW' === $label) : ?>
								<span class="inline-flex items-center px-[10px] py-[3px] bg-[#13AA05] text-white text-[12px] rounded-[3px] font-bold">
									<?php echo esc_html($label); ?>
								</span>
							<?php else : ?>
								<span class="inline-flex items-center px-[10px] py-[3px] bg-[#C7C7C7] text-[#333] text-[12px] rounded-[3px] font-bold">
									<?php echo esc_html($label); ?>
								</span>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<h1 class="text-[#222] text-[20px] md:text-[22px] leading-relaxed mt-[14px]">
					<?php echo esc_html(get_the_title()); ?>
				</h1>
			</div>

			<div class="px-[22px] py-[22px] text-[#222] text-[14px] md:text-[16px] leading-relaxed">
				<?php echo apply_filters('the_content', $detail_body); ?>
			</div>
		</article>

		<div class="flex justify-center mt-[28px] md:mt-[40px] xl:mt-[54px]">
			<a
				href="<?php echo esc_url(function_exists('evoluer_fanclub_ticket_archive_url') ? evoluer_fanclub_ticket_archive_url() : home_url('/ticket/')); ?>"
				class="inline-flex items-center gap-[10px] px-[30px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
				<span class="font-bold">›</span>
				<span>Ticket一覧へ</span>
			</a>
		</div>
	</section>
</main>

<?php get_footer(); ?>