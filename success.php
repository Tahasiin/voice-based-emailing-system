<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); # Date In The Past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); # Always Modified
header("Cache-Control: no-store, no-cache, must-revalidate"); # HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); # HTTP/1.0

session_start();
$_SESSION['username'];

if (isset($_POST["answer"])) {

    $answer = $_POST["answer"];
    if ($answer === 'yes') {
        header('location:address.php');
    } else if ($answer === 'no') {
       header('location:http://localhost/voice-based-emailing-system/check-inbox.php');
    }else if ($answer === 'check') {
        header('location:http://localhost/voice-based-emailing-system/login/what-to-check.php');
    } else {
        header('location:../error.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="cache-control" content="max-age=0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="-1">
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 11:00:00 GMT">
        <meta http-equiv="pragma" content="no-cache">
        <meta name="pragma" content="no-cache">
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="15;url=success.php" />

        <title>Building a Speech enabled text field</title>

        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../particles/style.css">
        <link rel="stylesheet" href="../matrix/style.css">
        <link rel="stylesheet" href="../index.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body style="background: black" onload="startDictation()">
        
        <div class="text">
            <div style="display: none">
                <iframe  src="sounds/success.mp3" allow="autoplay" ></iframe>
           

            <form id="labnol" method="POST" action="">
                <div class="speech">
                    <input type="text" name="answer" id="transcript" placeholder="Speak"  />
                    <img  src="//i.imgur.com/cHidSVu.gif" />
                </div>
            </form>
        </div>
        </div>

       

        <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="../matrix/script.js"></script>
        <script src="../index.js"></script>
        <script  src="../js/index.js"></script>
    </body>

</html>