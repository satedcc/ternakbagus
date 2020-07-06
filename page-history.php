<?php
session_start();
$sid = session_id();
get_header();

if (isset($_SESSION['id'])) {
    $result = $wpdb->get_results("SELECT * FROM wp_vouchers WHERE member_id='" . $_SESSION['member'] . "' ORDER BY v_id DESC", ARRAY_A);

    use_voucher($_POST['use'], $_POST['id']);

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
                            <?php
                            foreach ($result as $k) {
                                $use = $wpdb->get_var("SELECT SUM(qty) FROM wp_use WHERE v_id='" . $k['v_id'] . "'");
                                $total = $k['jumlah'] * 2000;
                                $voucher = $k['jumlah'] - $use;
                                if ($k['status_bayar'] == "1") :
                                    $status = "<span class='py-2 px-2 f-12 rounded text-white bg-success'><i class='far fa-badge-check mr-2'></i>Lunas</span>";
                                else :
                                    $status = "<span class='py-2 px-2 f-12 rounded text-white bg-warning'><i class='far fa-hourglass-half mr-2'></i>Menunggu Pembayaran</span>";
                                endif;
                            ?>
                                <div class="history mb-3">
                                    <div class="text-center item-history">
                                        <span>Nilai Voucher</span>
                                        <h1 class="bold-xl display-4"><?= format_rupiah($total); ?></h1>
                                    </div>
                                    <div class="item-history">
                                        <span class="bold-sm f-12">Pembelian: <?php echo time_ago($k['create_at']) ?></span>
                                        <h2 class="f-20">Jumlah Voucher <?= $k['jumlah']; ?></h2>
                                        Status : <?= $status; ?>
                                    </div>
                                    <div class="text-center align-self-center item-history">
                                        <?php
                                        if ($k['status_bayar'] == "1") {
                                            if ($voucher > 0) {
                                        ?>
                                                <button class="btn btn-info" data-toggle="modal" role="button" data-target="#exampleModal-<?= $k['v_id']; ?>">Gunakan</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-danger disabled" data-toggle="modal" role="button" aria-disabled="true">Habis</button>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <button class="btn btn-info disabled" data-toggle="modal" role="button" aria-disabled="true">Gunakan</button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal-<?= $k['v_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="" method="post">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Gunakan Voucher Iklan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-success my-2" role="alert">
                                                        <?php
                                                        $hasil = $k['jumlah'] - $use;
                                                        $all   = $hasil * 2000;
                                                        ?>
                                                        <table class="w-100">
                                                            <thead>
                                                                <thead class="text-center">
                                                                    <th>Digunakan</th>
                                                                    <th>Sisa Voucher</th>
                                                                    <th>Nilai(Rp)</th>
                                                                </thead>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="text-center">
                                                                    <td><?= $use; ?></td>
                                                                    <td><?= $hasil; ?></td>
                                                                    <td class="bold-md">Rp. <?= format_rupiah($all); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    Pilih jumlah voucher:
                                                    <select name="use" id="" class="form-control form-control-sm my-2">
                                                        <?php
                                                        for ($i = 1; $i <= $hasil; $i++) {
                                                            echo "<option>$i</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="text" name="id" id="" value="<?= $k['v_id']; ?>" hidden>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Gunakan Voucher</button>
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
