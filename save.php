<?php
require_once('../../../wp-config.php');
global $wpdb;


$date = date('Y-m-d H:i:s');
$table = "wp_chat";
$data = array(
    'receiver_id' => $_POST['receiver'],
    'send_id' => $_POST['sender'],
    'message' =>  $_POST['message'],
    'type_chat' => $_POST['type'],
    'chat_at' => $date
);

$cek = $wpdb->insert($table, $data, $format);

if ($cek) {
    echo "berhasil";
} else {
    echo "gagal";
}
