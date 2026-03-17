//送信時の必須項目入力チェック
function validCheck() {
  var err_cnt = 0;
  //入力チェック
  if ( $('#name').val() == "" )    { err_cnt += 1; }
  if ( $('#office').val() == "" )  { err_cnt += 1; }
  if ( $('#kana').val() == "" )    { err_cnt += 1; }
    else if (!$('#kana').val().match(/^[ァ-ンー　]+$/)) { err_cnt += 1; }
  if ( $('#tel').val() == "" )     { err_cnt += 1; }
    else if (!$('#tel').val().match(/^0\d{9,10}$/)) { err_cnt += 1;  }
  if ( $('#zip1').val() == "" )    {err_cnt += 1; }
    else if (!$('#zip1').val().match(/^[0-9]{3}$/) && $('#zip1').val() != "" )  { err_cnt += 1; }
  if ( $('#zip2').val() == "" )    {err_cnt += 1; }
    else if (!$('#zip2').val().match(/^[0-9]{4}$/) && $('#zip2').val() != "" )  { err_cnt += 1; }
  if ( $('#address').val() == "" ) { err_cnt += 1; }
  if ( $('#email').val() == "" )   { err_cnt += 1; }
    else if (!$('#email').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/))  { err_cnt += 1; }
  if ( $('#message').val() == "" ) { err_cnt += 1; }
  var flg = false;
  if ( $('#birth-year').val() ) {
    if ( $('#birth-year').val() < 1950 ) { flg = true; }
    if ( $('#birth-year').val() > 2010 ) { flg = true; }
  }
  if ( $('#birth-month').val() ) {
    if ( $('#birth-month').val() < 1 )  { flg = true; }
    if ( $('#birth-month').val() > 12 ) { flg = true; }
  }
  if ( $('#birth-day').val() ) {
    if ( $('#birth-day').val() < 1 )  { flg = true; }
    if ( $('#birth-day').val() > 31 ) { flg = true; }
  }
  if ( flg ){ err_cnt += 1; }

  if ( Number(err_cnt) > 0 ) {
    $('.mw_wp_form input[type="submit"]').prop( 'disabled', true );
    return false;
  } else {
    $('.mw_wp_form input[type="submit"]').prop( 'disabled', false );
    return true;
  }
}

$(window).on('load', function(){
  //表示状態の調整
  validCheck();
});

window.onpageshow = function(event) {
  //バック時等の表示状態の調整
  validCheck();
};

$(function () {

  //表示制御
  if( $('.mw_wp_form_input').length ) {
    $('#funclub_description').css('display', 'block');
    $('.form_confirm_area').css('display', 'none');
    $('.form_complete_area').css('display', 'none');
    //最初にボタンをdisabledにする
    $('.mw_wp_form input[type="submit"]').prop( 'disabled', true );
  }else if( $('.mw_wp_form_confirm').length ){
    $('#funclub_description').css('display', 'none');
    $('.form_confirm_area').css('display', 'block');
    $('.form_complete_area').css('display', 'none');
  }else if( $('.mw_wp_form_complete').length ){
    $('#funclub_description').css('display', 'none');
    $('.form_confirm_area').css('display', 'none');
    $('.form_complete_area').css('display', 'block');
  }

  $( '.mw_wp_form input[type="submit"]' ).click( function() {
    var err_cnt = 0;
    //入力チェック
    err_cnt += checkName();
    err_cnt += checkKana();
    err_cnt += checkTel();
    err_cnt += checkZip1();
    err_cnt += checkZip2();
    err_cnt += checkAddress();
    err_cnt += checkBirthYear();
    err_cnt += checkBirthMonth();
    err_cnt += checkBirthDay();
    err_cnt += checkEmail();

    if (Number(err_cnt) > 0) {
      $('.is-valid-top').html("入力内容に不備がございます。<br>お手数ですが、メッセージの表示された項目をご確認の上、再度ご入力ください。" );
      $('.is-valid-top').css('display', 'block');
      $('html,body').animate({
        scrollTop: $('.fanclub_form').offset().top
      }, 'fast');
      return false;
    } else {
      //XSS対策
      $('#name').val(escapeHTML( $('#name').val()));
      $('#email').val(escapeHTML( $('#email').val()));
      $('#address').val(escapeHTML( $('#address').val()));
      return true;
    }
  });

  //数字のみの入力制御をする
  $('#tel').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });
  $('#zip1').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });
  $('#zip2').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });
  $('#birth-year').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });
  $('#birth-month').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });
  $('#birth-day').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });

  // keyUp時の操作
  $('#email').keyup(function (event) {
    $('#email').val(hankaku2Zenkaku( $('#email').val()));
  });
  $('#zip2').keyup(function (event) {
    AjaxZip3.zip2addr('zip1', 'zip2', 'address', 'address');
  });

  //入力チェック
  $("#name" ).blur(function () {
    validCheck();
    checkName();
  });
  $("#kana" ).blur(function () {
    validCheck();
    checkKana();
  });
  $("#tel" ).blur(function () {
    validCheck();
    checkTel();
  });
  $("#zip1" ).blur(function () {
    validCheck();
    checkZip1();
  });
  $("#zip2" ).blur(function () {
    validCheck();
    checkZip2();
  });
  $("#address" ).blur(function () {
    validCheck();
    checkAddress();
  });
  $("#birth-year" ).blur(function () {
    validCheck();
    checkBirthYear();
  });
  $("#birth-month" ).blur(function () {
    validCheck();
    checkBirthMonth();
  });
  $("#birth-day" ).blur(function () {
    validCheck();
    checkBirthDay();
  });
  $("#email" ).blur(function () {
    validCheck();
    checkEmail();
  });
});