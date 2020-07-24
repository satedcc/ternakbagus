<?php
session_start();
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Load Composer's autoloader
//require 'vendor/autoload.php';

if (isset($_POST['daftar'])) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $nama       = $_POST['nama'];
    $email      = $_POST['email'];
    $kode       = $_GET['kode'];


    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'sate.dp@gmail.com';                     // SMTP username
    $mail->Password   = 'satria.dcc.27041987';                               // SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('sate.dp@gmail.com', 'Admin TernakBagus.com');
    $mail->addAddress($email, $nama);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('sate.dp@gmail.com', 'Admin TernakBagus.com');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Konfirmasi Akun Ternakbagus.com';
    $mail->Body    = '
    
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ternakbagus.com</title>
    <style>
        .container {
            background: rgb(182, 226, 255);
            font-family: "Roboto", sans-serif;
            font-size: 14px;
            width: 100%;
            padding: 50px;
            box-sizing: border-box;

        }

        .wrapper {
            width: 80%;
            height: auto;
            padding: 30px;
            background: #FFF;
            box-shadow: 0 3px 4px rgba(0, 0, 0, 0.04);
            margin: auto;
        }

        a.btn-aktivasi {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.8);
            background: rgb(0, 50, 143);
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: none;
            display: inline-block;
        }

        hr {
            margin-top: 50px;
        }

        .bottom {
            text-align: center;
            font-size: 12px;
            font-weight: lighter;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <h1>Terima kasih telah bergabung bersama Ternakbagus.com</h1>
            <p>untuk mengaktifkan akun anda silahkan klik link di bawah ini</p>
            <a href=' . get_site_url() . '/wp-content/themes/ternak/aktivasi.php?id=' . $_SESSION['sidnew'] . '&email=' . $email . ' class="btn-aktivasi">Aktivasi Akun</a>
            <hr>
            <div class="bottom">
                <p>Kami doakan semoga produk yang anda iklan terjual dan product yang anda cari sesuai dengan kebutuhan
                    anda.
                    Terima Kasih</p>
                <span>Copyright &copy; 2020. Ternakbagus.com | Jual ternak Cepat dan Dekat </span>
            </div>
        </div>
    </div>
</body>

</html>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    // if ($mail->send()) {
    //     echo '<script>alert("Message has been sent")</script>';
    // } else {
    //     echo "<script>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</script>";
    // }
} else {
    echo '<script>alert("submit dulu")</script>';
}
