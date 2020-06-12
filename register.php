<?php
// 会員登録ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/register_model.php';
require_once './model/common.php';

date_default_timezone_set('Asia/Tokyo');
$create_datetime = date('Y-m-d H:i:s');
$update_datetime = date('Y-m-d H:i:s');

$err_msg          = array();
$result_msg       = '';

$request_method = get_request_method();

try {
    // DB接続
    $dbh = get_db_connect();
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        header('Location: itemlist.php');
        exit;
    }

    if ($request_method === 'POST') {
        $user_name = get_post_data('user_name');
        $password  = get_post_data('password');
        $register_regex = '/^[a-zA-Z0-9]{6,8}$/';
        // エラーチェック
        check_user_name($register_regex, $user_name) ;
        check_password($register_regex, $password);

        if (count($err_msg) === 0 ){
            // ユーザーテーブルから情報を取得
            $data = get_ec_user_register($dbh, $user_name);
            if(empty($data)) {
                try {
                    // ユーザ情報を登録
                    insert_ec_user($dbh, $user_name, $password, $create_datetime, $update_datetime);
                    $result_msg = '新規登録が完了しました。「ログインする」ボタンよりログインしてください。';
                } catch (PDOException $e) {
                    $err_msg[] = 'ユーザ登録ができませんでした。理由：' .$e->getMessage();
                }
            } else {
                    $err_msg[] = 'このユーザ名はすでに使用されています。';
            }
        }
    }

} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/register_view.php';
