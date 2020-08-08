<?php

require_once('../../../wp-load.php');
global $wpdb;
$date           = date('Y-m-d H:i:s');

$table      = "wp_members";
$data       = array(
    'aktif' => "Y"
);
$condition  = array(
    'email' => $_GET['email'],
    'sid' => $_GET['id']
);

$cek = $wpdb->update($table, $data, $condition);
if ($cek) {
    header('location:login/?aktif=true');
} else {
    echo "<script>alert('Error')</script>";
}
