<?php
// 商品一覧ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/mypage_model.php';
require_once './model/common.php';

date_default_timezone_set('Asia/Tokyo');
$update_datetime = date('Y-m-d H:i:s');
$create_datetime = date('Y-m-d H:i:s');
$img_dir = './img/';
$err_msg = array();
$change  = '';
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

    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }
    if ($page > 1) {
        $start = ($page * 10) - 10;
    } else {
        $start = 0;
    }

    try {
        if (count($err_msg) === 0) {
            // データベースから該当データの取得
            $data = get_history_list($dbh, $user_id, $start);
            $page_num = get_count_history($dbh, $user_id);
            if (count($data) <= 0) {
                $err_msg[] = '購入履歴はありません。';
            }
        }
    }catch (PDOException $e) {
        $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/mypage_view.php';
