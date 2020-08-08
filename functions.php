<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

function load_file()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font/css/all.css', array(), '1.1', 'all');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/dist/assets/owl.theme.default.min.css', array(), '1.1', 'all');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/dist/assets/owl.carousel.min.css', array(), '1.1', 'all');
    wp_enqueue_script('owl-carousel-min', get_template_directory_uri() . '/assets/dist/owl.carousel.min.js', array('jquery'), 1.1, true);
}

add_action('wp_enqueue_scripts', 'load_file');

// $data = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
// $provinsi = json_decode($data, true);
// $provinsi = $provinsi["provinsi"];


function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


function time_ago($timestamp)
{
    //waktu lalu
    $time_ago = strtotime($timestamp);
    //waktu sekarang
    $currunt_time = time();
    // perbedaan waktu
    $time_difference = $currunt_time - $time_ago;

    //cari nilai detik
    $detik  = $time_difference;
    $menit  = round($detik / 60); // 60 detik
    $jam    = round($detik / 3600); // 3600 detik = 60 menit * 60 detik
    $hari   = round($detik / 86400); // 24 jam * 60 menit * 60 detik 
    $minggu = round($detik / 604800); // 7*4*60*60
    $bulan  = round($detik / 2629440);
    $tahun  = round($detik / 31553280);

    if ($detik <= 60) {
        return "Baru saja";
    } elseif ($menit < 60) {
        if ($menit == 1) {
            return "1 menit yang lalu";
        } else {
            return "$menit menit yang lalu";
        }
    } elseif ($jam <= 24) {
        if ($jam == 1) {
            return "1 jam yang lalu";
        } else {
            return "$jam jam yang lalu";
        }
    } elseif ($hari <= 7) {
        if ($hari == 1) {
            return "1 hari yang lalu";
        } else {
            return "$hari hari yang lalu";
        }
    } elseif ($minggu <= 4.3) {
        if ($minggu == 1) {
            return "1 minggu yang lalu";
        } else {
            return "$minggu minggu yang lalu";
        }
    } elseif ($bulan <= 12) {
        if ($bulan == 1) {
            return "1 bulan yang lalu";
        } else {
            return "$bulan bulan yang lalu";
        }
    } else {
        if ($tahun == 1) {
            return "1 tahun yang lalu";
        } else {
            return "$tahun tahun lalu yang lalu";
        }
    }
}



function format_rupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return $rupiah;
}

function textToSlug($text = '')
{
    $text = trim($text);
    if (empty($text)) return '';
    $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
    $text = strtolower(trim($text));
    $text = str_replace(' ', '-', $text);
    $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
    return $text;
}


function iklan_ternak()
{
    if ($_POST['tombol'] == "draft") {
        $draft = "Y";
    } else {
        $draft = "N";
    }
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_aads";
    $voucher            = "wp_use";
    $images             = "wp_images";

    $data  = array(
        'slug_ads'       => textToSlug($_POST['judul']),
        'kategori_iklan' => "ternak",
        'judul'          => $_POST['judul'],
        'umur'           => $_POST['umur'],
        'berat'          => $_POST['berat'],
        'satuan'         => $_POST['satuan'],
        'harga'          => $_POST['harga'],
        'keterangan'     => $_POST['ket'],
        'kategori_id'    => $_POST['kategori'],
        'sub_id'         => $_POST['jenis'],
        'lokasi'         => $_POST['kecamatan'],
        'member_id'      => $_SESSION['member'],
        'status'         => "0",
        'status_tayang'  => "1",
        'draft'          => $draft,
        'ads_create'     => $date,
        'ads_update'     => $date
    );

    $cek = $wpdb->insert($table, $data, $format);
    $idads = $wpdb->insert_id;
    if ($cek) {
        $data = array(
            'member_id'         => $_SESSION['member'],
            'qty'               => 1,
            'create_use'         => $date
        );
        $cekvoucher = $wpdb->insert($voucher, $data, $format);
        header('location:../detail/?success=1&id=' . $idads);
    }

    $limit              = 10 * 1024 * 1024;
    $ekstensi           = array('png', 'jpg', 'jpeg', 'gif');
    $jumlahFile         = count($_FILES['images']['name']);

    for ($x = 0; $x < $jumlahFile; $x++) {
        $namafile       = $_FILES['images']['name'][$x];
        $tmp            = $_FILES['images']['tmp_name'][$x];
        $tipe_file      = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran         = $_FILES['images']['size'][$x];
        $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" .  date('dmY-His') . '-' . $namafile;

        if ($ukuran > $limit) {
            header("location:index.php?alert=gagal_ukuran");
        } else {
            if (!in_array($tipe_file, $ekstensi)) {
                header("location:../ternak/?alert=gagal_ektensi");
            } else {
                move_uploaded_file($tmp, $path);
                $namarandom = date('dmY-His') . '-' . $namafile;
                $data = array(
                    'add_id' => $idads,
                    'img_desc' => $namarandom,
                    'create_img' => $date

                );
                $cek = $wpdb->insert($images, $data, $format);
                if ($_POST['tombol'] == "draft") {
                    header('location:../detail/?success=2&id=' . $idads);
                } else {
                    header('location:../detail/?success=1&id=' . $idads);
                }
            }
        }
    }
}

