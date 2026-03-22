<?php
/*
Template Name: Fanclub (Member) - Fanclub 1
*/
?>

<?php get_header('fanclub-member'); ?>

<?php
// Fetch fc-news posts for current Fanclub (URL /fanclub/shibuki/ … → fanclub_b, /fanclub/yonekichi/ … → fanclub_a).
$fanclub_term_slug = function_exists( 'evoluer_fanclub_term_slug_for_request' ) ? evoluer_fanclub_term_slug_for_request() : 'fanclub_a';

$news_items = array();
$news_query = new WP_Query(
	array(
		'post_type'      => EVOLUER_PT_FANCLUB_NEWS,
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => array($fanclub_term_slug),
			),
		),
		'post_status' => 'publish',
	)
);

if ($news_query->have_posts()) {
	while ($news_query->have_posts()) {
		$news_query->the_post();

		$post_id   = get_the_ID();
		$tag_names = wp_get_post_tags($post_id, array('fields' => 'names'));
		$all_meta  = get_post_meta($post_id);
		$is_out    = false;
		foreach ($all_meta as $meta_values) {
			foreach ((array) $meta_values as $meta_value) {
				$meta_value = (string) $meta_value;
				if ($meta_value === 'fc_out_news') {
					$is_out = true;
					break 2;
				}
			}
		}
		$out_link = trim((string) get_post_meta($post_id, 'out_link', true));
		$url      = $is_out && $out_link !== '' ? $out_link : get_permalink($post_id);

		$news_items[] = array(
			'date'  => get_the_date('Y/m/d'),
			'tags'  => is_array($tag_names) ? $tag_names : array(),
			'title' => get_the_title(),
			'url'   => $url,
			'is_external' => $is_out && $out_link !== '',
		);
	}
	wp_reset_postdata();
}

$gallery_items  = array();
$gallery_query = new WP_Query(
	array(
		'post_type'      => 'fc-gallery',
		'posts_per_page' => 3,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => array($fanclub_term_slug),
			),
		),
		'post_status' => 'publish',
	)
);

if ($gallery_query->have_posts()) {
	while ($gallery_query->have_posts()) {
		$gallery_query->the_post();
		$post_id   = get_the_ID();
		$fc_image  = get_post_meta($post_id, 'fc_image', true);
		$image_url = '';

		if (is_numeric($fc_image)) {
			$image_url = (string) wp_get_attachment_image_url((int) $fc_image, 'large');
		} elseif (is_array($fc_image)) {
			if (isset($fc_image['url'])) {
				$image_url = (string) $fc_image['url'];
			} elseif (isset($fc_image[0]['url'])) {
				$image_url = (string) $fc_image[0]['url'];
			}
		} elseif (is_string($fc_image)) {
			$image_url = $fc_image;
		}

		if ($image_url === '') {
			$image_url = (string) get_the_post_thumbnail_url($post_id, 'large');
		}

		if ($image_url !== '') {
			$gallery_items[] = array(
				'img' => $image_url,
				'alt' => get_the_title($post_id),
			);
		}
	}
	wp_reset_postdata();
}

$movie_items  = array();
$movie_query = new WP_Query(
	array(
		'post_type'      => 'fc-movie',
		'posts_per_page' => 6,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => array($fanclub_term_slug),
			),
		),
		'post_status' => 'publish',
	)
);

