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

// カートに商品がない、商品が非公開である、在庫数が足りないなどのエラーがある場合
if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL); // カートページへ遷移
} 
// カートの中身の合計数を変数にいれる
$total_price = sum_carts($carts);

// VIEWファイルの読み込み
include_once '../view/finish_view.php';