<?php
session_start();
$sid = session_id();
$kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);

get_header();
if ($_SESSION['id'] == "") {
    echo '<a href="#" class="iklan-bottom" data-toggle="modal" data-target="#iklan-bottom">
            <i class="far fa-bell mr-2"></i>PASANG IKLAN
        </a>';
} else {
    echo '<a href="ternak/" class="iklan-bottom">
            <i class="far fa-bell mr-2"></i>PASANG IKLAN
        </a>';
}
?>
<div class="categories my-5">
    <div class="container">
        <div class="row justify-content-center">
            <?php
            foreach ($kategori as $k) {
                $count = $wpdb->get_var("SELECT COUNT(kategori_id) FROM wp_subs WHERE kategori_id='" . $k['kategori_id'] . "'")
            ?>
                <div class="col-md-2 col-6 mb-4">
                    <a href="kategori/?idkategori=<?= $k['kategori_id']; ?>" class="item-ct d-block">
                        <img src="../wp-content/uploads/<?= $k['file_kategori']; ?>" alt="">
                        <h1 class="bold-sm f-12"><?= $k['kategori']; ?></h1>
                        <span class="f-12 bold-sm text-success"><?= $count; ?> Jenis</span>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="titlebar">
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <h1>Semua Ternak</h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $result = $wpdb->get_results("SELECT * FROM wp_aads 
                                                    LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id 
                                                    LEFT JOIN wp_images ON wp_aads.add_id=wp_images.add_id
                                                    LEFT JOIN kecamatan ON wp_aads.lokasi=kecamatan.id_kec 
                                                    WHERE kategori_id='" . $_GET['idkategori'] . "' 
                                                    AND status='1'
                                                    AND status_tayang='1'
                                                    GROUP BY wp_aads.add_id LIMIT 15", ARRAY_A);
            foreach ($result as $r) {
                $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_like WHERE member_id='" . $_SESSION['member'] . "' AND add_id='" . $r['add_id'] . "'");
                if ($cek > 0) {
                    $btn = "<button class='circle-sm disabled bg-info text-white'><i class='far fa-heart'></i></a></button>";
                } else {
                    if ($_SESSION['id'] == "") {
                        $btn = "<button class='circle-sm' data-toggle='modal' data-target='#iklan-bottom'><i class='far fa-heart'></i></a></button>";
                    } else {
                        $btn = "<button class='circle-sm like-btn' id='" . $r['add_id'] . "'><i class='far fa-heart'></i></a></button>";
                    }
                }
            ?>
                <div class="col-md-3 col-6 mb-4">
                    <div class="item">
                        <div class="imgbox">
                            <img src="../wp-content/uploads/<?php echo "$r[slug_nama]/$r[img_desc];" ?>" alt="">
                        </div>
                        <div class="body">
                            <h2 class="mt-2 f-18 m-0"><?php echo $r['judul']; ?></h2>
                            <span class="f-12"><i class="far fa-map-marker-alt text-primary mr-2"></i><?= $r['nama']; ?></span>
                            <div class="f-12 py-2 m-0">
                                <i class="far fa-badge-check text-success"></i> Tersedia - <span class="bold-sm"><?php echo $r['berat']; ?>kg</span>
                            </div>
                            <h1 class="bold-md mt-3 f-20 m-0">Rp. <?php echo format_rupiah($r['harga']); ?></h1>
                        </div>
                        <div class="beli">
                            <div class="beli-caption">
                                <div class="mt-3">
                                    <?php
                                    if ($_SESSION['id'] == "") {
                                    ?>
                                        <a href="#" class="circle-sm" data-toggle="modal" data-target="#iklan-bottom"><i class="far fa-eye"></i></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="view/?id=<?= $r['add_id']; ?>" class="circle-sm"><i class="far fa-eye"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <?= $btn; ?>
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
<!-- Modal -->
<div class="modal fade" id="iklan-bottom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda belum login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Silahkan Login atau Register terlebih dahulu untuk bisa beriklan dan melihat iklan di <span class="bold-md">ternakbagus.com</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
