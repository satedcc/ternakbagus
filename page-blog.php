<?php
get_header();
$news = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_status='publish' AND comment_status='open'", ARRAY_A);
?>
<a href="ternak/" class="iklan-bottom">
    <i class="far fa-bell mr-2"></i>PASANG IKLAN
</a>
<section id="dashboard" class="dashboard">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php
                foreach ($news as $n) {
                    // Tampilkan hanya sebagian isi berita
                    $isi_berita = htmlentities(strip_tags($n['post_content'])); // membuat paragraf pada isi berita dan mengabaikan tag html
                    $isi = substr($isi_berita, 0, 520); // ambil sebanyak 220 karakter
                    $isi = substr($isi_berita, 0, strrpos($isi, " ")); // potong per spasi kalimat
                    echo "<div class='content-utama p-5 mb-4 position-relative'>
                                <h1 class='titlenews'>$n[post_title]</h1>
                                <p>$isi</p>
                            </div>";
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