function editternak()
{

    if ($_POST['kecamatan'] == "") {
        $lokasi = $_POST['id_lokasi'];
    } else {
        $lokasi = $_POST['kecamatan'];
    }
    $jumlahInput        = count($_POST['images']);

    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_aads";
    $images             = "wp_images";

    $data  = array(
        'slug_ads'       => textToSlug($_POST['judul']),
        'judul'          => $_POST['judul'],
        'umur'           => $_POST['umur'],
        'berat'          => $_POST['berat'],
        'satuan'         => $_POST['satuan'],
        'harga'          => $_POST['harga'],
        'keterangan'     => $_POST['ket'],
        'kategori_id'    => $_POST['kategori'],
        'sub_id'         => $_POST['jenis'],
        'lokasi'         => $lokasi,
        'member_id'      => $_SESSION['member'],
        'ads_update'     => $date
    );

    $condition = array(
        'add_id'        => $_POST['id']
    );

    $cek = $wpdb->update($table, $data, $condition);

    $limit              = 10 * 1024 * 1024;
    $ekstensi           = array('png', 'jpg', 'jpeg', 'gif');
    $jumlahFile         = count($_FILES['images']['name']);
    $jumlahInput        = count($_POST['images']);

    for ($x = 0; $x < $jumlahFile; $x++) {
        $sate           = $_POST['images'][$x];
        $namafile       = $_FILES['images']['name'][$x];
        $tmp            = $_FILES['images']['tmp_name'][$x];
        $tipe_file      = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran         = $_FILES['images']['size'][$x];
        $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" .  date('dmY-His') . '-' . $namafile;

        if (!empty($namafile)) {
            if ($ukuran > $limit) {
                header("location:index.php?alert=gagal_ukuran");
            } else {
                if (!in_array($tipe_file, $ekstensi)) {
                    header("location:../ternak/?alert=gagal_ektensi");
                } else {
                    echo "<script>alert('$sate')</script>";

                    move_uploaded_file($tmp, $path);
                    $namarandom = date('dmY-His') . '-' . $namafile;
                    $data = array(
                        'img_desc' => $namarandom,
                        'create_img' => $date

                    );
                    $condition_img = array(
                        'image_id'        => $sate
                    );

                    $cek = $wpdb->update($images, $data, $condition_img);
                    header("location:../detail/?alert=berhasil");
                }
            }
        }
    }

    // $nama_file = $_FILES['file']['name'];
    // $ukuran_file = $_FILES['file']['size'];
    // $tipe_file = $_FILES['file']['type'];
    // $tmp_file = $_FILES['file']['tmp_name'];
    // $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    // global $wpdb;
    // $date = date('Y-m-d H:i:s');
    // if (move_uploaded_file($tmp_file, $path)) {
    //     $table = "wp_aads";
    //     $data  = array(
    //         'judul'         => $_POST['judul'],
    //         'slug_ads'      => textToSlug($_POST['judul']),
    //         'umur'          => $_POST['umur'],
    //         'berat'         => $_POST['berat'],
    //         'harga'         => $_POST['harga'],
    //         'keterangan'    => $_POST['ket'],
    //         'kategori_id'   => $_POST['kategori'],
    //         'sub_id'        => $_POST['jenis'],
    //         'lokasi'        => $_POST['lokasi'],
    //         'ads_update'    => $date,
    //         'file'          => $nama_file
    //     );
    // } else {
    //     $table = "wp_aads";
    //     $data  = array(
    //         'judul'         => $_POST['judul'],
    //         'slug_ads'      => textToSlug($_POST['judul']),
    //         'umur'          => $_POST['umur'],
    //         'berat'         => $_POST['berat'],
    //         'harga'         => $_POST['harga'],
    //         'keterangan'    => $_POST['ket'],
    //         'kategori_id'   => $_POST['kategori'],
    //         'sub_id'        => $_POST['jenis'],
    //         'lokasi'        => $_POST['lokasi'],
    //         'ads_update'    => $date
    //     );
    // }

    // $condition = array(
    //     'add_id'        => $_POST['id']
    // );

    // $cek = $wpdb->update($table, $data, $condition);
    // if ($cek) {
    //     header('location:detail/?editstatus=1');
    // }
}

