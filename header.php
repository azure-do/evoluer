<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-T748JC6');
  </script>
  <!-- End Google Tag Manager -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <?php
  $page_title       = "エヴォリュエ - Evoluer｜芸能プロダクション事務所";
  $page_type        = "article";
  $page_description = "芸能プロダクション事務所、株式会社エヴォリュエへの公式サイトです。";

  if (is_home() || is_front_page()) {
    $page_title = "エヴォリュエ - Evoluer｜芸能プロダクション事務所";
    $page_type  = "website";
    $page_description = "芸能プロダクション事務所、株式会社エヴォリュエへの公式サイトです。紫吹淳、中村米吉、白鳥 かすが　他所属";
  } elseif (is_page('contact')) {
    $page_title = get_the_title() . "｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
    $page_description = "芸能プロダクション事務所、株式会社エヴォリュエへのお問合せ・出演依頼はこちらから。";
  } elseif (is_page()) {
    $page_title = get_the_title() . "｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
    $page_description = "芸能プロダクション事務所、株式会社エヴォリュエの" . get_the_title() . "です。";
  } elseif (is_singular('fc-entry')) {
    $page_title = get_the_title() . "｜ファンクラブ｜エヴォリュエ - Evoluer";
    $page_description = "エヴォリュエ所属アーティスト、" . get_the_title() . "公式ファンクラブへのご入会はこちらから。";
  } elseif (is_singular('artist')) {
    $page_title = get_the_title() . "｜アーティスト｜エヴォリュエ - Evoluer";
    if (is_single(array(20))) {
      //紫吹淳
      $page_description = "エヴォリュエ所属アーティスト、" . get_the_title() . "の公式プロフィールページです。出演情報、最新情報、ファンクラブ入会はこちらから。";
    } else {
      $page_description = "エヴォリュエ所属アーティスト、" . get_the_title() . "の公式プロフィールページです。出演情報、最新情報はこちらから。";
    }
  } elseif (is_single()) {
    $page_title = get_the_title() . "｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
  } elseif (is_post_type_archive('')) {
    $page_title = " 一覧 ｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
  } elseif (is_category()) {
    $page_title = single_cat_tile() . "｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
  } elseif (is_search()) {
    $page_title = "検索結果 ｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
  } elseif (is_404()) {
    $page_title = "指定されたページが見つかりません｜エヴォリュエ - Evoluer｜芸能プロダクション事務所";
  }
  ?>
  <meta name="Keywords" content="エヴォリュエ,Evoluer,紫吹淳" />
  <meta name="description" content="<?php echo $page_description; ?>" />
  <meta property="og:url" content="<?php echo get_the_permalink(); ?>" />
  <meta property="og:type" content="<?php echo $page_type ?>" />
  <meta property="og:title" content="<?php echo $page_title ?>" />
  <meta property="og:description" content="<?php echo $page_description; ?>" />
  <meta property="og:site_name" content="エヴォリュエ - Evoluer｜芸能プロダクション事務所" />
  <meta property="og:image" content="<?php echo esc_url(home_url()); ?>/ogp.jpg" />
  <title><?php echo $page_title ?></title>
  <link rel="shortcut icon" href="<?php echo esc_url(home_url()); ?>/favicon.ico" type="image/x-icon">
  <!-- iOS Safari and Chrome -->
  <link rel="apple-touch-icon" href="<?php echo esc_url(home_url()); ?>/apple-touch-icon.png" sizes="128x128">
  <!-- Android標準ブラウザ(一部) -->
  <link rel="shortcut icon" href="<?php echo esc_url(home_url()); ?>/android-touch-icon.png" sizes="128x128">
  <?php wp_head(); ?>
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T748JC6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div id="wrapper">
    <header class="pc-area">
      <div class="mb mb-cont-no">
        <h1 class="header_logo pc-area">
          <a href="<?php echo esc_url(home_url()); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_pc.svg" alt="Evoluer" />
          </a>
        </h1>
        <nav class="header_content" id="menu">
          <ul class="header_list">
            <li>
              <p class="header_list_item"><a class="jp-point-font" href="<?php echo esc_url(home_url()); ?>">トップ<br><span class="en-font">Top</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item header_list_has_under"><a class="jp-point-font" href="javascript:void(0)">タレント<br><span class="en-font">Artist</span></a><span class="header_list_has_under_button"></span></p>
              <div class=" menu_contents">
                <ul class="header_list_sub">
                  <?php
                  global $post;
                  $artist_args = array(
                    'post_status'    => 'publish',
                    'post_type'      => 'artist',
                    'posts_per_page' => -1,
                    'order'          => 'ASC',
                    'orderby'        => 'post_date',
                  );
                  $artistPosts = get_posts($artist_args);
                  if ($artistPosts) :
                    foreach ($artistPosts as $post) : setup_postdata($post);
                  ?>
                      <li>
                        <p>
                          <a href="<?php the_permalink(); ?>">― <?php the_title(); ?></a>
                        </p>
                      </li>
                  <?php
                    endforeach;
                  endif;
                  ?>
                </ul>
              </div>
            </li>
            <li>
              <p class="header_list_item">
                <a class="jp-point-font" href="<?php echo esc_url(home_url()); ?>#news">最新情報<br><span class="en-font">News</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="jp-point-font" href="<?php echo esc_url(home_url()); ?>#schedule">出演情報<br><span class="en-font">Schedule</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="jp-point-font" href="<?php echo esc_url(home_url('/fc-entry/shibuki/')); ?>">ファンクラブ<br><span class="en-font">Fan Club</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="no-link jp-point-font" href="javascript:void(0)">オンラインショップ<br><span class="en-font">Comming Soon</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="jp-point-font" href="<?php echo esc_url(home_url('/contact/')); ?>">出演依頼<br><span class="en-font">Contact</span></a>
              </p>
            </li>
          </ul>
          <!-- <p class="header_contact_button"><a class="jp-point-font" href="<//?php echo esc_url(home_url('/contact/')); ?>"><span>出演依頼<br><span class="small en-font">Contact</span></span></a></p> -->
        </nav>
      </div>
    </header>
    <div id="header" class="mb-header">
      <div class="mb pc-cont-no">
        <h1 class="header_logo">
          <a href="<?php echo esc_url(home_url()); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_pc.svg" alt="Evoluer" />
          </a>
        </h1>
        <div class="header_nav_button">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <nav class="header_content">
          <ul class="header_list">
            <li>
              <p class="header_list_item"><a class="jp-point-font" href="<?php echo esc_url(home_url()); ?>">トップ<span class="en-font">Top</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item header_list_has_under"><a class="jp-point-font" href="javascript:void(0)">タレント<span class="en-font">Artist</span></a><span class="header_list_has_under_button"></span></p>
              <ul class="header_list_sub">
                <?php
                if ($artistPosts) :
                  foreach ($artistPosts as $post) : setup_postdata($post);
                ?>
                    <li>
                      <p>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                      </p>
                    </li>
                <?php
                  endforeach;
                endif;
                wp_reset_postdata();
                ?>
              </ul>
            </li>
            <li>
              <p class="header_list_item anchor-linkclose">
                <a class="jp-point-font" href="<?php echo esc_url(home_url()); ?>#news">最新情報<span class="en-font">News</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item anchor-linkclose">
                <a class="jp-point-font" href="<?php echo esc_url(home_url()); ?>#schedule">出演情報<span class="en-font">Schedule</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="jp-point-font" href="<?php echo esc_url(home_url('/fc-entry/shibuki/')); ?>">ファンクラブ<span class="en-font">Fan Club</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="no-link jp-point-font" href="javascript:void(0)">オンラインショップ<span class="en-font">Comming Soon</span></a>
              </p>
            </li>
            <li>
              <p class="header_list_item">
                <a class="jp-point-font" href="<//?php echo esc_url(home_url('/contact/')); ?>">出演依頼<span class="en-font">Contact</span></a>
              </p>
            </li>
            <li>
              <!-- <li class="sp">
              <p class="header_list_item"><a class="jp-point-font" href="<//?php echo esc_url(home_url('/contact/')); ?>">出演依頼<span class="en-font">Contact</span></a></p>
            </li> -->
          </ul>
        </nav>
      </div>
    </div>