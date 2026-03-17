<?php
/*
Template Name: お問い合わせ
*/
?>

<?php get_header(); ?>
<div id="container">
<?php if(have_posts()): while(have_posts()):the_post(); ?>
  <div class="common_head_area">
    <div class="inner">
      <div class="breadcrumb pc-area">
        <ol class="breadcrumb_list">
          <li class="breadcrumb_item"><a href="<?php echo esc_url( home_url() ); ?>" class="breadcrumb_link">TOP</a></li>
          <li class="breadcrumb_item">お問い合わせ</li>
        </ol>
      </div>
      <h1 class="common_pagettl">
          <span class="common_pagettl_en en-font">Contact</span>
          <span class="common_pagettl_jp jp-point-font">お問い合わせ・出演依頼</span>
      </h1>
    </div><!-- /common_head_area-->
  </div>

  <div class="common_section contact_form">
    <div class="inner">
      <div class="form_confirm_area">
        <p class="read_txt">
          入力内容にお間違いがないかご確認の上、「送信」ボタンを押してください。<br>
          再度入力される場合は「戻る」ボタンを押してください。
        </p>
      </div>
      <div class="form_area">
        <?php the_content(); ?>
      </div>
      <div class="form_complete_area">
        <p class="read_txt">
          お問い合わせありがとうございます。
        </p>
        <p class="read_txt">
          ただいま、お問い合わせの確認メールをお送りさせて頂きました。<br>
          お問い合わせ内容を確認の上、担当者よりお電話もしくはメールにてご連絡いたしますので、<br>
          今しばらくお待ちいただきますようお願い申し上げます。<br>
          ご不明点等は、お問い合わせよりご連絡ください。
        </p>
        <div class="form_return_item">
          <a href="<?php echo esc_url( home_url() ); ?>">トップページへ</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>