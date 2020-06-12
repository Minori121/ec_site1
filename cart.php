<?php
// ショッピングカートのcontoller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/cart_model.php';
require_once './model/common.php';

date_default_timezone_set('Asia/Tokyo');
$update_datetime = date('Y-m-d H:i:s');
$create_datetime = date('Y-m-d H:i:s');
$img_dir = './img/';
$err_msg = array();
$data = array();
$result_msg = array();
$stock_data = array();
$kist = array();
$login_msg = '';
$request_method = get_request_method();

try {
    // DB接続
    $dbh = get_db_connect();
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $login_msg = '現在、ログインしています。';
    } else {
        header('Location: login.php');
        exit;
    }

    if ($request_method === 'POST') {
        $process_kind = get_post_data('process_kind');
        if ($process_kind !== 'delete_item' && $process_kind !== 'update') {
            $item_id = get_post_data('item_id');
            $amount  = get_post_data('amount');
            check_amount($amount);
            check_item_id($item_id);

            if (count($err_msg) === 0){
                check_stock_amount($dbh, $item_id, $amount);
            }

            if (count($err_msg) === 0) {
                try {
                    $data = get_ec_cart_table($dbh, $user_id, $item_id);
                } catch (PDOException $e) {
                    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }

                try {
                    if (count($data) > 0) {
                        update_ec_cart_amount ($dbh, $user_id, $item_id, $amount, $update_datetime);
                    } else {
                        // データがなければカートテーブルに商品をinsert
                        insert_ec_cart ($dbh, $user_id, $item_id, $amount, $create_datetime, $update_datetime);
                    }

                } catch (PDOException $e) {
                    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
        }

        if ($process_kind === 'delete_item') {
            try {
                $cart_id = get_post_data('cart_id');
                // カートテーブルから商品を削除
                delete_ec_cart ($dbh, $user_id, $cart_id);
                $result_msg[] = 'カートから商品を削除しました。';
            } catch (PDOException $e) {
                $err_msg[] = 'データを削除できませんでした。理由：'. $e->getMessage();
            }
        }

        if ($process_kind === 'update') {
            try {
                $cart_id       = get_post_data('cart_id');
                $update_amount = get_post_data('update_amount');
                $item_id       = get_post_data('item_id');
                // 在庫数とのエラーチェック
                $stock_data = get_stock_data_cart($dbh, $item_id);
                $stock = $stock_data[0]['stock'];
                check_update_amount($update_amount);

                if(count($err_msg) === 0) {
                    if ($stock >= $update_amount) {
                        // カートテーブルの個数を更新
                        update_ec_cart ($dbh, $update_amount, $update_datetime, $cart_id);
                        $result_msg[] = '個数を変更しました。';
                    } else {
                        $err_msg[] = '在庫が足りません。個数を選びなおして下さい';
                    }
                }
            } catch (PDOException $e) {
                    $err_msg[] = 'データを更新できませんでした。理由：'. $e->getMessage();
            }
        }
    } // $_SERVER['REQUEST_METHOD'] === 'POST'の終了

    try {
        $data = get_cart_list($dbh, $user_id);
    } catch (PDOException $e) {
        $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}


include_once './view/cart_view.php';
