<?php
/*
Template Name: 404.php
*/
?>

<?php get_header(); ?>
<!-- 404 -->
<div id="container">
  <div class="common_head_area">
    <div class="inner">
      <div class="breadcrumb pc-area">
        <ol class="breadcrumb_list">
          <li class="breadcrumb_item"><a href="<?php echo esc_url( home_url() ); ?>" class="breadcrumb_link">TOP</a></li>
          <li class="breadcrumb_item">404 Not found</li>
        </ol>
      </div>
      <h1 class="common_pagettl">
        <span class="common_pagettl_en en-font">404 Not found</span>
        <span class="common_pagettl_jp jp-point-font">ページが見つかりません</span>
      </h1>
    </div>
  </div>
  <section class="common_section">
    <div class="inner">
      <br><br><br>お探しのページは見つかりませんでした。
    </div>
  </section>
</div>
<?php get_footer(); ?>