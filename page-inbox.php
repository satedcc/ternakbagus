<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {
    get_header();
?>
    <section id="dashboard" class="dashboard">
        <div class="container my-5">
            <?php
            $cek = $wpdb->get_var("SELECT COUNT(*) FROM wp_chat WHERE receiver_id='" . $_SESSION['member'] . "' OR send_id='" . $_SESSION['member'] . "'");

            if ($cek > 0) {
            ?>
                <div class="row">
                    <?php include "left-navbar.php"; ?>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <h1 class="f-18 bold-md">Inbox</h1>
                                <hr>
                                <?php
                                $chats = $wpdb->get_results("SELECT * FROM `wp_chat` LEFT JOIN wp_members ON wp_chat.send_id=wp_members.member_id WHERE chat_id IN (SELECT MAX(chat_id) FROM wp_chat GROUP BY send_id) AND receiver_id='" . $_SESSION['member'] . "' OR send_id='" . $_SESSION['member'] . "' GROUP BY send_id ORDER BY chat_at DESC", ARRAY_A);

                                foreach ($chats as $c) {
                                    if ($c['status_chat'] == "N") {
                                        $class = " new";
                                    }
                                ?>
                                    <div class="content-main<?= $class; ?>">
                                        <div class="row">
                                            <div class="col-auto m-0 pr-0">
                                                <?php
                                                if ($c['photo'] != "") {
                                                ?>
                                                    <img src="../wp-content/uploads/<?php echo "$c[slug_nama]/$c[photo]"; ?>" alt="" class="img-inbox mr-2">
                                                <?php
                                                } else {
                                                    echo "<div class='default-img-sm'><i class='far fa-user'></i></div>";
                                                }
                                                ?>
                                            </div>
                                            <div class="col list-message px-0">
                                                <a href="inbox/?receiver=<?= $c['receiver_id']; ?>&sender=<?= $c['send_id'] ?>&iklan=<?= $c['add_id']; ?>">
                                                    <h1 class="f-14 m-0 bold-md"><?= $c['nama']; ?></h1>
                                                    <?= $c['message']; ?>
                                                    <h6 class="jam"><?php echo time_ago($c['chat_at']); ?></h6>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a href="chatdelete/?receiver=<?= $c['receiver_id']; ?>&sender=<?= $c['send_id'] ?>&iklan=<?= $c['add_id']; ?>">
                                                    <i class="far fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-8">
                                <?php
                                if (isset($_GET['receiver']) && isset($_GET['sender'])) {
                                    if ($_GET['receiver'] == $_SESSION['member']) {
                                        $rec = $wpdb->get_row("SELECT nama,member_id,photo,slug_nama FROM wp_members WHERE member_id='" . $_GET['sender'] . "'", ARRAY_A);
                                        $status = "seller";
                                    } else {
                                        $status = "buyer";
                                        $rec = $wpdb->get_row("SELECT nama,member_id,photo,slug_nama FROM wp_members WHERE member_id='" . $_GET['receiver'] . "'", ARRAY_A);
                                    }
                                ?>
                                    <div class="content-utama">
                                        <div class="row justify-content-between p-3">
                                            <div class="col-auto d-flex align-items-center">
                                                <div>
                                                    <img src="../wp-content/uploads/<?php echo "$rec[slug_nama]/$rec[photo]" ?>" alt="" class="img-inbox mr-2">
                                                </div>
                                                <div>
                                                    <h2 class="f-18 m-0"><?= $rec['nama']; ?></h2>
                                                    <span>Status &middot; Online</span>
                                                </div>
                                            </div>
                                            <div class="col-auto"></div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="body-inbox">
                                            <div id="content"></div>

                                        </div>
                                        <hr class="my-2">
                                        <form action="../wp-content/themes/ternak/save.php" method="post">
                                            <div class="row p-3 justify-content-between align-items-center">
                                                <div class="col-md-8">
                                                    <input type="text" name="sender" value="<?= $_GET['sender']; ?>" hidden>
                                                    <input type="text" name="receiver" value="<?= $_GET['receiver']; ?>" hidden>
                                                    <input type="text" name="iklan" value="<?= $_GET['iklan']; ?>" hidden>
                                                    <input type="text" name="type" value="<?= $status; ?>" hidden>
                                                    <input type="text" name="message" id="pesan" placeholder="masukkan pesan anda..." class="w-100">
                                                </div>
                                                <div class="col-md-auto">
                                                    <label for="photo"><i class="far fa-paperclip f-20 text-secondary mr-4"></i></label>
                                                    <input type="file" name="photo" id="photo">
                                                    <button class="glow-btn" type="submit" name="pesan" value="pesan">
                                                        <i class="far fa-paper-plane mr-2"></i>Kirim Pesan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php
                                } else {
                                    echo "<div class='text-center empty-chat content-utama'>
                        <div class='body'>
                            <i class='far fa-comment-smile fa-8x my-3 gradient'></i>
                            <p>Belum ada pesan yang di pilih</p>
                        </div>
                </div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            } else {
                include "left-navbar.php";
                echo "
                    <div class='col-md-8 m-auto text-center empty-chat'>
                    <div class='body'>
                        <h1 class='f-18'>Belum ada pesan yang masuk</h1>
                        <i class='far fa-comment-smile fa-8x my-3'></i>
                        <p>Semua pesan akan tersimpan dan tampil di sini</p>
                    </div>
            </div>";
            }

            ?>

        </div>
    </section>


<?php
    get_footer();
} else {
    header('location:../');
}
?>

<script>
    $(document).ready(function() {
        loadData();
        setInterval(function() {
            loadData();
        }, 1000);
        $('form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function() {
                    loadData();
                    resetForm();
                }
            });
        })
    })

    function resetForm() {
        $('#pesan').val('');
        $('#pesan').focus();
    }



    function loadData() {
        $.get('<?= get_site_url(); ?>/simpan.php?receiver=<?= $_GET['receiver'] ?>&sender=<?= $_GET['sender'] ?>&iklan=<?= $_GET['iklan'] ?>', function(data) {
            $('#content').html(data)
        })
    }
</script>