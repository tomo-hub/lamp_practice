<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションスタート
session_start();
// ログインしていなかったら（ユーザIDが登録されていなかったら）ログインページへ遷移
if(is_logined() === false){
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

// データベース接続関数を変数にいれる
$db = get_db_connect();

$user = get_login_user($db);
// ユーザIDがadminでなければログインページへ遷移
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

// $_POSTで取得したものを変数にいれる
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
// $_FILESで取得したものを変数にいれる
$image = get_file('image');
// 商品を登録
if(regist_item($db, $name, $price, $stock, $status, $image)){
  set_message('商品を登録しました。');
// それ以外エラー
}else {
  set_error('商品の登録に失敗しました。');
}

// 商品管理ページへ遷移
redirect_to(ADMIN_URL);