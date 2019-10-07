<?php
require_once './database/connection.php';
session_start();
$username = $_SESSION['username'];
if (isset($_POST["submit"])) {

    
    $address = preg_replace('/\s+/', '', $_POST['address']);
    $id      = $_SESSION['mail_id'];
    
    if($address === $_SESSION['address']){

    $sql = "INSERT INTO `email`(`address`,`mail_id`,`username`) VALUES ('$address','$id','$username')";

    if ($conn->query($sql) === TRUE) {
        header('location:subject.php');
    } else {
        echo 'Error' . $sql . "<br>" . $conn->error;
    }
}
else {
        header('location:address-not-matched.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="refresh" content="60;url=username.php" />
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
        </style>
    </head>
    <body style="background: black" onload="startButton(event)">

        <audio src="sounds/confirm-address.mp3" autoplay></audio>
        
        <br>
        <div class="text" style="height: 100%;width: 100%">
            <form method="Post">
                <div id="results" style="">
                <textarea cols="85" rows="10" id="final_span" class="final" name="address" required></textarea>
                <span id="interim_span" class="interim" style="display: none"></span>
                <p>
            </div>
            <input type="submit" class="btn" name="submit" value="submit"/>
           
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
