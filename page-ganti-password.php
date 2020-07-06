<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {

    $user = $wpdb->get_row("SELECT * FROM wp_members LEFT JOIN wp_socials USING (member_id) WHERE member_id='" . $_SESSION['member'] . "'", ARRAY_A);
    if ($_POST['social'] == "social") {
        social();
    }
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
                    <h2 class="f-24 bold-md mt-5">Ganti Password</h2>
                    <form action="" method="post">
                        <div class="content-utama p-4 d-md-flex">
                            <div class="w-100">
                                <div class="profile-input">
                                    <label for="">New Password</label>
                                    <div class="profile-text">
                                        <input type="password" name="password" id="" required>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Konfirmasi Password</label>
                                    <div class="profile-text">
                                        <input type="password" name="konfirmasi" id="" required>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <button class="glow-btn" name="change" value="change">Ganti Password</button>
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
