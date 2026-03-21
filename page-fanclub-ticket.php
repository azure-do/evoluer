<?php
/*
Template Name: Fanclub (Member) - Ticket
*/
?>

<?php
get_header('fanclub-member');

$current_user      = wp_get_current_user();
$fanclub_term_slug = ( $current_user && in_array( 'fanclub_b', (array) $current_user->roles, true ) ) ? 'fanclub_b' : 'fanclub_a';
$ticket_items      = array();
$ticket_query      = new WP_Query(
	array(
		'post_type'      => 'fc-ticket',
		'posts_per_page' => 12,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => array( $fanclub_term_slug ),
			),
		),
		'post_status' => 'publish',
	)
);

if ( $ticket_query->have_posts() ) {
	while ( $ticket_query->have_posts() ) {
		$ticket_query->the_post();
		$post_id = get_the_ID();
		$content = trim( (string) get_post_field( 'post_content', $post_id ) );

		$ticket_items[] = array(
			'title'   => get_the_title( $post_id ),
			'content' => $content !== '' ? apply_filters( 'the_content', $content ) : '',
		);
	}
	wp_reset_postdata();
}
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

			<?php if ( ! empty( $ticket_items ) ) : ?>
				<div class="bg-transparent overflow-hidden mt-[30px]">
					<?php foreach ( $ticket_items as $t ) : ?>
						<div class="px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] xl:pt-[18px] xl:pb-[20px] border-b border-[#ffffff5c] ">
							<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] leading-relaxed font-semibold">
								<?php echo esc_html( $t['title'] ); ?>
							</p>
							<?php if ( ! empty( $t['content'] ) ) : ?>
								<div class="mt-[8px] text-[#222] text-[13px] md:text-[15px] leading-relaxed">
									<?php echo $t['content']; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">チケット情報はまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>