if ($movie_query->have_posts()) {
	while ($movie_query->have_posts()) {
		$movie_query->the_post();
		$post_id    = get_the_ID();
		$fc_video   = get_post_meta($post_id, 'fc_video', true);
		$video_url  = '';
		$is_video   = false;
		$mime_type  = '';

		if (is_numeric($fc_video)) {
			$attachment_id = (int) $fc_video;
			$mime_type     = (string) get_post_mime_type($attachment_id);
			$is_video      = strpos($mime_type, 'video/') === 0;
			if ($is_video) {
				$video_url = (string) wp_get_attachment_url($attachment_id);
			}
		} elseif (is_array($fc_video)) {
			$attachment_id = isset($fc_video['id']) ? (int) $fc_video['id'] : 0;
			if ($attachment_id > 0) {
				$mime_type = (string) get_post_mime_type($attachment_id);
				$is_video  = strpos($mime_type, 'video/') === 0;
				if ($is_video) {
					$video_url = (string) wp_get_attachment_url($attachment_id);
				}
			}
			if (! $is_video && isset($fc_video['type'])) {
				$mime_type = (string) $fc_video['type'];
				$is_video  = strpos($mime_type, 'video/') === 0;
			}
			if (! $is_video && isset($fc_video['url'])) {
				$video_url = (string) $fc_video['url'];
				$is_video  = (bool) preg_match('/\.(mp4|webm|ogg|mov|m4v)(\?.*)?$/i', $video_url);
			}
		} elseif (is_string($fc_video) && $fc_video !== '') {
			$video_url = $fc_video;
			$is_video  = (bool) preg_match('/\.(mp4|webm|ogg|mov|m4v)(\?.*)?$/i', $video_url);
		}

		if ($is_video && $video_url !== '') {
			$movie_items[] = array(
				'video_url' => $video_url,
				'mime_type' => $mime_type,
				'title'     => get_the_title($post_id),
			);
		}
	}
	wp_reset_postdata();
}

