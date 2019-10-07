<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header('location:../reply.php');
    exit;
}


require("mailer/PHPMailer/src/PHPMailer.php");
require("mailer/PHPMailer/src/SMTP.php");

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

require_once '../database/connection.php';

$link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

session_start();
$id = $_SESSION['mail_id'];
$_SESSION['username'];


if (isset($_POST['submit'])) {

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP


    $address = preg_replace('/\s+/', '', $_POST['address']);
// Subject
    $subject = $_POST['subject'];

// Message
    $message = $_POST['message'];


    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "mail address";
    $mail->Password = "password of mail address";
    $mail->SetFrom("xxxxxx@xxxxx.com");
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($address);

    if (!$mail->Send()) {
        $sql = "UPDATE `email` SET `status`='0' WHERE mail_id = '$id' ";
        if ($conn->query($sql) === TRUE) {
            header('location:failed.php');
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $sql = "UPDATE `email` SET `status`='1' WHERE mail_id = '$id' ";
        if ($conn->query($sql) === TRUE) {
            header('location:success.php');
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="refresh" content="30;url=mail.php" />
        <title></title>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../particles/style.css">
        <link rel="stylesheet" href="../matrix/style.css">
        <link rel="stylesheet" href="../index.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <style>
            input[type="submit"]
            {
                height: 800px;width: 100%;background: none;outline: none;border: none
            }
            input[type="email"]
            {
                background: none;border:none;outline:none;
            }
        </style>
    </head>
    <body style="background: black" onload="startButton(event)">

        <audio src="sounds/mail.mp3" autoplay></audio>

        <br>
        <div class="text" style="height: 100%;width: 100%">
            <form method="post" name="send-contact">
                <?php
                $sql = "SELECT * FROM `email` WHERE mail_id = '$id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div style="display: none">
                            <div class="col-lg-4 field">
                                <!--<input type="email" name="address" id="Username" onfocus="value = value.replace(/(\r\n\s|\n|\r|\s)/gm, '');" value="<?php echo $row['address'] ?>" placeholder="* To"  />-->
                                <input type="text" name="address" value="<?php echo $row['address'] ?>" placeholder="* To"  />
                            </div>

                            <div class="col-lg-4 field">
                                <input type="text" name="subject"  value="<?php echo $row['subject'] ?>" placeholder="* Subject" data-rule="email" data-msg="Please enter a valid email" />
                            </div>
                            <div class="col-lg-12 margintop10 field">
                                <textarea rows="12" name="message" placeholder="* Your message here..." data-rule="required" data-msg="Please write something">
                                                                                                         
                                                 [ This mail is from voice based e-mailing service for blind people.
                                                 The sender is user- <?php echo $row['username'] ?>.Here is the message for you: ]
                                                <br><br>
                                                 "<?php echo $row['message'] ?>"
                                                                         <br><br>     
                                                 [ If you want to reply please visit <a href="<?php echo $link ?>" target="_blank"><?php echo $link ?></a> and use this username <u style="color:red"><?php echo $row['username'] ?></u> to reply. Thank you.]
                                                                                                                                                                                        
                                </textarea>

                            </div>
                        </div>



                        <?php
                    }
                } else {
                    echo "0 results";
                }
                ?>
                <input type="submit" name="submit" value="submit"  >
            </form>

            <?php include './parts/essential.php'; ?>
        </div>
        <script>
            function click(e) {
                if (navigator.appName == 'Netscape' && e.which == 3) {
                    window.location.reload();
                    return false;
                } else {
                    if (navigator.appName == 'Microsoft Internet Explorer' && event.button == 2)
                        window.location.reload();
                    return false;
                }
                return true;
            }
            document.onmousedown = click;
            document.oncontextmenu = new Function("window.location.reload();return false;");
        </script>
        <script src="js/index.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="../matrix/script.js"></script>
        <script src="../index.js"></script>
        <script  src="../js/index.js"></script>

    </body>
</html>
