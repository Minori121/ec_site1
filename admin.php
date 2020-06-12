<?php
// 商品管理ページのcontroller

// 設定ファイルを読み込み
require_once './conf/const.php';
require_once './model/admin_model.php';
require_once './model/common.php';

date_default_timezone_set('Asia/Tokyo');
$create_datetime = date('Y-m-d H:i:s');
$update_datetime = date('Y-m-d H:i:s');

$img_dir          = './img/';
$data             = array();
$err_msg          = array();
$result_msg       = array();
$new_img_filename = '';
$process_kind = '';

$request_method = get_request_method();

try {
    // DB接続
    $dbh = get_db_connect();
    // POSTされた時の処理
    if ($request_method === 'POST') {
        $process_kind = get_post_data('process_kind');
        if ($process_kind === 'insert_item') {

            // POSTデータを取得
            $item_name = get_post_data('item_name');
            $price     = get_post_data('price');
            $stock     = get_post_data('stock');
            $status    = get_post_data('status');
            $select    = get_post_data('select');
            // エラーチェック
            check_item_name($item_name);
            check_price($price);
            check_stock($stock);
            check_status($status);
            check_select($select);

            // アップロード画像ファイルの保存
            if (count($err_msg) === 0) {
                $tmpfile  = $_FILES['new_img']['tmp_name'];
                $filename = $_FILES['new_img']['name'];
                $new_img_filename = file_upload ($tmpfile, $filename, $img_dir);
            }
            // エラーがない場合の処理
            if (count($err_msg) === 0) {
                // 商品の新規追加処理
                $dbh->beginTransaction();
                try {
                    insert_item_master ($dbh, $item_name, $price, $new_img_filename, $status, $create_datetime, $update_datetime, $select);
                    $item_id = $dbh->lastInsertId();
                    insert_item_stock($dbh, $item_id, $stock, $create_datetime, $update_datetime);
                    $dbh->commit();
                    $result_msg[] = '商品を追加しました';
                } catch (PDOException $e) {
                    // ロールバック処理
                    $dbh->rollback();
                    // 例外をスロー
                    throw $e;
                }
            }
        }

        // 在庫数の更新処理
        if ($process_kind === 'update_stock_data') {
            $update_stock = get_post_data('update_stock');
            $item_id      = get_post_data('item_id');
            check_stock($update_stock);

            if (count($err_msg) === 0) {
                try {
                    update_item_stock ($dbh, $update_stock, $update_datetime, $item_id);
                    $result_msg[] = '在庫数を更新しました';
                } catch (PDOException $e) {
                    $err_msg[] =  'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
        }
        // ステータスの更新処理
        if ($process_kind === 'update_status_data') {
            $update_status = get_post_data('update_status');
            $item_id       = get_post_data('item_id');
            check_status($update_status);

            if (count($err_msg) === 0) {
                try {
                    update_item_status ($dbh, $update_status, $update_datetime, $item_id) ;
                    $result_msg[] = 'ステータスを変更しました';
                } catch (PDOException $e) {
                    $err_msg[] =  'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
        }
        // 価格の更新処理
        if ($process_kind === 'update_price_data') {
            $update_price = get_post_data('update_price');
            $item_id      = get_post_data('item_id');
            check_price($update_price);

            if (count($err_msg) === 0) {
                try {
                    update_item_price ($dbh, $update_price, $update_datetime, $item_id);
                    $result_msg[] = '価格を変更しました';
                } catch (PDOException $e) {
                    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
        }
        // 商品名の更新処理
        if ($process_kind === 'update_name_data') {
            $update_name = get_post_data('update_name');
            $item_id     = get_post_data('item_id');
            check_item_name($update_name);

            if (count($err_msg) === 0) {
                try {
                    update_item_name ($dbh, $update_name, $update_datetime, $item_id);
                    $result_msg[] = '商品名を変更しました';
                } catch (PDOException $e) {
                    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
                }
            }
        }
        // 商品の削除処理
        if ($process_kind === 'delete_item_data') {
            $item_id = get_post_data('item_id');
            $dbh->beginTransaction();

            try {
                // 商品マスターから商品を削除
                delete_item_master ($dbh, $item_id);
                delete_item_stock ($dbh, $item_id);
                $result_msg[] = '商品を削除しました。';
                $dbh->commit();
            } catch (PDOException $e) {
                // ロールバック処理
                $dbh->rollback();
                // 例外をスロー
                throw $e;
            }
        }

    }// $_SERVER['REQUEST_METHOD'] === 'POST'の終了

    $select = get_post_data('select');
    if ($select !== '') {
       try {
            $data = get_item_list_admin_select($dbh, $select);
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    } else {
        try {
            $data = get_item_list_admin($dbh);
            // $data = escape($datas);
            // var_dump($data);
        } catch (PDOException $e) {
            $err_msg[] = 'データを取得できませんでした。理由：'. $e->getMessage();
        }
    }
}catch (PDOException $e) {
    $err_msg[] = 'データベース処理でエラーが発生しました。理由：' .$e->getMessage();
}

include_once './view/admin_view.php';

?>
