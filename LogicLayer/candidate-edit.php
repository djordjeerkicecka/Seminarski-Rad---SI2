<?php
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user" && $UserStatus != "prof"){
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
    $PointsRequirement = $RequirementSource->points;

    $CandidateObject = new Candidate($ConnectionObject, "kandidat");
    $ExamObject = new Exam($ConnectionObject, "ispit");

    $CandidateID = $_POST["candidateID"];
    $CandidateJMBG = $_POST["candidateJMBG"];
    $CandidateName = $_POST["candidateName"];
    $CandidateSurname = $_POST["candidateSurname"];
    $CandidateBirthday = $_POST["candidateBirthday"];
    $CandidateAddress = $_POST["candidateAddress"];
    $CandidatePoints = $_POST["candidatePoints"];

    $CandidateObject->GetCandidateByID($CandidateID);
    $CandidateOldJMBG = $CandidateObject->itemsArray[0][1];
    $CandidateOldExamID = $CandidateObject->itemsArray[0][7];
    $ExamObject->GetExamByID($CandidateOldExamID);

    $CandidateOldExamTerm = $ExamObject->itemsArray[0][3];

    // Validate JMBG and Exam Terms
    // Check if new JMBG Exists for old Term
    if($CandidateJMBG != "" && !isset($_POST["candidateExam"])){
        if($CandidateObject->IsJMBGUniqueInTerm($CandidateJMBG, $CandidateOldExamTerm)){
            $CandidateObject->EditColumn("KandidatJMBG", $CandidateJMBG, $CandidateID);
        }else {
            $ConnectionObject->Disconnect();
            $msg = "That JMBG already exists for that term";
            header("Location:../Pages/candidate-edit-page.php?error=$msg");
        }
    }

    //Check if old JMBG exists for new Term
    if($CandidateJMBG == "" && isset($_POST["candidateExam"])){
        $CandidateExam = $_POST["candidateExam"];
        $ExamObject->GetExamByID($CandidateExam);

        $CandidateNewTerm = $ExamObject->itemsArray[0][3];

        if($CandidateObject->IsJMBGUniqueInTerm($CandidateOldJMBG, $CandidateNewTerm)){
            $CandidateObject->EditColumn("PrijemniID", $CandidateExam, $CandidateID);
        }else {
            $ConnectionObject->Disconnect();
            $msg = "There is already a JMBG for that Term";
            header("Location:../Pages/candidate-edit-page.php?error=$msg");
        }
    }

    // Check if new JMBG exists for new Term
    if($CandidateJMBG != "" && isset($_POST["candidateExam"])){
        $CandidateExam = $_POST["candidateExam"];

        if($CandidateObject->IsJMBGUniqueInTerm($CandidateJMBG, $CandidateExam)){
            $CandidateObject->EditColumn("KandidatJMBG", $CandidateJMBG, $CandidateID);
            $CandidateObject->EditColumn("PrijemniID", $CandidateExam, $CandidateID);
        }else {
            $ConnectionObject->Disconnect();
            $msg = "This combination of JMBG and Term already exist";
            header("Location:../Pages/candidate-edit-page.php?error=$msg");
        }
    }

    if($CandidateName != ""){
        if(!ctype_alpha($CandidateName)){
            $ConnectionObject->Disconnect();
            $msg = "Names can only contain letters";
            header("Location:../Pages/candidate-edit-page.php?error=$msg");
        }else {
            $CandidateObject->EditColumn("KandidatIme", $CandidateName, $CandidateID);
        }
    }
    if($CandidateSurname != ""){   
        if(!ctype_alpha($CandidateSurname)){
            $ConnectionObject->Disconnect();
            $msg = "Surnames can only contain letters";
            header("Location:../Pages/candidate-edit-page.php?error=$msg");
        } else {
            $CandidateObject->EditColumn("KandidatPrezime", $CandidateSurname, $CandidateID);
        }
    }
    if($CandidateBirthday != ""){
        $CandidateObject->EditColumn("DatumRođenja", $CandidateBirthday, $CandidateID);
    }
    if($CandidateAddress != ""){
        $CandidateObject->EditColumn("KandidatAdresa", $CandidateAddress, $CandidateID);
    }
    if($CandidatePoints != "" && ($CandidatePoints >= 0 && $CandidatePoints <= 100)){
        $CandidateObject->EditColumn("KandidatBodovi", $CandidatePoints, $CandidateID);

        if($CandidatePoints >= $PointsRequirement){
            $CandidatePassed = true;
            $CandidateObject->EditColumn("KandidatPolozio", $CandidatePassed, $CandidateID);
        }else {
            $CandidatePassed = false;
            $CandidateObject->EditColumn("KandidatPolozio", $CandidatePassed, $CandidateID);
        }
    }

    $ConnectionObject->Disconnect();
    header("Location:../candidate-list-page.php");
?>