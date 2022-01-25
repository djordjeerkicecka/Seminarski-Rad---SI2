<?php
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user"){
        $msg = "You can't access that page";
        header("Location:../index.php");
    }

    require "../DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("../DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();


    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection error";
        exit();
    }

    require "../DataLayer/BaseClass.php";
    require "../DataLayer/ExamClass.php";

    $ExamObjectNew = new Exam($ConnectionObject, "ispit");
    $ExamObjectOld = new Exam($ConnectionObject, "ispit");

    $ExamID = $_POST["examID"];
    $ExamKey = $_POST["examKey"];
    $ExamSubject = $_POST["examSubject"];
    $ExamTerm = $_POST["examTerm"];
    $ExamDate = $_POST["examDate"];
    $ExamTime = $_POST["examTime"];
    $ExamCapacity = $_POST["examCapacity"];

    $ExamObjectOld->GetExamByID($ExamID);
    $ExamSubjectOld = $ExamObjectData->itemsArray[0][2];
    $ExamTermOld = $ExamObjectOld->itemsArray[0][3];

    if($ExamKey != ""){
        if($ExamObjectNew->IsKeyUnique($ExamKey)){
            $ExamObjectNew->EditColumn("IspitSifra", $ExamKey, $ExamID);
        }else {
            $ConnectionObject->Disconnect();
            $msg = "That key already exists";
            header("Location:../exam-list-page.php?error=$msg");
        }
    }

    if($ExamSubject != "" && $ExamTerm != ""){
        if($ExamObjectNew->IsExamSubjectInTerm($ExamSubject, $ExamTerm)){
            $ConnectionObject->Disconnect();
            $msg = "That subject already exists for that term";
            header("Location:../exam-list-page.php");
        }else {
            $ExamObjectNew->EditColumn("IspitPredmet", $ExamSubject, $ExamID);
            $ExamObjectNew->EditColumn("IspitRok", $ExamTerm, $ExamID);
        }
    }

    if($ExamSubject != "" && $ExamTerm == ""){
        if($ExamObjectNew->IsExamSubjectInTerm($ExamSubject, $ExamTermOld)){    
            $ConnectionObject->Disconnect();
            $msg = "That subject already exists for that term";
            header("Location:../exam-list-page.php?error=$msg");
        }else {
            $ExamObjectNew->EditColumn("IspitPredmet", $ExamSubject, $ExamID);
        }
    }

    if($ExamSubject == "" && $ExamTerm != ""){
        if($ExamObjectNew->IsExamSubjectInTerm($ExamSubjectOld, $ExamTerm)){
            $ConnectionObject->Disconnect();
            $msg = "That subject already exists for that term";
            header("Location:../exam-list-page.php?error=$msg");
        }else {
            $ExamObjectNew->EditColumn("IspitRok", $ExamTerm, $ExamID);
        }
    }

    if($ExamDate != ""){
        $ExamObjectNew->EditColumn("IspitDatum", $ExamDate, $ExamID);
    }

    if($ExamTime != ""){
        $ExamObjectNew->EditColumn("IspitVreme", $ExamTime, $ExamID);
    }

    if($ExamCapacity != ""){
        if($ExamCapacity > 0){
            $ExamObjectNew->EditColumn("IspitKapacitet", $ExamCapacity, $ExamID);
        }else {
            $ConnectionObject->Disconnect();
            $msg = "Capacity must be greater than 0";
            header("Location:../exam-list-page.php?error=$msg");
        }
    }

    $ConnectionObject->Disconnect();
    header("Location:../exam-list-page.php");
?>