<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title><?php bloginfo('name'); ?></title>
    <?php
    date_default_timezone_set('Asia/Jakarta');
    wp_head();
    ?>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            background: #f4f6ff;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php
    // Use the function
    if (isMobile()) {
    ?>
        <div class="header-mobile">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <?php
                    if (isset($_SESSION['id'])) {
                    ?>
                        <div id="mySidenavTop" class="sidenavTop">
                            <a href="javascript:void(0)" class="closebtn" onclick="closeNavTop()">&times;</a>
                            <div class="mobile-menu">
                                <ul>
                                    <li>
                                        <a href="dashboard">
                                            <div class="d-flex">
                                                <div>
                                                    <?php
                                                    if ($_SESSION['photo'] != "") {
                                                    ?>
                                                        <img src="<?php echo get_site_url(); ?>/wp-content/uploads/<?php echo "$_SESSION[slug]/$_SESSION[photo]" ?>" alt="">

                                                    <?php
                                                    } else {
                                                        echo "<div class='default-img-md mr-3'><i class='far fa-user'></i></div>";
                                                    }
                                                    ?>
                                                </div>
                                                <div>
                                                    Hay,
                                                    <h1 class="f-20 bold-md m-0 p-0"><?= $_SESSION['nama']; ?></h1>
                                                    <span class="f-18 text-lowercase"><?= $_SESSION['email']; ?></span>
                                                </div>
                                            </div>
                                        </a>
                                        <hr>
                                    </li>
                                    <li><a href="setting"><i class="far fa-cog mr-3"></i>Setting</a></li>
                                    <li><a href="inbox"><i class="far fa-inbox mr-3"></i>Inbox</a></li>
                                    <li><a href="detail"><i class="far fa-store mr-3"></i>Iklan Anda</a></li>
                                    <li><a href="favorit"><i class="far fa-heart mr-3"></i>Iklan Favorit</a></li>
                                    <li><a href="voucher"><i class="far fa-tag mr-3"></i>Voucher</a></li>
                                    <li><a href="setting"><i class="far fa-bell mr-3"></i>Notifikasi</a></li>
                                    <li><a href="ganti-password"><i class="far fa-key mr-3"></i>Ganti password</a></li>
                                    <li><a href="voucher"><i class="far fa-tag mr-3"></i>Voucher</a>
                                        <hr>
                                    </li>
                                    <li><a href="logout"><i class="fal fa-sign-out-alt mr-3"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div id="mySidenavTop" class="sidenavTop">
                            <a href="javascript:void(0)" class="closebtn" onclick="closeNavTop()">&times;</a>
                            <div class="mobile-menu">
                                <ul>
                                    <a href="login">
                                        <div class="d-flex">
                                            <div>
                                                <div class='default-img-md mr-3'><i class='far fa-user'></i></div>
                                            </div>
                                            <div>
                                                <h1 class="f-20 m-0 p-0">Masuk ke akun anda</h1>
                                                <span class="f-18 text-lowercase">Login ke akun anda sekarang</span>
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                    </li>
                                    <li><a href="login"><i class="fal fa-store mr-3"></i>Iklan Anda</a></li>
                                    <li><a href="register"><i class="fal fa-user mr-3"></i>Register</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <span style="font-size:30px;cursor:pointer" onclick="openNavTop()">&#9776;</span>
                </div>
                <div class="col-auto">
                    <a href="<?php echo get_site_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <header>
            <div class="topbar">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-3">
                            <div class="logo">
                                <!-- <a href="">
                                <h1>Ternak<span>Bagus</span></h1>
                            </a> -->
                                <a href="<?php echo get_site_url(); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <form action="../search" method="post">
                                <div class="input-text">
                                    <input type="text" placeholder="cari di sini">
                                    <button><i class="far fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <?php
                            if (isset($_SESSION['id'])) {
                                $qty = $wpdb->get_var("SELECT COUNT(*) FROM wp_notif WHERE member_id='" . $_SESSION['member'] . "' AND baca='Unread'");
                                $qty_chat = $wpdb->get_var("SELECT COUNT(*) FROM wp_chat WHERE send_id='" . $_SESSION['member'] . "' OR  receiver_id='" . $_SESSION['member'] . "' AND status_chat='N'");
                            ?>
                                <ul class="w-100 float-right">
                                    <li><a href="<?php echo get_site_url(); ?>">BERANDA</a></li>
                                    <li><a href="../blog">BLOG</a></li>
                                    <li><a href="../kontak">KONTAK</a></li>
                                    <li>
                                        <div class="dropdown">
                                            <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="top-akun">
                                                <i class="far fa-comment-alt-dots f-20"></i>
                                                <?php
                                                if ($qty_chat > 0) {
                                                    echo "<span class=notif_count></span>";
                                                }
                                                ?>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <?php
                                                if ($qty_chat > 0) {
                                                ?>
                                                    <a href="inbox/" class="f-12 link">Pesan Terbaru (<?= $qty_chat; ?>)</a>
                                                    <hr class="m-0">
                                                    <div class="message-list-top">
                                                        <?php

                                                        $chats = $wpdb->get_results("SELECT * FROM `wp_chat` LEFT JOIN wp_members ON wp_chat.send_id=wp_members.member_id WHERE chat_id IN (SELECT MAX(chat_id) FROM wp_chat GROUP BY send_id,receiver_id) AND receiver_id='" . $_SESSION['member'] . "' OR send_id='" . $_SESSION['member'] . "' ORDER BY chat_at DESC", ARRAY_A);
                                                        foreach ($chats as $c) {
                                                            if ($c['status_chat'] == "N") {
                                                                $class = " active";
                                                            }
                                                        ?>
                                                            <a href="inbox/?receiver=<?= $c['receiver_id'] ?>&sender=<?= $c['send_id']; ?>&iklan=<?= $c['add_id']; ?>" class="notif_message<?= $class; ?>">
                                                                <div class="notif_img mr-3">
                                                                    <div class="user_id">
                                                                        <i class="far fa-user"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="notif_info">
                                                                    <h1 class="bold-md f-14 m-0"><?= $c['nama']; ?></h1>
                                                                    <p class="m-0"><?= potong($c['message']); ?>...</p>
                                                                    <span class="notify_time">
                                                                        <?php echo time_ago($c['chat_at']); ?>
                                                                    </span>
                                                                </div>
                                                            </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                    <a href="inbox/" class="f-12 link">Lihat Semua Pesan</a>
                                            </div>
                                        <?php
                                                } else {
                                        ?>
                                            <div class="msg">
                                                <h1 class="f-14">Belum ada pesan yang masuk</h1>
                                                <i class="far fa-comment-smile fa-5x my-3"></i>
                                                <p class="f-12">Kami akan menyimpan percakapan untuk setiap barang yang Anda jual di sini</p>
                                            </div>
                                        <?php
                                                }
                                        ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="top-akun">
                                                <i class="far fa-bell f-20"></i>
                                                <?php
                                                if ($qty > 0) {
                                                    echo "<span class=notif_count></span>";
                                                }
                                                ?>
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <?php
                                                if ($qty > 0) {
                                                ?>
                                                    <a href="" class="link">Pemberitahuan (33)</a>
                                                    <hr class="m-0">

                                                    <?php
                                                    $notif = $wpdb->get_results("SELECT * FROM wp_notif", ARRAY_A);
                                                    foreach ($notif as $n) {
                                                    ?>
                                                        <a href="" class="notif_item <?php echo $n['baca']; ?>">
                                                            <div class="notif_icon">
                                                                <i class="far fa-ad f-20 mr-3 text-info"></i>
                                                            </div>
                                                            <div class="notif-info">
                                                                <p class="m-0">Iklan anda telah di moderisasi</p>
                                                                <span class="notify_time">
                                                                    <?php echo time_ago($n['created_at']); ?>
                                                                </span>
                                                            </div>
                                                        </a>
                                                    <?php
                                                    }
                                                    ?>

                                                    <a href="" class="link">Lihat semua pemberitahuan (33)</a>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="msg">
                                                        <h1 class="f-14">Belum ada pesan yang masuk</h1>
                                                        <i class="far fa-bell-on fa-5x my-3"></i>
                                                        <p class="f-12">Kami akan menyimpan percakapan untuk setiap barang yang Anda jual di sini</p>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="top-akun">
                                                <i class="far fa-user bg-primary"></i>
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <ul class="d-block user">
                                                    <li>
                                                        <a href="dashboard/">
                                                            <div class="d-flex my-3">
                                                                <div>
                                                                    <?php
                                                                    if ($_SESSION['photo'] != "") {
                                                                    ?>
                                                                        <img src="<?php echo get_site_url(); ?>/wp-content/uploads/<?php echo "$_SESSION[slug]/$_SESSION[photo]" ?>" alt="" class="img-profile-sm mr-2">

                                                                    <?php
                                                                    } else {
                                                                        echo "<div class='default-img-md mr-3'><i class='far fa-user'></i></div>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div>
                                                                    Hay,
                                                                    <h1 class="f-18 bold-md m-0 p-0"><?= $_SESSION['nama']; ?></h1>
                                                                    <span class="f-12 text-lowercase"><?= $_SESSION['email']; ?></span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <hr class="m-0">
                                                    </li>
                                                    <li><a href="setting/"><i class="far fa-heart mr-3"></i>Setting</a></li>
                                                    <li><a href="ganti-password/"><i class="far fa-key mr-3"></i>Ganti password</a></li>
                                                    <li><a href="logout"><i class="far fa-power-off mr-3"></i>Logout</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <ul>
                                    <li><a href="<?php echo get_site_url(); ?>">BERANDA</a></li>
                                    <li><a href="blog/">BLOG</a></li>
                                    <li><a href="kontak/">KONTAK</a></li>
                                    <li>
                                        <div class="dropdown">
                                            <a href="login/" id="dropdownMenuButton" class="top-akun">
                                                <i class="far fa-user bg-primary"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <ul>
                                <?php
                                global $wpdb;
                                $kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);
                                foreach ($kategori as $k) {
                                    echo "<li><a href='kategori/?idkategori=$k[kategori_id]'>$k[kategori]</a></li>";
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php
    }
    ?>