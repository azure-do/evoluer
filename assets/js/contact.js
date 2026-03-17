//送信時の必須項目入力チェックsubmitConfirm
function validCheck() {
  var err_cnt = 0;
  //入力チェック
  if ( $('#name').val() == "" )    { err_cnt += 1; }
  if ( $('#office').val() == "" )  { err_cnt += 1; }
  if ( $('#tel').val() == "" )     { err_cnt += 1; }
    else if (!$('#tel').val().match(/^(0[5-9]0[0-9]{8}|0[1-9][1-9][0-9]{7})$/)) { err_cnt += 1;  }
  if ( $('#email').val() == "" )  { err_cnt += 1; }
    else if (!$('#email').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/))  { err_cnt += 1; }
  if ( $('#message').val() == "" ) { err_cnt += 1; }
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
    $('.form_confirm_area').css('display', 'none');
    $('.form_complete_area').css('display', 'none');
    //最初にボタンをdisabledにする
    $('.mw_wp_form input[type="submit"]').prop( 'disabled', true );
  }else if( $('.mw_wp_form_confirm').length ){
    $('.form_confirm_area').css('display', 'block');
    $('.form_complete_area').css('display', 'none');
  }else if( $('.mw_wp_form_complete').length ){
    $('.form_confirm_area').css('display', 'none');
    $('.form_complete_area').css('display', 'block');
  }

  $( '.mw_wp_form input[type="submit"]' ).click( function() {
    var err_cnt = 0;
    //入力チェック
    err_cnt += checkName();
    err_cnt += checkOffice();
    err_cnt += checkTel();
    err_cnt += checkEmail();
    err_cnt += checkMessage();

    if (Number(err_cnt) > 0) {
      $('.is-valid-top').html("入力内容に不備がございます。<br>お手数ですが、メッセージの表示された項目をご確認の上、再度ご入力ください。");
      $('.is-valid-top').css('display', 'block');
      $('html,body').animate({
        scrollTop: $('.fanclub_form').offset().top
      }, 'fast');
      return false;
    } else {
      //XSS対策
      $('#name').val(escapeHTML($('#name').val()));
      $('#office').val(escapeHTML($('#office').val()));
      $('#email').val(escapeHTML($('#email').val()));
      $('#message').val(escapeHTML($('#message').val()));
      return true;
    }
  });

  //数字のみの入力制御をする
  $('#tel').on("keypress", function (event) {
    return leaveOnlyNumber(event);
  });

  // keyUp時の操作
  $('#email').keyup(function (event) {
    $('#email').val(hankaku2Zenkaku($('#email').val()));
  });

  //入力チェック
  $("#name").blur(function () {
    validCheck();
    checkName();
  });
  $("#office").blur(function () {
    validCheck();
    checkOffice();
  });
  $("#tel").blur(function () {
    validCheck();
    checkTel();
  });
  $("#email").blur(function () {
    validCheck();
    checkEmail();
  });
  $("#message").blur(function () {
    validCheck();
    checkMessage();
  });
});