$ticket_items  = array();
$ticket_query = new WP_Query(
	array(
		'post_type'      => EVOLUER_PT_FANCLUB_TICKET,
		'posts_per_page' => 6,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'fc-fanclub',
				'field'    => 'slug',
				'terms'    => array($fanclub_term_slug),
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
	<section class="w-full max-w-[1130px] mx-auto px-[30px] pt-[60px] xl:pt-[100px] pb-[28px]">
		<div class="relative mb-[32px] xl:mb-[60px]">
			<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
				NEWS
			</h3>
		</div>
		<div class="bg-transparent border-t border-[#ffffff5c] overflow-hidden">
			<?php foreach ($news_items as $item) : ?>
				<a href="<?php echo esc_url(! empty($item['url']) ? $item['url'] : '#'); ?>" <?php echo ! empty($item['is_external']) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> class="group block transition-colors">
					<div class="flex items-center justify-between px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] xl:pt-[18px] xl:pb-[20px] border-b border-[#ffffff5c]">
						<div class="flex flex-col gap-[6px]">
							<div class="flex items-center gap-[8px]">
								<span class="text-[#525252] text-[14px] font-semibold"><?php echo esc_html($item['date']); ?></span>
								<?php if (! empty($item['tags'])) : ?>
									<?php foreach ($item['tags'] as $tag) : ?>
										<?php if ('NEW' === $tag) : ?>
											<span class="inline-flex items-center px-[10px] py-[2px] xl:py-[3px] bg-[#13AA05] text-white text-[12px] rounded-[3px] font-bold">
												<?php echo esc_html($tag); ?>
											</span>
										<?php else : ?>
											<span class="inline-flex items-center px-[10px] py-[2px] xl:py-[3px] bg-[#C7C7C7] text-[#333] text-[12px] rounded-[3px] font-bold">
												<?php echo esc_html($tag); ?>
											</span>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] xl:text-[18px] leading-relaxed">
								<?php echo esc_html($item['title']); ?>
							</p>
						</div>

						<span class="text-[#9DB03F] text-[20px] leading-none group-hover:translate-x-[2px] transition-transform">›</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="flex justify-center mt-[28px] md:mt-[40px] xl:mt-[54px]">
			<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcnews_archive_url' ) ? evoluer_fanclub_fcnews_archive_url() : home_url( '/fcnews/' ) ); ?>" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
				<span class="font-bold">>></span>
				<span>もっと見る</span>
			</a>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[20px] md:pb-[40px] xl:pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
					GALLERY
				</h3>
			</div>

			<?php if (! empty($gallery_items)) : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px]">
					<?php foreach ($gallery_items as $g) : ?>
						<div class="group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
							<img
								src="<?php echo esc_url($g['img']); ?>"
								alt="<?php echo esc_attr($g['alt']); ?>"
								class="!w-full aspect-[35/37] object-cover transition-transform duration-200 group-hover:scale-[1.02]" />
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">ギャラリーはまだありません。</p>
			<?php endif; ?>

			<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
				<a href="<?php echo home_url('/fanclub/shibuki/gallery/'); ?>" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
					<span class="font-bold">>></span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[20px] md:pb-[40px] xl:pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
					Movie
				</h3>
			</div>

			<?php if (! empty($movie_items)) : ?>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-[34px] mt-[30px]">
					<?php foreach ($movie_items as $index => $m) : ?>
						<div class="js-fc-movie-card group relative block rounded-[12px] overflow-hidden bg-[#C9CDD0]">
							<video
								id="fc-movie-<?php echo esc_attr((string) $index); ?>"
								class="js-fc-movie-video !w-full aspect-[35/37] object-cover transition-transform duration-200 group-hover:scale-[1.02]"
								preload="metadata"
								playsinline>
								<source src="<?php echo esc_url($m['video_url']); ?>" <?php echo ! empty($m['mime_type']) ? ' type="' . esc_attr($m['mime_type']) . '"' : ''; ?>>
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

			<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
				<a href="<?php echo home_url('/fanclub/shibuki/movie/'); ?>" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
					<span class="font-bold">>></span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>

	<section class="w-full pt-[60px] pb-[20px] md:pb-[40px] xl:pb-[80px]">
		<div class="w-full max-w-[1130px] mx-auto px-[30px]">
			<div class="relative mb-[32px] xl:mb-[60px]">
				<h3 class="tracking-[8px] text-center text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
					Ticket
				</h3>
			</div>

			<?php if ( ! empty($ticket_items) ) : ?>
				<div class="bg-transparent overflow-hidden mt-[30px]">
					<?php foreach ($ticket_items as $t) : ?>
						<a href="<?php echo esc_url( $t['url'] ); ?>" class="group block px-[4px] md:px-[8px] xl:px-[22px] py-[12px] md:pt-[18px] md:pb-[20px] xl:pt-[18px] xl:pb-[20px] border-b border-[#ffffff5c] transition-colors hover:bg-white/10">
							<span class="text-[#525252] text-[14px] font-semibold block"><?php echo esc_html( $t['date'] ); ?></span>
							<p class="text-[#222] text-[14px] lg:text-[14px] xl:text-[16px] leading-relaxed font-semibold mt-[6px] group-hover:underline">
								<?php echo esc_html($t['title']); ?>
							</p>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="text-center text-[#666] text-[14px] md:text-[16px]">チケット情報はまだありません。</p>
			<?php endif; ?>

			<div class="flex justify-center mt-[26px] md:mt-[40px] xl:mt-[54px]">
				<a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_ticket_list_url' ) ? evoluer_fanclub_ticket_list_url() : home_url( '/ticket/' ) ); ?>" class="inline-flex items-center gap-[10px] px-[30px] xl:px-[70px] py-[10px] border border-[#13AA05] !text-[#13AA05] text-[14px] rounded-[2px]">
					<span class="font-bold">>></span>
					<span>もっと見る</span>
				</a>
			</div>
		</div>
	</section>
</main>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var cards = document.querySelectorAll('.js-fc-movie-card');
		cards.forEach(function(card) {
			var video = card.querySelector('.js-fc-movie-video');
			var playButton = card.querySelector('.js-fc-movie-play');
			if (!video || !playButton) {
				return;
			}

			var setPlaying = function(playing) {
				playButton.style.display = playing ? 'none' : 'inline-flex';
			};

			playButton.addEventListener('click', function() {
				if (video.paused) {
					video.play().then(function() {
						setPlaying(true);
					}).catch(function() {
						setPlaying(false);
					});
				} else {
					video.pause();
					setPlaying(false);
				}
			});

			video.addEventListener('click', function() {
				if (video.paused) {
					video.play().then(function() {
						setPlaying(true);
					}).catch(function() {
						setPlaying(false);
					});
				} else {
					video.pause();
					setPlaying(false);
				}
			});

			video.addEventListener('play', function() {
				setPlaying(true);
			});
			video.addEventListener('pause', function() {
				setPlaying(false);
			});
			video.addEventListener('ended', function() {
				setPlaying(false);
			});
		});
	});
</script>

<?php get_footer(); ?>