<?php
session_start();
$sid = session_id();

if (isset($_POST['delete-id'])) {
    $wpdb->delete('wp_aads', array('add_id' => $_POST['delete-id']));
}

if (isset($_SESSION['id'])) {
    $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_aads WHERE  member_id='" . $_SESSION['member'] . "'");
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
                    if ($_GET['status'] == 1) {
                        echo "<div class='alert alert-success' role='alert'>
                                <h1 class='f-18'>SELAMAT !!</h1>
                                <p>Iklan anda BERHASIL di buat dan dalam proses MODERASI. Anda akan mendapatkan notifikasi ketika iklan telah aktif.
                                Kami mendoakan semoga iklan Anda cepat laku.</p>
                                <a href='' class='myButton'>Preview Iklan Anda</a>
                            </div>";
                    }
                    ?>
                    <h1 class="f-20 bold-md mb-3">Iklan Anda</h1>
                    <div class="row">
                        <?php
                        $result = $wpdb->get_results("SELECT * FROM 
                                                        wp_aads 
                                                        JOIN wp_kategories ON wp_aads.kategori_id=wp_kategories.kategori_id
                                                        JOIN wp_subs ON wp_aads.sub_id=wp_subs.sub_id
                                                        JOIN wp_members ON wp_aads.member_id=wp_members.member_id
                                                        WHERE wp_aads.member_id='" . $_SESSION['member'] . "' ", ARRAY_A);
                        foreach ($result as $r) {
                            switch ($r['status']) {
                                case '1':
                                    $status = "<span class='py-2 px-3 bg-success text-white rounded'>Aktif</span>";
                                    break;

                                default:
                                    $status = "<span class='py-2 px-3 bg-warning text-white rounded'>Moderasi</span>";
                                    break;
                            }


                        ?>
                            <div class="col-md-6">
                                <div class="content-utama">
                                    <div class="iklan-header p-3">
                                        <div class="row justify-content-between">
                                            <div class="col-8 titledetail">
                                                <h1 class="f-18 bold-sm"><?= $r['judul']; ?></h1>
                                                <span class="f-12"><i class="far fa-map-marker-alt mr-2"></i>Kota Surabaya &middot; <span class="text-secondary"><?= time_ago($r['ads_create']); ?></span></span>
                                            </div>
                                            <div class="col-auto">
                                                <?= $status; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="iklan-body p-3">
                                        <img src="../wp-content/uploads/<?php echo "$_SESSION[slug]/$r[file];" ?>" alt="">
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
                                            <i class="far fa-user mr-1"></i>Pemilik: <span class="bold-lg"><?= $r['nama']; ?></span>
                                        </div>
                                        <div>
                                            <i class="far fa-heart mr-1"></i> 234 &middot; <i class="far fa-eye mr-1"></i>234
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
                                                <input type="radio" name="alasan" id="alasan">
                                                <label for="alasan">Terjual di pembeli luar</label>
                                                <input type="radio" name="alasan" id="alasan1">
                                                <label for="alasan1">Terjual di pembeli ternakbagus</label>
                                                <input type="radio" name="alasan" id="alasan2">
                                                <label for="alasan2">Iklan kurang mendapat tanggapan</label>
                                                <input type="radio" name="alasan" id="alasan3">
                                                <label for="alasan3">Alasan lain</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <form action="" method="post">
                                                <input type="text" name="delete-id" id="" value="<?= $r['add_id']; ?>">
                                                <button type="submit" class="btn btn-primary"><i class="far fa-trash-alt mr-2"></i>Hapus Iklan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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
