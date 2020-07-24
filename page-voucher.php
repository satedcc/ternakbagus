<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {

    $promo = $wpdb->get_var("SELECT COUNT(*) FROM wp_vouchers WHERE kode_bayar LIKE '%promo%' AND member_id='" . $_SESSION['member'] . "'");

    if (isset($_POST) && $_POST['klaim'] != "") {
        $date = date('Y-m-d H:i:s');
        $table = "wp_vouchers";
        $data  = array(
            'member_id'     => $_SESSION['member'],
            'v_paket'       => "4",
            'jumlah'        => "4",
            'kode_bayar'    => "promo",
            'bank'          => "promo",
            'status_bayar'  => "1",
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
                    <?php
                    if ($promo > 0) {
                    } else {
                    ?>
                        <div class='alert alert-success' role='alert'>
                            <h1 class='f-18'>Hai <?= $_SESSION['nama'] ?>,</h1>
                            <p>Selamat datang dan bergabung di ternakbagus.com, sebagai bentuk terima kasih kami kepada anda, kami akan memberikan voucher yang bisa di gunakan untuk beriklan di ternakbagus.com.</p>
                            <form action="" method="post">
                                <button type="button" class="btn btn-info my-2" data-toggle="modal" data-target="#exampleModal">Klaim Voucher</button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="voucher-promo text-center">
                                                    <h5 class="bold-md f-30 m-0">SELAMAT</h5>
                                                    <p>Anda mendapatkan promo voucher dengan bernilai</p>
                                                    <h1 class="display-4 bold-lg">Rp 10.000</h1>
                                                    4 Voucher
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary" name="klaim" value="klaim">Klaim Voucher</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="dashboard-content">
                        <div class="dashboard-head">
                            <ul>
                                <li><a href="../voucher">Voucher Anda</a></li>
                                <li><a href="../beli">Beli Voucher</a></li>
                                <li><a href="../beli">Detail Pembelian</a></li>
                                <li><a href="../history">History Pembelian</a></li>
                            </ul>
                        </div>
                        <div class="dashboard-body">
                            <h1 class="f-20 bold-md">VOUCHER ANDA</h1>
                            <div class="py-5">
                                <div class="box">
                                    <div class="ribbon ribbon-top-left"><span>Voucer</span></div>
                                    <div class="voucher">
                                        <div class="item-voucher">
                                            <?php
                                            $voucher = $wpdb->get_var("SELECT SUM(jumlah) AS total FROM wp_vouchers WHERE member_id='" . $_SESSION['id_member'] . "' AND status_bayar='1'");
                                            $use = $wpdb->get_var("SELECT SUM(qty) AS total FROM wp_use WHERE member_id='" . $_SESSION['id_member'] . "'");
                                            $total = $voucher - $use;
                                            $nilai  = $total * 2500;
                                            ?>

                                            <p>Selamat bergabung di ternakbagus, untuk beriklan di ternakbagus.com silahkan membeli voucher yang telah kami siapkan sehingga dapat memudahkan anda untuk beriklan</p>
                                            <h1 class="display-1 bold-xl text-white"><?= format_rupiah($nilai); ?> </h1>
                                            <hr>
                                            <h5 class="f-18 text-white float-left">Jumlah voucher : <?= $total; ?></h5>

                                            <span class="float-right text-secondary">
                                                <i class="fab fa-facebook-f mr-2"></i>
                                                <i class="fab fa-instagram mr-2"></i>
                                                <i class="fab fa-twitter mr-2"></i>
                                                <i class="fab fa-google mr-2"></i>
                                            </span>
                                        </div>
                                        <div class="p-4 item-voucher">
                                            <h2 class="bold-md mb-2 f-18">Hai,<br> <?= $_SESSION['nama'] ?></h2>
                                            <p class="f-12 mb-2">Jika vouchermu telah habis, silahkan membelinya di kami
                                                sehingga
                                                anda akan
                                                lebih
                                                mudah dalam beriklan di ternakbagus.</p>
                                            <a href="../beli/" class="btn btn-info block w-100 my-2">Beli Voucher</a>
                                            <span class="font-italic f-12 d-block">* 1 voucher untuk 1 iklan</span>
                                            <span class="font-italic f-12">* 1 voucher bernilai Rp.2500</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
