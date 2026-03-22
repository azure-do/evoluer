<?php
/*
Template Name: Fanclub (Member) - Movie
*/
?>

<?php
get_header('fanclub-member');

// URL /fanclub/yonekichi/movie/ → fanclub_a, /fanclub/shibuki/movie/ → fanclub_b.
$fanclub_term_slug = function_exists( 'evoluer_fanclub_term_slug_for_request' ) ? evoluer_fanclub_term_slug_for_request() : 'fanclub_a';
$movie_items       = array();
$movie_query       = new WP_Query(
	array(
		'post_type'      => 'fc-movie',
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

if ( $movie_query->have_posts() ) {
	while ( $movie_query->have_posts() ) {
		$movie_query->the_post();
		$post_id    = get_the_ID();
		$fc_video   = get_post_meta( $post_id, 'fc_video', true );
		$video_url  = '';
		$is_video   = false;
		$mime_type  = '';

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

		if ( $is_video && $video_url !== '' ) {
			$movie_items[] = array(
				'video_url' => $video_url,
				'mime_type' => $mime_type,
				'title'     => get_the_title( $post_id ),
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

	<section class="w-full pt-[60px] pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
					Movie
				</h3>
			</div>

			<?php if ( ! empty( $movie_items ) ) : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px] mt-[30px]">
					<?php foreach ( $movie_items as $index => $m ) : ?>
						<div class="js-fc-movie-card group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
							<video
								id="fc-movie-<?php echo esc_attr((string) $index); ?>"
								class="js-fc-movie-video w-full aspect-[35/37] object-cover transition-transform duration-200 group-hover:scale-[1.02]"
								preload="metadata"
								playsinline>
								<source src="<?php echo esc_url( $m['video_url'] ); ?>"<?php echo ! empty($m['mime_type']) ? ' type="' . esc_attr($m['mime_type']) . '"' : ''; ?>>
							</video>
							<button
								type="button"
								class="js-fc-movie-play absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 inline-flex items-center justify-center w-[78px] h-[78px] rounded-full bg-black/45 hover:bg-black/55 transition-colors"
								aria-label="動画を再生">
								<svg width="28" height="28" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path d="M20 12V52L52 32L20 12Z" fill="#fff" />
								</svg>
							</button>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">ムービーはまだありません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var cards = document.querySelectorAll('.js-fc-movie-card');
  cards.forEach(function (card) {
    var video = card.querySelector('.js-fc-movie-video');
    var playButton = card.querySelector('.js-fc-movie-play');
    if (!video || !playButton) {
      return;
    }

    var setPlaying = function (playing) {
      playButton.style.display = playing ? 'none' : 'inline-flex';
    };

    playButton.addEventListener('click', function () {
      if (video.paused) {
        video.play().then(function () {
          setPlaying(true);
        }).catch(function () {
          setPlaying(false);
        });
      } else {
        video.pause();
        setPlaying(false);
      }
    });

    video.addEventListener('click', function () {
      if (video.paused) {
        video.play().then(function () {
          setPlaying(true);
        }).catch(function () {
          setPlaying(false);
        });
      } else {
        video.pause();
        setPlaying(false);
      }
    });

    video.addEventListener('play', function () { setPlaying(true); });
    video.addEventListener('pause', function () { setPlaying(false); });
    video.addEventListener('ended', function () { setPlaying(false); });
  });
});
</script>

<?php get_footer(); ?>

