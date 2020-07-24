<?php
session_start();

global $wpdb;
if ($_SESSION['id'] != "") {
    // $table      = "wp_chat";
    // $condition  = array(
    //     'receiver_id' => $_GET['receiver'],
    //     'sender_id' => $_GET['sender'],
    //     'add_id' => $_GET['iklan']
    // );

    // $delete = $wpdb->delete($table, $condition);

    $delete = $wpdb->delete('wp_chat', array('receiver_id' => $_GET['receiver'], 'send_id' => $_GET['sender'], 'add_id' => $_GET['iklan']), array('%d', '%d', '%d'));

    if ($delete) {
        header('location:../inbox');
    } else {
        header('location:../inbox/?status=0');
    }
} else {
    header('location:' . get_site_url());
}
