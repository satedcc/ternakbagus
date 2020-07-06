<?php
session_start();
$sid = session_id();
if (isset($_POST) && $_POST['nama'] != '' && $_POST['email'] != '' && $_POST['telp'] != '') {
    $password = md5($_POST['password']);
    register($_POST['nama'], $_POST['email'], $password, $_POST['telp']);
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
        <div class="login-front">
            <form action="" method="post">
                <div class="form-main w-100">
                    <h2 class="f-24 bold-md mt-4">Daftar Sekarang</h2>
                    <h3 class="f-14">Dapatkan 5 iklan gratis untuk promo launching sebagai member ternakbagus</h3>
                    <div class="main-input">
                        <span class="float-right text-danger">
                            <?php echo $message; ?>
                        </span>
                        <label for="input-text" class="bold-md">Nama</label>
                        <div class="input-text">
                            <input type="text" required placeholder="nama anda" name="nama">
                        </div>
                    </div>
                    <div class="main-input">
                        <span class="float-right text-danger">
                        </span>
                        <label for="input-text" class="bold-md">Telp</label>
                        <div class="input-text">
                            <input type="text" required placeholder="no telp" name="telp">
                        </div>
                    </div>
                    <div class="main-input">
                        <span class="float-right text-danger">
                        </span>
                        <label for="input-text" class="bold-md">Email</label>
                        <div class="input-text">
                            <input type="text" required placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="main-input">
                        <label for="input-text" class="bold-md">Password</label>
                        <div class="input-text">
                            <input type="password" placeholder="password anda" name="password">
                        </div>
                    </div>
                    <div class="main-input">
                        <div class="input-text">
                            <input type="checkbox" name="robot"> Saya setuju dengan syarat ketentuan dan tata tertib ternakbagus.com
                        </div>
                    </div>
                    <div class="main-input">
                        <div class="input-text w-100">
                            <button class="myButton py-3 block w-100">DAFTAR SEKARANG</button>
                        </div>
                    </div>
                    <span>Sudah punya akun ? <a href="login">Login Sekarang</a></span>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
get_footer();
