<?php
session_start();
$sid = session_id();
if (isset($_POST) && $_POST['email'] != '' && $_POST['password'] != '') {
    $password = md5($_POST['password']);
    $login = $wpdb->get_var("SELECT COUNT(*) FROM wp_members WHERE email='" . $_POST['email'] . "' AND password='" . $password . "'");
    if ($login > 0) {

        $result = $wpdb->get_row("SELECT * FROM wp_members WHERE email='" . $_POST['email'] . "' AND password='" . $password . "'");

        $_SESSION['nama']   = $result->nama;
        $_SESSION['id']     = $sid;
        $_SESSION['email']  = $result->email;
        $_SESSION['slug']   = $result->slug_nama;
        $_SESSION['member'] = $result->member_id;
        $_SESSION['photo']  = $result->photo;
        $_SESSION['tgl']    = $result->create_at;
        header("Location: ternakbagus/dashboard");
        exit();
    } else {
        $message = "Email dan password salah";
    }
}


get_header();
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
                    <div class="iklan-button my-3">
                        <i class="far fa-bell mr-2"></i> Pasang Iklan
                    </div>
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
                        <span>Belum punya akun ? <a href="">Daftar Sekarang</a></span>
                    </div>
                </form>
            </div>
        <?php
        }

        ?>
    </div>
</section>


<?php
get_footer();
