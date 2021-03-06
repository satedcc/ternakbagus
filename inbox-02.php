<?php
session_start();
$sid = session_id();

if (isset($_SESSION['id'])) {

    // $cekuser = $wpdb->get_var("SELECT COUNT(*) FROM wp_chat WHERE receiver_id='" . $_SESSION['member'] . "'");
    // if ($cekuser > 0) {
    //     $memberid = "send_id";
    // } else {
    //     $memberid = "receiver_id";
    // }

    if (isset($_POST['pesan'])) {
        $date = date('Y-m-d H:i:s');
        $table = "wp_chat";
        $data = array(
            'receiver_id' => $_GET['receiver'],
            'send_id' => $_GET['sender'],
            'message' =>  $_POST['message'],
            'type_chat' => $_POST['type'],
            'chat_at' => $date
        );

        $cek = $wpdb->insert($table, $data, $format);
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
                <div class="col-md-4">
                    <?php
                    // $cekuser = $wpdb->get_var("SELECT COUNT(*) FROM wp_chat WHERE receiver_id='" . $_SESSION['member'] . "'");
                    // if ($cekuser > 0) {
                    //     $chats = $wpdb->get_results("SELECT * FROM `wp_chat` LEFT JOIN wp_members ON wp_chat.send_id=wp_members.member_id WHERE chat_id IN (SELECT MAX(chat_id) FROM wp_chat GROUP BY send_id) AND receiver_id='" . $_SESSION['member'] . "' ORDER BY chat_at DESC", ARRAY_A);
                    // } else {
                    //     $chats = $wpdb->get_results("SELECT * FROM `wp_chat` LEFT JOIN wp_members ON wp_chat.send_id=wp_members.member_id WHERE chat_id IN (SELECT MAX(chat_id) FROM wp_chat GROUP BY send_id) AND send_id='" . $_SESSION['member'] . "' ORDER BY chat_at DESC", ARRAY_A);
                    // }

                    $chats = $wpdb->get_results("SELECT * FROM `wp_chat` LEFT JOIN wp_members ON wp_chat.send_id=wp_members.member_id WHERE chat_id IN (SELECT MAX(chat_id) FROM wp_chat GROUP BY send_id) AND receiver_id='" . $_SESSION['member'] . "' OR send_id='" . $_SESSION['member'] . "' GROUP BY send_id ORDER BY chat_at DESC", ARRAY_A);

                    foreach ($chats as $c) {
                        if ($c['status_chat'] == "N") {
                            $class = " new";
                        }
                    ?>
                        <div class="menu-inbox">
                            <a href="inbox/?receiver=<?= $c['receiver_id']; ?>&sender=<?= $c['send_id']; ?>&iklan=<?= $c['add_id']; ?>" class="content-main d-flex align-items-center<?= $class; ?>">
                                <div>
                                    <img src="https://midone.left4code.com/dist/images/profile-3.jpg" alt="" class="img-inbox mr-2">
                                </div>
                                <div class="list-message">
                                    <h1 class="f-14 m-0 bold-md"><?= $c['nama']; ?></h1>
                                    <p class="m-0 f-12"><?= $c['message']; ?></p>
                                    <span class="jam"><?php echo time_ago($c['chat_at']); ?></span>
                                </div>
                            </a>
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
                                        <span>Hey, i am using chat &middot; Online</span>
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
                                        <input type="text" name="type" value="<?= $status; ?>" hidden>
                                        <input type="text" name="message" id="" placeholder="masukkan pesan anda..." class="w-100">
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
                        echo "Tidak ada chat";
                    }
                    ?>
                </div>
            </div>
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
                }
            });
        })
    })



    function loadData() {
        $.get('../wp-content/themes/ternak/simpan.php?receiver=<?= $_GET['receiver'] ?>&sender=<?= $_GET['sender'] ?>', function(data) {
            $('#content').html(data)
        })
    }
</script>