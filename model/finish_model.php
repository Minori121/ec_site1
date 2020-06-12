<?php
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
                    ec_item_master.status,
                    ec_cart.id,
                    ec_cart.user_id,
                    ec_cart.amount,
                    ec_item_stock.stock
                FROM
                    ec_item_master
                INNER JOIN ec_cart
                ON         ec_item_master.item_id = ec_cart.item_id
                INNER JOIN ec_item_stock
                ON         ec_item_master.item_id = ec_item_stock.item_id
                WHERE
                    ec_cart.user_id = ?';
        return fetch_all_query($dbh, $sql, array($user_id));
}

/** 購入履歴テーブルにinsert　*/
function insert_item_history($dbh, $data, $user_id, $create_datetime) {
        foreach ($data as $read){
            $sql = 'INSERT INTO ec_history(item_id, user_id, create_datetime, buy_amount)
                    VALUES(?, ?, ?, ?)';
            return execute_query($dbh, $sql, array($read['item_id'], $user_id, $create_datetime, $read['amount']));
    }
}

/** 在庫情報テーブルの在庫数を更新（購入後在庫数を1つ減らす）　*/
function reduce_item_stock ($dbh, $data, $update_datetime){
    foreach ($data as $read){
        $sql = 'UPDATE ec_item_stock
                SET    stock           = stock - ?,
                       update_datetime = ?
                WHERE  item_id         = ?
                AND    stock >= ?';
        return execute_query($dbh, $sql, array($read['amount'], $update_datetime, $read['item_id'], $read['amount']));
    }
}

/**
* カートテーブルからデータを削除
* @oaram obj $dbh DBハンドル
* @param int $user_id
* @param int $item_id
*/
function delete_ec_cart_finish($dbh, $user_id) {
        $sql = 'DELETE FROM ec_cart
                WHERE user_id = ?';
        return execute_query($dbh, $sql, array($user_id));
}

function check_sum($sum) {
    global $err_msg;
    if ($sum < 0 || $sum = '') {
        $err_msg[] = '正しくありません';
    }

}

function check_change($change) {
    global $err_msg;

    if ($change < 0) {
        $err_msg[] = 'お金が足りません';
    }
}


/** 購入処理でのエラーをチェックする
* $money, $selection, $price
*/
function check_money($money) {
    global $err_msg;

    if ($money === '') {
        $err_msg[] = 'お金を入力してください。';
    } else if ((ctype_digit($money) && $money >= 0) === FALSE) {
        $err_msg[] = 'お金は半角数字かつ0以上の整数で入力してください。';
    }
}

function check_item_id($item_id) {
    global $err_msg;

    if ($item_id === '') {
        $err_msg[] = '商品を選択してください。';
    }
}

function check_cart_amount($data) {
    global $err_msg;

    foreach($data as $read) {
        if ($read['amount'] > $read['stock']) {
            $err_msg[] = $read['name'] . 'の在庫が不足しております。買い物かごで数量を'. $read['stock']. '以下に変更して下さい。';
        }
    }
}
function check_cart_status($data) {
    global $err_msg;

    foreach($data as $read) {
        if($read['status'] === 0) {
            $err_msg[] = $read['name'] . 'は購入できません。買い物かごから削除してください。';
        }
    }
}
