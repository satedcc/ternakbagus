<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {
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
                    <div class='alert alert-success' role='alert'>
                        <h1 class='f-18'>Hai <?= $_SESSION['nama'] ?>,</h1>
                        <p>Selamat datang dan bergabung di ternakbagus.com, sebagai bentuk terima kasih kami kepada anda, kami akan memberikan voucher yang bisa di gunakan untuk beriklan di ternakbagus.com.</p>
                        <a href='' class='myButton'>Beli Voucher</a>
                    </div>
                    <div class="dashboard-content">
                        <div class="dashboard-head">
                            <ul>
                                <li><a href="../voucher">Voucher Anda</a></li>
                                <li><a href="../beli">Beli Voucher</a></li>
                                <li><a href="../history" class="active">History Pembelian</a></li>
                            </ul>
                        </div>
                        <div class="dashboard-body">
                            <h1 class="f-20 bold-md">VOUCHER ANDA</h1>
                            <div class="py-5">
                                <div class="box">
                                    <div class="ribbon ribbon-top-left"><span>Voucer</span></div>
                                    <div class="voucher">
                                        <div class="item-voucher">
                                            <p>Selamat bergabung di ternakbagus, sebagai bentuk terima kasih kepada anda
                                                kami akan memberikan voucher yang bisa di gunakan untuk beriklan di
                                                ternakbagus</p>
                                            <h1 class="display-1 bold-xl text-white">10.000</h1>
                                            <hr>
                                            <span class="font-italic f-12">* Maksimal voucher free 5 kali penggunaan</span>
                                            <span class="float-right">
                                                <i class="fab fa-facebook-f mr-2"></i>
                                                <i class="fab fa-instagram mr-2"></i>
                                                <i class="fab fa-twitter mr-2"></i>
                                                <i class="fab fa-google mr-2"></i>
                                            </span>
                                        </div>
                                        <div class="p-4 item-voucher">
                                            <h2 class="bold-md mb-2 f-18">Hai, Satria</h2>
                                            <p class="f-12 mb-2">Jika vouchermu telah habis, silahkan membelinya di kami
                                                sehingga
                                                anda akan
                                                lebih
                                                mudah dalam beriklan di ternakbagus.</p>
                                            <form action="../beli" method="post">
                                                <input type="text" name="voucher" id="">
                                                <button class="button-md blue block w-100 my-2">Proses</button>
                                            </form>
                                            <span class="font-italic f-12 d-block">* 1 voucher untuk 1 iklan</span>
                                            <span class="font-italic f-12">* 1 voucher bernilai Rp.2000</span>
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
