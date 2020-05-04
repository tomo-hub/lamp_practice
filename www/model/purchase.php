<?php 
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