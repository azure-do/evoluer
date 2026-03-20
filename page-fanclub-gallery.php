<?php
/*
Template Name: Fanclub (Member) - Gallery
*/
?>

<?php
get_header('fanclub-member');

$page_content = trim( get_post_field( 'post_content', get_queried_object_id() ) );
$gallery_items = array(
	array(
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

<main id="container" class="bg-[#DDE4DE] pb-[20px] md:pb-[30px] xl:pb-[40px]">
	<div class="w-full max-w-[1130px] mx-auto px-[30px]">
		<p class="text-[#7A7A7A] text-[14px] md:text-[16px] mb-[26px]">
			会員期間は今後27日残りしました。
		</p>
	</div>

	<section class="w-full pt-[60px] pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
					GALLERY
				</h3>
			</div>

			<?php if ( $page_content !== '' ) : ?>
				<div class="mt-[10px] text-[#222] text-[14px] md:text-[16px] leading-relaxed">
					<?php echo apply_filters( 'the_content', $page_content ); ?>
				</div>
			<?php else : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px]">
					<?php foreach ( $gallery_items as $g ) : ?>
						<div class="group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
							<img
								src="<?php echo esc_url( $g['img'] ); ?>"
								alt="<?php echo esc_attr( $g['alt'] ); ?>"
								class="w-full h-[240px] object-cover transition-transform duration-200" />
						</div>
					<?php endforeach; ?>
				</div>
				<div class="flex justify-center mt-[28px] md:mt-[40px] xl:mt-[54px]">
					<a href="#" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
						<span class="font-bold">›</span>
						<span>もっと見る</span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>

