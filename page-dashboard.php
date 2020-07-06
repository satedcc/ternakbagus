<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {

    $cekuser = $wpdb->get_var("SELECT COUNT(*) FROM wp_chat WHERE receiver_id='" . $_SESSION['member'] . "'");
    if ($cekuser > 0) {
        $memberid = "send_id";
    } else {
        $memberid = "receiver_id";
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
                    <h1 class="f-18 bold-md mb-3">Cari Ternak</h1>
                    <div class="content-utama p-3 d-md-flex justify-content-between align-items-center">
                        <div class="cari w-100 mr-2">
                            <select name="lokasi" id="" class="form-control">
                                <option value="">Lokasi Ternak</option>
                                <?php
                                foreach ($provinsi as $p) {
                                    echo "<option value='$p[id]'>$p[nama]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="cari w-100 mr-2">
                            <select id="kategori" class="form-control" name="kategori">
                                <option value="">Kategori Ternak</option>
                                <?php
                                $kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);
                                foreach ($kategori as $k) {
                                    echo "<option value='$k[kategori_id]'>$k[kategori]</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="cari w-100 mr-2">
                            <select id="subs" class="form-control" name="jenis">
                                <option value="">Ternak Jenis</option>
                                <?php
                                $subs = $wpdb->get_results("SELECT * FROM wp_subs INNER JOIN wp_kategories ON wp_subs.kategori_id = wp_kategories.kategori_id", ARRAY_A);
                                foreach ($subs as $s) {
                                    echo "<option id='subs' class='$s[kategori_id]' value='$s[sub_id]'>$s[sub_kategori]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="cari w-50 mr-2">
                            <button class="myButton block w-100 p-2">Cari</button>
                        </div>
                    </div>

                    <div class="content">
                        <div class="row">
                            <?php
                            $result = $wpdb->get_results("SELECT * FROM wp_aads LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id LIMIT 15", ARRAY_A);
                            foreach ($result as $r) {
                            ?>
                                <div class="col-md-4 col-6 mb-4">
                                    <div class="item">
                                        <div class="imgbox">
                                            <img src="../wp-content/uploads/<?php echo "$r[slug_nama]/$r[file];" ?>" alt="">
                                        </div>
                                        <div class="body">
                                            <h2 class="mt-2 f-18 m-0"><?php echo $r['judul']; ?></h2>
                                            <span class="f-12"><i class="far fa-map-marker-alt text-primary mr-2"></i>Kota
                                                Surabaya</span>
                                            <div class="f-12 py-2 m-0">
                                                <i class="far fa-badge-check text-success"></i> Tersedia - <span class="bold-sm"><?php echo $r['berat']; ?>kg</span>
                                            </div>
                                            <div class="rating my-3">
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="far fa-star text-secondary"></i>
                                                <i class="fas fa-star-half-alt text-secondary"></i>
                                            </div>
                                            <h1 class="bold-md mt-3 f-20 m-0"><?php echo format_rupiah($r['harga']); ?></h1>
                                            <span class="f-12 text-muted"><del>Rp. 18.000.000</del></span>
                                        </div>
                                        <div class="beli">
                                            <div class="beli-caption">
                                                <div class="mt-3">
                                                    <a href="view/?id=<?= $r['add_id']; ?>" class="circle-sm"><i class="far fa-eye"></i></a>
                                                    <a href="" class="circle-sm"><i class="far fa-heart"></i></a>
                                                </div>
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
