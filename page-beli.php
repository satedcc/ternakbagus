<?php
session_start();
$sid = session_id();
date_default_timezone_set('Asia/Jakarta');

if (isset($_SESSION['id'])) {
    $v = $_POST['voucher'] * 2000;

    if (isset($_POST) && $_POST['jumlah'] != '' && $_POST['kode'] != '') {
        $date = date('Y-m-d H:i:s');
        $table = "wp_vouchers";
        $data  = array(
            'member_id' => $_SESSION['member'],
            'jumlah' => $_POST['jumlah'],
            'kode_bayar' => $_POST['kode'],
            'status_bayar' => "0",
            'create_at' => $date
        );
        $hasil = $wpdb->insert($table, $data, $format);
        if ($hasil) {
            header('location:history/');
        }
    }
    get_header();
?>

    <div class="container bars">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="#" onclick="openNav()">
                    <i class="far fa-bars fa-2x"></i>
                </a>
            </div>
        </div>
    </div>

    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <div class="dashboard-content">
                        <div class="dashboard-head">
                            <ul>
                                <li><a href="../voucher">Voucher Anda</a></li>
                                <li><a href="../beli">Beli Voucher</a></li>
                                <li><a href="../history" class="active">History Pembelian</a></li>
                            </ul>
                        </div>
                        <div class="dashboard-body">
                            <form action="" method="post">
                                <h1 class="f-20 bold-md">DETAIL PEMBELIAN</h1>
                                <div>
                                    <p>Terima kasih telah melakukan pembelian voucher iklan</p>
                                    <table class="w-100">
                                        <tbody>
                                            <tr>
                                                <td class="w-50">Harga Voucher</td>
                                                <td class="text-right">Rp. 2000</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td class="text-right"><input type="text" value="<?= $_POST['voucher']; ?>" class="voucher-input" name="jumlah"></td>
                                            </tr>
                                            <tr>
                                                <td>Total Harga</td>
                                                <td class="text-right">Rp. <?php echo format_rupiah($v); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Diskon</td>
                                                <td class="text-right">0%</td>
                                            </tr>
                                            <tr class="bold-sm f-18">
                                                <td class="bg-info py-3 text-white">Kode Pembayaran</td>
                                                <td class="text-right bg-secondary text-white">
                                                    <input type="text" value="CVR023340011" class="voucher-input bold-md text-white" readonly name="kode"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr class="f-20 bold-md">
                                                <td>Total</td>
                                                <td class="text-right">Rp. <?php echo format_rupiah($v); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h1 class="my-3 bold-md f-14">Metode Pembayaran</h1>
                                    <div class="pembayaran">
                                        <div class="method">
                                            <input type="radio" name="method" id="mandiri">
                                            <label for="mandiri">
                                                <h2>Bank MANDIRI</h2>
                                                <span>REK 90023343434</span>
                                            </label>
                                        </div>
                                        <div class="method">
                                            <input type="radio" name="method" id="bca">
                                            <label for="bca">
                                                <h2>Bank BCA</h2>
                                                <span>REK 90023343434</span>
                                            </label>
                                        </div>
                                        <div class="method">
                                            <input type="radio" name="method" id="bri">
                                            <label for="bri">
                                                <h2>Bank BRI</h2>
                                                <span>REK 90023343434</span>
                                            </label>
                                        </div>
                                        <div class="method">
                                            <input type="radio" name="method" id="bni">
                                            <label for="bni">
                                                <h2>Bank BNI</h2>
                                                <span>REK 90023343434</span>
                                            </label>
                                        </div>
                                    </div>
                                    <button class="myButton block w-100 py-2 f-18" name="tombol">Bayar Sekarang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

    get_footer();
} else {
    header('location:../');
}
