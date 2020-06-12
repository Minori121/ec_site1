<?php
/** ユーザテーブルのデータを取得する
* 必要なデータのみを取得
*/
function get_ec_user_register($dbh, $user_name) {
        $sql = "SELECT
                    user_name
                FROM
                    ec_user
                WHERE
                    user_name = ?";
        return fetch_all_query($dbh, $sql, array($user_name));
}


/**
* ユーザテーブルにデータを作成
* @oaram obj $dbh DBハンドル
* @param str $user_name 商品名
* @param str $password 価格
* @param str $create_datetime 日付
* @param str $update_datetime 日付
* @return bool
*/
function insert_ec_user($dbh, $user_name, $password, $create_datetime, $update_datetime) {
        $sql = 'INSERT INTO ec_user(user_name, password, create_datetime, update_datetime)
                VALUES(?, ?, ?, ?)';
        return execute_query($dbh, $sql, array($user_name, $password, $create_datetime, $update_datetime));
}


/** 新規登録画面でのエラーをチェックする
* $user_name, $password
*/
function check_user_name($register_regex, $user_name) {
    global $err_msg;

    if ($user_name === '') {
        $err_msg[] = 'ユーザ名を入力してください';
    } else if (!preg_match($register_regex, $user_name)) {
        $err_msg[] = 'ユーザ名は6文字以上8文字以下の半角英数字で入力してください。';
    }
}

function check_password($register_regex, $password) {
    global $err_msg;

    if ($password === '') {
        $err_msg[] = 'パスワードを入力してください';
    } else if (!preg_match($register_regex, $password)) {
        $err_msg[] = 'パスワードは6文字以上8文字以下の半角英数字で入力してください。';
    }
}
