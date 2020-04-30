<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

// セッションスタート
session_start();
// ログインしていたら（ユーザIDが登録されていたら）ホームへ遷移
if(is_logined() === true){
  redirect_to(HOME_URL);
}
// $_POSTで受け取ったユーザ名を変数にいれる
$name = get_post('name');
// $_POSTで受け取ったパスワードを変数にいれる
$password = get_post('password');
// データベース接続関数を変数にいれる
$db = get_db_connect();

// ユーザ情報を変数にいれる
$user = login_as($db, $name, $password);
// ユーザ情報が登録されていないまたはパスワードが違っていた場合エラー ログインページへ遷移
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

// 受け取った$tokenを変数にいれる
$csrf_token = get_post('csrf_token');
// もし$tokenが空でfalseだった場合ログインページへ遷移
if(is_valid_csrf_token($csrf_token) === false){
  redirect_to(LOGIN_URL);
}
// 保存したセッション変数を削除
unset($_SESSION['csrf_token']);

set_message('ログインしました。');
// ユーザが管理者だった場合、商品管理ページへ遷移
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}

// ログインしたためホームへ遷移
redirect_to(HOME_URL);