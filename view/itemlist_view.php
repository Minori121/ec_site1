<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>週に一度のお花屋さん</title>
    <link rel="stylesheet" href="./view/itemlist.css">
</head>
<body>
    <header>
        <section>
            <h2><a href="top.php">週に一度のお花屋さん</a></h2>
            <?php if ($login_msg !== '') { ?>
                <label><?php print $login_msg; ?></label>
            <?php } else {?>
                <label><?php print 'ようこそゲストさん'; ?></label>
            <?php } ?>
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
                <h2>商品一覧</h2>
                <!--<div class="select">-->
                <!--    <form method="post">-->
                <!--        <select name="select">-->
                <!--            <option disabled selected value>カテゴリを選択してください</option>-->
                <!--            <option value="1">アレンジメント</option>-->
                <!--            <option value="2">プリザーブドフラワー</option>-->
                <!--            <option value="3">花束</option>-->
                <!--            <option value="4">鉢植え</option>-->
                <!--            <option value="5">蘭</option>-->
                <!--        </select>-->
                <!--        <button type="submit" name="process_kind" value="selection">絞込む</button>-->
                <!--    </form>-->
                <!--</div>-->
            </div>
        <div class="contents-wrapper">


            <nav class="select_menu">

                    <div class="search_title">
                        <h2>SERCH ITEMS</h2>
                    </div>
                    <section class="select">
                        <div class="select_title">
                            <p>並び替え</p>
                        </div>
                            <form>
                                <select id="order" name="order">
                                    <option value="">新着順</option>
                                    <option value="2">価格の安い順</option>
                                    <option value="3">価格の高い順</option>
                                </select>
                                <input type="submit" value="並び替える">

                            </form>
                    </section>

                <form method="post">
                    <section class="select">
                        <div class="select_title">
                            <p>カテゴリーで選ぶ</p>
                        </div>
                        <div class="select_body">
                            <ul>
                                <li>
                                    <input type="radio" name="search_c" value="1">アレンジメント
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_c" value="2">プリザーブドフラワー
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_c" value="3">花束
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_c" value="4">鉢植え
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_c" value="5">蘭
                                </li>
                            </ul>
                        </div>
                    </section>
                    <section class="select">
                        <div class="select_title">
                            <p>用途で選ぶ</p>
                        </div>
                        <div class="select_body">
                            <ul>
                                <li>
                                    <input type="radio" name="search_t" value="1">誕生日
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_t" value="2">冠婚葬祭
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_t" value="3">母の日
                                </li>
                            </ul>

                                <li>
                                    <input type="radio" name="search_t" value="4">送別
                                </li>
                            </ul>
                        </div>
                    </section>
                    <!-- <section class="select">
                        <div class="select_title">
                            <p>価格帯で選ぶ</p>
                        </div>
                        <div class="select_body">
                            <ul>
                                <li>
                                    <input type="radio" name="search_p" value="1">～3,000円
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_p" value="2">3,001円～5,000円
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_p" value="3">5,001円～10,000円
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <input type="radio" name="search_p" value="4">10,001円～
                                </li>
                            </ul>
                        </div>
                    </section> -->
                    <div class="search_title">
                        <button type="submit" name="process_kind" value="selection">この条件で絞り込む</button>
                    </div>
                </form>
            </nav>

            <article>
<?php if (count($err_msg) !== 0 ) { ?>
  <?php foreach ($err_msg as $value) { ?>
    <p><?php print $value; ?></p>
  <?php } ?>
<?php } ?>
<?php if (empty($items) ){ ?>
    <p><?php print '該当の商品がありません'; ?></p>
<?php } ?>
            <form method="post" action="detail.php">
                <div id="flex">
                    <?php foreach ($items as $item) { ?>
                    <div class="drink">
                        <img src="<?php print $img_dir . $item['img']; ?>">
                        <span><?php print (h($item['name'])); ?></span>
                        <span><?php print (h($item['price'])); ?>円</span>
                        <?php if ($item['stock'] === 0) { ?>
                        <span class="soldout">売り切れ</span>
                        <?php } else { ?>
                        <button type="submit" name="item_id" value="<?php print $item['item_id']; ?>">詳細を見る</button>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </form>
        </div>
        <div class="pagination">
            <?php for ($x = 1; $x <= $page_num; $x++) { ?>
                <a class="page" href="itemlist.php?page=<?php print $x ?>"><?php print $x; ?></a>
            <?php } ?>
        </div>
        </article>
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
