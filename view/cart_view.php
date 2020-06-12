<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>週に一度のお花屋さん</title>
    <link rel="stylesheet" href="./view/cart.css">
</head>
<body>
    <header>
        <section>
            <h2><a href="top.php">週に一度のお花屋さん</a></h2>
            <?php if ($login_msg !== '') { ?>
                <label><?php print $login_msg; ?></label>
            <?php } ?>
            <nav class="top_menu">
                <ul class="top_menu_ul">
                    <li><a href="login.php">LOGIN</a></li>
                    <li><a href="register.php">SIGN UP</a></li>
                    <li><a href="cart.php">CART</a></li>
                    <li><a href="mypage.php">HISTORY</a></li>
                    <form method="post" action="logout.php" class="logout">
                        <input type="submit" name="delete" value="ログアウトする" >
                    </form>
                </ul>
            </nav>
        </section>
        <nav class="main_menu">
            <a href="itemlist.php">SHOP</a>
            <a href="#">GARALLEY</a>
            <a href="#">GUIDE</a>
            <a href="#">BLOG</a>
            <a href="#">CONTACT</a>
        </nav>
    </header>
    <main>
        <div class="content">
            <h2>商品詳細</h2>
            <?php if (count($err_msg) !== 0) { ?>
                <?php foreach ($err_msg as $value) { ?>
                    <p><?php print $value; ?></p>
                <?php } ?>
            <?php } ?>
            <?php if (count($result_msg) !== 0) { ?>
                <?php foreach ($result_msg as $result) { ?>
                    <p><?php print $result; ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    <div class="contents-wrapper">
        <?php if (empty($data)) { ?>
            <p class="empty"><?php print '※買い物かごに商品が入っていません。'; ?></p>
        <?php } else { ?>
    <table>
        <tr>
            <th>削除</th>
            <th>商品写真</th>
            <th>商品名</th>
            <th>価格</th>
            <th>個数</th>
            <th>小計</th>
        </tr>

    <?php foreach($data as $read) { ?>
        <tr>
            <form method="post">
                <td class="delete">
                    <button type="submit" name="process_kind" value="delete_item">削除する</button>
                    <input type="hidden" name="cart_id" value="<?php print $read['id']; ?>">
                </td>
            </form>
                <td class="pic">
                    <img src="<?php print $img_dir . $read['img']; ?>">
                </td>
                <td class="item_name">
                    <?php print (h($read['name'])); ?>
                </td>
                <td class="price">
                    <?php print (h($read['price'])); ?>円
                </td>
            <form method="post">
                <td class="amount">
                    <input type="text" name="update_amount" value="<?php print (h($read['amount'])); ?>">個
                    <button type="submit" name="process_kind" value="update">変更する</button>
                    <input type="hidden" name="item_id" value="<?php print $read['item_id']; ?>">
                    <input type="hidden" name="cart_id" value="<?php print $read['id']; ?>">
                </td>
            </form>
            <td class="price">
                <?php print ($read['price'] * $read['amount']); ?>円
            </td>
        </tr>

        <?php
        $sum = '';
        (int)$sum += ((int)$read['price'] * (int)$read['amount']); ?>
  　<?php }?>
        <tr class="sum">
            <td colspan="5">合計</td>
            <td><?php print $sum; ?>円</td>
        </tr>
    </table>


    <form method="post" action="finish.php" class="money_form">
        <p><input type"text" name="money" placeholder="金額を入力してください"></p>
        <input type="submit" value="購入する">
        <input type="hidden" name="sum" value="<?php print $sum; ?>">
    </form>
<?php }?>
    <a href="itemlist.php" class="btn top">TOPページに戻る</a>
        </div>
    </main>
    <footer>
        <nav class="fotter_menu">
            <a href="#">アクセス</a>
            <a href="#">会社概要</a>
            <a href="#">お問い合わせ</a>
            <a href="#">特定商取引に基づく表示</a>
            <a href="#">個人情報保護方針</a>
        </nav>
        <p><small>Copyright &copy; Once a Week All Rights Reserved.</small></p>
    </footer>
</body>
</html>
