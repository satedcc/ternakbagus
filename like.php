<?php
session_start();
require_once('../../../wp-config.php');
global $wpdb;
$date       	= date('Y-m-d H:i:s');

$status = $_POST['status'];
if ($status == "inputpesan") {
	$member = $_POST['member'];
	$iklan = $_POST['iklan'];
	$pesan = $_POST['pesan'];

	$tablepesan = "wp_chat";
	$data = array(
		'receiver_id' => $member,
		'send_id' => $_SESSION['member'],
		'add_id' => $iklan,
		'message' => $pesan,
		'status_chat' => "N",
		'chat_at' => $date
	);
	$cekpesan = $wpdb->insert($tablepesan, $data, $format);
} elseif ($status == "inputawar") {
	$member = $_POST['member'];
	$iklan = $_POST['iklan'];
	$tawar = "Hello, saya menawar iklannya anda pada harga Rp. " . format_rupiah($_POST['tawar']) . ". Jika berkenan mohon membalas pesan ini";

	$tablepesan = "wp_chat";
	$data = array(
		'receiver_id' => $member,
		'send_id' => $_SESSION['member'],
		'add_id' => $iklan,
		'message' => $tawar,
		'status_chat' => "N",
		'chat_at' => $date
	);
	$cekpesan = $wpdb->insert($tablepesan, $data, $format);
} else {
	$iklan = $_POST['iklan'];
	$member = $_SESSION['member'];

	$liketable 		= "wp_like";

	$cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_like WHERE member_id='" . $member . "' AND add_id='" . $iklan . "'");
	if ($cek > 0) {
		echo "data sudah ada";
	} else {



		$data	   		= array(
			'add_id'	=>	$iklan,
			'member_id'		=> $member,
			'like_count' => 1,
			'create_like' => $date
		);

		$like = $wpdb->insert($liketable, $data, $format);
	}
}
