<?php
// 商品一覧ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/itemlist_model.php';
require_once './model/common.php';
require_once './model/login_model.php';

$img_dir = './img/';
$request_method = get_request_method();
$process_kind   = get_post_data('process_kind');
$login_msg = '';
$err_msg = array();

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

    $order = get_get('order');
    $select_category = get_post_data('search_c');
    $select_type = get_post_data('search_t');
    if($order !== '') {
        try {
            $items = get_item_list_order($dbh, $order, $start);
            $page_num = get_count_item($dbh);
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    } else if ($select_category !== '' && $select_type === '') {
       try {
            $items = get_item_list_select_category($dbh, $select_category);
            $page_num = '';
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    } else if ($select_category === '' && $select_type !== '') {
        try {
            $items = get_item_list_select_type($dbh, $select_type);
            $page_num = '';
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    } else if ($select_category !== '' && $select_type !== '') {
        try {
            $items = get_item_list_select($dbh, $select_category, $select_type);
            $page_num = '';
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    }


    else {
        // DBから一覧データを読み取る
        try {
             $items = get_item_list_page($dbh, $start);
             $page_num = get_count_item($dbh);
            //  var_dump($data);
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}
include_once './view/itemlist_view.php';

?>
