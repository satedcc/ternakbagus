<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

function load_file()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font/css/all.css', array(), '1.1', 'all');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/dist/assets/owl.theme.default.min.css', array(), '1.1', 'all');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/dist/assets/owl.carousel.min.css', array(), '1.1', 'all');
    wp_enqueue_script('owl-carousel-min', get_template_directory_uri() . '/assets/dist/owl.carousel.min.js', array('jquery'), 1.1, true);
    wp_enqueue_script('chained', get_template_directory_uri() . '/assets/js/jquery-chained.min.js', array('jquery'), 1.1, true);
}

add_action('wp_enqueue_scripts', 'load_file');

$data = file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
$provinsi = json_decode($data, true);
$provinsi = $provinsi["provinsi"];


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
    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];
    $tmp_file = $_FILES['file']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_aads";

    if ($_POST['judul'] != "" && $_POST['harga'] != "") {
        if (move_uploaded_file($tmp_file, $path)) {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'kategori_iklan' => "ternak",
                'judul'          => $_POST['judul'],
                'umur'           => $_POST['umur'],
                'berat'          => $_POST['berat'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_create'     => $date,
                'ads_update'     => $date,
                'file'           => $nama_file
            );
        } else {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'kategori_iklan' => "ternak",
                'judul'          => $_POST['judul'],
                'umur'           => $_POST['umur'],
                'berat'          => $_POST['berat'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_update'     => $date
            );
        }
        $cek = $wpdb->insert($table, $data, $format);
        if ($cek) {
            header('location:detail/');
        } else {
            header('location:ternak/');
        }
    }
}

function editternak()
{

    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];
    $tmp_file = $_FILES['file']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    if (move_uploaded_file($tmp_file, $path)) {
        $table = "wp_aads";
        $data  = array(
            'judul'         => $_POST['judul'],
            'slug_ads'      => textToSlug($_POST['judul']),
            'umur'          => $_POST['umur'],
            'berat'         => $_POST['berat'],
            'harga'         => $_POST['harga'],
            'keterangan'    => $_POST['ket'],
            'kategori_id'   => $_POST['kategori'],
            'sub_id'        => $_POST['jenis'],
            'lokasi'        => $_POST['lokasi'],
            'ads_update'    => $date,
            'file'          => $nama_file
        );
    } else {
        $table = "wp_aads";
        $data  = array(
            'judul'         => $_POST['judul'],
            'slug_ads'      => textToSlug($_POST['judul']),
            'umur'          => $_POST['umur'],
            'berat'         => $_POST['berat'],
            'harga'         => $_POST['harga'],
            'keterangan'    => $_POST['ket'],
            'kategori_id'   => $_POST['kategori'],
            'sub_id'        => $_POST['jenis'],
            'lokasi'        => $_POST['lokasi'],
            'ads_update'    => $date
        );
    }

    $condition = array(
        'add_id'        => $_POST['id']
    );

    $cek = $wpdb->update($table, $data, $condition);
    if ($cek) {
        header('location:ternak/?edit=' . $_POST['id'] . '');
    }
}

function iklan_perlengkapan()
{
    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];
    $tmp_file = $_FILES['file']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_aads";

    if ($_POST['judul'] != "" && $_POST['harga'] != "") {
        if (move_uploaded_file($tmp_file, $path)) {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'kategori_iklan' => "perlengkapan",
                'judul'          => $_POST['judul'],
                'kondis'         => $_POST['kondisi'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_create'     => $date,
                'ads_update'     => $date,
                'file'           => $nama_file
            );
        } else {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'kategori_iklan' => "ternak",
                'judul'          => $_POST['judul'],
                'kondis'        => $_POST['kondisi'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_update'     => $date
            );
        }
        $cek = $wpdb->insert($table, $data, $format);
        if ($cek) {
            header('location:detail/?status=1');
        } else {
            header('location:perlengkapan/?status=0');
        }
    }
}

