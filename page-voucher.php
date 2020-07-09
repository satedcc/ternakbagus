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
                                                <button class="btn btn-primary block w-100 my-2">Klaim Voucher</button>
                                                <button class="btn btn-info block w-100 my-2">Beli Voucher</button>
                                            </form>
                                            <span class="font-italic f-12 d-block">* 1 voucher untuk 1 iklan</span>
                                            <span class="font-italic f-12">* 1 voucher bernilai Rp.2000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="f-18 bold-md my-3">Beli Voucher</h1>
                    <form action="../beli/" method="post">
                        <div class="content-utama p-4">
                            <h2 class="f-18">Pembelian voucher ternakbagus</h2>
                            <div class="voucher-package">
                                <div>
                                    <input type="radio" name="paket" id="paket" value="1">
                                    <label for="paket">
                                        <h3 class="f-14 bold-md">Paket 1</h3>
                                        <h1 class="bold-xl f-30">Rp. 2.500</h1>
                                        <ul>
                                            <li>Masa berlaku 30 hari</li>
                                        </ul>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="paket" id="paket-four" value="4">
                                    <label for="paket-four">
                                        <h3 class="f-14 bold-md">Paket 4</h3>
                                        <h1 class="bold-xl f-30">Rp. 10.000</h1>
                                        <ul>
                                            <li>Gratis 1 Voucher</li>
                                            <li>Masa berlaku 30 hari</li>
                                        </ul>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="paket" id="paket-ten" value="10">
                                    <label for="paket-ten">
                                        <h3 class="f-14 bold-md">Paket 10</h3>
                                        <h1 class="bold-xl f-30">Rp. 25.000</h1>
                                        <ul>
                                            <li>Gratis 3 Voucher</li>
                                            <li>Masa berlaku 30 hari</li>
                                        </ul>
                                    </label>
                                </div>
                            </div>
                            <div class="d-md-flex">
                                <div class="w-100 m-2">
                                    <span>Metode Pembayaran</span>
                                    <div>
                                        <select name="" id="" class="w-100">
                                            <option value="">Transfer</option>
                                            <option value="" disabled>Kartu Kredit</option>
                                            <option value="" disabled>Virtual Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-100  m-2">
                                    <div>
                                        <span>Pilih Bank</span>
                                        <div>
                                            <select id="" class="w-100" name="bank">
                                                <option value="MANDIRI">BANK MANDIRI - 9000023232</option>
                                                <option value="BCA">BANK BCA - 9000023232</option>
                                                <option value="BRI">BANK BNI - 9000023232</option>
                                                <option value="BNI">BANK BRI - 9000023232</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-2">
                                <button class="glow-btn">Bayar Sekarang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php

    get_footer();
} else {
    header('location:../');
}
