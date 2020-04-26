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
// $_POSTで受け取ったカートIDを変数にいれる
$cart_id = get_post('cart_id');
// $_POSTで受け取ったカートIDを変数にいれる
$amount = get_post('amount');

// 受け取ったカートIDの購入数を変更する
if(update_cart_amount($db, $cart_id, $amount)){
  set_message('購入数を更新しました。');
// それ以外エラー
} else {
  set_error('購入数の更新に失敗しました。');
}

// カートページへ遷移
redirect_to(CART_URL);