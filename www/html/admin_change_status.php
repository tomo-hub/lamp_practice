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
// データベース接続関数を変数にいれる
$db = get_db_connect();

$user = get_login_user($db);
// ユーザIDがadminでなければログインページへ遷移
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
// $_POSTで受け取った商品IDを変数にいれる
$item_id = get_post('item_id');
// $_POSTで受け取ったステータス情報を変数にいれる
$changes_to = get_post('changes_to');

// $_POSTで受け取ったステータス情報がopen（公開）だった場合公開に
if($changes_to === 'open'){
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  set_message('ステータスを変更しました。');
// $_POSTで受け取ったステータス情報がclose（非公開）だった場合非公開に
}else if($changes_to === 'close'){
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  set_message('ステータスを変更しました。');
// $_POSTで受け取ったステータス情報がそれ意外だった場合
}else {
  set_error('不正なリクエストです。');
}

// 商品管理ページへ遷移
redirect_to(ADMIN_URL);