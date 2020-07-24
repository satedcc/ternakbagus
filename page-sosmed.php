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

    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "top-profile.php"; ?>
                <div class="col-md-12">
                    <h2 class="f-24 bold-md mt-5">Social Media</h2>
                    <form action="" method="post">
                        <div class="content-utama p-4 d-md-flex">
                            <div class="w-100">
                                <div class="profile-input">
                                    <label for="">Facebook</label>
                                    <div class="profile-text">
                                        <input type="text" name="fb" value="<?= $user['facebook']; ?>" id="">
                                        <div class="icon-input">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Instagram</label>
                                    <div class="profile-text">
                                        <input type="text" name="ig" value="<?= $user['instagram']; ?>" id="">
                                        <div class="icon-input">
                                            <i class="fab fa-instagram"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Twitter</label>
                                    <div class="profile-text">
                                        <input type="text" name="tw" value="<?= $user['twitter']; ?>" id="">
                                        <div class="icon-input">
                                            <i class="fab fa-twitter"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Youtube</label>
                                    <div class="profile-text">
                                        <input type="text" name="yt" value="<?= $user['youtube']; ?>" id="">
                                        <div class="icon-input">
                                            <i class="fab fa-youtube"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <label for="">Website</label>
                                    <div class="profile-text">
                                        <input type="text" name="web" value="<?= $user['website']; ?>" id="">
                                        <div class="icon-input">
                                            <i class="far fa-link"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-input">
                                    <button class="glow-btn" name="social" value="social">Simpan</button>
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
