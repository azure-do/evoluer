<?php
/*
Template Name: Fanclub (Member) - Fanclub 1
*/
?>

<?php get_header('fanclub-member'); ?>

<?php
// NOTE: Placeholder content for now. Duplicate this page for Fanclub A/B and replace arrays/HTML later.
$member_note = '会員期間は今後27日残りしました。';

$news_items = array(
	array(
		'date'  => '2026/03/10',
		'tags'  => array('NEW', '更新'),
		'title' => '2月16日(月)6:30〜 BS12「ハッスルミュージック」♯6　是非ご覧ください。',
	),
	array(
		'date'  => '2026/03/10',
		'tags'  => array('更新'),
		'title' => '2月2日(月)6:30〜 BS12にて放送です。是非ご覧ください。',
	),
	array(
		'date'  => '2026/01/11',
		'tags'  => array(),
		'title' => '1月11日(日)テレビ朝日「答えて当」！地元愛Qプレッシャー」に出演致します。',
	),
	array(
		'date'  => '2026/01/10',
		'tags'  => array(),
		'title' => '1月12日(月)　日本テレビ「飲芸ちゃん＆香取慎吾　第１０回全国日本仮放大賞」にて審査員として出演致します。',
	),
);

$gallery_items = array(
	array(
		// Replace with real gallery images later.
		'img' => get_template_directory_uri() . '/assets/images/profile-official-ico.svg',
		'alt' => 'gallery image 1',
	),
	array(
		'img' => get_template_directory_uri() . '/assets/images/profile-official-ico.svg',
		'alt' => 'gallery image 2',
	),
	array(
		'img' => get_template_directory_uri() . '/assets/images/profile-official-ico.svg',
		'alt' => 'gallery image 3',
	),
);

$movie_items = array(
	array(
		// Replace with real movie thumbnails later.
		'img' => get_template_directory_uri() . '/assets/images/profile-official-ico.svg',
		'alt' => 'movie thumbnail 1',
	),
	array(
		'img' => get_template_directory_uri() . '/assets/images/profile-official-ico.svg',
		'alt' => 'movie thumbnail 2',
	),
	array(
		'img' => get_template_directory_uri() . '/assets/images/profile-official-ico.svg',
		'alt' => 'movie thumbnail 3',
	),
);

$ticket_items = array(
	array(
		'text' => 'ミュージカル「レ・ビザック」東京公演 ファンクラブ先行受付',
	),
	array(
		'text' => '「エリザベート TAKARAZUKA 30th スペシャル・ガラ・コンサート」FC先行チケット受付',
	),
	array(
		'text' => '「エリザベート TAKARAZUKA 30th スペシャル・ガラ・コンサート」FC先行チケット受付',
	),
);
?>

<main id="container" class="bg-[#DDE4DE] pb-[20px] md:pb-[30px] xl:pb-[40px]">
	<div class="w-full max-w-[1130px] mx-auto px-[30px]">
		<p class="text-[#CC6868] text-[14px] md:text-[16px] mb-[26px]">
			<?php echo esc_html($member_note); ?>
		</p>
	</div>
	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] xl:pt-[100px] pb-[28px]">
		<div class="relative mb-[32px] xl:mb-[60px]">
			<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
				NEWS
			</h3>
		</div>
		<div class="bg-transparent border-t border-[#ffffff5c] overflow-hidden">
			<?php foreach ($news_items as $item) : ?>
				<a href="#" class="group block transition-colors">
					<div class="flex items-center justify-between px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] xl:pt-[18px] xl:pb-[20px] border-b border-[#ffffff5c]">
						<div class="flex flex-col gap-[6px]">
							<div class="flex items-center gap-[8px]">
								<span class="text-[#525252] text-[14px] font-semibold"><?php echo esc_html($item['date']); ?></span>
								<?php if (! empty($item['tags'])) : ?>
									<?php foreach ($item['tags'] as $tag) : ?>
										<?php if ('NEW' === $tag) : ?>
											<span class="inline-flex items-center px-[10px] py-[2px] xl:py-[3px] bg-[#13AA05] text-white text-[12px] rounded-[3px] font-bold">
												<?php echo esc_html($tag); ?>
											</span>
										<?php else : ?>
											<span class="inline-flex items-center px-[10px] py-[2px] xl:py-[3px] bg-[#C7C7C7] text-[#333] text-[12px] rounded-[3px] font-bold">
												<?php echo esc_html($tag); ?>
											</span>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] xl:text-[18px] leading-relaxed">
								<?php echo esc_html($item['title']); ?>
							</p>
						</div>

						<span class="text-[#9DB03F] text-[20px] leading-none group-hover:translate-x-[2px] transition-transform">›</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="flex justify-center mt-[28px] md:mt-[40px] xl:mt-[54px]">
			<a href="#" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
				<span class="font-bold">>></span>
				<span>もっと見る</span>
			</a>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[20px] md:pb-[40px] xl:pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
					GALLERY
				</h3>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px]">
				<?php foreach ($gallery_items as $g) : ?>
					<a href="#" class="group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
						<img
							src="<?php echo esc_url($g['img']); ?>"
							alt="<?php echo esc_attr($g['alt']); ?>"
							class="w-full h-[240px] object-cover transition-transform duration-200 group-hover:scale-[1.02]" />
					</a>
				<?php endforeach; ?>
			</div>

			<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
				<a href="#" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
					<span class="font-bold">>></span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[20px] md:pb-[40px] xl:pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
					Movie
				</h3>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px] mt-[30px]">
				<?php foreach ($movie_items as $m) : ?>
					<a href="#" class="group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
						<img
							src="<?php echo esc_url($m['img']); ?>"
							alt="<?php echo esc_attr($m['alt']); ?>"
							class="w-full h-[220px] object-cover transition-transform duration-200 group-hover:scale-[1.02]" />
						<svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" width="80" height="80" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M20 12V52L52 32L20 12Z"
								fill="#fff" />
						</svg>
					</a>
				<?php endforeach; ?>
			</div>

			<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
				<a href="#" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
					<span class="font-bold">>></span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[20px] md:pb-[40px] xl:pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
					Ticket
				</h3>
			</div>

			<div class="bg-transparent overflow-hidden mt-[30px]">
				<?php foreach ($ticket_items as $t) : ?>
					<div class="px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] xl:pt-[18px] xl:pb-[20px] border-b border-[#ffffff5c] ">
						<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] leading-relaxed">
							<?php echo esc_html($t['text']); ?>
						</p>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
				<a href="#" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
					<span class="font-bold">>></span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer('fanclub-member'); ?>