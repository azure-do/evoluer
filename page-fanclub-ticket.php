<?php
/*
Template Name: Fanclub (Member) - Ticket
*/
?>

<?php
get_header('fanclub-member');

$page_content = trim( get_post_field( 'post_content', get_queried_object_id() ) );
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
		<p class="text-[#7A7A7A] text-[14px] md:text-[16px] mb-[26px]">
			会員期間は今後27日残りしました。
		</p>
	</div>

	<section class="w-full pt-[60px] pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
					Ticket
				</h3>
			</div>

			<?php if ( $page_content !== '' ) : ?>
				<div class="mt-[10px] text-[#222] text-[14px] md:text-[16px] leading-relaxed">
					<?php echo apply_filters( 'the_content', $page_content ); ?>
				</div>
			<?php else : ?>
				<div class="bg-transparent overflow-hidden mt-[30px]">
					<?php foreach ( $ticket_items as $t ) : ?>
						<div class="px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] xl:pt-[18px] xl:pb-[20px] border-b border-[#ffffff5c] ">
							<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] leading-relaxed">
								<?php echo esc_html( $t['text'] ); ?>
							</p>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
					<a href="#" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
						<span class="font-bold">››</span>
						<span>もっと見る</span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>

