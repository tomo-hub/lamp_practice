<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print h(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">

    <div class="container clearfix">
      <div class="float-right">
        <!--商品の並び替え機能-->
        <form method="get">
          <select name="sort">
            <option value="new_arrival" <?php if($sort === 'new_arrival'){ print h('selected'); } ?>>新着順</option>
            <option value="cheap_price" <?php if($sort === 'cheap_price'){ print h('selected'); } ?>>価格の安い順</option>
            <option value="high_price" <?php if($sort === 'high_price'){ print h('selected'); } ?>>価格の高い順</option>
          </select>
          <input type="submit" value="並び替え">
        </form>

        <!--ページネーション-->
        <?php for($i = 1; $i <= $total_pages; $i++){ 
           if ($i == $now_page) { 
               print h($now_page); 
           } else { ?>
             <a href='/index.php?page=<?php print h($i); ?>&sort=<?php print h($sort); ?>'><?php print h($i); ?></a>
        <?php } 
         } ?>
        
      </div>
      <h1>商品一覧</h1>
    </div>

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print h($item['name']); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print h(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
                <?php print h(number_format($item['price'])); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>