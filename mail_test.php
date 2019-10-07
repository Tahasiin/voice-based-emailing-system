<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

require_once './database/connection.php';

session_start();
$id = $_SESSION['mail_id'];
if (isset($_POST['submit'])) {
// Multiple recipients
    $address = $_POST['address']; // note the comma
    $to = str_replace(' ', '', $address);
    echo $to;
// Subject
    $subject = $_POST['subject'];

// Message
    $message = $_POST['message'];

// To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
    $headers[] = 'From: Birthday Reminder <birthday@example.com>';
    $headers[] = 'Cc: birthdayarchive@example.com';
    $headers[] = 'Bcc: birthdaycheck@example.com';

// Mail it
    if (mail($to, $subject, $message, implode("\r\n", $headers))) {
        echo "<script>alert('Mail was sent !');</script>";
        echo "<script>document.location.href='index.php'</script>";
        $sql = "UPDATE `email` SET `status`='sent' WHERE mail_id = '$id' ";
        if ($conn->query($sql) === TRUE) {
            echo '<audio src="sounds/confirm-address.mp3" autoplay></audio>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {

        $sql = "UPDATE `email` SET `status`='not sent' WHERE mail_id = '$id' ";
        if ($conn->query($sql) === TRUE) {
            echo '<audio src="sounds/confirm-address.mp3" autoplay></audio>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    
</script>

<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>PHP Mail</h4>
                <form id="contactform" action="" method="post" class="validateform" name="send-contact">
                    <?php
                    $sql = "SELECT * FROM `email` WHERE mail_id = '$id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="row">
                                <div class="col-lg-4 field">
                                    <input  name="address" id="Username"  value="<?php echo $row['address'] ?>" placeholder="* To"  />
                                    <!--<input type="email" name="address" id="Username" onfocus="value = value.replace(/(\r\n\s|\n|\r|\s)/gm, '');" value="" placeholder="* To"  />-->
                                </div>
                                <div class="col-lg-4 field">
                                    <input type="text" name="subject"  value="<?php echo $row['subject'] ?>" placeholder="* Subject" data-rule="email" data-msg="Please enter a valid email" />
                                </div>
                                <div class="col-lg-12 margintop10 field">
                                    <textarea rows="12" name="message" placeholder="* Your message here..." data-rule="required" data-msg="Please write something">
                                        <?php echo $row['message'] ?>
                                    </textarea>
                                    <p>
                                        <button name="submit" value="submit" class="btn btn-theme margintop10 pull-left" type="submit">Submit message</button>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
