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
                <div class="col-md-3">
                    <div id="mySidenav" class="sidenav">
                        <div class="titlesidebar">
                            <h1 class="f-18 m-0">ACCOUNT</h1>
                            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        </div>
                        <div class="profile p-4 text-center">
                            <img src="../wp-content/themes/ternak/assets/img/img (32).jpg" alt="" class="img-profile">
                            <h1 class="bold-md f-18 m-0"><?php echo $_SESSION['nama']; ?></h1>
                            <span class="f-12">Bergabung sejak 29 Juni 2020</span>
                            <a href="" class="icon-link blue text-white rounded f-12 mt-3">
                                <i class="far fa-cog mr-2"></i> Update Profile
                            </a>
                            <a href="" class="icon-link bg-warning text-white rounded f-12">
                                <i class="far fa-rocket-launch"></i>
                            </a>
                        </div>
                        <hr>
                        <div class="menusidebar f-14">
                            <ul>
                                <li><a href=""><i class="far fa-inbox mr-3"></i>Inbox</a></li>
                                <li><a href=""><i class="far fa-cog mr-3"></i>Setting</a></li>
                                <li><a href=""><i class="far fa-store-alt mr-3"></i>Iklan Anda</a></li>
                                <li><a href=""><i class="far fa-heart mr-3"></i>Iklan Favorit</a></li>
                                <li><a href=""><i class="far fa-key mr-3"></i>Ganti Password</a></li>
                                <li><a href=""><i class="far fa-sign-out-alt mr-3"></i>Keluar</a></li>
                            </ul>
                        </div>
                        <div class="titlesidebar">
                            <h1 class="f-18 m-0">INFORMATION</h1>
                        </div>
                        <div class="menusidebar f-14">
                            <ul>
                                <li><a href="">Tentang Kami</a></li>
                                <li><a href="">Syarat & Ketentuan</a></li>
                                <li><a href="">Semua Iklan</a></li>
                                <li><a href="">Lokasi Ternak</a></li>
                                <li><a href="">Hubungi Kami</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
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
                    <div class="titlecontent">
                        <h1>iklan anda</h1>
                    </div>
                    <div class="dashboard-content">
                        <?php
                        if ($cek > 0) {
                        ?>
                            <?php
                            $result = $wpdb->get_results("SELECT * FROM wp_aads WHERE member_id='" . $_SESSION['member'] . "' AND kategori_iklan='Ternak'");
                            foreach ($result as $r) {
                                $k  = $wpdb->get_row("SELECT * FROM 
                                                wp_kategories,wp_subs 
                                                WHERE wp_kategories.kategori_id
                                                AND wp_subs.kategori_id
                                                AND wp_subs.kategori_id='" . $r->kategori_id . "'");
                            ?>
                                <div class="dashboard-body d-md-flex detail-iklan">
                                    <div class="w-50 mr-4">
                                        <div class="imgdetail position-relative">
                                            <img src="../wp-content/uploads/ternak/<?php echo $r->file ?>" alt="">
                                            <div class="detail-btn">
                                                <a href="" class="icon-link bg-success text-white rounded f-12 mt-3"><i class="far fa-eye mr-2"></i> 23 kali</a>
                                                <a href="" class="icon-link bg-info text-white rounded f-12 mt-3"><i class="far fa-heart mr-2"></i> 5 favorit</a>
                                            </div>
                                        </div>
                                        <div class="input-text my-4">
                                            <textarea name="" id=""><?php echo $r->keterangan; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="w-50">
                                        <span>STATUS: <h2 class="bg-warning d-inline f-14 text-white py-2 px-3 rounded">MODERASI</h2></span>
                                        <h1 class="f-20 my-3"><?php echo $result->judul; ?></h1>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                                <i class="far fa-layer-group f-12"></i>
                                                Kategori
                                            </div>
                                            <div class="w-75">
                                                <input type="text" class="w-100 p-2 istyle" value="<?php echo $k->kategori; ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                                <i class="far fa-paw f-12"></i>
                                                Jenis
                                            </div>
                                            <div class="w-75">
                                                <input type="text" class="w-100 p-2 istyle" value="<?php echo $k->sub_kategori; ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                                <i class="far fa-weight-hanging f-12"></i>
                                                Berat
                                            </div>
                                            <div class="w-75">
                                                <input type="text" class="w-100 p-2 istyle" value="<?php echo $r->berat; ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                                <i class="far fa-fire f-12"></i>
                                                Umur
                                            </div>
                                            <div class="w-75">
                                                <input type="text" class="w-100 p-2 istyle" value="<?php echo $r->umur; ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                                <i class="far fa-map-marker-alt f-12"></i>
                                                Lokasi
                                            </div>
                                            <div class="w-75">
                                                <input type="text" class="w-100 p-2 istyle" value="<?php echo $r->lokasi; ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                                <i class="far fa-tag f-12"></i>
                                                Harga
                                            </div>
                                            <div class="w-75">
                                                <input type="text" class="w-100 p-2 istyle" value="<?php echo $r->harga; ?>">
                                            </div>
                                        </div>
                                        <div class="d-flex my-3 align-items-center">
                                            <div class="icon">
                                            </div>
                                            <div class="w-75">
                                                <button class="btn btn-info">Edit Iklan</button>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"><i class="far fa-trash-alt mr-2"></i>Hapus</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <input type="text" name="delete-id" id="" value="<?php echo $r->add_id; ?>" hidden>
                                                    <button type="submit" class="btn btn-primary"><i class="far fa-trash-alt mr-2"></i>Hapus Iklan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            <?php
                            }
                            ?>
                        <?php
                        } else {
                        ?>
                            <div class="col-md-6 m-auto text-center">
                                <div class="show-items">
                                    <h1 class="f-20">
                                        <img src="../wp-content/uploads/2020/06/cow.svg" alt="">
                                        <h1 class="f-18">Belum ada iklan tampil</h1>
                                        <a href="dashboard/" class="myButton">Ayo Beriklan</a>
                                    </h1>
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
