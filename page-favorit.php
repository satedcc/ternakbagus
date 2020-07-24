<?php
session_start();
$sid = session_id();

if (isset($_GET['id'])) {
    $wpdb->delete('wp_like', array('add_id' => $_GET['id']));
}

if (isset($_SESSION['id'])) {
    $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_like WHERE  member_id='" . $_SESSION['member'] . "'");
    get_header();

?>

    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <?php
                    if ($cek > 0) {
                    ?>
                        <h1 class="f-20 bold-md mb-3">Iklan Favorit</h1>
                        <div class="row">
                            <?php
                            $result = $wpdb->get_results("SELECT * FROM 
                                                        wp_aads 
                                                        JOIN wp_kategories ON wp_aads.kategori_id=wp_kategories.kategori_id
                                                        JOIN wp_subs ON wp_aads.sub_id=wp_subs.sub_id
                                                        JOIN wp_members ON wp_aads.member_id=wp_members.member_id
                                                        JOIN wp_like ON wp_aads.add_id=wp_like.add_id
                                                        JOIN wp_images on wp_aads.add_id=wp_images.add_id
                                                        WHERE wp_like.member_id='" . $_SESSION['member'] . "' 
                                                        GROUP BY wp_aads.add_id", ARRAY_A);
                            foreach ($result as $r) {
                            ?>
                                <div class="col-md-6">
                                    <div class="content-utama">
                                        <div class="iklan-header p-3">
                                            <div class="row justify-content-between">
                                                <div class="col-auto">
                                                    <h1 class="f-18 bold-sm"><?= $r['judul']; ?></h1>
                                                    <span class="f-12"><i class="far fa-map-marker-alt mr-2"></i>Kota Surabaya &middot; <span class="text-secondary"><?= time_ago($r['ads_create']); ?></span></span>
                                                </div>
                                                <div class="col-auto">
                                                    <?php
                                                    if ($r['status_iklan'] == "1") {
                                                        echo "<span class='py-2 px-3 bg-warning text-white rounded'>TERJUAL</span>";
                                                    } else {
                                                        echo "<span class='py-2 px-3 bg-info text-white rounded'>Aktif</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="iklan-body p-3">
                                            <img src="../wp-content/uploads/<?php echo "$r[slug_nama]/$r[img_desc];" ?>" alt="">
                                            <div class="mt-3">
                                                <span>Kategori: <?= $r['kategori']; ?></span>
                                            </div>
                                            <h1 class="f-20 my-2 bold-md">Rp <?= format_rupiah($r['harga']); ?></h1>
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
                                        <div class="iklan-tombol p-3 d-md-flex justify-content-end">
                                            <div class="w-50 text-right">
                                                <a href="favorit/?id=<?= $r['add_id']; ?>" class="btn btn-danger block w-100 f-12"><i class="far fa-trash-alt mr-2"></i>Delete Iklan</a>
                                            </div>
                                        </div>
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
                                    <h1 class="f-18">Anda belum mempunyai iklan favorit</h1>
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
