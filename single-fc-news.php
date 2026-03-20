<?php
/*
Template Name: Fanclub News Detail
*/
?>

<?php
get_header('fanclub-member');

// For fc-news single view.
$current_user      = wp_get_current_user();
$fanclub_term_slug = ( $current_user && in_array( 'fanclub_b', (array) $current_user->roles, true ) ) ? 'fanclub_b' : 'fanclub_a';

$tags = get_the_tags();
?>

<main id="container" class="bg-[#DDE4DE] pb-[20px] md:pb-[30px] xl:pb-[40px]">
	<div class="w-full max-w-[1130px] mx-auto px-[30px]">
		<p class="text-[#7A7A7A] text-[14px] md:text-[16px] mb-[26px]">
			会員期間は今後27日残りしました。
		</p>
	</div>

	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] pb-[60px]">
		<div class="relative mb-[32px] xl:mb-[60px]">
			<h2 class="text-center text-[#9DB03F] font-bold tracking-[0.45em] text-[34px] md:text-[40px] en-font">
				<span class="inline-block">N</span>&nbsp;<span class="inline-block">E</span>&nbsp;<span class="inline-block">W</span>&nbsp;<span class="inline-block">S</span>
			</h2>
		</div>

		<article class="bg-transparent border border-[#E5E5E5] rounded-[6px] overflow-hidden">
			<div class="px-[22px] py-[18px] border-b border-[#E5E5E5]">
				<div class="flex items-center gap-[10px] flex-wrap">
					<span class="text-[#6F6F6F] text-[14px] font-semibold">
						<?php echo esc_html( get_the_date('Y/m/d') ); ?>
					</span>

					<?php if ( $tags ) : ?>
						<?php foreach ( $tags as $tag ) : ?>
							<?php $label = $tag->name; ?>
							<?php if ( 'NEW' === $label ) : ?>
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
					<?php echo esc_html( get_the_title() ); ?>
				</h1>
			</div>

			<div class="px-[22px] py-[22px] text-[#222] text-[14px] md:text-[16px] leading-relaxed">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile;
				endif;
				?>
			</div>
		</article>

		<div class="flex justify-center mt-[28px] md:mt-[40px] xl:mt-[54px]">
			<a
				href="<?php echo esc_url( home_url('/news/') ); ?>"
				class="inline-flex items-center gap-[10px] px-[30px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
				<span class="font-bold">›</span>
				<span>NEWS一覧へ</span>
			</a>
		</div>
	</section>
</main>

<?php get_footer(); ?>

