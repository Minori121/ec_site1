<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>在庫管理ページ</title>
    <style>
        body {
            min-width:1920px;
        }
        table {
            border-collapse:collapse;
            margin-top:50px;
        }

        table, tr, th, td {
            border:solid 1px;
            padding:10px;
            text-align:center;
        }
        img {
            width:280px;
        }
        .manage {
            border-top:solid 2px;
            border-bottom:solid 2px;
            padding-bottom: 20px;
        }

        .item-name {
            width:100px;
        }

        .price {
            width:250px;
        }
        .status_undisclosed.gray {
            background-color:gray;
        }
    </style>
</head>
<body>
<?php if (count($result_msg) !== 0) {
      foreach ($result_msg as $result) { ?>
        <p><?php print $result; ?></p>
    <?php } ?>
<?php } ?>

<h1>ECサイト在庫管理ツール</h1>
<div class="manage">
    <h2>新規商品追加</h2>
    <ul>
        <?php if (count($err_msg) !== 0) {
            foreach ($err_msg as $value) { ?>
                <li><?php print $value; ?></li>
            <?php } ?>
        <?php } ?>
    </ul>
    <!-- 商品追加のためのフォーム -->
    <form method="post" enctype="multipart/form-data">
        <div><label>名前： <input type="text" name="item_name" value=""></label></div>
        <div><label>値段： <input type="text" name="price" value=""></label></div>
        <div><label>個数： <input type="text" name="stock" value=""></label></div>
        <div>画像： <input type="file" name="new_img"></div>
        <div>ステータス：
            <select name="status">
                <option value="0">非公開</option>
                <option value="1">公開</option>
            </select></div>
        カテゴリー：
        <select name="select">
            <option value="1">アレンジメント</option>
            <option value="2">プリザーブドフラワー</option>
            <option value="3">花束</option>
            <option value="4">鉢植え</option>
            <option value="5">蘭</option>
        </select>
        <input type="hidden" name="process_kind" value="insert_item">
        <div><input type="submit" value="商品を追加"></div>
    </form>
</div>
<div>
    <h2>商品情報変更</h2>
    <h3>商品一覧</h3>
        <div class="select">
            <form method="post">
                <select name="select">
                    <option disabled selected value>カテゴリを選択してください</option>
                    <option value="1">アレンジメント</option>
                    <option value="2">プリザーブドフラワー</option>
                    <option value="3">花束</option>
                    <option value="4">鉢植え</option>
                    <option value="5">蘭</option>
                </select>
                <button type="submit" name="process_kind" value="selection">絞込む</button>
            </form>
        </div>
<?php if(empty($data)) { ?>
    <p><?php print '該当の商品は登録されていません。'; ?></p>
<?php } else { ?>
    <table>
        <tr>
            <th>商品画像</th>
            <th class="item_name">商品名</th>
            <th class="price">価格</th>
            <th class="stock">在庫数</th>
            <th class="status">ステータス</th>
            <th class="category">カテゴリー</th>
            <th class="delete">削除</th>
        </tr>
    <?php foreach ($data as $read) { ?>
        <tr class="status_undisclosed<?php if ($read['status'] === 0) {?> gray <?php } ?>">
            <td>
                <img src="<?php print $img_dir . $read['img']; ?>">
            </td>

            <!-- 商品名の更新 -->
            <form method="post">
                <td>
                    <input type="text" name="update_name" value="<?php print (h($read['name'])); ?>">&nbsp;&nbsp;<input type="submit" value="変更">
                </td>
                <input type="hidden" name="item_id" value="<?php print $read['item_id']; ?>">
                <input type="hidden" name="process_kind" value="update_name_data">
            </form>

            <!-- 価格の更新 -->
            <form method="post">
                <td>
                    <input type="text" name="update_price" value="<?php print (h($read['price'])); ?>">円&nbsp;&nbsp;<input type="submit" value="変更">
                </td>
                <input type="hidden" name="item_id" value="<?php print $read['item_id']; ?>">
                <input type="hidden" name="process_kind" value="update_price_data">
            </form>

            <!-- 在庫数の更新 -->
            <form method="post">
                <td>
                    <input type="text" name="update_stock" value="<?php print (h($read['stock'])) ?>">個&nbsp;&nbsp;<input type="submit" value="変更">
                </td>
                <input type="hidden" name="item_id" value="<?php print $read['item_id']; ?>">
                <input type="hidden" name="process_kind" value="update_stock_data">
            </form>

            <!-- ステータスの更新 -->
            <form method="post">
                <td>
                    <?php if ($read['status'] === 0) { ?>
                    <button type="submit" name="update_status" value="1">公開する</button>
                    <?php } else { ?>
                    <button type="submit" name="update_status" value="0">非公開にする</button>
                    <?php } ?>
                </td>
                <input type="hidden" name="item_id" value="<?php print $read['item_id']; ?>">
                <input type="hidden" name="process_kind" value="update_status_data">
            </form>

            <form method="post">
                <td>
                    <?php if($read['category'] === 1) {
                        print 'アレンジメント';
                    } else if($read['category'] === 2) {
                        print 'プリザーブドフラワー';
                    } else if($read['category'] === 3) {
                        print '花束';
                    } else if($read['category'] === 4) {
                        print '鉢植え';
                    } else if($read['category'] === 5) {
                        print '蘭';
                    } ?>
                </td>
                <td>
                    <button type="submit" name="delete_item">削除する</button>
                </td>
                <input type="hidden" name="item_id" value="<?php print $read['item_id']; ?>">
                <input type="hidden" name="process_kind" value="delete_item_data">
            </form>
        </tr>
    <?php } ?>
    </table>
<?php } ?>
</div>
</body>
</html>
