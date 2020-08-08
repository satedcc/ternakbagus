<?php
session_start();
$sid = session_id();

if (isset($_POST['delete-id'])) {
    $wpdb->delete('wp_aads', array('add_id' => $_POST['delete-id']));
    //$wpdb->delete('wp_images', array('add_id' => $_POST['delete-id']));
}

if (isset($_SESSION['id'])) {
    $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_aads WHERE  member_id='" . $_SESSION['member'] . "'");

    if ($_POST['tombol'] == "save") {
        use_voucher();
    } elseif ($_POST['tombol'] == "draft") {
        use_draft();
    }

    get_header();

?>
    <a href="ternak/" class="iklan-bottom">
        <i class="far fa-bell mr-2"></i>PASANG IKLAN
    </a>
    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <?php
                    if ($_GET['success'] == 1) {
                        echo "<div class='alert alert-success' role='alert'>
                                <h1 class='f-18'>SELAMAT !!</h1>
                                <p>Iklan anda BERHASIL di buat dan dalam proses MODERASI. Anda akan mendapatkan notifikasi ketika iklan telah aktif.
                                Kami mendoakan semoga iklan Anda cepat laku.</p>
                                <a href='view/?id=$_GET[id]' target='New' class='myButton'>Preview Iklan Anda</a>
                            </div>";
                    } elseif ($_GET['success'] == 2) {
                        echo "<div class='alert alert-success' role='alert'>
                                <p>Iklan telah berhasil di simpan sebagai draf, mohon untuk membeli voucher terlebih dahulu untuk mengaktifkan kembali iklan anda.</p>
                            </div>";
                    } elseif ($_GET['alert'] == "berhasil") {
                        echo "<div class='alert alert-success' role='alert'>
                                <h1 class='f-14'>Data berhasil di update</h1>
                            </div>";
                    }
                    if ($cek > 0) {
                    ?>
                        <h1 class="f-20 bold-md mb-3">Iklan Anda</h1>
                        <div class="row">
                            <?php
                            $result = $wpdb->get_results("SELECT * FROM 
                                                        wp_aads 
                                                        JOIN wp_kategories ON wp_aads.kategori_id=wp_kategories.kategori_id
                                                        JOIN wp_subs ON wp_aads.sub_id=wp_subs.sub_id
                                                        JOIN wp_members ON wp_aads.member_id=wp_members.member_id
                                                        JOIN wp_images ON wp_aads.add_id=wp_images.add_id
                                                        JOIN kecamatan ON wp_aads.lokasi=kecamatan.id_kec
                                                        WHERE wp_aads.member_id='" . $_SESSION['member'] . "' 
                                                        GROUP BY wp_aads.add_id", ARRAY_A);
                            foreach ($result as $r) {
                                switch ($r['status']) {
                                    case '1':
                                        $status = "<span class='py-2 px-3 bg-success text-white rounded'>Aktif</span>";
                                        break;

                                    default:
                                        $status = "<span class='py-2 px-3 bg-warning text-white rounded'>Moderasi</span>";
                                        break;
                                }
                                switch ($r['draft']) {
                                    case 'Y':
                                        $draft = '<div class="draft">
                                        <button class="btn btn-info btn-sm mt-3" data-toggle="modal" data-target="#draftModal' . $r['add_id'] . '">Aktifkan Iklan</button></p>
                                                    </div>';
                                        break;
                                }



                            ?>
                                <div class="col-md-6">
                                    <div class="content-utama">
                                        <?= $draft; ?>
                                        <div class="iklan-header p-3">
                                            <div class="row justify-content-between">
                                                <div class="col-8 titledetail">
                                                    <h1 class="f-18 bold-sm"><a href="../view/?id=<?= $r['add_id']; ?>" target="new" class="text-primary"><?= $r['judul']; ?></a></h1>
                                                    <span class="f-12"><i class="far fa-map-marker-alt mr-2"></i><?= $r['nama']; ?> &middot; <span class="text-secondary"><?= time_ago($r['ads_create']); ?></span></span>
                                                </div>
                                                <div class="col-auto">
                                                    <?= $status; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="iklan-body p-3">
                                            <div class="iklan-header">
                                                <img src="../wp-content/uploads/<?php echo "$r[slug_nama]/$r[img_desc];" ?>" alt="">
                                                <?php
                                                if ($r['status_tayang'] == "0") {
                                                    echo '<div class="durasi">
                                                            <p>Iklan telah sampai pada waktu masa tayang, untuk kembali tayang silahkan gunakan voucher anda.<br>
                                                            <button class="btn btn-info btn-sm mt-3" data-toggle="modal" data-target="#iklanModal' . $r['add_id'] . '">Aktifkan Iklan</button></p>
                                                        </div>';
                                                }
                                                ?>
                                            </div>
                                            <div class="mt-3">
                                                <span>Kategori: <?= $r['kategori']; ?></span>
                                            </div>
                                            <h1 class="f-24 my-2 bold-lg">Rp <?= format_rupiah($r['harga']); ?></h1>
                                            <p><?php echo $r['keterangan']; ?></p>
                                        </div>
                                        <hr class="m-0">
                                        <div class="iklan-footer p-3">
                                            <div class="f-12">
                                                <?php
                                                if ($r['kategori_iklan'] == "ternak") {
                                                ?>
                                                    <span class="f-12 bold-md">Berat:</span> <?= $r['berat']; ?> &middot;
                                                    <span class="f-12 bold-md">Umur:</span> <?= $r['umur']; ?> thn &middot;
                                                <?php
                                                } elseif ($r['kategori_iklan'] == "perlengkapan") {
                                                ?>
                                                    <span class="f-12 bold-md">Kondisi:</span> <?= $r['kondis']; ?> &middot;
                                                <?php
                                                } elseif ($r['kategori_iklan'] == "layanan") {
                                                ?>
                                                    <span class="f-12 bold-md">Layanan:</span> <?= $r['layanan']; ?> &middot;
                                                <?php
                                                }
                                                ?>
                                                <span class="f-12 bold-md">Jenis:</span> <?= $r['sub_kategori']; ?>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="p-3 d-flex justify-content-between">
                                            <div>
                                                <i class="far fa-user mr-1"></i>Pemilik: <span class="bold-lg"><?= $r['slug_nama']; ?></span>
                                            </div>
                                            <div>
                                                <i class="far fa-heart mr-1"></i> 0 &middot; <i class="far fa-eye mr-1"></i>0
                                            </div>
                                        </div>
                                        <div class="iklan-tombol p-3 d-md-flex justify-content-between">
                                            <div class="w-50 mb-2">
                                                <a href="<?php echo "../$r[kategori_iklan]/?edit=$r[add_id]";; ?>" class="btn btn-primary block w-75 f-12"><i class="fal fa-pencil-alt mr-2"></i>Edit Iklan</a>
                                            </div>
                                            <div class="w-50 mb-2 text-right">
                                                <a href="#" class="btn btn-danger block w-75 f-12" data-toggle="modal" data-target="#exampleModal<?= $r['add_id']; ?>"><i class="far fa-trash-alt mr-2"></i>Delete Iklan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?= $r['add_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Apakah iklan ingin di hapus?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h1 class="f-18">Mohon di isi alasan untuk menghapus iklan</h1>
                                                <div class="delete f-12">
                                                    <div>
                                                        <input type="radio" name="alasan" id="alasan-<?= $r['add_id']; ?>">
                                                        <label for="alasan-<?= $r['add_id']; ?>">Terjual di pembeli luar</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" name="alasan" id="alasan-1<?= $r['add_id']; ?>">
                                                        <label for="alasan-1<?= $r['add_id']; ?>">Terjual di pembeli ternakbagus</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" name="alasan" id="alasan-2<?= $r['add_id']; ?>">
                                                        <label for="alasan-2<?= $r['add_id']; ?>">Iklan kurang mendapat tanggapan</label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" name="alasan" id="alasan-3<?= $r['add_id']; ?>">
                                                        <label for="alasan-3<?= $r['add_id']; ?>">Alasan lain</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="" method="post">
                                                    <input type="text" name="delete-id" id="" value="<?= $r['add_id']; ?>" hidden>
                                                    <button type="submit" class="btn btn-primary"><i class="far fa-trash-alt mr-2"></i>Hapus Iklan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="iklanModal<?= $r['add_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <?php
                                        $voucher = $wpdb->get_var("SELECT SUM(jumlah) AS total FROM wp_vouchers WHERE member_id='" . $_SESSION['id_member'] . "' AND status_bayar='1'");
                                        $use = $wpdb->get_var("SELECT SUM(qty) AS total FROM wp_use WHERE member_id='" . $_SESSION['id_member'] . "'");
                                        $total = $voucher - $use;
                                        if ($total > 0) {

                                        ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Aktifkan iklan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Anda akan mengaktifkan kembali iklan dengan menggunakan 1 voucher dan saldo voucher saat ini <span class="bold-xl"><?= $total; ?></span>. Apakah anda yakin untuk memasang iklan ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="" method="post">
                                                        <input type="text" name="iklan" value="<?= $r['add_id']; ?>" hidden>
                                                        <input type="text" name="member" value="<?= $_SESSION['member']; ?>" hidden>
                                                        <button type="submit" class="btn btn-primary" name='tombol' value='save'>Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi pemasangan iklan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Saldo voucher anda tidak cukup untuk memasang iklan, silahkan membeli voucher terlebih dahulu.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="beli/" type="button" class="btn btn-primary">Beli voucher</a>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="draftModal<?= $r['add_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <?php
                                        $voucher = $wpdb->get_var("SELECT SUM(jumlah) AS total FROM wp_vouchers WHERE member_id='" . $_SESSION['id_member'] . "' AND status_bayar='1'");
                                        $use = $wpdb->get_var("SELECT SUM(qty) AS total FROM wp_use WHERE member_id='" . $_SESSION['id_member'] . "'");
                                        $total = $voucher - $use;
                                        if ($total > 0) {

                                        ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Aktifkan iklan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Anda akan mengaktifkan kembali iklan dengan menggunakan 1 voucher dan saldo voucher saat ini <span class="bold-xl"><?= $total; ?></span>. Apakah anda yakin untuk memasang iklan ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="" method="post">
                                                        <input type="text" name="iklan" value="<?= $r['add_id']; ?>" hidden>
                                                        <input type="text" name="member" value="<?= $_SESSION['member']; ?>" hidden>
                                                        <button type="submit" class="btn btn-primary" name='tombol' value='draft'>Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi pemasangan iklan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Saldo voucher anda tidak cukup untuk memasang iklan, silahkan membeli voucher terlebih dahulu.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <a href="beli/" type="button" class="btn btn-primary">Beli voucher</a>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="text-center content-utama">
                            <div class="show-items">
                                <h1 class="f-20">
                                    <img src="<?= get_site_url(); ?>/wp-content/uploads/cow.svg" alt="">
                                    <h1 class="f-18">Anda belum mempunyai iklan</h1>
                                    <a href="ternak/" class="myButton">Ayo Beriklan</a>
                                </h1>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>

<?php

    get_footer();
} else {
    header('location:../');
}
