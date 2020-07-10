<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {

    $user = $wpdb->get_row("SELECT * FROM wp_members LEFT JOIN wp_socials USING (member_id) WHERE member_id='" . $_SESSION['member'] . "'", ARRAY_A);
    if ($_POST['social'] == "social") {
        social();
    }

    updateprofile($nama_file);

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
                <?php include "top-profile.php"; ?>
                <div class="col-md-12">
                    <?php
                    switch ($_GET['status']) {
                        case '1':
                            echo "<div class='alert alert-success' role='alert'>
                                    Data berhasil di update
                                    </div>";
                            break;

                        case '0':
                            echo "<div class='alert alert-danger' role='alert'>
                        Data Gagal di update
                        </div>";
                            break;
                    }
                    ?>
                    <h2 class="f-24 bold-md">Profile</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="content-utama p-4 d-md-flex">
                            <div class="mr-4 bg-light p-3 uploads">
                                <?php
                                if ($user['photo'] != "") {
                                ?>
                                    <img src="../wp-content/uploads/<?php echo "$user[slug_nama]/$user[photo];" ?>" alt="">

                                <?php
                                } else {
                                    echo "<div class='default-img mb-4'><i class='far fa-user'></i></div>";
                                }
                                ?>
                                <label for="photo"><i class="far fa-camera-alt mr-3"></i>Upload Foto</label>
                                <input type="file" name="photo" id="photo">
                                <p class="f-12">Besar file: maksimum 10.000.000 bytes (10 Megabytes)
                                    Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</p>
                            </div>
                            <div class="w-100">
                                <div class="profile-input">
                                    <label for="">Nama</label>
                                    <div class="profile-text">
                                        <input type="text" name="nama" value="<?= $user['nama']; ?>" id="">
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Email</label>
                                    <div class="profile-text">
                                        <input type="text" name="email" value="<?= $user['email']; ?>" id="">
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Telp</label>
                                    <div class="profile-text">
                                        <input type="text" name="telp" value="<?= $user['telp']; ?>" id="">
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Alamat</label>
                                    <div class="profile-text">
                                        <textarea name="alamat" id="" cols="100%" rows="10"><?= $user['alamat']; ?></textarea>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <button class="glow-btn">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>

<?php

    get_footer();
} else {
    header('location:../');
}