function iklan_perlengkapan()
{
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_aads";
    $voucher            = "wp_use";
    $images             = "wp_images";

    $data  = array(
        'slug_ads'       => textToSlug($_POST['judul']),
        'kategori_iklan' => "perlengkapan",
        'judul'          => $_POST['judul'],
        'kondis'           => $_POST['kondisi'],
        'harga'          => $_POST['harga'],
        'keterangan'     => $_POST['ket'],
        'kategori_id'    => $_POST['kategori'],
        'sub_id'         => $_POST['jenis'],
        'lokasi'         => $_POST['lokasi'],
        'member_id'      => $_SESSION['member'],
        'status'         => "0",
        'status_tayang'   => "1",
        'ads_create'     => $date,
        'ads_update'     => $date
    );

    $cek = $wpdb->insert($table, $data, $format);
    $idads = $wpdb->insert_id;
    if ($cek) {
        $data = array(
            'member_id'         => $_SESSION['member'],
            'qty'               => 1,
            'create_use'         => $date
        );
        $cekvoucher = $wpdb->insert($voucher, $data, $format);
        header('location:../detail/?success=1&id=' . $idads);
    }

    $limit              = 10 * 1024 * 1024;
    $ekstensi           = array('png', 'jpg', 'jpeg', 'gif');
    $jumlahFile         = count($_FILES['images']['name']);

    for ($x = 0; $x < $jumlahFile; $x++) {
        $namafile       = $_FILES['images']['name'][$x];
        $tmp            = $_FILES['images']['tmp_name'][$x];
        $tipe_file      = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran         = $_FILES['images']['size'][$x];
        $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" .  date('dmY-His') . '-' . $namafile;

        if ($ukuran > $limit) {
            header("location:index.php?alert=gagal_ukuran");
        } else {
            if (!in_array($tipe_file, $ekstensi)) {
                header("location:../ternak/?alert=gagal_ektensi");
            } else {
                move_uploaded_file($tmp, $path);
                $namarandom = date('dmY-His') . '-' . $namafile;
                $data = array(
                    'add_id' => $idads,
                    'img_desc' => $namarandom,
                    'create_img' => $date

                );
                $cek = $wpdb->insert($images, $data, $format);
                header('location:../detail/?success=1&id=' . $idads);
            }
        }
    }
}

function edit_perlengkapan()
{
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_aads";
    $images             = "wp_images";

    $data  = array(
        'slug_ads'       => textToSlug($_POST['judul']),
        'judul'          => $_POST['judul'],
        'kondis'           => $_POST['kondisi'],
        'harga'          => $_POST['harga'],
        'keterangan'     => $_POST['ket'],
        'kategori_id'    => $_POST['kategori'],
        'sub_id'         => $_POST['jenis'],
        'lokasi'         => $_POST['lokasi'],
        'member_id'      => $_SESSION['member'],
        'status'         => "0",
        'ads_update'     => $date
    );

    $condition = array(
        'add_id'        => $_POST['id']
    );

    $cek = $wpdb->update($table, $data, $condition);
    //header("location:../detail/?alert=berhasil");

    $limit              = 10 * 1024 * 1024;
    $ekstensi           = array('png', 'jpg', 'jpeg', 'gif');
    $jumlahFile         = count($_FILES['images']['name']);
    $jumlahInput        = count($_POST['images']);

    for ($x = 0; $x < $jumlahFile; $x++) {
        $sate           = $_POST['images'][$x];
        $namafile       = $_FILES['images']['name'][$x];
        $tmp            = $_FILES['images']['tmp_name'][$x];
        $tipe_file      = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran         = $_FILES['images']['size'][$x];
        $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" .  date('dmY-His') . '-' . $namafile;

        if (!empty($namafile)) {
            if ($ukuran > $limit) {
                header("location:index.php?alert=gagal_ukuran");
            } else {
                if (!in_array($tipe_file, $ekstensi)) {
                    header("location:../ternak/?alert=gagal_ektensi");
                } else {
                    move_uploaded_file($tmp, $path);
                    $namarandom = date('dmY-His') . '-' . $namafile;
                    $data = array(
                        'img_desc' => $namarandom,
                        'create_img' => $date

                    );
                    $condition_img = array(
                        'image_id'        => $sate
                    );

                    $cek = $wpdb->update($images, $data, $condition_img);
                    header("location:../detail/?alert=berhasil");
                }
            }
        }
    }
}

