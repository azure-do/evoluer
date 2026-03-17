<?php
/*
Template Name: index.php
*/
?>
<?php get_header(); ?>

<div id="container">
  <div class="common_head_area">
    <div class="inner">
      <div class="breadcrumb pc-area">
        <ol class="breadcrumb_list">
          <li class="breadcrumb_item"><a href="<?php echo esc_url( home_url() ); ?>" class="breadcrumb_link">TOP</a></li>
          <li class="breadcrumb_item"><?php the_title(); ?></li>
        </ol>
      </div>
      <h1 class="common_pagettl">
        <span class="common_pagettl_en en-font"></span>
        <span class="common_pagettl_jp jp-point-font"><?php the_title(); ?></span>
      </h1>
    </div>
  </div>
  <section class="common_section">
    <div class="inner">
<?php
if ( have_posts() ) :
  get_template_part( 'loop' );
else :
  get_template_part( 'content', 'none' );
endif;
?>
    </div>
  </section>
</div>
<?php get_footer(); ?>