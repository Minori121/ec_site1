<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>週に一度のお花屋さん</title>
    <link rel="stylesheet" href="./view/finish.css">
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
            <h2>購入完了ページ</h2>
        </div>
        <div class="contents-wrapper">
            <?php if (count($err_msg) !== 0) {
                foreach ($err_msg as $value) { ?>
                    <p><?php print $value; ?></p>
                <?php } ?>
            <?php } else { ?>
            <p>お買い上げありがとうございました。</p>
            <table>
                <tr>
                    <th>商品写真</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>個数</th>
                    <th>小計</th>
                </tr>
            <?php foreach($data as $read) { ?>
                <tr>
                    <td class="pic">
                        <img src="<?php print $img_dir . $read['img']; ?>">
                    </td>
                    <td class="item_name">
                        <?php print (h($read['name'])); ?>
                    </td>
                    <td class="price">
                        <?php print (h($read['price'])); ?>円
                    </td>
                    <td class="amount">
                        <?php print (h($read['amount'])); ?>
                    </td>
                    <td class="price">
                        <?php print ($read['price'] * $read['amount']); ?>円
                    </td>
                </tr>
                <?php $sum_finish += ($read['price'] * $read['amount']); ?>
            <?php } ?>
                <tr class="sum">
                    <td colspan="4">合計</td>
                    <td><?php print $sum_finish; ?>円</td>
                </tr>
                <tr class="sum">
                    <td colspan="4">お支払い</td>
                    <td><?php print $money; ?>円</td>
                </tr>
                <tr class="sum">
                    <td colspan="4">お釣り</td>
                    <td><?php print $change; ?>円</td>
                </tr>
            </table>
            <?php } ?>
                <a href="itemlist.php" class="btn top">TOPページに戻る</a>
            <?php if (count($err_msg) === 0) { ?>
                <a href="mypage.php" class="btn history">購入履歴を見る</a>
            <?php } else { ?>
                <a href="cart.php" class="btn cart">買い物かごを見る</a>
            <?php } ?>
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
