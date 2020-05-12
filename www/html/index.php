<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once '../model/functions.php';
require_once '../model/user.php';
require_once '../model/item.php';

// セッションスタート
session_start();
// ログインしていなかったら（ユーザIDが登録されていなかったら）ログインページへ遷移
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// データベース接続関数を変数にいれる
$db = get_db_connect();
$user = get_login_user($db);


// 現在のページ番号を変数にいれる
if(get_get('page') === ''){
  $now_page = 1;
}else{
  $now_page = get_get('page');
}
// SQLのLIMIT句用
$limit_page_number = ($now_page - 1) * 8;

// 受け取った選択された並び替え順を変数にいれる
$sort = get_get('sort');

// 公開している新着順の商品情報を変数にいれる
if($sort === 'new_arrival'){
  $items = get_new_arrival_items($db,$limit_page_number);
// 公開している価格の安い順の商品情報を変数にいれる
}else if($sort === 'cheap_price'){
  $items = get_cheap_price_items($db,$limit_page_number);
// 公開している価格の高い順の商品情報を変数にいれる
}else if($sort === 'high_price'){
  $items = get_high_price_items($db,$limit_page_number);
// 公開している商品情報を変数にいれる
}else{
  $items = get_open_items($db,$limit_page_number);
}

// 全ての商品の取得
$total_items = get_all_open_items($db);
// 全ての商品の合計
$total_items = count($total_items);
// 総ページ数を変数にいれる(端数切り上げ)
$total_pages = ceil($total_items / 8);


// トークンの生成を変数にいれる
$token = get_csrf_token();

// VIEWファイルの読み込み
include_once VIEW_PATH . 'index_view.php';