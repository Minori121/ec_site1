<?php
// 商品一覧ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/itemlist_model.php';
require_once './model/common.php';

$img_dir = './img/';
$request_method = get_request_method();
$process_kind   = get_post_data('process_kind');
$login_msg = '';

try {
    // DB接続
    $dbh = get_db_connect();

    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $login_msg = '現在、ログインしています。';
    }

    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }
    if ($page > 1) {
        $start = ($page * 9) - 9;
    } else {
        $start = 0;
    }

    $select = get_post_data('select');
    if ($select !== '') {
       try {
            $data = get_item_list_select($dbh, $select);
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    } else {
        // DBから一覧データを読み取る
        try {
             $data = get_item_list_page($dbh, $start);
             $page_num = get_count_item($dbh);
            //  var_dump($data);
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}
include_once './view/top_view.php';

?>
