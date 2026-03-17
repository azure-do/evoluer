<?php
/*
Template Name: タレント詳細
*/
?>

<?php get_header(); ?>
<?php if(have_posts()): while(have_posts()):the_post(); ?>
	<div id="container" class="artist">
		<div class="common_head_area">
			<div class="inner">
				<div class="breadcrumb pc-area">
					<ol class="breadcrumb_list">
						<li class="breadcrumb_item"><a href="<?php echo esc_url( home_url() ); ?>" class="breadcrumb_link">TOP</a></li>
						<li class="breadcrumb_item"><?php the_title(); ?></li>
					</ol>
				</div>
				<h1 class="common_pagettl">
					<span class="common_pagettl_en en-font">Artist</span>
					<span class="common_pagettl_jp jp-point-font">タレント</span>
				</h1>
			</div>
		</div>
		<div class="artist_top">
			<div class="artist_inner">
				<div class="artist_top_contents">

					<div class="left">
<?php
$profile_images= SCF::get( 'artist_images' );
if( $profile_images ):
?>
						<div class="slider_box">
							<div class="slider-for">
<?php
	foreach ($profile_images as $profile_image ):
		$img_url = wp_get_attachment_image_src( $profile_image['artist_img'], 'full' );
		if( $img_url ):
?>
								<div class="img">
									<img src="<?php echo $img_url[0]; ?>" alt="<?php the_title(); ?>プロフィール写真">
								</div>
<?php
		endif;
	endforeach;
?>
							</div>
							<div class="slider-nav">
<?php
	foreach ($profile_images as $profile_image ):
		$img_url = wp_get_attachment_image_src( $profile_image['artist_img'], 'full');
		if( $img_url ):
?>
								<div class="img">
									<img src="<?php echo $img_url[0]; ?>" alt="<?php the_title(); ?>プロフィール写真ナビゲーション">
								</div>
<?php
		endif;
	endforeach;
?>
							</div>
						</div>
<?php endif; ?>
					</div>

					<div class="right">
						<div class="artist_name_box">
							<p class="artist_name jp-point-font">
								<?php the_title(); ?><span class="en-font"><?php echo post_custom( 'name_en' ); ?></span>
							</p>
<?php
	$sns_icon_1 = post_custom( 'sns_icon_1' );
	$sns_url_1  = post_custom( 'sns_url_1' );
	$sns_icon_2 = post_custom( 'sns_icon_2' );
	$sns_url_2  = post_custom( 'sns_url_2' );

	switch ($sns_icon_1) {
		case 'insta':
?>
							<p class="insta_icon">
								<a href="<?php echo $sns_url_1; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-instagram-ico.svg" alt="instagram">
								</a>
							</p>
<?php
			break;
		case 'blog':
?>
							<p class="blog_icon">
								<a href="<?php echo $sns_url_1; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-blog-ico.svg" alt="blog">
								</a>
							</p>
<?php
			break;
		case 'home':
?>
							<p class="blog_icon">
								<a href="<?php echo $sns_url_1; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-official-ico.svg" alt="official">
								</a>
							</p>
<?php
			break;
		case 'tweeter':
?>
							<p class="blog_icon">
								<a href="<?php echo $sns_url_1; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-twitter-ico.svg" alt="tweeter">
								</a>
							</p>
<?php
			break;
	}

	switch ($sns_icon_2) {
		case 'insta':
?>
							<p class="insta_icon">
								<a href="<?php echo $sns_url_2; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-instagram-ico.svg" alt="instagram">
								</a>
							</p>
<?php
			break;
		case 'blog':
?>
							<p class="blog_icon">
								<a href="<?php echo $sns_url_2; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-blog-ico.svg" alt="blog">
								</a>
							</p>
<?php
			break;
		case 'home':
?>
							<p class="blog_icon">
								<a href="<?php echo $sns_url_2; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-official-ico.svg" alt="official">
								</a>
							</p>
<?php
			break;
		case 'tweeter':
?>
							<p class="blog_icon">
								<a href="<?php echo $sns_url_2; ?>" target="blank" rel="noopener">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-twitter-ico.svg" alt="tweeter">
								</a>
							</p>
<?php
			break;
	}
?>
						</div>

						<table class="artist_profile jp-point-font">
