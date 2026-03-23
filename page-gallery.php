<?php
/*
Template Name: Fanclub (Member) - Gallery
*/
?>

<?php
get_header('fanclub-member');

// URL /fanclub/{artist}/gallery/ → uses current term slugs.
$fanclub_term_slugs = function_exists( 'evoluer_fanclub_term_slugs_for_request' )
	? evoluer_fanclub_term_slugs_for_request()
	: array( 'fanclub_yonekichi' );
$gallery_items     = array();
$gallery_query     = new WP_Query(
	array(
		'post_type'      => 'fc-gallery',
		'posts_per_page' => 12,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => $fanclub_term_slugs,
			),
		),
		'post_status' => 'publish',
	)
);

if ( $gallery_query->have_posts() ) {
	while ( $gallery_query->have_posts() ) {
		$gallery_query->the_post();
		$post_id   = get_the_ID();
		$fc_image  = get_post_meta( $post_id, 'fc_image', true );
		$image_url = '';

		if ( is_numeric( $fc_image ) ) {
			$image_url = (string) wp_get_attachment_image_url( (int) $fc_image, 'large' );
		} elseif ( is_array( $fc_image ) ) {
			if ( isset( $fc_image['url'] ) ) {
				$image_url = (string) $fc_image['url'];
			} elseif ( isset( $fc_image[0]['url'] ) ) {
				$image_url = (string) $fc_image[0]['url'];
			}
		} elseif ( is_string( $fc_image ) ) {
			$image_url = $fc_image;
		}

		if ( $image_url === '' ) {
			$image_url = (string) get_the_post_thumbnail_url( $post_id, 'large' );
		}

		if ( $image_url !== '' ) {
			$gallery_items[] = array(
				'img' => $image_url,
				'alt' => get_the_title( $post_id ),
			);
		}
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

	<section class="w-full pt-0 lg:pt-[60px] pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="mb-[16px] md:mb-[20px]">
				<?php
				if ( function_exists( 'evoluer_fanclub_back_to_hub_button_html' ) ) {
					echo evoluer_fanclub_back_to_hub_button_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
					GALLERY
				</h3>
			</div>

			<?php if ( ! empty( $gallery_items ) ) : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px]">
					<?php foreach ( $gallery_items as $g ) : ?>
						<div class="group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
							<img
								src="<?php echo esc_url( $g['img'] ); ?>"
								alt="<?php echo esc_attr( $g['alt'] ); ?>"
								class="!w-full aspect-[35/37] object-cover transition-transform duration-200 group-hover:scale-[1.02]" />
						</div>
					<?php endforeach; ?>
				</div>
				<div class="flex justify-center mt-[28px] md:mt-[40px] xl:mt-[54px]">
					<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_artist_base_url' ) ? evoluer_fanclub_artist_base_url() : home_url( '/fanclub/' ) ); ?>" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
						<span class="font-bold">›</span>
						<span>もっと見る</span>
					</a>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">ギャラリーはまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>

