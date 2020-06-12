<?php
function check_item_id($item_id) {
    global $err_msg;

    if ($item_id === '') {
        $err_msg[] = '商品を選択してください。';
    }
}

function get_item_list_result($dbh, $item_id) {
    $sql = "SELECT
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
                ec_item_master.item_id = ?";
    return fetch_all_query($dbh, $sql, array($item_id));
}
