<section class="bg-white border-t border-[#E5E5E5] px-[30px]">
  <div class="max-w-[1150px] mx-auto pb-[40px] pt-[60px] md:pb-16 md:pt-[90px]">
    <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-20 md:gap-16 xl:gap-[90px]">
      <!-- Logo & SNS -->
      <div class="w-[220px]">
        <div class="mb-6">
          <a href="<?php echo esc_url(home_url()); ?>" class="inline-block">
            <img
              src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo_pc.svg'); ?>"
              alt="Evoluer"
              class="!w-[220px]" />
          </a>
        </div>
        <div class="flex items-center gap-3 text-[#B5C86D] justify-center md:justify-start">
          <?php
          // Use placeholder links for now; replace with real URLs if available.
          $sns_links = array(
            'instagram' => '#',
            'tiktok'    => '#',
            'facebook'  => '#',
          );
          ?>
          <?php foreach ($sns_links as $sns => $url) : ?>
            <a
              href="<?php echo esc_url($url); ?>"
              class="w-8 h-8 flex items-center justify-center rounded-full border border-[#B5C86D] text-[16px] text-center hover:bg-[#B5C86D] hover:text-white transition-colors"
              aria-label="<?php echo esc_attr(ucfirst($sns)); ?>">
              <?php echo esc_html(strtoupper(substr($sns, 0, 1))); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Navigation columns -->
      <div class="flex-1 w-full grid grid-cols-2 xl:flex justify-between gap-16 lg:gap-8 text-sm text-[#555]">
        <!-- Official contents -->
        <div class="!space-y-14">
          <h3 class="text-[18px] font-medium tracking-[-1px] text-[#676767] h-[32px]">
            OFFICIAL CONTENTS
          </h3>
          <ul class="space-y-3 text-[16px]">
            <li><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
            <li><a href="<?php echo esc_url(home_url('#news')); ?>">NEWS</a></li>
            <li>
              <span>FAN CLUB</span>
              <div class="!text-[12px] pl-[12px] space-y-3 mt-2 mb-4">
                <a href="<?php echo esc_url(home_url('/fanclub/shibuki/')); ?>">
                  <span class="jp-point-font block">シブキofficial fan club</span>
                </a>
                <a href="<?php echo esc_url(home_url('/fanclub/yonekichi/')); ?>">
                  <span class="jp-point-font block">中村米吉official fan club</span>
                </a>
              </div>
            </li>
            <li><a href="<?php echo esc_url(home_url('/shop/')); ?>">SHOPPING</a></li>
          </ul>
        </div>

        <!-- Fan club 1 -->
        <div class="!space-y-14">
          <h3 class="text-[18px] font-medium tracking-[-1px] text-[#676767] h-[32px]">
            中村米吉<br>official fan club
          </h3>
          <ul class="space-y-3 text-[16px]">
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcnews_archive_url' ) ? evoluer_fanclub_fcnews_archive_url() : home_url( '/fcnews/' ) ); ?>">NEWS</a></li>
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcgallery_archive_url' ) ? evoluer_fanclub_fcgallery_archive_url() : home_url( '/fc-gallery/' ) ); ?>">GALLERY</a></li>
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fc_movie_archive_url' ) ? evoluer_fanclub_fc_movie_archive_url() : home_url( '/fc-movie/' ) ); ?>">Movie</a></li>
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_ticket_archive_url' ) ? evoluer_fanclub_ticket_archive_url() : home_url( '/ticket/' ) ); ?>">Ticket</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact US</a></li>
          </ul>
        </div>

        <!-- Fan club 2 -->
        <div class="!space-y-14">
          <h3 class="text-[18px] font-medium tracking-[-1px] text-[#676767] h-[32px]">
            中村米吉<br>official fan club
          </h3>
          <ul class="space-y-3 text-[16px]">
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcnews_archive_url' ) ? evoluer_fanclub_fcnews_archive_url() : home_url( '/fcnews/' ) ); ?>">NEWS</a></li>
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fcgallery_archive_url' ) ? evoluer_fanclub_fcgallery_archive_url() : home_url( '/fc-gallery/' ) ); ?>">GALLERY</a></li>
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_fc_movie_archive_url' ) ? evoluer_fanclub_fc_movie_archive_url() : home_url( '/fc-movie/' ) ); ?>">Movie</a></li>
            <li><a href="<?php echo esc_url( function_exists( 'evoluer_fanclub_ticket_archive_url' ) ? evoluer_fanclub_ticket_archive_url() : home_url( '/ticket/' ) ); ?>">Ticket</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact US</a></li>
          </ul>
        </div>

        <!-- Others -->
        <div class="!space-y-14">
          <h3 class="text-[18px] font-medium tracking-[-1px] text-[#676767] h-[32px]">
            OTHERS
          </h3>
          <ul class="space-y-3 text-[16px]">
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">よくある質問・お問い合わせ</a></li>
            <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
            <li><a href="<?php echo esc_url(home_url('/commerce/')); ?>">特定商取引法に基づく表記</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom copyright bar -->
  <div class="border-t border-[#E5E5E5] bg-white">
    <div class="max-w-[1130px] mx-auto px-4 md:px-6 lg:px-8 py-4 text-center text-[16px] text-[#676767]">
      © <?php echo date_i18n('Y'); ?> copyright
    </div>
  </div>
</section>