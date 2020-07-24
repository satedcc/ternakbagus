<?php
$iklan = $wpdb->get_var("SELECT COUNT(member_id) FROM wp_aads WHERE member_id='" . $_SESSION['member'] . "'");
$favorit = $wpdb->get_var("SELECT COUNT(member_id) FROM wp_like WHERE member_id='" . $_SESSION['member'] . "'");

?>

<div class="col-md-12">
    <div class="content-utama">
        <div class="info-diri  d-md-flex p-4 align-items-center justify-content-between">
            <div class="d-flex align-items-center justify-content-center">
                <div class="mr-4">
                    <?php
                    if ($user['photo'] != "") {
                    ?>
                        <img src="../wp-content/uploads/<?php echo "$user[slug_nama]/$user[photo];" ?>" alt="" class="img-profile-md">
                    <?php
                    } else {
                        echo "<div class='default-img mb-4'><i class='far fa-user'></i></div>";
                    }
                    ?>
                </div>
                <div>
                    <h1 class="f-18 bold-md"><?= $user['nama']; ?></h1>
                    <h6 class="f-14 m-0">Pengiklan</h6>
                    <span class="f-12"><?= time_ago($user['create_at']); ?></span>
                </div>
            </div>
            <div class="text-secondary account-sosmed">
                <h2 class="f-14"><i class="far fa-envelope mr-3"></i><?= $user['email']; ?></h2>
                <h2 class="f-14"><i class="far fa-phone mr-3"></i><?= $user['telp']; ?></h2>
                <h2 class="f-14"><i class="fab fa-facebook mr-3"></i><?= $user['facebook']; ?></h2>
                <h2 class="f-14"><i class="fab fa-instagram mr-3"></i><?= $user['instagram']; ?></h2>
            </div>
            <div class="text-secondary d-flex justify-content-center">
                <div class="count-profile">
                    <h2><?= $iklan; ?></h2>
                    Iklan Terbit
                </div>
                <div class="count-profile">
                    <h2><?= $favorit; ?></h2>
                    Iklan Favorit
                </div>
                <div class="count-profile">
                    <h2>0</h2>
                    Item Terjual
                </div>
            </div>
        </div>
        <hr class="m-0">
        <ul class="menu-profile">
            <li><a href="" class="active"><i class="far fa-user mr-2"></i><label for="" class="m-0">Profile</label></a></li>
            <li><a href="sosmed/"><i class="far fa-shield-alt mr-2"></i><label for="" class="m-0">Account</label></a></li>
            <li><a href="ganti-password/"><i class="far fa-lock mr-2"></i><label for="" class="m-0">Change Password</label></a></li>
            <li><a href="setting/"><i class="far fa-cog mr-2"></i><label for="" class="m-0">Setting</label></a></li>
        </ul>
    </div>
</div>