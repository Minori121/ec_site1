<?php
/** 商品情報と在庫情報を取得する
* 必要なデータのみを取得するために3パターン用意
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_item_list_index($dbh) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_stock. stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id
            WHERE
                status = 1';
    return fetch_all_query($dbh,$sql);
}

/** 商品情報と在庫情報を取得する
* 必要なデータのみを取得するために3パターン用意
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_item_list_page($dbh, $start) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_stock. stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id
            WHERE
                status = 1
            ORDER BY
                item_id DESC
            LIMIT
                ?, 9';
    return fetch_all_query($dbh, $sql, array($start));
}

function get_count_item($dbh) {
    global $pagination;
try {
    $sql = 'SELECT
                COUNT(*) item_id
            FROM
                ec_item_master
            WHERE
                status = 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $stmt = $stmt->fetchColumn();
    $pagination = ceil($stmt / 9);
} catch (PDOException $e) {
        $err_msg[] = 'データを取得できませんでした。理由：' .$e->getMessage();
    }
    return $pagination;
}


/** 商品情報と在庫情報を取得する
* selectされたカテゴリのみを取得
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_item_list_select_category($dbh, $select_category) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_stock. stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id
            WHERE
                status = 1
            AND
                ec_item_master.category = ?';
        return fetch_all_query($dbh, $sql, array($select_category));
}

function get_item_list_select_type($dbh, $select_type) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_stock. stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id
            WHERE
                status = 1
            AND
                ec_item_master.item_type = ?';
        return fetch_all_query($dbh, $sql, array($select_type));
}

function get_item_list_select($dbh, $select_category, $select_type) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_stock. stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id
            WHERE
                status = 1
            AND
                ec_item_master.category = ?
            AND
                ec_item_master.item_type = ?';
        return fetch_all_query($dbh, $sql, array($select_category, $select_type));
}

function get_item_list_order($dbh, $order, $start) {
    $sql = 'SELECT
                ec_item_master.item_id,
                ec_item_master.name,
                ec_item_master.price,
                ec_item_master.img,
                ec_item_master.status,
                ec_item_stock. stock
            FROM
                ec_item_master
            INNER JOIN ec_item_stock
            ON         ec_item_master.item_id = ec_item_stock.item_id
            ';
            if($order === '2') {
                $sql .= '
                WHERE status = 1
                ORDER BY price
                LIMIT
                ?, 9';
            } else if($order === '3') {
                $sql .= '
                WHERE status = 1
                ORDER BY price DESC
                LIMIT
                ?, 9';
            } else {
                $sql .= '
                WHERE status = 1
                ORDER BY item_id DESC
                LIMIT
                ?, 9';
            }
        return fetch_all_query($dbh, $sql, array($start));
}
