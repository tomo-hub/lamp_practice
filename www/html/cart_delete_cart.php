<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

// 関数ファイルの読み込み
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

// $_POSTで受け取ったカートIDを変数にいれる
$cart_id = get_post('cart_id');

// 受け取ったカートIDの商品を削除
if(delete_cart($db, $cart_id)){
  set_message('カートを削除しました。');
  // それ以外はエラー
} else {
  set_error('カートの削除に失敗しました。');
}

// カートページへ遷移
redirect_to(CART_URL);