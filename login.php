<?php
// ログインページのcontroller

//設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/login_model.php';
require_once './model/common.php';



$err_msg          = array();
$data = array();
$result_msg = '';
$request_method = get_request_method();

try {
    // DB接続
    $dbh = get_db_connect();
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $name = $_SESSION['user_name'];
        header('Location: itemlist.php');
        exit;
    }
    // POSTされた場合の処理
    if ($request_method === 'POST') {
        // ログインボタンが押されたかどうかの確認
            $user_name = get_post_data('user_name');
            $password  = get_post_data('password');
            $register_regex = '/^[a-zA-Z0-9]{6,8}$/';;

            // エラーチェック
            check_user_name($register_regex, $user_name);
            check_password($register_regex, $password);

            if (count($err_msg) === 0 ) {
                try {
                    session_start();
                    check_ec_user_login($dbh, $user_name, $password);
                    $result_msg = 'ログインできました';
                } catch (PDOException $e) {
                    $err_msg[] = 'ユーザデータベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
    }
} catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/login_view.php';
