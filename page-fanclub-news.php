<?php
/*
Template Name: Fanclub (Member) - News FV
*/
?>

<?php get_header('fanclub-member'); ?>

<?php
// For now this is a placeholder. When you duplicate this page for Fanclub A/B,
// you can switch content here (or replace with real WP queries later).
$plan_label = '中村米吉official fan club';
$member_note = '会員期間は今後27日残りしました。';

// Fetch fc-news posts for the logged-in Fanclub (A/B).
// We use user role because /news/ page can be shared by both types.
$current_user      = wp_get_current_user();
$fanclub_term_slug = ( $current_user && in_array( 'fanclub_b', (array) $current_user->roles, true ) ) ? 'fanclub_b' : 'fanclub_a';

$news_items = array();
$news_query = new WP_Query(
	array(
		'post_type'      => 'fc-news',
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => array($fanclub_term_slug),
			),
		),
		'post_status' => 'publish',
	)
);

if ($news_query->have_posts()) {
	while ($news_query->have_posts()) {
		$news_query->the_post();

		$tag_names = wp_get_post_tags(get_the_ID(), array('fields' => 'names'));
		$news_items[] = array(
			'date'  => get_the_date('Y/m/d'),
			'tags'  => is_array($tag_names) ? $tag_names : array(),
			'title' => get_the_title(),
			'url'   => get_permalink(),
		);
	}
	wp_reset_postdata();
}
?>

<main id="container" class="bg-[#DDE4DE]">
	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] pb-[80px]">
		<p class="text-[#7A7A7A] text-[14px] md:text-[16px] mb-[26px]">
			<?php echo esc_html($member_note); ?>
		</p>

		<h2 class="text-center text-[#9DB03F] font-bold tracking-[0.45em] text-[34px] md:text-[40px] mb-[22px] en-font">
			<span class="inline-block">N</span>&nbsp;<span class="inline-block">E</span>&nbsp;<span class="inline-block">W</span>&nbsp;<span class="inline-block">S</span>
		</h2>

		<div class="bg-transparent border border-[#E5E5E5] rounded-[6px] overflow-hidden">
			<?php foreach ($news_items as $item) : ?>
				<a
					href="<?php echo esc_url(! empty($item['url']) ? $item['url'] : '#'); ?>"
					class="group block bg-[#F3F5F3] hover:bg-white transition-colors">
					<div class="flex items-center justify-between px-[22px] py-[18px] border-b border-[#E5E5E5]">
						<div class="flex flex-col gap-[6px]">
							<div class="flex items-center gap-[8px]">
								<span class="text-[#6F6F6F] text-[14px] font-semibold"><?php echo esc_html($item['date']); ?></span>
								<?php if (! empty($item['tags'])) : ?>
									<?php foreach ($item['tags'] as $tag) : ?>
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
								<?php echo esc_html($item['title']); ?>
							</p>
						</div>

						<span class="text-[#9DB03F] text-[20px] leading-none group-hover:translate-x-[2px] transition-transform">›</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="flex justify-center mt-[28px]">
			<a
				href="#"
				class="inline-flex items-center gap-[10px] px-[30px] py-[10px] border border-[#B5C86D] text-[#B5C86D] text-[14px] rounded-[2px] bg-white">
				<span class="font-bold">››</span>
				<span>もっと見る</span>
			</a>
		</div>
	</section>
</main>

<?php get_footer(); ?>