function edit_perlengkapan()
{
    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];
    $tmp_file = $_FILES['file']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_aads";

    if ($_POST['judul'] != "" && $_POST['harga'] != "") {
        if (move_uploaded_file($tmp_file, $path)) {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'judul'          => $_POST['judul'],
                'kondis'         => $_POST['kondisi'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_create'     => $date,
                'ads_update'     => $date,
                'file'           => $nama_file
            );
        } else {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'judul'          => $_POST['judul'],
                'kondis'        => $_POST['kondisi'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_update'     => $date
            );
        }
        $condition = array(
            'add_id'        => $_POST['id']
        );
        $cek = $wpdb->update($table, $data, $condition);
        if ($cek) {
            header('location:detail/?status=1');
        } else {
            header('location:perlengkapan/?status=0');
        }
    }
}

function layanan()
{
    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];
    $tmp_file = $_FILES['file']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_aads";

    if ($_POST['judul'] != "" && $_POST['harga'] != "") {
        if (move_uploaded_file($tmp_file, $path)) {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'kategori_iklan' => "layanan",
                'judul'          => $_POST['judul'],
                'layanan'         => $_POST['layanan'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_create'     => $date,
                'ads_update'     => $date,
                'file'           => $nama_file
            );
        } else {
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
                'ads_update'     => $date
            );
        }
        $cek = $wpdb->insert($table, $data, $format);
        if ($cek) {
            header('location:detail/?status=1');
        } else {
            header('location:layanan/?status=0');
        }
    }
}

function editlayanan()
{
    $nama_file = $_FILES['file']['name'];
    $ukuran_file = $_FILES['file']['size'];
    $tipe_file = $_FILES['file']['type'];
    $tmp_file = $_FILES['file']['tmp_name'];
    $path = "wp-content/uploads/" . $_SESSION['slug'] . "/" . $nama_file;
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_aads";

    if ($_POST['judul'] != "" && $_POST['harga'] != "") {
        if (move_uploaded_file($tmp_file, $path)) {
            $data  = array(
                'slug_ads'       => textToSlug($_POST['judul']),
                'judul'          => $_POST['judul'],
                'layanan'         => $_POST['layanan'],
                'harga'          => $_POST['harga'],
                'keterangan'     => $_POST['ket'],
                'kategori_id'    => $_POST['kategori'],
                'sub_id'         => $_POST['jenis'],
                'lokasi'         => $_POST['lokasi'],
                'member_id'      => $_SESSION['member'],
                'status'         => "0",
                'ads_create'     => $date,
                'ads_update'     => $date,
                'file'           => $nama_file
            );
        } else {
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
        }
        $condition = array(
            'add_id'        => $_POST['id']
        );
        $cek = $wpdb->update($table, $data, $condition);
        if ($cek) {
            header('location:detail/?status=1');
        } else {
            header('location:layanan/?status=0');
        }
    }
}

function use_voucher($use, $id)
{
    if (isset($use) && (isset($id))) {
        global $wpdb;
        $date = date('Y-m-d H:i:s');
        $table = "wp_use";
        $data  = array(
            'v_id' => $id,
            'qty' => $use,
            'create_use' => $date
        );
        $cek = $wpdb->insert($table, $data, $format);
        // echo "<script>alert('$use')</script>";
    }
}

function register($nama, $email, $password, $telp)
{
    global $wpdb;
    $date = date('Y-m-d H:i:s');
    $table = "wp_members";
    $data  = array(
        'nama' => $nama,
        'slug_nama'     => textToSlug($nama),
        'email'         => $email,
        'telp'          => $telp,
        'password'      => $password,
        'create_at'     => $date
    );
    $_SESSION['nama']   = $nama;
    $_SESSION['id']     = $sid;
    $_SESSION['email']  = $email;
    $cek = $wpdb->insert($table, $data, $format);

    mkdir('wp-content/uploads/' . textToSlug($nama) . '');

    if ($cek) {
        header('location:dashboard/?success=1');
    } else {
        header('location:register/?seccess=0');
    }
    $wpdb->close();
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