<?php
	$profiles = SCF::get( 'artist_profiles' );
	if( $profiles ):
		foreach ($profiles as $profile ):
?>
							<tr>
								<th>
									<?php echo $profile['profile_title'];?>
								</th>
								<td>
									<?php echo $profile['profile_detail'];?>
								</td>
							</tr>
<?php
		endforeach;
	endif;
?>
						</table>

						<div class="artist_linkbtn">
							<ul class="artist_flex">
<?php if( post_custom( 'disp_official_twitter' ) == 'on'): ?>
								<li>
									<a href="https://twitter.com/shibuki_staff" target="blank" rel="noopener"><span class="twitter">エヴォリュエ公式Twitter</span></a>
								</li>
<?php endif; ?>
<?php if( post_custom( 'disp_online_shop' ) == 'on'): ?>
								<li class="soon">
									<a href="<?php echo esc_url( home_url() ); ?>"><span class="online">オンラインショップ</span></a>
									<p class="comingsoon">coming soon</p>
								</li>
<?php endif; ?>
<?php if( post_custom( 'fc-entry_url' ) ): ?>
								<li>
									<a href="<?php echo post_custom( 'fc-entry_url' ); ?>" target="blank" rel="noopener"><span class="funclub">ファンクラブ</span></a>
								</li>
<?php endif; ?>
								<li class="layer_stage"><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span class="stage">出演依頼</span></a></li>
							</ul>
						</div>
					</div>
				</div>

<?php
	$news_slug = post_custom( 'select_news_cat' );

	global $post;
	$news_args = array(
		'post_status'    => 'publish',
		'post_type'      => 'news',
		'tax_query'      => array(
			array(
				'taxonomy' => 'news-cat',
				'field'    => 'slug',
				'terms'    => $news_slug
			)
		),
		'posts_per_page' => 2,
		'order'          => 'DESC',
		'orderby'        => 'post_date',
	);
	$newsPosts = get_posts($news_args);
	if( $newsPosts ):
?>
			<div id="news" class="artist_news">
				<div class="artist_inner">
					<h3 class="artist_newsttl en-font">News<span class="jp-point-font">最新情報</span></h3>
					<div class="artist_newssbox">
		<?php foreach($newsPosts as $post ) : setup_postdata( $post ); ?>
						<div class="artist_news_card">
			<?php if( post_custom('news_link') ):?>
							<a href="<?php echo post_custom('news_link');?>" target="blank" rel="noopener">
			<?php endif; ?>
								<p class="year jp-point-font"><?php the_time('Y.m.d'); ?></p>
								<h4 class="news_card_ttl"><?php the_title(); ?></h4>
								<p class="news_card_txt"><?php the_content(); ?></p>
			<?php if( post_custom('news_link') ):?>
							</a>
			<?php endif; ?>
						</div>
		<?php endforeach; ?>
					</div>
				</div>
			</div>
<?php
		wp_reset_postdata();
	endif;
?>

<?php
	$schedule_slug  = post_custom( 'select_schedule_cat' );
	$taxonomy       = 'schedule-cat';
	$schedule_term  = get_term_by('slug', $schedule_slug, $taxonomy );
	$term_id        = $schedule_term->term_id;
	$sc_child_terms = get_term_children( $term_id, $taxonomy );

	$cnt_args = array(
		'post_status'    => 'publish',
		'post_type'      => 'schedule',
		'tax_query'      => array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $schedule_slug
			)
		),
		'posts_per_page' => 1
	);
	$cntPosts = get_posts($cnt_args);
	wp_reset_postdata();

	//スケジュールが1件以上登録されているかどうか
	if( $cntPosts ):
?>
			<div id="schedule" class="artist_schedule">
				<div class="artist_inner">
					<h3 class="artist_schedulettl en-font">Schedule<span class="jp-point-font">出演情報</span></h3>
		<?php if( $sc_child_terms && !is_wp_error($sc_child_terms) ): ?>
					<div class="pc_schedule_box pc-area">

						<div class="tab_area">
							<ul>
<?php
			$first_flg = true;
			foreach( $sc_child_terms as $child_term_id ):
				$child_term = get_term( $child_term_id, $taxonomy );
				if ( $first_flg ):
?>
								<li class="en-font tab active"><?php echo $child_term->name; ?></li>
<?php
					$first_flg = false;
				else:
