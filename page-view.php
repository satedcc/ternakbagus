<?php
session_start();
$sid = session_id();


if (isset($_SESSION['id'])) {
    $ads = $wpdb->get_row("SELECT * FROM wp_aads 
                                    LEFT JOIN wp_kategories ON wp_aads.kategori_id=wp_kategories.kategori_id
                                    LEFT JOIN wp_subs ON wp_aads.sub_id=wp_subs.sub_id
                                    LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id
                                    WHERE  add_id='" . $_GET['id'] . "'", ARRAY_A);
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
                <div class="col-md-8">
                    <div class="content-utama p-4 mb-4">
                        <div class="img-iklan">
                            <img src="../wp-content/uploads/<?php echo "$ads[slug_nama]/$ads[file];" ?>" alt="">
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
                                <span class="text-secondary"><?= $ads['umur']; ?></span>
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
                            $result = $wpdb->get_results("SELECT member_id,judul,lokasi,harga,file,slug_nama,berat,harga,add_id FROM wp_aads LEFT JOIN wp_members USING(member_id) WHERE kategori_id='" . $ads['kategori_id'] . "' LIMIT 3", ARRAY_A);
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
                <div class="col-md-4">
                    <div class="content-utama p-3">
                        <h1 class="bold-xl f-30">Rp. <?= format_rupiah($ads['harga']); ?></h1>
                        <h2 class="text-secondary f-18 mb-4"><?= $ads['judul']; ?></h2>
                        <div class="d-flex justify-content-between f-12">
                            <div><i class="far fa-map-marker-alt mr-2"></i>Kambu, Kendari</div>
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
                                <img src="../wp-content/uploads/<?php echo "$_SESSION[slug]/$_SESSION[photo]" ?>" alt="<?= $ads['nama']; ?>" class="img-desc mr-3">
                            </div>
                            <div>
                                <h1 class="f-18 bold-md"><?= $ads['nama']; ?></h1>
                                <span class="f-14 text-secondary"><?= time_ago($ads['create_at']); ?></span>
                            </div>
                        </div>
                        <div class="sale-button d-flex justify-content-between">
                            <div class="w-50">
                                <a href="#" class="btn btn-info btn-sm block w-75" data-toggle="modal" data-target="#exampleModal">Nego Harga</a>
                            </div>
                            <div class="w-50 text-right">
                                <a href="" class="btn btn-success btn-sm block w-75" data-toggle="modal" data-target="#chatModal">Chat Penjual</a>
                            </div>
                        </div>
                    </div>
                    <div class="content-utama p-3">
                        <h2 class="f-18">LOKASI</h2>
                        <span class="f-12"><i class="far fa-map-marker-alt mr-2"></i>Baruga, Kendari Sulawesi Tenggara</span>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22191.06566476887!2d122.48139182996691!3d-4.036226159405919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d988dcb04291869%3A0x6d2f98ce0a25264c!2sBaruga%2C%20Kota%20Kendari%2C%20Sulawesi%20Tenggara!5e0!3m2!1sid!2sid!4v1593793373503!5m2!1sid!2sid" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
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
                        <div class="custom-body text-center">
                            <h1 class="f-big bold-md">Selamat</h1>
                            <p>Anda akan langsung menawar iklan pada harga</p>
                            <input type="number" class="mb-3" placeholder="masukkan penawaran anda">
                            <p>Tawar harga tidak mengikat. Anda tetap di rekomendasikan untuk bertemu dan melihat langsung barang yang di jual sebelum ada kesepakatan</p>
                        </div>
                        <div class="custom-footer text-center mb-4">
                            <button type="button" class="btn btn-primary">Tawar Harga</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
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
                        <div class="custom-body">
                            <p>Silahkan kirim pesan ke <span class="bold-md"><?= $ads['nama']; ?></span> untuk menanyakan iklan</p>
                            <textarea name="" placeholder="tuliskan pesan anda"></textarea>
                        </div>
                        <div class="custom-footer px-3 mb-4">
                            <button type="button" class="btn btn-info">Kirim Pesan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
