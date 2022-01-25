<?php 
    session_start();

    if(isset($_POST["submitGuest"])){
        $_SESSION["UserStatus"] = "guest";
        header("Location:../candidate-list-page.php");
    }else {
        $msg = "Submit not clicked. Access Denied";
        header("Location:../index.php?error=$msg");
    }
?>