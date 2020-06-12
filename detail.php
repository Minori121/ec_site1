<?php
// 商品一覧ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/detail_model.php';
require_once './model/common.php';

date_default_timezone_set('Asia/Tokyo');
$update_datetime = date('Y-m-d H:i:s');
$create_datetime = date('Y-m-d H:i:s');
$img_dir = './img/';
$err_msg = array();
$data    = array();
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
        // POSTデータの取得
        $item_id = get_post_data('item_id');
        check_item_id($item_id);

        try {
            if (count($err_msg) === 0) {
                // データベースから該当データの取得
                $data = get_item_list_result($dbh, $item_id);

                if (count($data) > 0) {
                    $item_name = $data[0]['name'];
                    $price = (int)$data[0]['price'];
                    $new_img_filename = $data[0]['img'];
                    $stock = (int)$data[0]['stock'];
                    $status = (int)$data[0]['status'];
                }
            }
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：' .$e->getMessage();
        }
    } else {
        $err_msg[] = '不正な処理です。';
    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/detail_view.php';
