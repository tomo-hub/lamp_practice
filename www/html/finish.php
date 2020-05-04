<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'purchase.php';

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

// 受け取った$tokenを変数にいれる
$csrf_token = get_post('csrf_token');
// もし$tokenが空でfalseだった場合ログインページへ遷移
if(is_valid_csrf_token($csrf_token) === false){
  redirect_to(LOGIN_URL);
}
// 保存したセッション変数を削除
unset($_SESSION['csrf_token']);

// カートの中身の合計金額を変数にいれる
$total_price = sum_carts($carts);

// 購入履歴テーブルの追加
// user_id total_price
$db->beginTransaction();
if(insert_purchase_history($db,$user['user_id'],$total_price) === false){
  $db->rollback();
  redirect_to(CART_URL);
}

$purchase_history_id = $db->lastInsertId();

// 購入明細テーブルの追加
// 購入履歴ID $carts
if(is_foreach_carts ($db,$carts,$purchase_history_id) === false){
  $db->rollback();
  redirect_to(CART_URL);
}
$db->commit();

// VIEWファイルの読み込み
include_once '../view/finish_view.php';