<?php
/*
Template Name: Front-Page
*/
?>

<?php get_header(); ?>
<div id="container">
  <div class="scrolldown-img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/scrollDown.png" alt="scrolldown"></div>
  <div class="top_mv mb-area">
    <div class="mv-artist">
      <ul class="slider-wrap slider">
        <li><img src="<?php echo get_template_directory_uri(); ?>/assets/images/shibuki_mv01_mb.png" alt="紫吹淳"></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/assets/images/nakamura_mv02_mb.png" alt="中村米吉"></li>
      </ul>
    </div>
  </div>
  <div class="top_mv pc-area">
    <div class="mv-artist">
      <ul class="slider-wrap slider">
        <li><img src="<?php echo get_template_directory_uri(); ?>/assets/images/shibuki_mv01_pc.png" alt="紫吹淳"></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/assets/images/nakamura_mv02_pc.png" alt="中村米吉"></li>
      </ul>
    </div>
  </div>
  <div class="sec-artist">
    <div class="ttl-box">
      <div class="backStr en-font">ARTIST</div>
      <h3 class="frontStr en-font">Artist<br><span class="jp-point-font">タレント</span></h3>
    </div>
    <div class="inner">
      <div class="artist-phot-info">
        <div class="phot-wrap">
          <ul>
            <li class="phot-bundle">
              <div class="big-size">
                <a ontouchstart="" href="<?php echo get_post_meta( 442 ,'artist_list_1st_link', true); ?>">
                  <dl class="artist-name">
                    <dt><?php echo get_post_meta( 442 ,'artist_list_1st_name', true); ?></dt>
                    <dd class="en-font"><?php echo get_post_meta( 442 ,'artist_list_1st_ruby', true); ?></dd>
                  </dl>
<?php
  $img_url_mb = wp_get_attachment_image_src( get_post_meta( 442 ,'artist_list_1st_mb_img', true), 'full' );
  $img_url_pc = wp_get_attachment_image_src( get_post_meta( 442 ,'artist_list_1st_pc_img', true), 'full' );
?>
                  <img class="mb-area" src="<?php echo $img_url_mb[0]; ?>" alt="<?php echo get_post_meta( 442 ,'artist_list_1st_name', true); ?>">
                  <img class="pc-area" src="<?php echo $img_url_pc[0]; ?>" alt="<?php echo get_post_meta( 442 ,'artist_list_1st_name', true); ?>">
                </a>
              </div>
            </li>
            <li class="phot-bundle">
<?php
  $artist_list_group_set = SCF::get( 'artist_list_medium', 442 );
  foreach ( $artist_list_group_set as $field_name => $field_value ) :
?>
              <div class="medium-size">
                <a ontouchstart="" href="<?php echo esc_html( $field_value['artist_list_medium_link'] ); ?>">
                  <dl class="artist-name">
                    <dt><?php echo esc_html( $field_value['artist_list_medium_name'] ); ?></dt>
                    <dd class="en-font"><?php echo esc_html( $field_value['artist_list_medium_ruby'] ); ?></dd>
                  </dl>

<?php
    $img_url_mb = wp_get_attachment_image_src( $field_value['artist_list_medium_mb_img'], 'full' );
    $img_url_pc = wp_get_attachment_image_src( $field_value['artist_list_medium_pc_img'], 'full' );
?>
                  <img class="mb-area" src="<?php echo $img_url_mb[0]; ?>" alt="<?php echo esc_html( $field_value['artist_list_medium_name'] ); ?>">
                  <img class="pc-area" src="<?php echo $img_url_pc[0]; ?>" alt="<?php echo esc_html( $field_value['artist_list_medium_name'] ); ?>">
                </a>
              </div>
<?php
  endforeach;
?>
            </li>


            <li class="phot-bundle">
<?php
  $artist_list_group_set = SCF::get( 'artist_list_small', 442 );
  $artist_cnt = 1;
  foreach ( $artist_list_group_set as $field_name => $field_value ) :
    if( $artist_cnt == 4 ):
?>
            </li>
            <li class="phot-bundle">
<?php
    endif;
