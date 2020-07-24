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

    <!-- <div class="container bars">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="#" onclick="openNav()">
                    <i class="far fa-bars fa-2x"></i>
                </a>
            </div>
        </div>
    </div> -->
    <a href="ternak/" class="iklan-bottom">
        <i class="far fa-bell mr-2"></i>PASANG IKLAN
    </a>
    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <form action="../search" method="post">
                        <h1 class="f-18 bold-md mb-3">Cari Ternak</h1>
                        <div class="content-utama p-3 d-md-flex justify-content-between align-items-center">
                            <div class="cari w-100 mr-2">
                                <label for="">Provinsi</label>
                                <select id="provinsi" class="form-control" name="provinsi">
                                    <option value="">Provinsi</option>
                                    <?php
                                    $prov = $wpdb->get_results("SELECT * FROM provinsi ORDER BY nama", ARRAY_A);
                                    foreach ($prov as $p) { ?>

                                        <option value="<?php echo $p['id_prov']; ?>">
                                            <?php echo $p['nama']; ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="cari w-100 mr-2">
                                <label for="">Kabupaten/Kota</label>
                                <select id="kota" class="form-control" name="kota">
                                    <option value="">Kota/Kab</option>
                                    <?php
                                    $query = $wpdb->get_results("SELECT kabupaten.nama AS nama_kab, provinsi.id_prov, kabupaten.id_kab FROM kabupaten INNER JOIN provinsi ON kabupaten.id_prov = provinsi.id_prov order by nama_kab", ARRAY_A);
                                    foreach ($query as $row) { ?>

                                        <option id="kota" class="<?php echo $row['id_prov']; ?>" value="<?php echo $row['id_kab']; ?>">
                                            <?php echo $row['nama_kab']; ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="cari w-100 mr-2">
                                <label for="">Kecamatan</label>
                                <select id="kecamatan" class="form-control" name="lokasi">
                                    <option value="">Kecamatan</option>
                                    <?php
                                    $query = $wpdb->get_results("SELECT kecamatan.nama AS nama_kec, kabupaten.id_kab, kecamatan.id_kec FROM kecamatan INNER JOIN kabupaten ON kecamatan.id_kab = kabupaten.id_kab order by nama_kec", ARRAY_A);
                                    foreach ($query as $row) { ?>

                                        <option id="kecamatan" class="<?php echo $row['id_kab']; ?>" value="<?php echo $row['id_kec']; ?>">
                                            <?php echo $row['nama_kec']; ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="cari w-100 mr-2">
                                <label for="">Kategori</label>
                                <select id="kategori" class="form-control" name="kategori">
                                    <option value="">Kategori</option>
                                    <?php
                                    $kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);
                                    foreach ($kategori as $k) {
                                        echo "<option value='$k[kategori_id]'>$k[kategori]</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="cari w-100 mr-2">
                                <label for="">Jenis</label>
                                <select id="subs" class="form-control" name="jenis">
                                    <option value="">Jenis</option>
                                    <?php
                                    $subs = $wpdb->get_results("SELECT * FROM wp_subs INNER JOIN wp_kategories ON wp_subs.kategori_id = wp_kategories.kategori_id", ARRAY_A);
                                    foreach ($subs as $s) {
                                        echo "<option id='subs' class='$s[kategori_id]' value='$s[sub_id]'>$s[sub_kategori]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="cari w-50 mr-2">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="myButton block w-100 p-2">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="content">
                        <div class="row">
                            <?php
                            $result = $wpdb->get_results("SELECT * FROM wp_aads 
                                                                    LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id 
                                                                    LEFT JOIN kecamatan ON wp_aads.lokasi=kecamatan.id_kec 
                                                                    LEFT JOIN wp_images on wp_aads.add_id=wp_images.add_id
                                                                    WHERE status='1'
                                                                    AND status_tayang='1'
                                                                    GROUP BY wp_aads.add_id
                                                                    LIMIT 15", ARRAY_A);
                            foreach ($result as $r) {
                            ?>
                                <div class="col-md-4 col-6 mb-4">
                                    <div class="item">
                                        <div class="imgbox">
                                            <img src="../wp-content/uploads/<?php echo "$r[slug_nama]/$r[img_desc];" ?>" alt="">
                                        </div>
                                        <div class="body">
                                            <h2 class="mt-2 f-18 m-0"><?php echo $r['judul']; ?></h2>
                                            <span class="f-12"><i class="far fa-map-marker-alt text-primary mr-2"></i><?php echo $r['nama']; ?></span>
                                            <div class="f-12 py-2 m-0">
                                                <i class="far fa-badge-check text-success"></i> Tersedia - <span class="bold-sm"><?php echo $r['berat']; ?>kg</span>
                                            </div>
                                            <h1 class="bold-md mt-3 f-20 m-0">Rp. <?php echo format_rupiah($r['harga']); ?></h1>
                                        </div>
                                        <div class="beli">
                                            <div class="beli-caption">
                                                <div class="mt-3">
                                                    <a href="view/?id=<?= $r['add_id']; ?>" class="circle-sm"><i class="far fa-eye"></i></a>
                                                    <?php
                                                    $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_like WHERE member_id='" . $_SESSION['member'] . "' AND add_id='" . $r['add_id'] . "'");
                                                    if ($cek > 0) {
                                                        $btn = "<button class='circle-sm disabled bg-info text-white'><i class='far fa-heart'></i></a></button>";
                                                    } else {
                                                        $btn = "<button class='circle-sm like-btn' id='" . $r['add_id'] . "'><i class='far fa-heart'></i></a></button>";
                                                    }
                                                    echo $btn;
                                                    ?>
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
