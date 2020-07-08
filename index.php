<?php
session_start();
$sid = session_id();
$kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);

if (isset($_POST) && $_POST['email'] != '' && $_POST['password'] != '') {
    $password = md5($_POST['password']);
    $login = $wpdb->get_var("SELECT COUNT(*) FROM wp_members WHERE email='" . $_POST['email'] . "' AND password='" . $password . "'");
    if ($login > 0) {

        $result = $wpdb->get_row("SELECT * FROM wp_members WHERE email='" . $_POST['email'] . "' AND password='" . $password . "'");

        $_SESSION['nama'] = $result->nama;
        $_SESSION['id'] = $sid;
        $_SESSION['email'] = $result->email;
        $_SESSION['slug'] = $result->slug_nama;
        $_SESSION['member'] = $result->member_id;
        $_SESSION['photo'] = $result->photo;
        $_SESSION['tgl'] = $result->create_at;
        $_SESSION['id_member']    = $result->member_id;
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
                <img src="wp-content/themes/ternak/assets/img/indonesia.svg" alt="">
                <span class="marker1">
                    <img src="wp-content/themes/ternak/assets/img/Asset 1.svg" alt="">
                </span>
                <span class="marker2">
                    <img src="wp-content/themes/ternak/assets/img/Asset 3.svg" alt="">
                </span>
                <span class="marker3">
                    <img src="wp-content/themes/ternak/assets/img/Asset 10.svg" alt="">
                </span>
                <span class="marker4">
                    <img src="wp-content/themes/ternak/assets/img/Asset 10.svg" alt="">
                </span>
                <span class="marker5">
                    <img src="wp-content/themes/ternak/assets/img/Asset 4.svg" alt="">
                </span>
                <span class="marker6">
                    <img src="wp-content/themes/ternak/assets/img/Asset 1.svg" alt="">
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
                                <input type="password" placeholder="password" name="password">
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
        <?php
        }

        ?>
    </div>
</section>

<div class="categories top-middle">
    <div class="container">
        <div class="row justify-content-center">
            <?php
            foreach ($kategori as $k) {
                $count = $wpdb->get_var("SELECT COUNT(kategori_id) FROM wp_subs WHERE kategori_id='" . $k['kategori_id'] . "'")
            ?>
                <div class="col-md-2 col-6 mb-4">
                    <a href="kategori/?idkategori=<?= $k['kategori_id']; ?>" class="item-ct d-block">
                        <img src="wp-content/uploads/<?= $k['file_kategori']; ?>" alt="">
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

<?php
foreach ($kategori as $k) {
?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlebar">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h1><?php echo $k['kategori']; ?></h1>
                            </div>
                            <div class="col-auto text-right">
                                <a href="kategori/?idkategori=<?= $k['kategori_id']; ?>">Lihat Semua <i class="fad fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_aads WHERE kategori_id='" . $k['kategori_id'] . "'");

                if ($cek > 0) {
                ?>
                    <div class="owl-carousel owl-theme">
                        <?php
                        $result = $wpdb->get_results("SELECT * FROM wp_aads LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id WHERE kategori_id='" . $k['kategori_id'] . "'", ARRAY_A);
                        foreach ($result as $r) {
                            if ($r['kategori_iklan'] == "ternak") {
                                $desc = $r['berat'] . "kg";
                            } elseif ($r['kategori_iklan'] == "perlengkapan") {
                                $desc = $r['kondis'];
                            } elseif ($r['kategori_iklan'] == "layanan") {
                                $desc = $r['layanan'];
                            }
                        ?>
                            <div class="col-lg col-md-4 p-0">
                                <div class="item">
                                    <div class="imgbox">
                                        <img src="wp-content/uploads/<?php echo "$r[slug_nama]/$r[file];" ?>" alt="">
                                    </div>
                                    <div class="body">
                                        <h2 class="mt-2 f-18 m-0"><?php echo $r['judul']; ?></h2>
                                        <span class="f-12"><i class="far fa-map-marker-alt text-primary mr-2"></i>Kota
                                            Surabaya</span>
                                        <div class="f-12 py-2 m-0">
                                            <i class="far fa-badge-check text-success"></i> Tersedia - <span class="bold-sm"><?php echo $desc; ?></span>
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
                <?php
                } else {
                ?>
                    <div class="col-md-6 m-auto text-center">
                        <div class="show-items">
                            <h1 class="f-20">
                                <img src="wp-content/uploads/2020/06/cow.svg" alt="">
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
<?php
}
?>

<?php
get_footer();
