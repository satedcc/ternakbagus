<?php
session_start();
$sid = session_id();


if (isset($_SESSION['id'])) {
    $ads = $wpdb->get_row("SELECT * FROM wp_aads 
                                    LEFT JOIN wp_kategories ON wp_aads.kategori_id=wp_kategories.kategori_id
                                    LEFT JOIN wp_subs ON wp_aads.sub_id=wp_subs.sub_id
                                    LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id
                                    WHERE  add_id='" . $_GET['id'] . "'
                                    AND draft='N'", ARRAY_A);

    $lokasi = $wpdb->get_row("SELECT id_prov,id_kab,id_kec, provinsi.nama AS nama_prov, kabupaten.nama AS nama_kab, kecamatan.nama AS nama_kec FROM provinsi LEFT JOIN kabupaten using (id_prov) 
                                    LEFT JOIN kecamatan USING (id_kab)
                                WHERE id_kec='" . $ads['lokasi'] . "'", ARRAY_A);
    if ($_POST['btn-tawar'] != "") {
        tawar();
    } else {
        pesanchat();
    }
    get_header();

?>
    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="content-utama p-4 mb-4 position-relative">
                        <div class="photo-detail">
                            <?php
                            $photo = $wpdb->get_results("SELECT * FROM wp_images WHERE add_id='" . $ads['add_id'] . "'", ARRAY_A);
                            foreach ($photo as $p) {
                                echo "<div class='photo-item' data-toggle='modal' data-target='#imgproduct'>
                                <img src='../wp-content/uploads/$ads[slug_nama]/$p[img_desc]' alt=''>
                                        </div>";
                            ?>
                                <div class="modal fade" id="imgproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Galery <?= $ads['judul']; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                                    </ol>
                                                    <div class="carousel-inner">
                                                        <?php
                                                        $photox = $wpdb->get_results("SELECT * FROM wp_images WHERE add_id='" . $ads['add_id'] . "'", ARRAY_A);
                                                        foreach ($photox as $px) {
                                                            echo "
                                                            <div class='carousel-item'>
                                                                <img src='../wp-content/uploads/$ads[slug_nama]/$px[img_desc]' class='d-block w-100' alt='...'>
                                                            </div>";
                                                        }
                                                        ?>

                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <h1 class="f-24 my-3">DETAIL</h1>
                    <div class="content-utama p-3 d-flex justify-content-between text-center">
                        <div>
                            <h2 class="f-18">Kategori</h2>
                            <span class="text-secondary"><?= $ads['kategori']; ?></span>
                        </div>
                        <div>
                            <h2 class="f-18">Jenis</h2>
                            <span class="text-secondary"><?= $ads['sub_kategori']; ?></span>
                        </div>
                        <?php
                        if ($ads['kategori_iklan'] == "ternak") {
                        ?>
                            <div>
                                <h2 class="f-18">Umur</h2>
                                <span class="text-secondary"><?= $ads['umur']; ?> <?= $ads['satuan']; ?></span>
                            </div>
                            <div>
                                <h2 class="f-18">Berat</h2>
                                <span class="text-secondary"><?= $ads['berat']; ?>kg</span>
                            </div>
                        <?php
                        } elseif ($ads['kategori_iklan'] == "perlengkapan") {
                        ?>
                            <div>
                                <h2 class="f-18">Kondisi</h2>
                                <span class="text-secondary"><?= $ads['kondis']; ?></span>
                            </div>
                        <?php
                        } elseif ($ads['kategori_iklan'] == "layanan") {
                        ?>
                            <div>
                                <h2 class="f-18">Layanan</h2>
                                <span class="text-secondary"><?= $ads['layanan']; ?></span>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="content-utama p-3">
                        <?= $ads['keterangan']; ?>
                    </div>
                    <hr>
                    <h1 class="f-18 mt-5">Lihat Iklan Lainnya</h1>
                    <div class="content">
                        <div class="row">
                            <?php
                            $result = $wpdb->get_results("SELECT * FROM wp_aads 
                                                                    LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id 
                                                                    LEFT JOIN wp_images ON wp_aads.add_id=wp_images.add_id
                                                                    LEFT JOIN kecamatan ON wp_aads.lokasi=kecamatan.id_kec 
                                                                    GROUP BY wp_aads.add_id
                                                                    LIMIT 3", ARRAY_A);
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
                                                <i class="far fa-badge-check text-success"></i> Tersedia - <span class="bold-sm"><?php echo $r['berat']; ?> kg</span>
                                            </div>
                                            <!-- <div class="rating my-3">
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="far fa-star text-secondary"></i>
                                                <i class="fas fa-star-half-alt text-secondary"></i>
                                            </div> -->
                                            <h1 class="bold-md mt-3 f-20 m-0">Rp. <?php echo format_rupiah($r['harga']); ?></h1>
                                            <!-- <span class="f-12 text-muted"><del>Rp. 18.000.000</del></span> -->
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
                <div class="col-md-4">
                    <div class="content-utama p-3">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h1 class="bold-xl f-30">Rp. <?= format_rupiah($ads['harga']); ?></h1>
                            </div>
                            <div class="col-auto">
                                <span>
                                    <?php
                                    $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_like WHERE member_id='" . $_SESSION['member'] . "' AND add_id='" . $ads['add_id'] . "'");
                                    if ($cek > 0) {
                                        $btn = "<button class='circle-sm disabled bg-info text-white'><i class='far fa-heart'></i></a></button>";
                                    } else {
                                        $btn = "<button class='circle-sm like-btn' id='" . $ads['add_id'] . "'><i class='far fa-heart'></i></a></button>";
                                    }
                                    echo $btn;
                                    ?>
                                </span>
                            </div>
                        </div>
                        <h2 class="text-secondary f-18 mb-4"><?= $ads['judul']; ?></h2>
                        <div class="d-flex justify-content-between f-12">
                            <div><i class="far fa-map-marker-alt mr-2"></i><?php echo "$lokasi[nama_kab],$lokasi[nama_kec]"; ?></div>
                            <div><?= time_ago($ads['ads_create']); ?></div>
                        </div>
                    </div>
                    <div class="content-utama p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="f-18">PEMILIK</span>
                            </div>
                            <div>
                                <span class="f-12">
                                    <i class="far fa-phone-alt mr-2"></i><?= $ads['telp']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex my-3 align-items-center">
                            <div>
                                <?php
                                if ($ads['photo']) {

                                ?>
                                    <img src="../wp-content/uploads/<?php echo "$ads[slug_nama]/$ads[photo]" ?>" alt="<?= $ads['nama']; ?>" class="img-desc mr-3">
                                <?php
                                } else {
                                    echo "<div class='default-img mb-4 mr-3'><i class='far fa-user'></i></div>";
                                }
                                ?>
                            </div>
                            <div>
                                <h1 class="f-18 bold-md"><?= $ads['nama']; ?></h1>
                                <span class="f-14 text-secondary"><?= time_ago($ads['create_at']); ?></span>
                            </div>
                        </div>
                        <div class="sale-button mt-4 mb-2">
                            <div>
                                <a href="#" class="tbl btn-success" data-toggle="modal" data-target="#exampleModal">Nego Harga</a>
                            </div>
                            <div>
                                <a href="" class="tbl btn-info" data-toggle="modal" data-target="#chatModal">Chat Penjual</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="content-utama p-3">
                        <h2 class="f-18">LOKASI</h2>
                        <span class="f-12"><i class="far fa-map-marker-alt mr-2"></i>Baruga, Kendari Sulawesi Tenggara</span>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22191.06566476887!2d122.48139182996691!3d-4.036226159405919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d988dcb04291869%3A0x6d2f98ce0a25264c!2sBaruga%2C%20Kota%20Kendari%2C%20Sulawesi%20Tenggara!5e0!3m2!1sid!2sid!4v1593793373503!5m2!1sid!2sid" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-custom">
                        <div class="custom-header">
                            <img src="https://image.flaticon.com/icons/svg/3135/3135667.svg" alt="">
                        </div>
                        <form action="" method="post">
                            <div class="custom-body text-center">
                                <h1 class="f-big bold-md">Selamat</h1>
                                <p>Anda akan langsung menawar iklan pada harga</p>
                                <input type="text" name="member" id="member" value="<?= $ads['member_id']; ?>" hidden>
                                <input type="text" name="iklan" id="iklan" value="<?= $ads['add_id']; ?>" hidden>
                                <input type="number" name="tawar" class="mb-3" placeholder="masukkan penawaran anda" id="tawarpesan">
                                <p>Tawar harga tidak mengikat. Anda tetap di rekomendasikan untuk bertemu dan melihat langsung barang yang di jual sebelum ada kesepakatan</p>
                            </div>
                            <div class="custom-footer text-center mb-4">
                                <button type="button" class="btn btn-primary" name="btn-tawar" value="btn-tawar" id="tawar">Tawar Harga</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-custom">
                        <div class="custom-header">
                            <img src="https://image.flaticon.com/icons/svg/941/941565.svg" alt="">
                        </div>
                        <form action="" method="post">
                            <div class="custom-body">
                                <p>Silahkan kirim pesan ke <span class="bold-md"><?= $ads['nama']; ?></span> untuk menanyakan iklan</p>
                                <input type="text" name="member" id="member" value="<?= $ads['member_id']; ?>" hidden>
                                <input type="text" name="iklan" id="iklan" value="<?= $ads['add_id']; ?>" hidden>
                                <textarea name="pesan" placeholder="tuliskan pesan anda" id="pesan"></textarea>
                            </div>
                            <div class="custom-footer px-3 mb-4">
                                <button type="button" class="btn btn-info" name="btn-pesan" value="btn-pesan" id="kirimpesan">Kirim Pesan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="notifikasi-pesan">
        Pesan anda telah terkirim
    </div>
<?php

    get_footer();
} else {
    header('location:../');
}
