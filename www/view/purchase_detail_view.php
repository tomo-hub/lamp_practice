<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
  <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>

    <p>注文番号：<?php print h($purchase_history['purchase_history_id']); ?></p>
    <p>合計金額：<?php print h($purchase_history['total_price']); ?></p>
    <p>購入日時：<?php print h($purchase_history['purchase_date']); ?></p>

    <table class="table table-bordered text-center">
        <thead class="thead-light">
        <tr>
            <th>商品名</th>
            <th>購入時の商品価格</th>
            <th>購入数</th>
            <th>小計</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($purchase_detail as $detail){ ?>
        <tr>
            <td><?php print h($detail['name']); ?></td>
            <td><?php print h(number_format($detail['price'])); ?></td>
            <td><?php print h($detail['purchase_number']); ?></td>
            <td><?php print h(number_format($detail['price'] * $detail['purchase_number'])); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</body>