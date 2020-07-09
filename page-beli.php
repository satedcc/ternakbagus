<?php
session_start();
$sid = session_id();
date_default_timezone_set('Asia/Jakarta');

if (isset($_SESSION['id'])) {

    if ($_POST['paket'] == "1") {
        $jumlah  = 1;
        $harga   = 2500;
        $voucher = 2500;
        $keterangan = "<h1 class='f-18 m-0 bold-md'>Paket " . $_POST['paket'] . "</h1>
        <span class='f-12'>(Tiap voucher tayang 30 hari ternakbagus.com)</span>";
    } elseif ($_POST['paket'] == "4") {
        $jumlah  = 5;
        $harga   = 10000;
        $voucher = 2500 * 5;
        $keterangan = "<h1 class='f-18 m-0 bold-md'>Paket " . $_POST['paket'] . "</h1>
        <span class='f-12'>(Gratis 1 voucher & Tiap voucher tayang 30 hari ternakbagus.com)</span>";
    } elseif ($_POST['paket'] == "10") {
        $jumlah  = 13;
        $harga   = 25000;
        $voucher = 2500 * 13;
        $keterangan = "<h1 class='f-18 m-0 bold-md'>Paket " . $_POST['paket'] . "</h1>
        <span class='f-12'>(Gratis 3 voucher & Tiap voucher tayang 30 hari ternakbagus.com)</span>";
    }

    if (isset($_POST) && $_POST['jumlah'] != '' && $_POST['kode'] != '') {
        $date = date('Y-m-d H:i:s');
        $table = "wp_vouchers";
        $data  = array(
            'member_id'     => $_SESSION['member'],
            'v_paket'     => $_POST['paket'],
            'jumlah'        => $_POST['jumlah'],
            'kode_bayar'    => $_POST['kode'],
            'bank'          => $_POST['bank'],
            'status_bayar'  => "0",
            'create_at'     => $date
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
                                                <td class="w-50">Paket</td>
                                                <td class="text-right">
                                                    <div class="paket">
                                                        <input type="text" name="paket" value="<?= $_POST['paket']; ?>" hidden>
                                                        <?php echo $keterangan; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="w-50">Nilai Voucher</td>
                                                <td class="text-right">Rp. <?= format_rupiah($voucher); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td class="text-right"><input type="text" value="<?= $jumlah; ?>" class="voucher-input" name="jumlah" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Total Harga</td>
                                                <td class="text-right">Rp. <?php echo format_rupiah($harga); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Diskon</td>
                                                <td class="text-right">0%</td>
                                            </tr>
                                            <tr class="bold-sm f-18">
                                                <td class="bg-info py-3 text-white">Kode Pembayaran</td>
                                                <td class="text-right bg-secondary text-white">
                                                    <input type="text" value="<?= randomString(5); ?>" class="voucher-input bold-md text-white" readonly name="kode"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr class="f-20 bold-md">
                                                <td>Total</td>
                                                <td class="text-right">Rp. <?php echo format_rupiah($harga); ?></td>
                                            </tr>
                                            <tr class="f-18">
                                                <td>Metode Pembayaran</td>
                                                <td class="text-right">
                                                    <span>Transfer</span>
                                                    <input type="text" name="bank" id="" value="<?= $_POST['bank']; ?>" hidden>
                                                    <h3 class="f-20 bold-md m-0">BANK <?= $_POST['bank']; ?></h3>
                                                    <h4 class="f-18 m-0">Rek. 90232323232</h4>
                                                    <h5 class="f-18">Gunawan Dwijatmiko</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button class="glow-btn block w-100 py-2 f-18" name="tombol">Bayar Sekarang</button>
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
