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
        header("Location: ternakbagus/dashboard");
        exit();
    } else {
        $message = "Email dan password salah";
    }
}


get_header();
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
            $result = $wpdb->get_results("SELECT * FROM wp_aads LEFT JOIN wp_members ON wp_aads.member_id=wp_members.member_id WHERE kategori_id='" . $_GET['idkategori'] . "' LIMIT 15", ARRAY_A);
            foreach ($result as $r) {
            ?>
                <div class="col-md-3 col-6 mb-4">
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

<?php
get_footer();
