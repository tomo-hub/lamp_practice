<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
<?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <table class="table table-bordered text-center">
        <thead class="thead-light">
        <tr>
            <th>注文番号</th>
            <th>該当の注文の合計金額</th>
            <th>購入日時</th>
            <th>購入明細</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($purchase_histories as $purchase_history){ ?>
        <tr>
            <td><?php print h($purchase_history['purchase_history_id']); ?></td>
            <td><?php print h(number_format($purchase_history['total_price'])); ?></td>
            <td><?php print h($purchase_history['purchase_date']); ?></td>
            <td>
                <form method="post" action="purchase_detail.php">
                    <input type="submit" value="表示" class="btn btn-secondary">
                    <input type="hidden" name="purchase_history_id" value="<?php print h($purchase_history['purchase_history_id']); ?>">
                </form>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</body>