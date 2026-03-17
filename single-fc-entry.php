<?php
/*
Template Name:ファンクラブエントリーフォーム
*/
?>

<?php get_header(); ?>
  <div id="container" class="page_fanclub top">

<?php
if(have_posts()): while(have_posts()):the_post();
  $artist_no   = mb_substr( post_custom( 'fc_select_artist' ), 3 );
?>
    <div class="common_head_area">
      <div class="inner">
        <div class="breadcrumb pc-area">
          <ol class="breadcrumb_list">
            <li class="breadcrumb_item"><a href="<?php echo esc_url( home_url() ); ?>" class="breadcrumb_link">TOP</a></li>
            <li class="breadcrumb_item"><?php the_title(); ?>ファンクラブ</li>
          </ol>
        </div>
        <h1 class="common_pagettl">
          <span class="common_pagettl_en en-font">Fan Club</span>
          <span class="common_pagettl_jp jp-point-font">ファンクラブ</span>
        </h1>
      </div>
    </div>

    <section id="funclub_description" class="common_section">
      <div class="inner">
        <div class="fanclub_summary">
          <div class="read_area_top">
            <h2 class="read_ttl">
              <span class="read_ttl_en en-font">FanClub</span>
              <span class="read_ttl_jp jp-point-font"><?php the_title(); ?>ファンクラブ<br class="mb-area">ご入会方法</span>
            </h2>

            <p class="read_txt">
              入会案内書をご希望の方は、【入会お申し込み】フォームに必要事項をご記入の上、送信ボタンを押してください。<br> ご記入いただきました、ご住所に『入会案内書』をお送りいたします。
            </p>

          </div>
          <!-- read_area/ -->

          <div class="read_area_bottom">
            <dl class="read_list_01">
              <div class="read_wrap_01">
                <dt class="read_title_01 jp-point-font">入会特典</dt>
                <dd class="read_content_01">
                  <?php echo nl2br( get_post_meta( $artist_no, 'fc_new_benefits', true ) ); ?>
                </dd>
              </div>
              <div class="read_wrap_01">
                <dt class="read_title_01 jp-point-font">会員特典</dt>
                <dd class="read_content_01">
<?php
  $fc_benefits = SCF::get( 'fc_benefits', $artist_no );
  if( $fc_benefits ):
?>
                  <ul class="read_content_in_list">
    <?php foreach ($fc_benefits as $benefit ): ?>
                    <li class="read_content_in_item"><?php echo $benefit['fc_benefit'];?></li>
    <?php endforeach; ?>
                  </ul>
  <?php endif; ?>
                </dd>
              </div>
            </dl>
            <div class="read_table_area">
              <table class="read_table_box">
                <tbody class="read_table_tbody pc-area">
                  <tr class="read_table_tr">
                    <th class="read_table_th">新規入会</th>
                    <th class="read_table_th">ご継続の方</th>
                  </tr>
                  <tr class="read_table_tr">
                    <td class="read_table_td">
                      <div class="read_table_td_in">
                        <?php echo nl2br( get_post_meta( $artist_no, 'fc_new_enrollment', true ) ); ?>
                      </div>
                    </td>
                    <td class="read_table_td">
                      <div class="read_table_td_in right-part">
                        <?php echo nl2br( get_post_meta( $artist_no, 'fc_continuing', true ) ); ?>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody class="read_table_tbody mb-area">
                  <tr class="read_table_tr">
                    <th class="read_table_th">新規入会</th>
                    <td class="read_table_td">
                      <?php echo nl2br( get_post_meta( $artist_no, 'fc_new_enrollment', true ) ); ?>
                    </td>
                  </tr>
                  <tr class="read_table_tr">
                    <th class="read_table_th">ご継続の方</th>
                    <td class="read_table_td">
                      <?php echo nl2br( get_post_meta( $artist_no, 'fc_continuing', true ) ); ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
<?php
  $fc_cautions = SCF::get( 'fc_cautions', $artist_no );
  if( $fc_cautions ):
?>
            <ul class="read_list_02">
    <?php foreach ($fc_cautions as $caution ): ?>
              <li class="read_list_02_item"><?php echo $caution['fc_caution'];?></li>
    <?php endforeach; ?>
            </ul>
  <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="common_section fanclub_form">
      <div class="inner">
        <h2 class="read_ttl">
          <span class="read_ttl_en en-font">FanClub Form</span>
          <span class="read_ttl_jp jp-point-font">ファンクラブ入会<br class="mb-area">お申し込みフォーム</span>
        </h2>
        <div class="form_confirm_area">
          <p class="read_txt">
            入力内容にお間違いがないかご確認の上、「送信」ボタンを押してください。<br>
            再度入力される場合は「戻る」ボタンを押してください。
          </p>
        </div>
        <div class="form_area">
          <div id="error-text-top" class="error-box is-valid-top"></div>
  <?php echo do_shortcode('[mwform_formkey key="31"]'); ?>
        </div>
        <div class="form_complete_area">
          <p class="read_txt">
            <?php the_title(); ?>Evoluer<br>
            お申し込みありがとうございます。
          </p>
          <p class="read_txt">
            ただいま、お申し込みの確認メールをお送りさせて頂きました。<br>
            ご登録内容を確認の上、新規入会のご案内を郵送いたします。<br>
            今一度、ご住所等お間違えないかご確認くださいませ。<br>
            ご不明点等は、お問い合わせよりご連絡ください。
          </p>
          <div class="form_return_item">
            <a href="<?php echo esc_url( home_url() ); ?>">トップページへ</a>
          </div>
        </div>

      </div>
    </section>

  </div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>