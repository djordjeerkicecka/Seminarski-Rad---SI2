<?php 
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if(isset($_GET["error"])){
        include_once "../Utility/utilityFunctions.php";
        PrintErrorMessage($_GET["error"]);
    }


    if($UserStatus != "admin" && $UserStatus  != "user" && $UserStatus != "prof"){
        $msg = "You can't access that page";
        header("Location:../index.php?error=$msg");
    }

    $SiteTitle = "Candidate Edit Page";

    $TargetID = $_POST["candidateID"];

    require "../DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("../DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection error";
        exit();
    }

    require "../DataLayer/BaseClass.php";
    require "../DataLayer/ExamClass.php";

    $ExamList = new Exam($ConnectionObject, "ispit");
    $ExamList->GetAllExams();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Exam Edit Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/style.css">
</head>
<body>
    <!-- Aside -->
    <?php include "../Includes/aside-inner.php"; ?>
    <!-- Navigation -->
    <?php include "../Includes/navigation-inner.php"; ?>


    <section class="offset-2 col-10">
        <h1 class="section-title">Edit Candidate Information</h1>

        <form action="../LogicLayer/candidate-edit.php" method="POST">
            <input type="hidden" name="candidateID" value="<?php echo $TargetID?>">

            <?php if($UserStatus == "admin" || $UserStatus == "user"){ ?>
            <div class="form-row">
                <label class="form-label" for="candidateJMBG">JMBG :</label>
                <input class="form-text" type="text" name="candidateJMBG" id="candidateJMBG" maxlength="13" pattern="[0-9]{13}">
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateName">Name :</label>
                <input class="form-text" type="text" name="candidateName" id="candidateName">
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateSurname">Surname :</label>
                <input class="form-text" type="text" name="candidateSurname" id="candidateSurname">
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateBirthday">Birthday :</label>
                <input class="form-text" type="date" name="candidateBirthday" id="candidateBirthday">
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateAddress">Address</label>
                <input class="form-text" type="text" name="candidateAddress" id="candidateAddress">
            </div>
            <?php }?>

            <div class="form-row">
                <label class="form-label" for="candidatePoints">Points :</label>
                <input class="form-text" type="number" name="candidatePoints" id="candidatePoints" min="0" max="100">
            </div>

            <?php if($UserStatus == "admin" || $UserStatus == "user"){ ?>
            <div class="form-row">
                <label class="form-label" for="candidateExam">Subject :</label>
                <select class="form-text" name="candidateExam" id="candidateExam">
                    <option value="" disabled hidden selected>Choose Here</option>
                    <?php
                        foreach($ExamList->itemsArray as $Index => $Row){
                            ?>
                            <option value="<?php echo $Row[0]; ?>"> <?php echo $Row[2]; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <?php }?>

            <div class="form-row">
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>


        </form>
    </section>

    <!-- Bootstrap JS -->
    <script src="Bootstrap/JS/jquery.js"></script>
    <script src="Bootstrap/JS/bootstrap.min.js"></script>    
</body>
</html>