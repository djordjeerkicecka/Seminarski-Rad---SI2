<?php
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user"){
        $msg = "You can't access that page";
        header("Location:index.php?error=$msg");
    }

    $SiteTitle = "Candidate Add Page";

    require "DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection Error";
        exit();
    }

    require "DataLayer/BaseClass.php";
    require "DataLayer/ExamClass.php";

    $ExamList = new Exam($ConnectionObject, "ispit");
    $ExamList->GetAllExams();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Candidate Add Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Styles/style.css">

</head>
<body>
    <!-- Aside -->
    <?php include "Includes/aside-outer.php"; ?>
    <!-- Navigation -->
    <?php include "Includes/navigation-outer.php"; ?>


    <section class="offset-2 col-10">
        <h1 class="section-title">Add A New Candidate</h1>
        
        <form action="LogicLayer/candidate-add.php" method="post">
            <div class="form-row">
                <label class="form-label" for="candidateJMBG">JMBG:</label>
                <input class="form-text" type="text" name="candidateJMBG" id="candidateJMBG" maxlength="13" required pattern="[0-9]{13}">
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateName">Name:</label>
                <input class="form-text" type="text" name="candidateName" id="candidateName" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateSurname">Surname:</label>
                <input class="form-text" type="text" name="candidateSurname" id="candidateSurname" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateBirthday">Birthday:</label>
                <input class="form-text" type="date" name="candidateBirthday" id="candidateBirthday" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateAddress">Address:</label>
                <input class="form-text" type="text" name="candidateAddress" id="candidateAddress" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="candidatePoints">Points:</label>
                <input class="form-text" type="number" name="candidatePoints" id="candidatePoints" min="0" max="100">
            </div>
            <div class="form-row">
                <label class="form-label" for="candidateExam">Subject:</label>
                <select class="form-text" name="candidateExam" id="candidateExam" required>
                    <option value="" disabled hidden selected>Choose Here</option>
                    <?php 
                        foreach ($ExamList->itemsArray as $Index => $Row) {
                    ?>
                        <option value="<?php echo $Row[0]; ?>"><?php echo $Row[2]; ?></option>
                    <?php    
                        }
                    ?>
                </select>
            </div>

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