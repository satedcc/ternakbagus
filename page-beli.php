<?php
session_start();
$sid = session_id();
date_default_timezone_set('Asia/Jakarta');

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
                    <h1 class="f-18 bold-md my-3">Beli Voucher</h1>
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
                            <h1 class="f-18">Pilih paket: </h1>
                            <form action="../detail-beli/" method="post">
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
                                            <select name="" id="" class="w-100 form-control">
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
                                                <select id="" class="w-100 form-control" name="bank">
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
                                    <button class="glow-btn">Selanjutnya</button>
                                </div>
                        </div>
                        </form>
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
