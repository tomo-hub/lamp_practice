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

// $_POSTで受け取った商品IDを変数にいれる
$item_id = get_post('item_id');
// 受け取った商品IDの商品を追加する、すでにある場合は購入数を１増やす
if(add_cart($db,$user['user_id'], $item_id)){
  set_message('カートに商品を追加しました。');
// それ以外はエラー
} else {
  set_error('カートの更新に失敗しました。');
}

// ホームへ遷移
redirect_to(HOME_URL);