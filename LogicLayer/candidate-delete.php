<?php 
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user"){
        $msg = "You can't access that page";
        header("Location:../index.php?error=$msg");
    }

    require "../DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("../DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection Error";
        exit();
    }

    require "../DataLayer/BaseClass.php";
    require "../DataLayer/CandidateClass.php";

    $TargetID = $_POST["candidateID"];

    $CandidateObject = new Candidate($ConnectionObject, "kandidat");
    $CandidateObject->DeleteCandidate($TargetID);

    $ConnectionObject->Disconnect();
    header("Location:../candidate-list-page.php");
?>