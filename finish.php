<?php
// 商品一覧ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/finish_model.php';
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

    if ($request_method === 'POST') {
        // 商品の購入
        $money = get_post_data('money');
        $sum   = get_post_data('sum');
        check_money($money);
        check_sum($sum);

        try {
            if (count($err_msg) === 0) {
                // データベースから該当データの取得
                $data = get_cart_list($dbh, $user_id);
                if (count($data) > 0) {
                    // お釣りの計算
                    $change = (int)$money - $sum;
                    // お釣りのチェック
                    check_change($change);
                    // 個数のチェック
                    check_cart_amount($data);
                    check_cart_status($data);
                } else {
                    $err_msg[] = 'データがありません';
                }
            }
        }catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }

        // 今までのチェックでエラーが一つもなければ購入処理をする
        if (count($err_msg) === 0) {
            $dbh->beginTransaction();
            try {
                // 購入処理
                reduce_item_stock ($dbh, $data, $update_datetime);
                delete_ec_cart_finish($dbh, $user_id);
                insert_item_history($dbh, $data, $user_id, $create_datetime);
                $dbh->commit();
            } catch (PDOException $e) {
                $dbh->rollback();
                // 例外をスロー
                throw $e;
            }
        }
    } else {
        $err_msg[] = '不正な処理です。';
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/finish_view.php';
