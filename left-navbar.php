<div class="col-md-3">
    <div id="mySidenav" class="sidenav">
        <div class="titlesidebar">
            <h1 class="f-18 m-0">ACCOUNT</h1>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        </div>
        <div class="profile p-4 text-center">
            <?php
            if ($_SESSION['photo'] != "") {
            ?>
                <img src="<?php echo get_site_url(); ?>/wp-content/uploads/<?php echo "$_SESSION[slug]/$_SESSION[photo]" ?>" alt="" class="img-profile">
            <?php
            } else {
                echo "<div class='default-img mb-4'><i class='far fa-user'></i></div>";
            }
            ?>
            <h1 class="bold-md f-18 m-0"><?php echo $_SESSION['nama']; ?></h1>
            <span class="f-12">Bergabung sejak <?php echo time_ago($_SESSION['tgl']); ?>
            </span>
            <a href="dashboard" class="icon-link blue text-white rounded f-12 mt-3">
                <i class="far fa-cog mr-2"></i> Dashboard
            </a>
            <!-- <a href="" class="icon-link bg-warning text-white rounded f-12">
                <i class="far fa-rocket-launch"></i>
            </a> -->
        </div>
        <hr>
        <div class="menusidebar f-14">
            <ul>
                <li><a href="inbox/"><i class="far fa-inbox mr-3"></i>Inbox</a></li>
                <li><a href="detail/"><i class="far fa-store-alt mr-3"></i>Iklan Anda</a></li>
                <li><a href="favorit/"><i class="far fa-heart mr-3"></i>Iklan Favorit</a></li>
                <li><a href="voucher/"><i class="far fa-tag mr-3"></i>Beli Voucher</a></li>
                <li><a href="logout/"><i class="far fa-sign-out-alt mr-3"></i>Keluar</a></li>
            </ul>
        </div>
        <div class="titlesidebar">
            <h1 class="f-18 m-0">INFORMATION</h1>
        </div>
        <div class="menusidebar f-14">
            <ul>
                <li><a href="../tentang-kami">Tentang Kami</a></li>
                <li><a href="../syarat-dan-ketentuan">Syarat & Ketentuan</a></li>
                <li><a href="../kontak">Hubungi Kami</a></li>
            </ul>
        </div>
    </div>
</div>