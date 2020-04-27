<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

// セッションスタート
session_start();
// ログインしていなかったら（ユーザIDが登録されていなかったら）ログインページへ遷移
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// データベース接続関数を変数にいれる
$db = get_db_connect();
$user = get_login_user($db);
// ユーザのカート情報を変数にいれる
$carts = get_user_carts($db, $user['user_id']);
// カートの中身の合計数を変数にいれる
$total_price = sum_carts($carts);

// VIEWファイルの読み込み
include_once VIEW_PATH . 'cart_view.php';