function layanan()
{
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_aads";
    $voucher            = "wp_use";
    $images             = "wp_images";

    $data  = array(
        'slug_ads'       => textToSlug($_POST['judul']),
        'kategori_iklan' => "layanan",
        'judul'          => $_POST['judul'],
        'layanan'        => $_POST['layanan'],
        'harga'          => $_POST['harga'],
        'keterangan'     => $_POST['ket'],
        'kategori_id'    => $_POST['kategori'],
        'sub_id'         => $_POST['jenis'],
        'lokasi'         => $_POST['lokasi'],
        'member_id'      => $_SESSION['member'],
        'status'         => "0",
        'status_tayang'   => "1",
        'ads_create'     => $date,
        'ads_update'     => $date
    );

    $cek = $wpdb->insert($table, $data, $format);
    $idads = $wpdb->insert_id;
    if ($cek) {
        $data = array(
            'member_id'         => $_SESSION['member'],
            'qty'               => 1,
            'create_use'         => $date
        );
        $cekvoucher = $wpdb->insert($voucher, $data, $format);
        header('location:../detail/?success=1&id=' . $idads);
    }

    $limit              = 10 * 1024 * 1024;
    $ekstensi           = array('png', 'jpg', 'jpeg', 'gif');
    $jumlahFile         = count($_FILES['images']['name']);

    for ($x = 0; $x < $jumlahFile; $x++) {
        $namafile       = $_FILES['images']['name'][$x];
        $tmp            = $_FILES['images']['tmp_name'][$x];
        $tipe_file      = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran         = $_FILES['images']['size'][$x];
        $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" .  date('dmY-His') . '-' . $namafile;

        if ($ukuran > $limit) {
            header("location:index.php?alert=gagal_ukuran");
        } else {
            if (!in_array($tipe_file, $ekstensi)) {
                header("location:../ternak/?alert=gagal_ektensi");
            } else {
                move_uploaded_file($tmp, $path);
                $namarandom = date('dmY-His') . '-' . $namafile;
                $data = array(
                    'add_id' => $idads,
                    'img_desc' => $namarandom,
                    'create_img' => $date

                );
                $cek = $wpdb->insert($images, $data, $format);
                header('location:../detail/?success=1&id=' . $idads);
            }
        }
    }
}

function editlayanan()
{
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_aads";
    $images             = "wp_images";

    $data  = array(
        'slug_ads'       => textToSlug($_POST['judul']),
        'judul'          => $_POST['judul'],
        'layanan'        => $_POST['layanan'],
        'harga'          => $_POST['harga'],
        'keterangan'     => $_POST['ket'],
        'kategori_id'    => $_POST['kategori'],
        'sub_id'         => $_POST['jenis'],
        'lokasi'         => $_POST['lokasi'],
        'member_id'      => $_SESSION['member'],
        'status'         => "0",
        'ads_update'     => $date
    );

    $condition = array(
        'add_id'        => $_POST['id']
    );

    $cek = $wpdb->update($table, $data, $condition);
    //header("location:../detail/?alert=berhasil");

    $limit              = 10 * 1024 * 1024;
    $ekstensi           = array('png', 'jpg', 'jpeg', 'gif');
    $jumlahFile         = count($_FILES['images']['name']);
    $jumlahInput        = count($_POST['images']);

    for ($x = 0; $x < $jumlahFile; $x++) {
        $sate           = $_POST['images'][$x];
        $namafile       = $_FILES['images']['name'][$x];
        $tmp            = $_FILES['images']['tmp_name'][$x];
        $tipe_file      = pathinfo($namafile, PATHINFO_EXTENSION);
        $ukuran         = $_FILES['images']['size'][$x];
        $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" .  date('dmY-His') . '-' . $namafile;

        if (!empty($namafile)) {
            if ($ukuran > $limit) {
                header("location:index.php?alert=gagal_ukuran");
            } else {
                if (!in_array($tipe_file, $ekstensi)) {
                    header("location:../ternak/?alert=gagal_ektensi");
                } else {
                    move_uploaded_file($tmp, $path);
                    $namarandom = date('dmY-His') . '-' . $namafile;
                    $data = array(
                        'img_desc' => $namarandom,
                        'create_img' => $date

                    );
                    $condition_img = array(
                        'image_id'        => $sate
                    );

                    $cek = $wpdb->update($images, $data, $condition_img);
                    header("location:../detail/?alert=berhasil");
                }
            }
        }
    }
}

