<?php

session_start();
require_once('../../../wp-config.php');
global $wpdb;
$date            = date('Y-m-d H:i:s');


$cek = $wpdb->get_results("SELECT tgl_tayang,add_id,tgl_tayang FROM wp_aads", ARRAY_A);

foreach ($cek as $c) {
    $durasi = convertDate($c['tgl_tayang']);
    if ($durasi >= 30) {
        $table  = "wp_aads";
        $data   = array(
            'status_tayang' => "0",
            'tgl_tayang' => $date
        );
        $condition = array(
            'add_id' => $c['add_id']
        );
        $cek = $wpdb->update($table, $data, $condition);
        echo "<script>alert('Masa tayang habis $c[add_id]')</script>";
    } else {
        echo "<script>alert('masih ada $c[add_id]')</script>";
    }
}
