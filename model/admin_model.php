<?php
/** 商品情報と在庫情報を取得する
* 必要なデータのみを取得するために3パターン用意
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_item_list_admin($dbh) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_master.category,
                ec_item_stock.stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id';
    return fetch_all_query($dbh,$sql);
}

/** 商品情報と在庫情報を取得する
* selectされたカテゴリのみを取得
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_item_list_admin_select($dbh, $select) {
        $sql = 'SELECT
                    ec_item_master.item_id,
                    ec_item_master.name,
                    ec_item_master.price,
                    ec_item_master.img,
                    ec_item_master.status,
                    ec_item_master.category,
                    ec_item_stock.stock
                FROM
                    ec_item_master
                INNER JOIN ec_item_stock
                ON         ec_item_master.item_id = ec_item_stock.item_id
                WHERE
                    ec_item_master.category = ?';
        return fetch_all_query($dbh, $sql, array($select));
}


/**
* 商品情報テーブルにデータを作成
* @oaram obj $dbh DBハンドル
* @param str $item_name 商品名
* @param int $price 価格
* @param str $new_img_filename ファイル名
* @param str $date 日付
* @return bool
*/
function insert_item_master($dbh, $item_name, $price, $new_img_filename, $status, $create_datetime, $update_datetime, $select) {
        $sql = 'INSERT INTO ec_item_master(name, price, img, status, create_datetime, update_datetime, category)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        return execute_query($dbh, $sql, array($item_name, $price, $new_img_filename, $status, $create_datetime, $update_datetime, $select));
}

/**
* 在庫情報テーブルにデータを作成
* @param obj $dbh
* @oaram int $stock 在庫数
* @param str $date
*/
function insert_item_stock($dbh, $item_id, $stock, $create_datetime, $update_datetime) {
        $sql = 'INSERT INTO ec_item_stock(item_id, stock, create_datetime, update_datetime)
                VALUES(?, ?, ?, ?)';
        return execute_query($dbh, $sql, array($item_id, $stock, $create_datetime, $update_datetime));
}

/** 在庫情報テーブルの在庫数を更新　*/
function update_item_stock ($dbh, $update_stock, $update_datetime, $item_id) {
    $sql = 'UPDATE ec_item_stock
            SET    stock           = ?,
                   update_datetime = ?
            WHERE  item_id         = ?';
    return execute_query($dbh, $sql, array($update_stock, $update_datetime, $item_id));
}

/** 商品情報テーブルのステータスを更新　*/
function update_item_status ($dbh, $update_status, $update_datetime, $item_id) {
    $sql = 'UPDATE ec_item_master
            SET    status          = ?,
                   update_datetime = ?
            WHERE  item_id         = ?';
    return execute_query($dbh, $sql, array($update_status, $update_datetime, $item_id));
}

/** 商品情報テーブルの価格を更新　*/
function update_item_price ($dbh, $update_price, $update_datetime, $item_id) {
    $sql = 'UPDATE ec_item_master
            SET    price           = ?,
                   update_datetime = ?
            WHERE  item_id         = ?';
    return execute_query($dbh, $sql, array($update_price, $update_datetime, $item_id));
}

/** 商品情報テーブルの商品名を更新　*/
function update_item_name ($dbh, $update_name, $update_datetime, $item_id) {
    $sql = 'UPDATE ec_item_master
            SET    name            = ?,
                   update_datetime = ?
            WHERE  item_id         = ?';
    return execute_query($dbh, $sql, array($update_name, $update_datetime, $item_id));
}

/**
* 商品情報テーブルからデータを削除
* @oaram obj $dbh DBハンドル
* @param int $item_id
*/
function delete_item_master ($dbh, $item_id) {
        $sql = 'DELETE FROM ec_item_master
                WHERE item_id = ?';
        return execute_query($dbh, $sql, array($item_id));
}

/**
* 商品在庫テーブルからデータを削除
* @oaram obj $dbh DBハンドル
* @param int $item_id
*/
function delete_item_stock ($dbh, $item_id) {
        $sql = 'DELETE FROM ec_item_stock
                WHERE item_id = ?';
        return execute_query($dbh, $sql, array($item_id));
}

/** 商品登録画面でのエラーをチェックする
* $item_name, $price, $stock, &update_stock
*/
function check_item_name($item_name) {
    global $err_msg;

    if ($item_name === '') {
        $err_msg[] = '商品名を入力してください。';
    }
}

function check_price($price) {
    global $err_msg;

    if ($price === '') {
        $err_msg[] = '価格を入力してください。';
    } else if ((ctype_digit($price) && $price >= 0) === FALSE) {
        $err_msg[] = '価格は半角数字かつ0以上の整数で入力してください。';
    }
}

function check_stock($stock) {
    global $err_msg;

    if ($stock === '') {
        $err_msg[] ='在庫数を入力してください';
    } else if ((ctype_digit($stock) && $stock >= 0) === FALSE) {
        $err_msg[] = '在庫数は半角数字かつ0以上の整数で入力してください。';
    }
}

function check_status($status) {
    global $err_msg;

    if ($status === '') {
        $err_msg[] ='ステータスを入力してください';
    } else if ($status !== '1' && $status !== '0') {
        $err_msg[] = 'ステータスの値が正しくありません';
    }
}

function check_select($select) {
    global $err_msg;

    if ($select === '') {
        $err_msg[] ='カテゴリを入力してください';
    } else if ($select !== '1' && $select !== '2' && $select !== '3' && $select !== '4' && $select !== '5') {
        $err_msg[] = 'カテゴリの値が正しくありません';
    }
}

/** 画像アップロードの処理
* $tmpfile, $filename はtool.phpで定義
*/
function file_upload ($tmpfile, $filename, $img_dir){
    global $err_msg;

    // HTTP POSTでファイルがアップロードされたかどうかチェック
    if (is_uploaded_file($tmpfile) === TRUE) {
        // 画像の拡張子を取得
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        // 指定の拡張子であるかどうかチェック
        if (strtolower($extension) === 'jpeg' || strtolower($extension) === 'jpg'|| strtolower($extension) === 'png') {
            // 保存する新しいファイル名の生成
            $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
            // 同名ファイルが存在するかどうかチェック
            if (is_file($img_dir . $new_img_filename) !== TRUE) {
                // アップロードされたファイルを指定してディレクトリに移動して保存
                if (move_uploaded_file($tmpfile, $img_dir . $new_img_filename) !== TRUE) {
                    $err_msg[] = 'ファイルのアップロードに失敗しました。';
                }
            } else {
                $err_msg[] = 'ファイルのアップロードに失敗しました。再度お試しください。';
            }
        } else {
            $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPGまたはPNGのみ利用可能です。';
        }
    } else {
        $err_msg[] = 'ファイルを選択してください。';
    }
    return $new_img_filename;
}



