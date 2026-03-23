<?php
/**
 * Archive: ファンクラブ動画一覧（/fc-movie/ および /fanclub/{artist}/movie/）
 */
if ( function_exists( 'evoluer_enqueue_fc_movie_player_script' ) ) {
	evoluer_enqueue_fc_movie_player_script();
}
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
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
					Movie
				</h3>
			</div>

			<?php
			ob_start();
			$index = 0;
			while ( have_posts() ) :
				the_post();
					$post_id   = get_the_ID();
					$fc_video  = get_post_meta( $post_id, 'fc_video', true );
					$video_url = '';
					$is_video  = false;
					$mime_type = '';

					if ( is_numeric( $fc_video ) ) {
						$attachment_id = (int) $fc_video;
						$mime_type     = (string) get_post_mime_type( $attachment_id );
						$is_video      = strpos( $mime_type, 'video/' ) === 0;
						if ( $is_video ) {
							$video_url = (string) wp_get_attachment_url( $attachment_id );
						}
					} elseif ( is_array( $fc_video ) ) {
						$attachment_id = isset( $fc_video['id'] ) ? (int) $fc_video['id'] : 0;
						if ( $attachment_id > 0 ) {
							$mime_type = (string) get_post_mime_type( $attachment_id );
							$is_video  = strpos( $mime_type, 'video/' ) === 0;
							if ( $is_video ) {
								$video_url = (string) wp_get_attachment_url( $attachment_id );
							}
						}
						if ( ! $is_video && isset( $fc_video['type'] ) ) {
							$mime_type = (string) $fc_video['type'];
							$is_video  = strpos( $mime_type, 'video/' ) === 0;
						}
						if ( ! $is_video && isset( $fc_video['url'] ) ) {
							$video_url = (string) $fc_video['url'];
							$is_video  = (bool) preg_match( '/\.(mp4|webm|ogg|mov|m4v)(\?.*)?$/i', $video_url );
						}
					} elseif ( is_string( $fc_video ) && $fc_video !== '' ) {
						$video_url = $fc_video;
						$is_video  = (bool) preg_match( '/\.(mp4|webm|ogg|mov|m4v)(\?.*)?$/i', $video_url );
					}

					if ( ! $is_video || $video_url === '' ) {
						continue;
					}
					?>
					<div class="js-fc-movie-card group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
						<video
							id="fc-movie-<?php echo esc_attr( (string) $index ); ?>"
							class="js-fc-movie-video !w-full aspect-[35/37] object-cover transition-transform duration-200 group-hover:scale-[1.02]"
							preload="metadata"
							playsinline>
							<source src="<?php echo esc_url( $video_url ); ?>"<?php echo $mime_type !== '' ? ' type="' . esc_attr( $mime_type ) . '"' : ''; ?>>
						</video>
						<?php get_template_part( 'template-parts/fc-movie-card-controls' ); ?>
					</div>
					<?php
				++$index;
			endwhile;
			$cards_html = ob_get_clean();
			?>
			<?php if ( $index > 0 ) : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px] mt-[30px]">
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
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">ムービーはまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
