<?php
require_once('../../../wp-config.php');
global $wpdb;
$chat_message = $wpdb->get_results("SELECT * FROM wp_chat WHERE receiver_id='" . $_GET['receiver'] . "' AND send_id='" . $_GET['sender'] . "'", ARRAY_A);
foreach ($chat_message as $cm) {
    if ($cm['type_chat'] == "seller") {
?>
        <div class="seller p-3 d-flex justify-content-end">
            <div class="replay">
                <p class="block"><?= $cm['message']; ?></p>
                <span class="text-info"><?php echo time_ago($cm['chat_at']); ?></span>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="buyer p-3 d-flex">
            <div class="chat">
                <p class="block"><?= $cm['message']; ?></p>
                <span class="text-secondary"><?php echo time_ago($cm['chat_at']); ?></span>
            </div>
        </div>
<?php
    }
}
?>