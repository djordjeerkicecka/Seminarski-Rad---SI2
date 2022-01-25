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
    require "../DataLayer/ExamClass.php";

    $ExamObject = new Exam($ConnectionObject, "ispit");

    $ExamKey = $_POST["examKey"];
    $ExamSubject = $_POST["examSubject"];
    $ExamTerm = $_POST["examTerm"];
    $ExamDate = $_POST["examDate"];
    $ExamTime = $_POST["examTime"];
    $ExamCapacity = $_POST["examCapacity"];

    if($ExamObject->IsKeyUnique($ExamKey)){
        $ExamObject->AddNewExam($ExamKey, $ExamSubject, $ExamTerm, $ExamDate, $ExamTime, $ExamCapacity);
        $ConnectionObject->Disconnect();
        header("Location:../exam-list-page.php");
    }else {
        $ConnectionObject->Disconnect();
        $msg = "That key already exists";
        header("Location:../Pages/exam-add-page.php?error=$msg");
    }
?>