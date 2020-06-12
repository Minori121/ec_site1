<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>週に一度のお花屋さん</title>
    <link rel="stylesheet" href="./view/detail.css">
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
            <?php } else { ?>
        </div>
            <div class="contents-wrapper">
                <img src="<?php print $img_dir . $new_img_filename; ?>">
                <div class="detail">
                    <p>商品名：<?php print (h($item_name)); ?></p>
                    <p>価格：<?php print $price .'円'; ?></p>
                    <form method="post" action="cart.php">
                        <p>個数：
                        <select name="amount">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        </p>
                        <p>
                            <button type="submit" name="process_kind" value="cart_inset">買い物かごに入れる</button>
                            <input type="hidden" name="item_id" value="<?php print $item_id; ?>">
                        </p>
                    </form>
                </div>
            </div>
<?php } ?>
<div class="down_btn">
        <a href="itemlist.php" class="btn top">TOPページに戻る</a>
        <a href="cart.php" class="btn cart">買い物かごを見る</a>
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
