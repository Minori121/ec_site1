<?php
/** カート情報を取得する
* 必要なデータのみを取得するために3パターン用意
* @param obj $dbh
* @param $rows 配列一覧データ
*/
function get_history_list($dbh, $user_id, $start) {
        $sql = 'SELECT
                    ec_item_master.item_id,
                    ec_item_master.name,
                    ec_item_master.price,
                    ec_item_master.img,
                    ec_history.history_id,
                    ec_history.user_id,
                    ec_history.buy_amount,
                    ec_history.create_datetime
                FROM
                    ec_item_master
                INNER JOIN ec_history
                ON         ec_item_master.item_id = ec_history.item_id
                WHERE
                    ec_history.user_id = ?
                LIMIT
                    ?, 10';
        return fetch_all_query($dbh, $sql, array($user_id, $start));
}

function get_count_history($dbh, $user_id) {
    global $pagination;

try {
    $sql = 'SELECT
                COUNT(*) history_id
            FROM
                ec_history
            WHERE
                ec_history.user_id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_id , PDO::PARAM_INT);
    $stmt->execute();
    $stmt = $stmt->fetchColumn();
    $pagination = ceil($stmt / 10);
} catch (PDOException $e) {
        $err_msg[] = 'データを取得できませんでした。理由：' .$e->getMessage();
    }
    return $pagination;
}