?>
								<li class="en-font tab"><?php echo $child_term->name; ?></li>
<?php
				endif;
			endforeach;
?>
							</ul>
						</div>

<?php
			$first_flg = true;
			foreach( $sc_child_terms as $child_term_id ):
				$child_term = get_term( $child_term_id, $taxonomy );
				$schedule_args = array(
					'post_status'    => 'publish',
					'post_type'      => 'schedule',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'schedule-cat',
							'field'    => 'slug',
							'terms'    => $child_term->slug
						)
					),
					//'orderby'  => array(
					//  'public_date' => 'DESC',	//出演日降順
					//  'date'       => 'DESC'		//投稿日降順
					//)
					'order'          => 'DESC',
					'orderby'        => 'post_date',
				);
				$schedulePosts = get_posts($schedule_args);
				if($first_flg):
?>
						<div class="s_content show">
<?php
					$first_flg = false;
				else:
?>
						<div class="s_content">
<?php
				endif;
				if( $schedulePosts ):
					foreach($schedulePosts as $post ) : setup_postdata( $post );
?>
							<dl>
								<dt><?php echo post_custom( 'appearance_date' ); ?></dt>
								<dd>
									<?php the_title();?><br>
									<?php echo nl2br( post_custom( 'appearance_detail' ) ); ?>
								</dd>
							</dl>
<?php
					endforeach;
				else:
?>
							<dl>
								<dt style="width:40%;"><?php echo $child_term->name; ?>の出演情報はありません</dt>
								<dd>&nbsp;</dd>
							</dl>
<?php
				endif;
				wp_reset_postdata();
?>
						</div>
<?php
			endforeach;
?>
						</div>

						<div class="sp_schedulebox mb-area">
<?php
	foreach( $sc_child_terms as $child_term_id ):
		$child_term = get_term( $child_term_id, $taxonomy );
		$schedule_args = array(
			'post_status'    => 'publish',
			'post_type'      => 'schedule',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'schedule-cat',
					'field'    => 'slug',
					'terms'    => $child_term->slug
				)
			),
			//'orderby'  => array(
			//  'public_date' => 'DESC',	//出演日降順
			//  'date'       => 'DESC'		//投稿日降順
			//)
			'order'          => 'DESC',
			'orderby'        => 'post_date',
		);
		$schedulePosts = get_posts($schedule_args);
?>
							<div class="sp_schedule_list">
								<div class="schedule_accdttl js_accd en-font">
									<p><?php echo $child_term->name; ?></p>
								</div>
								<div class="schedule_accdcont">
<?php
		if( $schedulePosts ):
			foreach($schedulePosts as $post ) : setup_postdata( $post );
 ?>
									<dl>
										<dt><?php echo post_custom( 'appearance_date' ); ?></dt>
										<dd>
											<?php the_title();?><br>
											<?php echo nl2br( post_custom( 'appearance_detail' ) ); ?>
										</dd>
									</dl>
<?php
			endforeach;
		else:
?>
									<dl>
										<dt style="width:70%;"><?php echo $child_term->name; ?>の出演情報はありません</dt>
										<dd>&nbsp;</dd>
									</dl>
<?php
		endif;
		wp_reset_postdata();
?>
								</div>
							</div>
<?php
	endforeach;
?>
						</div>

		<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="artist_banner_under">
				<div class="artist_inner">
					<div class="banner_contents">
<?php
	// 2023/03 追加箇所
	$banner_uppers = SCF::get( 'banner_under' );
	if( $banner_uppers ):
?>
						<ul>
<?php
		foreach ( $banner_uppers as $banner_upper ):
			$img_url = wp_get_attachment_image_src( $banner_upper['banner_under_img'], 'full' );
			if( $img_url ):
?>
							<li>
	<?php if( $banner_upper['banner_under_url'] ) : ?>
								<a href="<?php echo $banner_upper['banner_under_url']; ?> " target="_blank">
									<img src="<?php echo $img_url[0]; ?>" alt="">
								</a>
	<?php else: ?>
								<img src="<?php echo $img_url[0]; ?>" alt="">
	<?php endif;?>
							</li>
<?php
			endif;
		endforeach;
?>
						</ul>
	<?php endif;?>
					</div>

				</div>
			</div>
	<?php endif; ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
