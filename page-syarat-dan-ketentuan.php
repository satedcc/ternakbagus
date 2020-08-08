<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {
    get_header();

?>

    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <h1 class="f-20 mb-3">Syarat dan Ketentuan</h1>
                    <div class="content-utama p-4">

                        <?php
                        $row = $wpdb->get_row("SELECT post_name,post_status,comment_status,post_content FROM wp_posts WHERE post_name='syarat-dan-ketentuan' AND post_status='publish' AND comment_status='open'", ARRAY_A);
                        echo "$row[post_content]";
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

    get_footer();
} else {
    header('location:../');
}
