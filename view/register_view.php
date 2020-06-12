<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>週に一度のお花屋さん</title>
    <link rel="stylesheet" href="./view/register.css">
</head>
<body>
    <header>
        <section>
            <h2><a href="top.php">週に一度のお花屋さん</a></h2>
            <nav class="top_menu">
                <ul class="top_menu_ul">
                    <li class="login"><a href="login.php">LOGIN</a></li>
                    <li><a href="register.php" class="sign_up">SIGN UP</a></li>
                    <li><a href="cart.php" class="cart">CART</a></li>
                    <li><a href="mypage.php" class="history">HISTORY</a></li>
                    <form method="post" action="logout.php" class="logout">
                        <input type="submit" name="delete" value="ログアウトする" >
                    </form>
                </ul>
            </nav>
        </section>
        <nav class="main_menu">
            <a href="itemlist.php" class="login">SHOP</a>
            <a href="#" class="sign_up">GARALLEY</a>
            <a href="#" class="cart">GUIDE</a>
            <a href="#" class="history">BLOG</a>
            <a href="#" class="history">CONTACT</a>
        </nav>
    </header>
    <main>
        <div class="content">
            <h2>新規会員登録ページ</h2>
        </div>
        <div class="contents-wrapper">
            <section class="register_box">
                <h3>会員登録（入力フォーム）</h3>
                <p class="explain red">会員の方は、ユーザネームとパスワードでログインしてください。</p>
                <?php if(count($err_msg) !== 0) { ?>
                    <?php foreach ($err_msg as $value) { ?>
                        <p class="red"><?php print $value; ?></p>
                    <?php } ?>
                <?php } else if(count($result_msg) !== 0) {?>
                        <p><?php print $result_msg; ?></p>
                <?php } ?>
            <form method="post">
                <p>ユーザネーム：<br><input type="text" name="user_name"></p>
                <p>パスワード：<br><input type="password" name="password"></p>
                <input type="submit" value="会員登録をする">
            </form>
<?php if($result_msg !== '') { ?>
    <a href="login.php" class="btn login02">ログインする</a>
<?php } ?>
        </div>
    </main>
    <footer>
        <nav class="fotter_menu">
            <a href="#" class="login">アクセス</a>
            <a href="#" class="sign_up">会社概要</a>
            <a href="#" class="cart">お問い合わせ</a>
            <a href="#" class="history">特定商取引に基づく表示</a>
            <a href="#" class="history">個人情報保護方針</a>
        </nav>
        <p><small>Copyright &copy; Once a Week All Rights Reserved.</small></p>
    </footer>
</body>
</html>
