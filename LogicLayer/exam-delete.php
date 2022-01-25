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

    $TargetID = $_POST["examID"];

    require "../DataLayer/BaseClass.php";
    require "../DataLayer/ExamClass.php";
    require "../DataLayer/CandidateClass.php";

    $CandidateObject = new Candidate($ConnectionObject, "kandidat");

    $ExamObject = new Exam($ConnectionObject, "ispit");

    if($CandidateObject->HasExam($TargetID)){
        $ConnectionObject->Disconnect();
        $msg = "You must erase candidates using this exam first";
        header("Location:../exam-list-page.php?error=$msg");
    }else {
        $ExamObject->DeleteExam($TargetID);
        $ConnectionObject->Disconnect();
        header("Location:../exam-list-page.php");
    }

?>