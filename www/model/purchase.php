<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';


// 購入履歴テーブルに追加
function insert_purchase_history ($db,$user_id,$total_price){
    $sql = "INSERT INTO 
    purchase_history (
        user_id,
        total_price
    )
    VALUES(:user_id,:total_price)
    ";
    $params = array(':user_id' => $user_id , ':total_price' => $total_price);
    return execute_query($db, $sql, $params);
}

// 購入明細テーブルに追加
function insert_purchase_detail ($db,$purchase_history_id,$item_id,$price,$purchase_number){
    $sql = "INSERT INTO 
    purchase_detail (
        purchase_history_id,
        item_id,
        price,
        purchase_number
    )
    VALUES(:purchase_history_id,:item_id,:price,:purchase_number)
    ";
    $params = array(':purchase_history_id' => $purchase_history_id , ':item_id' => $item_id , ':price' => $price , ':purchase_number' => $purchase_number);
    return execute_query($db, $sql, $params);
}

function is_foreach_carts ($db,$carts,$purchase_history_id){
    foreach($carts as $value){
        if(insert_purchase_detail($db,$purchase_history_id,$value['item_id'],$value['price'],$value['amount']) === false){
            return false;
        }
    }
    return true;
}


// 購入履歴の取得
function get_purchase_histories ($db,$user_id){
    $sql = "SELECT 
            purchase_history_id,
            total_price,
            purchase_date 
            FROM purchase_history 
            WHERE user_id = :user_id 
            ORDER BY purchase_date DESC
            ";
    $params = array(':user_id' => $user_id);
    return fetch_all_query($db, $sql, $params);
}

// 購入明細の取得
function get_purchase_detail ($db,$purchase_history_id){
    $sql = "SELECT 
            items.name,
            purchase_detail.price,
            purchase_detail.purchase_number 
            FROM purchase_detail 
            JOIN items 
            ON purchase_detail.item_id = items.item_id 
            WHERE purchase_detail.purchase_history_id = :purchase_history_id
            ";
    $params = array(':purchase_history_id' => $purchase_history_id);
    return fetch_all_query($db, $sql, $params);
}

// 表示選択された購入履歴の取得
function get_purchase_history ($db,$purchase_history_id){
    $sql = "SELECT 
            purchase_history_id,
            total_price,
            purchase_date 
            FROM purchase_history 
            WHERE purchase_history_id = :purchase_history_id
            ";
    $params = array(':purchase_history_id' => $purchase_history_id);
    return fetch_query($db, $sql, $params);
}