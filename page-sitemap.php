<?php
/*
Template Name: サイトマップ
*/
?>

<?php get_header(); ?>
<div id="container" class="sitemap">
  <div class="common_head_area">
    <div class="inner">
      <div class="breadcrumb pc-area">
        <ol class="breadcrumb_list">
          <li class="breadcrumb_item"><a href="<?php echo esc_url( home_url() ); ?>" class="breadcrumb_link">TOP</a></li>
          <li class="breadcrumb_item">サイトマップ</li>
        </ol>
      </div>
      <h1 class="common_pagettl">
        <span class="common_pagettl_en en-font">Site Map</span>
        <span class="common_pagettl_jp jp-point-font">サイトマップ</span>
      </h1>
    </div>
  </div><!-- /common_head_area-->
  <div class="sitemap_box">
    <div class="sitemap_inner">
      <div class="sitemap_cont">
        <!-- sitemap_line----->
        <div class="sttemap_line">
          <div class="item">
            <h3 class="site_ttl"><a href="<?php echo esc_url( home_url() ); ?>">トップページ</a></h3>
          </div>
          <div class="item">
            <h3 class="site_ttl e_none"><a href="javascript:void(0)">タレント</a></h3>
            <ul>
              <li><a href="<?php echo esc_url( home_url( '/artist/shibuki/' ) ); ?>">紫吹 淳</a></li>
              <li><a href="<?php echo esc_url( home_url( '/artist/nakamura/' ) ); ?>">中村 米吉</a></li>
              <li><a href="<?php echo esc_url( home_url('/artist/shiratori/' ) ); ?>">白鳥 かすが</a></li>
              <li><a href="<?php echo esc_url( home_url( '/artist/shiho/' ) ); ?>">SHIHO</a></li>
              <li><a href="<?php echo esc_url( home_url( '/artist/saki/' ) ); ?>">SAKI</a></li>
              <li><a href="<?php echo esc_url( home_url( '/artist/nao/' ) ); ?>">NAO</a></li>
            </ul>
          </div>
        </div>

        <div class="sttemap_line">
          <div class="item">
            <h3 class="site_ttl e_none"><a href="<?php echo esc_url( home_url( '/fc-entry/shibuki/' ) ); ?>">ファンクラブ</a></h3>
            <ul>
              <li><a href="<?php echo esc_url( home_url( '/fc-entry/shibuki/' ) ); ?>">紫吹 淳</a></li>
            </ul>
          </div>
          <div class="item">
            <h3 class="site_ttl"><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問合せ・出演依頼</a></h3>
          </div>
          <div class="item">
            <h3 class="site_ttl"><a href="<?php echo esc_url( home_url( '/company/' ) ); ?>">会社情報</a></h3>
          </div>
          <div class="item online-item">
            <h3 class="site_ttl shop_soon"><a href="javascript:void(0)">オンラインショップ</a></h3>
            <p class="soon">coming soon</p>
          </div>
        </div>
        <!-- sitemap_line- -->
        <div class="sttemap_line">
          <div class="item">
            <h3 class="site_ttl"><a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">プライバシーポリシー</a></h3>
          </div>
          <!-- <div class="item">
            <h3 class="site_ttl"><a href="javascript:void(0)">ご利用規約</a></h3>
          </div> -->
          <div class="item">
            <h3 class="site_ttl"><a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>">サイトマップ</a></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
<?php get_footer(); ?>