<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>週に一度のお花屋さん</title>
    <link rel="stylesheet" href="./view/top.css">
</head>
<body>
    <header>
        <nav>
                <a href="login.php" class="login">LOGIN</a></li>
                <a href="register.php" class="sign_up">SIGN UP</a>
                <a href="cart.php" class="cart">CART</a>
                <a href="mypage.php" class="history">HISTORY</a>
                <form method="post" action="logout.php" class="logout">
                    <input type="submit" name="delete" value="ログアウトする" >
                </form>
            </ul>
        </nav>
<?php if ($login_msg !== '') { ?>
    <label><?php print $login_msg; ?></label>
<?php } ?>
    </header>

    <main>
        <div class="main_column">
            <article class="main_top">
                <section class="main_top_content">
                    <h1>週に一度のお花屋さん</h1>
                    <p>大切な方へ贈るお花をご用途に応じ、厳選した季節のお花を使ってご用意いたします。</p>
                </section>
            </article>

            <nav class="main_menu">
                <a href="itemlist.php" class="login">SHOP</a>
                <a href="#" class="sign_up">GARALLEY</a>
                <a href="#" class="cart">GUIDE</a>
                <a href="#" class="history">BLOG</a>
                <a href="#" class="history">CONTACT</a>
            </nav>

            <section class="contentblock contents01">
                <div class="titleblock01">
                    <h2>About</h2>
                    <h4>週に一度訪れてください</h4>
                    <p>何気ない日常をほんの少し暖かくしてくれる「お花」。<br>週に一度だけでいいので、私達のお店を覗いてみてください。<br>季節にあったお花であなたの日常を彩ります。</p>
                </div>
            </section>

            <section class="contentblock contents02">
                <div class="titleblock02">
                    <a href="itemlist.php"><h2>Shop</h2></a>
                    <h4>お買い物はこちらで</h4>
                    <p>当店の仕入れは週に1回。<br>仕入れに合わせて週に一度、全ての商品が入れ替わります。<br></p>
                </div>
            </section>
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
