<?php
session_start();
$sid = session_id();
$kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);

get_header();
?>


<div class="container mt-5">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="titlebar">
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <h1>Hasil Pencarian</h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $result = $wpdb->get_results("SELECT * FROM wp_aads 
                                                    LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id
                                                    LEFT JOIN wp_images on wp_aads.add_id=wp_images.add_id
                                                    LEFT JOIN kecamatan ON wp_aads.lokasi=kecamatan.id_kec
                                                    WHERE status='1'
                                                    AND status_tayang='1'
                                                    GROUP BY wp_aads.add_id", ARRAY_A);
            foreach ($result as $r) {
            ?>
                <div class="col-md-3 col-6 mb-4">
                    <div class="item">
                        <div class="imgbox">
                            <img src="<?php echo get_site_url() . "/wp-content/uploads/$r[slug_nama]/$r[img_desc];" ?>" alt="">
                        </div>
                        <div class="body">
                            <h2 class="mt-2 f-18 m-0"><?php echo $r['judul']; ?></h2>
                            <span class="f-12"><i class="far fa-map-marker-alt text-primary mr-2"></i><?php echo $r['nama']; ?></span>
                            <div class="f-12 py-2 m-0">
                                <i class="far fa-badge-check text-success"></i> Tersedia - <span class="bold-sm"><?php echo $r['berat']; ?>kg</span>
                            </div>
                            <h1 class="bold-lg mt-3 f-20 m-0">Rp. <?php echo format_rupiah($r['harga']); ?></h1>
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

<?php
get_footer();