function use_voucher()
{
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_use";
    $data               = array(
        'member_id'     => $_SESSION['member'],
        'qty'           => 1,
        'create_use'    => $date
    );
    $cek = $wpdb->insert($table, $data, $format);

    $tayang             = "wp_aads";
    $datatayang         = array(
        'status_tayang' => "1",
        'tgl_tayang'    => $date
    );
    $conditiontayang    = array(
        'add_id'        => $_POST['iklan']
    );
    $cektayang = $wpdb->update($tayang, $datatayang, $conditiontayang);
    header('location:google.com');
}

function use_draft()
{
    global $wpdb;
    $date               = date('Y-m-d H:i:s');
    $table              = "wp_use";
    $data               = array(
        'member_id'     => $_SESSION['member'],
        'qty'           => 1,
        'create_use'    => $date
    );
    $cek = $wpdb->insert($table, $data, $format);

    $tayang             = "wp_aads";
    $datatayang         = array(
        'draft'         => "N",
        'tgl_tayang'    => $date
    );
    $conditiontayang    = array(
        'add_id'        => $_POST['iklan']
    );
    $cektayang = $wpdb->update($tayang, $datatayang, $conditiontayang);
    if ($cektayang) {
        header('location:../detail/?success=1&id=' . $_POST['iklan']);
    }
}

