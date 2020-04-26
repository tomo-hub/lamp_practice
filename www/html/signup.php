<?php
// 設定ファイルの読み込み
require_once '../conf/const.php';
// 関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';

// セッションスタート
session_start();
// ログインしていたら（ユーザIDが登録されていたら）ホームへ遷移
if(is_logined() === true){
  redirect_to(HOME_URL);
}
// VIEWファイルの読み込み
include_once VIEW_PATH . 'signup_view.php';



