<?php
/*
Template Name: Fanclub (Member) - Ticket
*/
?>

<?php
get_header( 'fanclub-member' );

$fanclub_term_slug = function_exists( 'evoluer_fanclub_term_slug_for_request' ) ? evoluer_fanclub_term_slug_for_request() : 'fanclub_a';
$ticket_items      = array();
$ticket_query      = new WP_Query(
	array(
		'post_type'      => EVOLUER_PT_FANCLUB_TICKET,
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

		$ticket_items[] = array(
			'title' => get_the_title( $post_id ),
			'url'   => get_permalink( $post_id ),
			'date'  => get_the_date( 'Y/m/d', $post_id ),
		);
	}
	wp_reset_postdata();
}
?>

<main id="container" class="bg-[#DDE4DE] pb-[20px] md:pb-[30px] xl:pb-[40px]">
	<div class="w-full max-w-[1130px] mx-auto px-[30px]">
		<?php
		if ( function_exists( 'evoluer_fanclub_member_period_notice_html' ) ) {
			echo evoluer_fanclub_member_period_notice_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
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
						<a href="<?php echo esc_url( $t['url'] ); ?>" class="group block border-b border-[#ffffff5c] px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] transition-colors hover:bg-white/10">
							<div class="flex flex-col gap-[6px]">
								<span class="text-[#525252] text-[14px] font-semibold"><?php echo esc_html( $t['date'] ); ?></span>
								<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] leading-relaxed font-semibold group-hover:underline">
									<?php echo esc_html( $t['title'] ); ?>
								</p>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">チケット情報はまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
