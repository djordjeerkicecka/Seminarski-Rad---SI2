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
    require "../DataLayer/ExamClass.php";

    $RequirementSource = simplexml_load_file("BusinessRequirement.xml");
    $PointRequirement = $RequirementSource->points;

    $CandidateObject = new Candidate($ConnectionObject, "kandidat");

    $CandidateJMBG = $_POST["candidateJMBG"];
    $CandidateName = $_POST["candidateName"];
    $CandidateSurname = $_POST["candidateSurname"];
    $CandidateBirthday = $_POST["candidateBirthday"];
    $CandidateAddress = $_POST["candidateAddress"];
    $CandidatePoints = $_POST["candidatePoints"];
    $CandidateSubject = $_POST["candidateExam"];


    // Validation. 
    // Don't allow input if new candidate jmbg already exists for the term of that exam
    if(!$CandidateObject->IsJMBGUniqueInTerm($CandidateJMBG, $CandidateSubject)){
        $ConnectionObject->Disconnect();
        $msg = "That candidate already exists for that term!";
        header("Location:../Pages/candidate-add-page.php?error=$msg"); 
    }

    if(!ctype_alpha($CandidateName)){
        $ConnectionObject->Disconnect();
        $msg = "Names can only contain letters";
        header("Location:../Pages/candidate-add-page.php?error=$msg");
    }

    if(!ctype_alpha($CandidateSurname)){
        $ConnectionObject->Disconnect();
        $msg = "Surnames can only contain letters";
        header("Location:../Pages/candidate-add-page.php?error=$msg");
    }

    if($CandidatePoints == ""){
        $CandidatePoints = 0;
    }

    if($CandidatePoints >= $PointRequirement){
        $CandidatePassed = true;
    }else {
        $CandidatePassed = false;
    }

    $CandidateObject->AddNewCandidate($CandidateJMBG, $CandidateName, $CandidateSurname, $CandidateBirthday, $CandidateAddress, $CandidatePoints, $CandidateSubject, $CandidatePassed);

    $ConnectionObject->Disconnect();

    header("Location:../candidate-list-page.php");
?>