<?php get_header(); ?>


<div id="container">
  <div
    class="bg-cover bg-center relative">
    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/fv-fanclub.webp'); ?>" alt="ファンクラブ" class="w-full !h-[420px] md:!h-full object-cover">
    <div class="absolute top-1/2 -translate-y-1/2 md:right-[12%] right-1/2 md:translate-x-0 -translate-x-[-50%] w-full md:w-fit h-full flex flex-col justify-center items-center gap-5">
      <h1 class="text-center text-[#13AA05] !text-[36px] md:!text-[40px] xl:!text-[50px] leading-[1.2] font-bold" style="-webkit-text-stroke: 1px #CFDA38">
        ファンクラブ限定の<br>特別な体験を!
      </h1>
      <div class="flex gap-5">
        <a href="<?php echo esc_url(home_url('/fanclub-event')); ?>" class="xl:min-w-[180px] rounded-[12px] header_btn_login ml-3 text-[16px] border border-[#13AA05] border-solid !border-[1.5px] !text-[#13AA05] px-8 py-3 inline-block no-underline text-center">イベントを見る</a>
        <a href="<?php echo esc_url(home_url('/fc-entry/login')); ?>" class="xl:min-w-[180px] rounded-[12px] header_btn_login ml-3 text-[16px] border bg-[#13AA05] border-[#13AA05] border-solid !border-[1.5px] !text-white px-8 py-3 inline-block no-underline text-center">ログイン</a>
      </div>
    </div>
  </div>
</div>
<section class="bg-[#DDE4DE]">
  <div class="w-full flex justify-center items-center py-[60px] lg:py-[80px] xl:py-[124px]">
    <div class="w-full max-w-[1130px] relative flex flex-col items-center">
      <div class="relative inline-block mx-auto">
        <span class="absolute -right-4 bottom-[-2px] w-[160px] h-[26px] bg-[#FBFEA3] -z-[1]" style="transform: skew(-20deg);"></span>
        <h3 class="z-10 text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3]" style="-webkit-text-stroke: 1px #096B00;">
          ファンクラブ会員特典
        </h3>
      </div>
      <div class="flex flex-col md:flex-row gap-4 md:gap-4 lg:gap-6 xl:gap-8 my-12 lg:my-16 xl:my-24 px-[30px]">
        <!-- 限定コンテンツ -->
        <div class="bg-white rounded-[12px] shadow p-[16px] md:p-[12px] xl:p-[24px] flex flex-col max-w-[350px]">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/exclusive-content.webp'); ?>" alt="限定コンテンツ" class="w-full h-[176px] object-cover rounded-[8px] mb-6" />
          <div class="font-bold text-[18px] mb-2 text-[#222]">限定コンテンツ</div>
          <div class="text-[14px] text-[#666] leading-relaxed">
            ファンクラブ会員だけが楽しめる特別なコンテンツをご用意。<br>ここでしか見られない限定動画や写真、舞台裏の様子などをお楽しみいただけます。
          </div>
        </div>
        <!-- チケット先行予約 -->
        <div class="bg-white rounded-[12px] shadow p-[16px] md:p-[12px] xl:p-[24px] flex flex-col max-w-[350px]">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/advance-reserve.webp'); ?>" alt="チケット先行予約" class="w-full h-[176px] object-cover rounded-[8px] mb-6" />
          <div class="font-bold text-[18px] mb-2 text-[#222]">チケット先行予約</div>
          <div class="text-[14px] text-[#666] leading-relaxed">
            ライブやイベントのチケットを一般販売よりも早くお申し込みいただけます。<br>人気公演のチケットを確保できるチャンスが広がります。
          </div>
        </div>
        <!-- 会員限定イベント -->
        <div class="bg-white rounded-[12px] shadow p-[16px] md:p-[12px] xl:p-[24px] flex flex-col max-w-[350px]">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/member-event.webp'); ?>" alt="会員限定イベント" class="w-full h-[176px] object-cover rounded-[8px] mb-6" />
          <div class="font-bold text-[18px] mb-2 text-[#222]">会員限定イベント</div>
          <div class="text-[14px] text-[#666] leading-relaxed">
            ファンクラブ会員限定の特別イベントを開催。<br>
            オンライン配信やスペシャル企画など、会員だけの特別な体験をご提供します。
          </div>
        </div>
      </div>
      <div class="relative inline-block mx-auto mt-6 lg:mt-8 xl:mt-12">
        <h3 class="z-10 text-[28px] lg:text-[32px] xl:text-[34px] font-bold text-[#FBFEA3] " style="-webkit-text-stroke: 1px #096B00;">
          年会費
        </h3>
      </div>
      <div class="w-full flex flex-col items-center mt-12 lg:mt-16 xl:mt-21 px-[30px]">
        <div class="bg-white shadow rounded-[12px] px-10 lg:px-6 py-8 xl:px-[88px] md:pt-[88px] md:pb-[70px] w-full mx-auto mb-8">
          <!-- 入会手続方法 -->
          <div class="flex flex-col gap-8">
            <div class="flex flex-col md:flex-row md:items-center md:gap-10">
              <div class="w-[280px] font-bold text-black text-[18px] mb-2">入会手続き方法</div>
              <div class="flex-1 mb-4 md:mb-0 min-w-[140px]">
                スマートフォン・パソコンからご入会可能！
              </div>
            </div>
            <div class="border-b border-dotted border-[#9B9B9B]"></div>
            <div class="flex flex-col md:flex-row md:items-start md:gap-10">
              <div class="w-[280px] flex flex-col gap-3 text-[16px] text-black">
                <div class="font-semibold">入会金：1,000円(税込)</div>
                <div class="font-semibold">+ 年会費：7,000円(税込)</div>
              </div>
              <ul class="flex-1 mt-3 list-disc space-y-1 text-[14px]">
                <li>・翌年からは年会費7,000円(税込)のみとなります。</li>
                <li>・入会・継続手続きの際は、事務手数料として別途250円(税込)かかります。</li>
                <li>・海外にお住まいの方で、郵送物(会員証も含む)を希望される場合は「海外郵送コース 2,000円(税込)/年」のお申込が必要となります。</li>
                <li>お支払い方法等は、入会手続き後にご案内します。</li>
              </ul>
            </div>
            <div class="border-b border-dotted border-[#9B9B9B]"></div>
            <!-- ご利用出来るお支払い方法 -->
            <div class="flex flex-col md:flex-row md:items-start md:gap-10">
              <div class="w-[280px] font-bold text-black text-[18px] mb-2">ご利用出来るお支払い方法 </div>
              <ul class="flex-1 text-[14px] text-black leading-relaxed list-disc space-y-1">
                <li>・クレジットカード決済（「VISA」「MASTER」「JCB」「Diners」「American Express」）</li>
                <li>・コンビニペーパーレス決済</li>
                <li>・Pay-easy決済</li>
                <li>※決済完了後すぐにファンクラブ限定サイトをご覧いただけます。</li>
              </ul>
            </div>
          </div>
        </div>
        <button class="w-full md:w-auto bg-[#13AA05] hover:bg-[#0F9105] text-white rounded-[8px] text-[16px] lg:text-[18px] xl:text-[20px] font-bold py-4 px-[30px] md:px-[40px] xl:px-[88px] mt-12 lg:mt-16 xl:mt-20 transition-colors duration-200 shadow"
          type="button">
          入会手続きに進む
        </button>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>