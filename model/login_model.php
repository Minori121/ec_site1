<?php
function check_ec_user_login($dbh, $user_name, $password) {
    global $err_msg;
    $user_id = '';
        $sql = 'SELECT
                    user_id,
                    user_name
                FROM
                    ec_user
                WHERE
                    user_name = ?
                AND
                    password = ?';

        $data = fetch_all_query($dbh, $sql, array($user_name, $password));
    if (isset($data)) {
        $_SESSION['user_id'] = $data[0]['user_id'];
        $_SESSION['user_name'] = $data[0]['user_name'];
        if($user_name === 'admin1') {
           header('Location: admin.php');
           exit;
        } else {
            header('Location: itemlist.php');
            exit;
        }
    } else {
        $err_msg[] = 'ログインができませんでした。';
    }
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
