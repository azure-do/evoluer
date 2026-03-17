// 名前
function checkName() {
  if ($('#name').val() == "") {
    $('#name').addClass('error');
    $('.is-valid-name').text("お名前が未入力です。");
    $('.is-valid-name').css('display', 'block');
    return 1;
  } else {
    $('#name').removeClass('error');
    $('.is-valid-name').text("");
    $('.is-valid-name').css('display', 'none');
    return 0;
  }
}

// 名前
function checkOffice() {
  if ($('#office').val() == "") {
    $('#office').addClass('error');
    $('.is-valid-office').text("会社名が未入力です。");
    $('.is-valid-office').css('display', 'block');
    return 1;
  } else {
    $('#office').removeClass('error');
    $('.is-valid-office').text("");
    $('.is-valid-office').css('display', 'none');
    return 0;
  }
}

// フリガナ
function checkKana() {
  if ($('#kana').val() == "") {
    $('#kana').addClass('error');
    $('.is-valid-kana').text("フリガナが未入力です。");
    $('.is-valid-kana').css('display', 'block');
    return 1;
  } else if (!$('#kana').val().match(/^[ァ-ンー　]+$/)) {
    $('#kana').addClass('error');
    $('.is-valid-kana').text("カタカナで入力してください。");
    $('.is-valid-kana').css('display', 'block');
    return 1;
  } else {
    $('#kana').removeClass('error');
    $('.is-valid-kana').text("");
    $('.is-valid-kana').css('display', 'none');
    return 0;
  }
}

// 電話番号
function checkTel() {
  if ($('#tel').val() == "") {
    $('#tel').addClass('error');
    $('.is-valid-tel').text("電話番号が未入力です。");
    $('.is-valid-tel').css('display', 'block');
    return 1;
  } else if (!$('#tel').val().match(/^0\d{9,10}$/)) {
    $('#tel').addClass('error');
    $('.is-valid-tel').text("電話番号は0から始まる半角数字のみ、10桁または11桁で入力してください。");
    $('.is-valid-tel').css('display', 'block');
    return 1;
  } else {
    $('#tel').removeClass('error');
    $('.is-valid-tel').text("");
    $('.is-valid-tel').css('display', 'none');
    return 0;
  }
}

// 郵便番号
function checkZip1() {
  if ($('#zip1').val() == "") {
    $('.is-valid-zip1').text("郵便番号の前半が未入力です。");
    return 1;
  } else if (!$('#zip1').val().match(/^[0-9]{3}$/) && $('#zip1').val() != "") {
    $('.is-valid-zip1').text("郵便番号の前半は半角数字のみ3桁で入力してください。");
    return 1;
  } else {
    $('.is-valid-zip1').text("");
    return 0;
  }
}
function checkZip2() {
  if ($('#zip2').val() == "") {
    $('.is-valid-zip2').text("郵便番号の後半が未入力です。");
    return 1;
  } else if (!$('#zip2').val().match(/^[0-9]{4}$/) && $('#zip2').val() != "") {
    $('.is-valid-zip2').text("郵便番号の後半は半角数字のみ4桁で入力してください。");
    return 1;
  } else {
    $('.is-valid-zip2').text("");
    return 0;
  }
}

// 住所
function checkAddress() {
  if ($('#address').val() == "") {
    $('#address').addClass('error');
    $('.is-valid-address').text("住所が未入力です。");
    $('.is-valid-address').css('display', 'block');
    return 1;
  } else {
    $('#address').removeClass('error');
    $('.is-valid-address').text("");
    $('.is-valid-address').css('display', 'none');
    return 0;
  }
}

// 誕生日
function checkBirthYear() {
  var flg = false;
  if ( $('#birth-year').val() ) {
    if ($('#birth-year').val() < 1950 ){
      flg = true;
    }
    if ($('#birth-year').val() > 2010 ) {
      flg = true;
    }
  }
  if ( flg ){
    $('#birth-year').addClass('error');
    $('.is-valid-birthyear').text("生まれた年は西暦1950年～2010年の範囲で入力してください。");
    $('.is-valid-birthyear').css('display', 'block');
    return 1;
  }else{
    $('#birth-year').removeClass('error');
    $('.is-valid-birthyear').text("");
    $('.is-valid-birthyear').css('display', 'none');
    return 0;
  }
}
function checkBirthMonth() {
  var flg = false;
  if ( $('#birth-month').val() ) {
    if ($('#birth-month').val() < 1 ){
      flg = true;
    }
    if ($('#birth-month').val() > 12 ) {
      flg = true;
    }
  }
  if ( flg ){
    $('#birth-month').addClass('error');
    $('.is-valid-birthmonth').text("月は1～12の数字を入力してください。");
    $('.is-valid-birthmonth').css('display', 'block');
    return 1;
  }else{
    $('#birth-month').removeClass('error');
    $('.is-valid-birthmonth').text("");
    $('.is-valid-birthmonth').css('display', 'none');
    return 0;
  }
}
function checkBirthDay() {
  var flg = false;
  if ( $('#birth-day').val() ) {
    if ($('#birth-day').val() < 1 ){
      flg = true;
    }
    if ($('#birth-day').val() > 31 ) {
      flg = true;
    }
  }
  if ( flg ){
    $('#birth-day').addClass('error');
    $('.is-valid-birthday').text("日付は1～31の数字を入力してください。");
    $('.is-valid-birthday').css('display', 'block');
    return 1;
  }else{
    $('#birth-day').removeClass('error');
    $('.is-valid-birthday').text("");
    $('.is-valid-birthday').css('display', 'none');
    return 0;
  }
}

// メールアドレス
function checkEmail() {
  if ( $('#email').val() == "" ) {
    $('#email').addClass('error');
    $('.is-valid-email').text("メールアドレスが未入力です。");
    $('.is-valid-email').css('display', 'block');
    return 1;
  } else if (!$('#email').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)) {
    $('#email').addClass('error');
    $('.is-valid-email').text("有効なメールアドレス形式で入力してください。");
    $('.is-valid-email').css('display', 'block');
    return 1;
  } else {
    $('#email').removeClass('error');
    $('.is-valid-email').text("");
    $('.is-valid-email').css('display', 'none');
    return 0;
  }
}

// メッセージ
function checkMessage() {
  if ($('#message').val() == "") {
    $('#message').addClass('error');
    $('.is-valid-message').text("お問い合わせ・ご依頼内容が未入力です。");
    $('.is-valid-message').css('display', 'block');
    return 1;
  } else {
    $('#message').removeClass('error');
    $('.is-valid-message').text("");
    $('.is-valid-message').css('display', 'none');
    return 0;
  }
}

// 全角英数→半角英数
function hankaku2Zenkaku(str) {
  return str.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) {
    return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
  });
}

// 数字のみにする
function leaveOnlyNumber(e) {
  // 数字以外の不要な文字を削除
  var st = String.fromCharCode(e.which);
  if ("0123456789".indexOf(st, 0) < 0) {
    return false;
  }
  return true;
}

//エスケープ処理
function escapeHTML(str) {
  str = str.replace(/&/g, '&amp;');
  str = str.replace(/</g, '&lt;');
  str = str.replace(/>/g, '&gt;');
  str = str.replace(/"/g, '&quot;');
  str = str.replace(/'/g, '&#39;');
  return str;
}