<?php
/** 在庫情報を取得する
* 必要なデータのみを取得する
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function check_stock_amount($dbh, $item_id, $amount) {
    global $err_msg;

        $sql = 'SELECT
                    item_id
                FROM
                    ec_item_stock
                WHERE
                    item_id = ?
                AND
                    stock >= ?';
        $data = fetch_all_query($dbh, $sql, array($item_id, $amount));
    if (count($data) === 0) {
        $err_msg[] = '在庫が足りません。';
    }
}
// function check_stock_amount($dbh, $item_id, $amount) {
//     global $err_msg;
//     try {
//         $sql = 'SELECT
//                     item_id
//                 FROM
//                     ec_item_stock
//                 WHERE
//                     item_id = ?
//                 AND
//                     stock >= ?';
//         $stmt = $dbh->prepare($sql);
//         $stmt->bindValue(1, $item_id, PDO::PARAM_INT);
//         $stmt->bindValue(2, $amount , PDO::PARAM_INT);
//         $stmt->execute();
//         $rows = $stmt->fetchAll();
//         $rows = fetch_all_query($dbh, $sql, array($item_id, $amount));
//     } catch (PDOException $e) {
//         $err_msg[] = 'データを取得できませんでした。理由：' .$e->getMessage();
//     }
//     if (count($rows) === 0) {
//         $err_msg[] = '在庫が足りません。';
//     }
// }

/** 在庫情報を取得する
* 必要なデータのみを取得する
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_stock_data_cart($dbh, $item_id) {
        $sql = 'SELECT
                    item_id,
                    stock
                FROM
                    ec_item_stock
                WHERE
                    item_id = ?';
        return fetch_all_query($dbh, $sql, array($item_id));
}



/** カート情報を取得する
* 必要なデータのみを取得するために3パターン用意
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_cart_list($dbh, $user_id) {
        $sql = 'SELECT
                    ec_item_master.item_id,
                    ec_item_master.name,
                    ec_item_master.price,
                    ec_item_master.img,
                    ec_cart.id,
                    ec_cart.user_id,
                    ec_cart.amount
                FROM
                    ec_item_master
                INNER JOIN ec_cart
                ON         ec_item_master.item_id = ec_cart.item_id
                WHERE
                    ec_cart.user_id = ?';
        return fetch_all_query($dbh, $sql, array($user_id));
}

function get_ec_cart_table($dbh, $user_id, $item_id) {
        $sql = 'SELECT
                    item_id
                FROM
                    ec_cart
                WHERE
                    user_id = ?
                AND
                    item_id = ?';
        return fetch_all_query($dbh, $sql, array($user_id, $item_id));
}

/**
* カートテーブルにデータを作成
* @oaram obj $dbh DBハンドル
* @param int $user_id
* @param int $item_id
* @param int $amount ファイル名
* @param str $date 日付
* @return bool
*/
function insert_ec_cart ($dbh, $user_id, $item_id, $amount, $create_datetime, $update_datetime) {
        $sql = 'INSERT INTO ec_cart(user_id, item_id, amount, create_datetime, update_datetime)
                VALUES(?, ?, ?, ?, ?)';
        return execute_query($dbh, $sql, array($user_id, $item_id, $amount, $create_datetime, $update_datetime));
}

/** カートテーブルの個数を上書き　*/
function update_ec_cart_amount ($dbh, $user_id, $item_id, $amount, $update_datetime) {
    $sql = 'UPDATE ec_cart
            SET    amount           = amount + ?,
                   update_datetime  = ?
            WHERE  user_id  = ?
            AND    item_id = ?';
    return execute_query($dbh, $sql, array($amount, $update_datetime, $user_id, $item_id));
}

/** カートテーブルの個数を更新　*/
function update_ec_cart ($dbh, $update_amount, $update_datetime, $cart_id) {
    $sql = 'UPDATE ec_cart
            SET    amount           = ?,
                   update_datetime  = ?
            WHERE  id  = ?';
    return execute_query($dbh, $sql, array($update_amount, $update_datetime, $cart_id));
}

/**
* カートテーブルからデータを削除
* @oaram obj $dbh DBハンドル
* @param int $user_id
* @param int $item_id
*/
function delete_ec_cart ($dbh, $user_id, $cart_id) {
        $sql = 'DELETE FROM ec_cart
                WHERE user_id = ?
                AND id = ?';
        return execute_query($dbh, $sql, array($user_id, $cart_id));
}


function check_amount($amount) {
    global $err_msg;

    if ($amount < 0 || $amount > 5 || !ctype_digit($amount)) {
        $err_msg[] = '数量を正しく設定して下さい';
    } else if ($amount = '') {
        $err_msg[] = '数量を選択してください';
    }
}

function check_item_id($item_id) {
    global $err_msg;

    if ($item_id < 0 || $item_id='') {
        $err_msg[] = '商品を選択してください';
    }
}

function check_update_amount($update_amount) {
    global $err_msg;

    if ($update_amount === '') {
        $err_msg[] ='個数を入力してください';
    } else if ((ctype_digit($update_amount) && $stock >= 0) === FALSE) {
        $err_msg[] = '個数は半角数字かつ0以上の整数で入力してください。';
    }
}
