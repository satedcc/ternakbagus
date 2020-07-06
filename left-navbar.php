<div class="col-md-3">
    <div id="mySidenav" class="sidenav">
        <div class="titlesidebar">
            <h1 class="f-18 m-0">ACCOUNT</h1>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        </div>
        <div class="profile p-4 text-center">
            <img src="../wp-content/uploads/<?php echo "$rec[slug_nama]/$rec[photo]" ?>" alt="" class="img-profile">
            <h1 class="bold-md f-18 m-0"><?php echo $_SESSION['nama']; ?></h1>
            <span class="f-12">Bergabung sejak <?php echo time_ago($_SESSION['tgl']); ?>
            </span>
            <a href="setting" class="icon-link blue text-white rounded f-12 mt-3">
                <i class="far fa-cog mr-2"></i> Update Profile
            </a>
            <a href="" class="icon-link bg-warning text-white rounded f-12">
                <i class="far fa-rocket-launch"></i>
            </a>
        </div>
        <hr>
        <div class="menusidebar f-14">
            <ul>
                <li><a href="inbox/"><i class="far fa-inbox mr-3"></i>Inbox</a></li>
                <li><a href="setting/"><i class="far fa-cog mr-3"></i>Setting</a></li>
                <li><a href="detail/"><i class="far fa-store-alt mr-3"></i>Iklan Anda</a></li>
                <li><a href="favorit/"><i class="far fa-heart mr-3"></i>Iklan Favorit</a></li>
                <li><a href="ganti-password/"><i class="far fa-key mr-3"></i>Ganti Password</a></li>
                <li><a href="logout/"><i class="far fa-sign-out-alt mr-3"></i>Keluar</a></li>
            </ul>
        </div>
        <div class="titlesidebar">
            <h1 class="f-18 m-0">INFORMATION</h1>
        </div>
        <div class="menusidebar f-14">
            <ul>
                <li><a href="">Tentang Kami</a></li>
                <li><a href="">Syarat & Ketentuan</a></li>
                <li><a href="">Semua Iklan</a></li>
                <li><a href="">Lokasi Ternak</a></li>
                <li><a href="">Hubungi Kami</a></li>
            </ul>
        </div>
    </div>
</div>