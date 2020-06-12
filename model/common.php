<?php
/**
* DBハンドルを取得
* @return obj $dbh DBハンドル
*/
function get_db_connect() {
    try {
        // データベースに接続
        $dbh = new PDO(DSN, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => DB_CHARSET));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
        throw $e;
    }
    return $dbh;
}

/** クエリを実行しその結果を配列で取得する
* @param obj $dbh
* @param str $sql
* @return array
*/
function fetch_all_query($dbh, $sql, $params = array()) {
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
    return $rows;
}

function execute_query($dbh, $sql, $params = array()) {
    try {
        $stmt = $dbh->prepare($sql);
        return $stmt->execute($params);
    } catch(PDOException $e) {
        throw $e;
    }
}

/**
* リクエストメソッドを取得
* @return str
*/
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}

/** POSTデータを取得する
* @param str $str
* @param $key
*/
function get_post_data($key) {
    $str = '';
    if (isset($_POST[$key]) === TRUE) {
        $str = $_POST[$key];
    }
    return $str;
}

function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}

/** 画像アップロードの処理
* $tmpfile, $filename はtool.phpで定義
*/
function file_upload ($tmpfile, $filename, $img_dir){
    global $err_msg;

    // HTTP POSTでファイルがアップロードされたかどうかチェック
    if (is_uploaded_file($tmpfile) === TRUE) {
        // 画像の拡張子を取得
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        // 指定の拡張子であるかどうかチェック
        if (strtolower($extension) === 'jpeg' || strtolower($extension) === 'jpg'|| strtolower($extension) === 'png') {
            // 保存する新しいファイル名の生成
            $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
            // 同名ファイルが存在するかどうかチェック
            if (is_file($img_dir . $new_img_filename) !== TRUE) {
                // アップロードされたファイルを指定してディレクトリに移動して保存
                if (move_uploaded_file($tmpfile, $img_dir . $new_img_filename) !== TRUE) {
                    $err_msg[] = 'ファイルのアップロードに失敗しました。';
                }
            } else {
                $err_msg[] = 'ファイルのアップロードに失敗しました。再度お試しください。';
            }
        } else {
            $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPGまたはPNGのみ利用可能です。';
        }
    } else {
        $err_msg[] = 'ファイルを選択してください。';
    }
    return $new_img_filename;
}

function h($str){
  return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