?>
              <div class="small-size">
                <a ontouchstart="" href="<?php echo esc_html( $field_value['artist_list_small_link'] ); ?>">
                  <dl class="artist-name">
                    <dt><?php echo esc_html( $field_value['artist_list_small_name'] ); ?></dt>
                    <dd class="en-font"><?php echo esc_html( $field_value['artist_list_small_ruby'] ); ?></dd>
                  </dl>

<?php
    $img_url_mb = wp_get_attachment_image_src( $field_value['artist_list_small_mb_img'], 'full' );
    $img_url_pc = wp_get_attachment_image_src( $field_value['artist_list_small_pc_img'], 'full' );
?>
                  <img class="mb-area" src="<?php echo $img_url_mb[0]; ?>" alt="<?php echo esc_html( $field_value['artist_list_small_name'] ); ?>">
                  <img class="pc-area" src="<?php echo $img_url_pc[0]; ?>" alt="<?php echo esc_html( $field_value['artist_list_small_name'] ); ?>">
                </a>
              </div>
<?php
    $artist_cnt++;
  endforeach;

  if( $artist_cnt <= 6  && $artist_cnt != 4 ):
    for ($i = $artist_cnt; $i <= 6; $i++):
?>
              <div class="small-size">

                  <img class="mb-area" src="<?php echo get_template_directory_uri(); ?>/assets/images/news_noimage.png" alt="evoluer">
                  <img class="pc-area" src="<?php echo get_template_directory_uri(); ?>/assets/images/news_noimage.png" alt="evoluer">

              </div>
<?php
    endfor;
  endif;
?>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>

  <div id="news" class="sec-news">
    <div class="inner">
      <div class="ttl-box">
        <h3 id="t_news" class="frontStr en-font">News<br class="mb-area"><span class="jp-point-font">最新情報</span></h3>
      </div>
      <div class="news-wrap mb-area">
        <ul class="slider multiple-item">
<?php
global $post;
$news_args = array(
  'post_status'    => 'publish',
  'post_type'      => 'news',
  'posts_per_page' => 5,
  'order'          => 'DESC',
  'orderby'        => 'post_date',
);
$newsPosts = get_posts($news_args);
if ($newsPosts) :
  foreach ($newsPosts as $post) : setup_postdata($post);
    $terms = get_the_terms($post->ID, 'news-cat');
    $term_slug  = "";
    $term_name  = "";
    if( $terms && !is_wp_error($terms) ):
      foreach ($terms as $term) :
        $term_slug  = mb_substr($term->slug, 5);
        $term_name  = $term->name;
        break;
      endforeach;
    endif;
    //リンク設定
    $link_flg = false;
    $link_url = "";
    //外部リンク設定
    if( post_custom('news_link') ):
      $link_flg = true;
      $link_url = post_custom('news_link');
    endif;
    //アンカーリンク設定
    $ankers = get_post_meta( $post->ID, 'use_anker', false );
    foreach( $ankers as $anker ):
      if ( $anker == 'on' ):
        $link_flg = true;
        $link_url = esc_url(home_url())."/artist/".$term_slug."#news";
      endif;
      break;
    endforeach;
?>
          <li class="news-bandle">
    <?php if( $link_flg ): ?>
            <a href="<?php echo $link_url;?>">
    <?php endif; ?>
              <div class="individual">
                <div class="indi-name">
                  <div>
                    <p class="jp-point-font">
                      <span><?php the_time('Y.m.d'); ?></span><br>
                      <?php echo $term_name; ?>
                    </p>
                  </div>
                  <p class="det-txt"><?php the_title(); ?></p>
                </div>
              </div>
    <?php if( $link_flg ): ?>
            </a>
    <?php endif; ?>
          </li>
<?php
  endforeach;
endif;
?>
        </ul>
      </div>

      <div class="news-wrap pc-area">
        <ul>
