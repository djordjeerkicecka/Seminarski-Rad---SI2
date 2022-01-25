<?php
    session_start();
    
    if(!isset($_POST["submitLogin"])){
        $msg = "Submit not clicked. Access Denied";
        header("Location:../index.php?error=$msg");
    }

    // Utility Class
    require_once "../Utility/utilityFunctions.php";

    // Get Login Info From The Form
    $loginUsername = $_POST["loginUsername"];
    $loginPassword = $_POST["loginPassword"];

    // Include classes
    require "../DatabaseLayer/ConnectionClass.php";
    require "../DataLayer/BaseClass.php";
    require "../DataLayer/UserClass.php";

    // Connect to database
    $ConnectionObject = new Connection("../DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    // Check Connection
    if($ConnectionObject->ConnectionToDB){
        $CurrentUser = new User($ConnectionObject, "korisnik");

        // Authenticate user in the database
        if($CurrentUser->AuthenticateUser($loginUsername, $loginPassword)){
            //PrintValueFormated($CurrentUser->itemsArray);
            //PrintValueFormated($CurrentUser->itemsNumberOfColumns);
            
            // Load data into the session
            $_SESSION["UserID"] = $CurrentUser->GetNthColumn(0);
            $_SESSION["UserName"] = $CurrentUser->GetNthColumn(3);
            $_SESSION["UserSurname"] = $CurrentUser->GetNthColumn(4);
            $_SESSION["UserStatus"] = $CurrentUser->GetNthColumn(5);           
            
            $ConnectionObject->Disconnect();
            if($_SESSION["UserStatus"] == "prof"){
                header("Location:../candidate-list-page.php");
            }else {
                header("Location:../exam-list-page.php");
            }
        }else {
            $ConnectionObject->Disconnect();
            $msg = "Login information incorrect, try again.";
            header("Location:../index.php?error=$msg");
        }
    }
    
?>