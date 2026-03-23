<?php
/**
 * Archive: ファンクラブギャラリー一覧（/fc-gallery/ および /fanclub/{artist}/gallery/）
 */
get_header( 'fanclub-member' );
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

			<?php
			// 外側で have_posts() を呼ばない（ループが 1 件目をスキップするため）。
			ob_start();
			$shown = 0;
			while ( have_posts() ) :
				the_post();
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

					if ( $image_url === '' ) {
						continue;
					}
					?>
					<div class="group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
						<img
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( get_the_title() ); ?>"
							class="!w-full aspect-[35/37] object-cover transition-transform duration-200 group-hover:scale-[1.02]" />
					</div>
					<?php
				++$shown;
			endwhile;
			$cards_html = ob_get_clean();
			?>
			<?php if ( $shown > 0 ) : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px]">
					<?php echo $cards_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div class="flex justify-center mt-[32px]">
					<?php
					the_posts_pagination(
						array(
							'mid_size'  => 2,
							'prev_text' => '‹',
							'next_text' => '›',
						)
					);
					?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">ギャラリーはまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