<?php
if ($newsPosts) :
  foreach ($newsPosts as $post) : setup_postdata($post);
    $terms      = get_the_terms($post->ID, 'news-cat');
    $term_slug  = "";
    $term_name  = "";
    if( $terms && !is_wp_error($terms) ):
      foreach ($terms as $term) :
        $term_slug  = mb_substr($term->slug, 5);
        $term_name  = $term->name;
        break;
      endforeach;
    endif;
    //リンク設定
    $link_flg = false;
    $link_url = "";
    //外部リンク設定
    if( post_custom('news_link') ):
      $link_flg = true;
      $link_url = post_custom('news_link');
    endif;
    //アンカーリンク設定
    $ankers = get_post_meta( $post->ID, 'use_anker', false );
    foreach( $ankers as $anker ):
      if ( $anker == 'on' ):
        $link_flg = true;
        $link_url = esc_url(home_url())."/artist/".$term_slug."#news";
      endif;
      break;
    endforeach;
?>
          <li class="news-bandle">
    <?php if( $link_flg ): ?>
            <a href="<?php echo $link_url;?>">
    <?php endif; ?>
              <div class="individual">
                <div class="indi-name">
                  <div>
                    <p class="jp-point-font">
                      <span><?php the_time('Y.m.d'); ?></span><br>
                      <?php echo $term_name; ?>
                    </p>
                  </div>
                  <p class="det-txt"><?php the_title(); ?></p>
                </div>
              </div>
    <?php if( $link_flg ): ?>
            </a>
    <?php endif; ?>
          </li>
<?php
  endforeach;
endif;
wp_reset_postdata();
?>
        </ul>
      </div>
    </div>
  </div>

  <div id="schedule" class="sec-schedule">
    <div class="inner">
      <div class="ttl-box">
        <div class="backStr en-font">SCHEDULE</div>
        <h3 id="t_schedule" class="frontStr en-font">Schedule<br class="sp-none"><span class="jp-point-font">出演情報</span></h3>
      </div>
      <div class="artist-phot-info">
        <div class="phot-wrap">
          <ul>
<?php
//date_default_timezone_set('Asia/Tokyo');
$start_date = date("Y/m/d");
$end_date   = date("Y/m/d", strtotime("+7 day"));

$schedule_args = array(
  'post_status'    => 'publish',
  'post_type'      => 'schedule',
  'posts_per_page' => -1,
  'meta_query'     => array(
      array(
        'key'      => 'public_date',
        'value'    => array( $start_date, $end_date ),
        'compare'  => 'BETWEEN',
        'type'     => 'DATE',
      ),
  ),
  'orderby' => array(
    'public_date' => 'DESC',	//出演日降順
    'date'        => 'DESC'		//投稿日降順
  )

);
$schedulePosts = get_posts($schedule_args);
if ($schedulePosts) :
  foreach ($schedulePosts as $post) : setup_postdata($post);
    $terms            = get_the_terms($post->ID, 'schedule-cat');
    foreach ($terms as $term) :
      $term_name      = $term->name;
      $parent_term_id = $term->parent;
      break;
    endforeach;
    $parent_term      = get_term( $parent_term_id );
    $parent_term_name = $parent_term->name;
    $parent_term_slug = mb_substr( $parent_term->slug, 3 );
    $artist_icon      = SCF::get_term_meta( $parent_term_id, 'schedule-cat', 'artist_icon' );
    $artist_icon_pc   = wp_get_attachment_image_src( $artist_icon, 'artist_icon_pc' );
    $artist_icon_mb   = wp_get_attachment_image_src( $artist_icon, 'artist_icon_mb' );
?>
                <li class="indivi-news">
                  <a href="<?php echo esc_url(home_url()); ?>/artist/<?php echo $parent_term_slug ?>#schedule">
                    <div class="artist-schedule">
                      <div class="min-photbox">
                        <img class="mb-area" src="<?php echo $artist_icon_mb[0]; ?>" alt="<?php echo $parent_term_name; ?>">
                        <img class="pc-area" src="<?php echo $artist_icon_pc[0]; ?>" alt="<?php echo $parent_term_name; ?>">
                      </div>
                      <div class="news-box">
                        <div class="date jp-point-font"><?php echo post_custom( 'public_date' ); ?>｜<span><?php echo $term_name; ?></span></div>
                        <p class="det-txt"><?php the_title(); ?></p>
                      </div>
                    </div>
                  </a>
                </li>
<?php
  endforeach;
endif;
wp_reset_postdata();
?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
