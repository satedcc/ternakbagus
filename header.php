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
    </style>
</head>

<body>
    <header>
        <a href="dashboard/" class="iklan-bottom">
            <i class="far fa-bell mr-2"></i>PASANG IKLAN
        </a>
        <div class="topbar">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="">
                                <h1>Ternak<span>Bagus</span></h1>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="input-text">
                            <input type="text" placeholder="cari di sini">
                            <button><i class="far fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?php
                        if (isset($_SESSION['id'])) {
                        ?>
                            <ul class="w-75 float-right">
                                <li>
                                    <div class="dropdown">
                                        <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="far fa-comment-alt-dots f-20"></i>
                                            <span class="notif_count"></span>
                                        </a>
                                        <?php
                                        $qty = $wpdb->get_var("SELECT COUNT(*) FROM wp_chat WHERE receiver_id='" . $_SESSION['member'] . "' AND status_chat='N' AND type_chat='buyer'");
                                        ?>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <?php
                                            if ($qty > 0) {
                                            ?>
                                                <a href="" class="f-12 link">Pesan Terbaru (<?= $qty; ?>)</a>
                                                <hr class="m-0">
                                                <?php

                                                $chats = $wpdb->get_results("SELECT * FROM `wp_chat` LEFT JOIN wp_members ON wp_chat.send_id=wp_members.member_id WHERE chat_id IN (SELECT MAX(chat_id) FROM wp_chat GROUP BY send_id) AND receiver_id='" . $_SESSION['member'] . "' ORDER BY chat_at DESC", ARRAY_A);
                                                foreach ($chats as $c) {
                                                    if ($c['status_chat'] == "N") {
                                                        $class = " active";
                                                    }
                                                ?>
                                                    <a href="" class="notif_message<?= $class; ?>">
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

                                                <a href="" class="f-12 link">Lihat Semua Pesan</a>
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
                                        <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="far fa-bell f-20"></i>
                                            <span class="notif_count"></span>
                                        </a>
                                        <?php
                                        $qty = $wpdb->get_var("SELECT COUNT(*) FROM wp_notif WHERE member_id='" . $_SESSION['member'] . "' AND baca='Unread'");
                                        ?>
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
                                <li class="menu-akun">
                                    <a href="#" class="top-akun">
                                        <i class="far fa-user"></i>
                                    </a>
                                    <div class="menu-dropdown-top">
                                        <ul>
                                            <li>
                                                <a href="setting/">
                                                    <div class="d-flex my-3">
                                                        <div>
                                                            <img src="<?php echo get_site_url(); ?>/wp-content/uploads/<?php echo "$_SESSION[slug]/$_SESSION[photo]" ?>" alt="" class="img-profile-sm mr-2">
                                                        </div>
                                                        <div>
                                                            Hay,
                                                            <h1 class="f-18 bold-md m-0"><?= $_SESSION['nama']; ?></h1>
                                                            <span class="f-10"><?= $_SESSION['email']; ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                                <hr class="m-0">
                                            </li>
                                            <li><a href="detail/"><i class="far fa-ad mr-2"></i>Iklan Anda</a></li>
                                            <li><a href="voucher/"><i class="far fa-tag mr-2"></i>Beli Voucher</a></li>
                                            <li><a href="logout"><i class="far fa-power-off mr-2"></i>Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        <?php
                        } else {
                        ?>
                            <ul>
                                <li><a href="">BERANDA</a></li>
                                <li><a href="">BLOG</a></li>
                                <li><a href="">KONTAK</a></li>
                                <li class="menu-akun">
                                    <a href="#" class="top-akun">
                                        <i class=" far fa-user"></i>
                                    </a>
                                    <div class="menu-dropdown-top">
                                        <ul>
                                            <li><a href="login"><i class="far fa-lock mr-2"></i>Login</a></li>
                                        </ul>
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
                                echo "<li><a href=''>$k[kategori]</a></li>";
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>