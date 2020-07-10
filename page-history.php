<?php
session_start();
$sid = session_id();


if (isset($_SESSION['id'])) {
    $result = $wpdb->get_results("SELECT * FROM wp_vouchers WHERE member_id='" . $_SESSION['member'] . "' ORDER BY v_id DESC", ARRAY_A);
    //use_voucher($_POST['use'], $_POST['id']);

    if (isset($_POST['btn-konfirmasi'])) {
        konfirmasi();
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
                    if ($_GET['status'] == "1") {
                        echo "<div class='alert alert-success' role='alert'>
                            <h2 class='f-18 bold-md'>Data telah tersimpan</h2>
                            <p>Terima kasih telah melakukan pembayaran untuk voucher dan mohon menunggu konfirmasi dari admin kami untuk melakukan pengecekkan pembayaran anda.
                                Terima kasih
                            </p>
                        </div>";
                    } elseif ($_GET['status'] == "0") {
                        echo "<div class='alert alert-danger' role='alert'>
                            <h2 class='f-18 bold-md'>Data gagal tersimpan</h2>
                        </div>";
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
                            <?php
                            foreach ($result as $k) {
                                if ($k['status_bayar'] == "1") :
                                    $status = "<span class='py-2 px-2 f-12 rounded text-white bg-success'><i class='far fa-badge-check mr-2'></i>Lunas</span>";
                                else :
                                    $status = "<span class='py-2 px-2 f-12 rounded text-white bg-warning'><i class='far fa-hourglass-half mr-2'></i>Menunggu Pembayaran</span>";
                                endif;

                                if ($k['v_paket'] == "1") :
                                    $nilai = 2500;
                                elseif ($k['v_paket'] == "4") :
                                    $nilai = 10000;
                                elseif ($k['v_paket'] == "10") :
                                    $nilai = 25000;
                                endif;
                            ?>
                                <div class="history mb-3">
                                    <div class="text-center item-history">
                                        <span>Nilai Voucher</span>
                                        <h1 class="bold-xl display-4"><?= format_rupiah($nilai); ?></h1>
                                    </div>
                                    <div class="item-history">
                                        <span class="bold-sm f-12">Pembelian: <?php echo time_ago($k['create_at']) ?></span>
                                        <h2 class="f-20">Jumlah Voucher <?= $k['jumlah']; ?></h2>
                                        Status : <?= $status; ?>
                                    </div>
                                    <div class="text-center align-self-center item-history">
                                        <?php
                                        if ($k['status_bayar'] == "0") {
                                        ?>
                                            <button class="btn btn-info" data-toggle="modal" role="button" data-target="#exampleModal-<?= $k['v_id']; ?>">Konfirmasi</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button class="btn btn-info disabled" data-toggle="modal" role="button">Konfirmasi</button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal-<?= $k['v_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Konfimasi Pembayaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h2 class="f-18">ORDER ID: <span class="bold-md">2345</span></h2>
                                                    <div class="confirm">
                                                        <span>Paket 10</span>
                                                        <h1 class="bold-lg"><sup>Rp</sup> 25.000</h1>
                                                        <ul>
                                                            <li>Gratis 3 voucher</li>
                                                            <li>Tiap voucher tayang 30 hari di ternakbagus.com</li>
                                                        </ul>
                                                    </div>
                                                    <h2 class="f-18">DATA DIRI</h2>
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Nama Lengkap</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Bank Asal</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm" name="asal">
                                                                <option value="Mandiri">Mandiri</option>
                                                                <option value="BCA">BCA</option>
                                                                <option value="BRI">BRI</option>
                                                                <option value="BNI">BNI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="jumlah">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword" class="col-sm-4 col-form-label">Bank Tujuan</label>
                                                        <div class="col-sm-8">
                                                            <select id="inputState" class="form-control form-control-sm" name="tujuan">
                                                                <option>BANK MANDIRI - 9034343432</option>
                                                                <option>BANK BCA - 9034343432</option>
                                                                <option>BANK BRI - 9034343432</option>
                                                                <option>BANK BNI - 9034343432</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control form-control-sm" rows="3" name="keterangan"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Upload File</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" name="file" class="form-control-file">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="text" name="voucher_id" value="<?= $k['v_id']; ?>" hidden>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="btn-konfirmasi" value="btn-konfirmasi">Konfirmasi Pembayaran</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
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