function cek_input($data)
{

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function register($nama, $email, $password, $telp)
{
    $sid = session_id();

    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_members";

    $emailcek = $wpdb->get_var("SELECT COUNT(email) FROM wp_members WHERE email='" . $email . "'");

    if ($emailcek > 0) {
        header('location:register/?email=true');
    } else {
        $data  = array(
            'nama' => $nama,
            'slug_nama'     => textToSlug($nama),
            'email'         => $email,
            'telp'          => $telp,
            'password'      => $password,
            'aktif'         => "N",
            'sid'           => $sid,
            'create_at'     => $date
        );
        $_SESSION['sidnew'] = $sid;
        $cek = $wpdb->insert($table, $data, $format);

        mkdir('wp-content/uploads/' . textToSlug($nama) . '');

        if ($cek) {
            include "assets/PHPMailer/kirim.php";
            header('location:login/?success=1');
        } else {
            header('location:register/?seccess=0');
        }
        $wpdb->close();
    }
}


function potong($isi)
{
    $potong = substr($isi, 0, 35); // ambil sebanyak 220 karakter
    $potong = substr($isi, 0, strrpos($potong, " ")); // potong per spasi kalimat

    return $potong;
}

function social()
{
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_socials";
    $data  = array(
        'member_id'     => $_SESSION['member'],
        'facebook'      => $_POST['fb'],
        'instagram'     => $_POST['ig'],
        'twitter'       => $_POST['tw'],
        'youtube'       => $_POST['yt'],
        'website'       => $_POST['web'],
        'social_at'     => $date
    );
    $cek = $wpdb->insert($table, $data, $format);
    if ($cek) {
        return "Data Tersimpan";
    }
    $wpdb->close();
}

function updateprofile()
{
    global $wpdb;
    $table = "wp_members";
    $nama_file = $_FILES['photo']['name'];
    // $ukuran_file = $_FILES['photo']['size'];
    // $tipe_file = $_FILES['photo']['type'];
    $tmp_file = $_FILES['photo']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;

    if ($_POST['nama'] != "" && $_POST['email'] != "" && $_POST['telp'] != "") {
        if (move_uploaded_file($tmp_file, $path)) {
            $data  = array(
                'nama'      => $_POST['nama'],
                'email'     => $_POST['email'],
                'telp'      => $_POST['telp'],
                'alamat'    => $_POST['alamat'],
                'photo'     => $nama_file
            );
        } else {
            $data  = array(
                'nama'      => $_POST['nama'],
                'email'     => $_POST['email'],
                'telp'      => $_POST['telp'],
                'alamat'    => $_POST['alamat']
            );
        }

        $condition = array(
            'member_id' => $_SESSION['member']
        );
        $cek = $wpdb->update($table, $data, $condition);
        if ($cek) {
            header('location:setting/?status=1');
        } else {
            header('location:setting/?status=0');
        }
        $wpdb->close();
    }
}


function tawar()
{
    if (isset($_POST['tawar'])) {
        $tawar = "Hello, saya menawar iklannya anda pada harga Rp. " . $_POST['tawar'] . ". Jika berkenan mohon membalas pesan ini";
        global $wpdb;
        $date = date('Y-m-d H:i:s');
        $table = "wp_chat";
        $data  = array(
            'receiver_id'   => $_POST['member'],
            'send_id'       => $_SESSION['id_member'],
            'add_id'        => $_POST['iklan'],
            'message'       => $tawar,
            'status_chat'   => "N",
            'type_chat'     => "buyer",
            'chat_at'       => $date
        );
        $cek = $wpdb->insert($table, $data, $format);

        if ($cek) {
            header('location:view/?id=' . $_POST['iklan'] . '&status=1');
        } else {
            header('location:view/?id=' . $_POST['iklan'] . '&status=0');
        }
        $wpdb->close();
    }
}
function pesanchat()
{
    if (isset($_POST['pesan'])) {
        global $wpdb;
        $date = date('Y-m-d H:i:s');
        $table = "wp_chat";
        $data  = array(
            'receiver_id'   => $_POST['member'],
            'send_id'       => $_SESSION['id_member'],
            'add_id'        => $_POST['iklan'],
            'message'       => $_POST['pesan'],
            'status_chat'   => "N",
            'type_chat'     => "buyer",
            'chat_at'       => $date
        );
        $cek = $wpdb->insert($table, $data, $format);

        if ($cek) {
            header('location:view/?id=' . $_POST['iklan'] . '&status=1');
        } else {
            header('location:view/?id=' . $_POST['iklan'] . '&status=0');
        }
        $wpdb->close();
    }
}


function randomString($length)
{
    $str        = "";
    $characters = '1234567890';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

function konfirmasi()
{
    ob_start();
    $nama_file      = $_FILES['file']['name'];
    $ukuran_file    = $_FILES['file']['size'];
    $tipe_file      = $_FILES['file']['type'];
    $tmp_file       = $_FILES['file']['tmp_name'];
    $path           = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date           = date('Y-m-d H:i:s');
    $table          = "wp_konfirmasi";
    if (move_uploaded_file($tmp_file, $path)) {
        $data           = array(
            'nama_pembeli'      => $_POST['nama'],
            'asal'              => $_POST['asal'],
            'tujuan'            => $_POST['tujuan'],
            'jumlah_bayar'      => $_POST['jumlah'],
            'keterangan'        => $_POST['keterangan'],
            'v_id'              => $_POST['voucher_id'],
            'konf_status'       => "N",
            'bukti_bayar'       => $nama_file,
            'konf_at'           => $date
        );
        $cek = $wpdb->insert($table, $data, $format);

        if ($cek) {
            include "assets/PHPMailer/konfirmasi.php";
            header('location:history/?status=1');
        } else {
            header('location:history/?status=0');
        }
        $wpdb->close();
    } else {
        header('location:history/?upload=0');
    }
    ob_end_flush();
}

function changepassword()
{
    global $wpdb;
    $table              = "wp_members";

    if ($_POST['password'] != $_POST['konfirmasi']) {
        header('location:ganti-password/?pass=false');
    } else {
        $password = md5($_POST['password']);
        $data = array(
            'password' => $password
        );
        $condition = array(
            'member_id' => $_SESSION['member']
        );
        $wpdb->update($table, $data, $condition);
        header('location:logout/?login=false');
    }
}


function convertDate($value)
{
    $tglnow = date("Y-m-d");
    list($date, $time) = explode(' ', $value);

    $start = new DateTime($date);
    $end   = new DateTime($tglnow);

    $interval = $start->diff($end);

    $selisih = $interval->days;

    return $selisih;
}
