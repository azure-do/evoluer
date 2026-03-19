<?php
/*
Template Name: Fanclub (Member) - Fanclub 1
*/
?>

<?php get_header( 'fanclub-member' ); ?>

<?php
// NOTE: Placeholder content for now. Duplicate this page for Fanclub A/B and replace arrays/HTML later.
$member_note = '会員期間は今後27日残りしました。';

$news_items = array(
	array(
		'date'  => '2026/03/10',
		'tags'  => array( 'NEW', '更新' ),
		'title' => '2月16日(月)6:30〜 BS12「ハッスルミュージック」♯6　是非ご覧ください。',
	),
	array(
		'date'  => '2026/03/10',
		'tags'  => array( '更新' ),
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
?>

<main id="container" class="bg-[#DDE4DE]">
	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] pb-[28px]">
		<p class="text-[#7A7A7A] text-[14px] md:text-[16px] mb-[26px]">
			<?php echo esc_html( $member_note ); ?>
		</p>

		<h2 class="text-center text-[#9DB03F] font-bold tracking-[0.45em] text-[34px] md:text-[40px] mb-[22px] en-font">
			<span class="inline-block">N</span>&nbsp;<span class="inline-block">E</span>&nbsp;<span class="inline-block">W</span>&nbsp;<span class="inline-block">S</span>
		</h2>

		<div class="bg-transparent border border-[#E5E5E5] rounded-[6px] overflow-hidden">
			<?php foreach ( $news_items as $item ) : ?>
				<a href="#" class="group block hover:bg-white transition-colors">
					<div class="flex items-center justify-between px-[22px] py-[18px] border-b border-[#E5E5E5]">
						<div class="flex flex-col gap-[6px]">
							<div class="flex items-center gap-[8px]">
								<span class="text-[#6F6F6F] text-[14px] font-semibold"><?php echo esc_html( $item['date'] ); ?></span>
								<?php if ( ! empty( $item['tags'] ) ) : ?>
									<?php foreach ( $item['tags'] as $tag ) : ?>
										<?php if ( 'NEW' === $tag ) : ?>
											<span class="inline-flex items-center px-[10px] py-[3px] bg-[#13AA05] text-white text-[12px] rounded-[3px] font-bold">
												<?php echo esc_html( $tag ); ?>
											</span>
										<?php else : ?>
											<span class="inline-flex items-center px-[10px] py-[3px] bg-[#C7C7C7] text-[#333] text-[12px] rounded-[3px] font-bold">
												<?php echo esc_html( $tag ); ?>
											</span>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<p class="text-[#222] text-[15px] md:text-[16px] leading-relaxed">
								<?php echo esc_html( $item['title'] ); ?>
							</p>
						</div>

						<span class="text-[#9DB03F] text-[20px] leading-none group-hover:translate-x-[2px] transition-transform">›</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="flex justify-center mt-[28px]">
			<a href="#" class="inline-flex items-center gap-[10px] px-[30px] py-[10px] border border-[#B5C86D] text-[#B5C86D] text-[14px] rounded-[2px] bg-white">
				<span class="font-bold">››</span>
				<span>もっと見る</span>
			</a>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<h2 class="text-center text-[#9DB03F] font-bold tracking-[0.45em] text-[34px] md:text-[40px] mb-[30px] en-font">
				<span class="inline-block">G</span>&nbsp;<span class="inline-block">A</span>&nbsp;<span class="inline-block">L</span>&nbsp;<span class="inline-block">L</span>&nbsp;<span class="inline-block">E</span>&nbsp;<span class="inline-block">R</span>&nbsp;<span class="inline-block">Y</span>
			</h2>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px]">
				<?php foreach ( $gallery_items as $g ) : ?>
					<div class="rounded-[12px] overflow-hidden bg-[#C9CDD0]">
						<img
							src="<?php echo esc_url( $g['img'] ); ?>"
							alt="<?php echo esc_attr( $g['alt'] ); ?>"
							class="w-full h-[240px] object-cover"
						/>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="flex justify-center mt-[26px]">
				<a href="#" class="inline-flex items-center gap-[10px] px-[40px] py-[10px] border border-[#B5C86D] text-[#B5C86D] text-[14px] rounded-[2px] bg-transparent">
					<span class="font-bold">››</span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer( 'fanclub-member' ); ?>

