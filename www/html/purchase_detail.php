<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
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


// $_POSTで受け取った購入履歴IDを変数にいれる
$purchase_history_id = get_post('purchase_history_id');

// 購入履歴画面で選択された購入履歴テーブルを取得し変数にいれる
$purchase_history = get_purchase_history($db,$purchase_history_id);

// 購入明細テーブルを取得し変数にいれる
$purchase_detail = get_purchase_detail($db,$purchase_history_id);

// VIEWファイルの読み込み
include_once VIEW_PATH . 'purchase_detail_view.php';