<?php
session_start();
$sid = session_id();
if (isset($_POST) && $_POST['email'] != '' && $_POST['password'] != '') {
    $password = md5($_POST['password']);
    $login = $wpdb->get_var("SELECT COUNT(*) FROM wp_members WHERE email='" . $_POST['email'] . "' AND password='" . $password . "'  AND aktif='Y'");
    if ($login > 0) {

        $result = $wpdb->get_row("SELECT * FROM wp_members WHERE email='" . $_POST['email'] . "' AND password='" . $password . "'  AND aktif='Y'");

        $_SESSION['nama']   = $result->nama;
        $_SESSION['id']     = $sid;
        $_SESSION['email']  = $result->email;
        $_SESSION['slug']   = $result->slug_nama;
        $_SESSION['member'] = $result->member_id;
        $_SESSION['photo']  = $result->photo;
        $_SESSION['tgl']    = $result->create_at;
        $_SESSION['id_member']    = $result->member_id;
        header("Location: ternakbagus/dashboard");
        exit();
    } else {
        $message = "Email dan password salah";
    }
}


get_header();
if ($_GET['success'] == "1") {
?>
    <!-- Modal -->
    <div class="modal fade" id="konfirmasiRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Daftar akun berhasil, mohon untuk mengecek email anda
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php
} elseif ($_GET['aktif'] == "true") {
?>
    <!-- Modal -->
    <div class="modal fade" id="konfirmasiRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Akun telah aktif, silahkan login untuk beriklan di <span class="bold-md">ternakbagus.com</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>



<section id="hero">
    <div class="hero-caption">
        <div <?php if (isset($_SESSION['id'])) : echo "class='w-100'";
                else : echo "class='w-75'";
                endif; ?>>
            <div class="map w-100">
                <img src="../wp-content/themes/ternak/assets/img/indonesia.svg" alt="">
                <span class="marker1">
                    <img src="../wp-content/themes/ternak/assets/img/Asset 1.svg" alt="">
                </span>
                <span class="marker2">
                    <img src="../wp-content/themes/ternak/assets/img/Asset 3.svg" alt="">
                </span>
                <span class="marker3">
                    <img src="../wp-content/themes/ternak/assets/img/Asset 10.svg" alt="">
                </span>
                <span class="marker4">
                    <img src="../wp-content/themes/ternak/assets/img/Asset 10.svg" alt="">
                </span>
                <span class="marker5">
                    <img src="../wp-content/themes/ternak/assets/img/Asset 4.svg" alt="">
                </span>
                <span class="marker6">
                    <img src="../wp-content/themes/ternak/assets/img/Asset 1.svg" alt="">
                </span>
            </div>
        </div>
        <?php

        if (!isset($_SESSION['id'])) {
        ?>
            <div class="login-front">
                <form action="" method="post">
                    <div class="ribbon-login">
                        <h1 class="f-14 m-0">PROMO</h1>
                        <span>Join Member</span>
                    </div>
                    <h2 class="f-18 bold-md mt-4">Ingin jual ternak dengan cepat ?</h2>
                    <?php
                    if ($_SESSION['id'] == "") {
                        echo '<a href="" class="iklan-button my-3" data-toggle="modal" data-target="#iklan-bottom">
                        <i class="far fa-bell mr-2"></i> Pasang Iklan
                    </a>';
                    } else {
                        echo '<a href="ternak/" class="iklan-button my-3">
                        <i class="far fa-bell mr-2"></i> Pasang Iklan
                    </a>';
                    }

                    ?>
                    <div class="form-main">
                        <h3 class="f-18">Sudah punya akun</h3>
                        <div class="main-input">
                            <span class="float-right text-danger">
                                <?php echo $message; ?>
                            </span>
                            <label for="input-text" class="bold-md">Email/No.Telp</label>
                            <div class="input-text">
                                <input type="text" placeholder="email anda" name="email">
                            </div>
                        </div>
                        <div class="main-input">
                            <label for="input-text" class="bold-md">Password</label>
                            <div class="input-text">
                                <input type="password" placeholder="email anda" name="password">
                            </div>
                        </div>
                        <div class="main-input">
                            <div class="input-text">
                                <input type="checkbox" name="robot"> Saya bukan robot
                            </div>
                        </div>
                        <div class="main-input">
                            <div class="input-text">
                                <button class="myButton py-2">LOGIN</button>
                            </div>
                        </div>
                        <span>Belum punya akun ? <a href="register">Daftar Sekarang</a></span>
                    </div>
                </form>
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
                            Silahkan Login atau Register terlebih dahulu untuk bisa beriklan atau melihat iklan di <span class="bold-md">ternakbagus.com</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }

        ?>
    </div>
</section>


<?php
get_footer();
