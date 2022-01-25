<?php
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user"){
        $msg = "You can't access that page";
        header("Location:index.php?error=$msg");
    }

    $SiteTitle = "Exam Add Page";

    require "DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection Error";
        exit();
    }

    require "DataLayer/BaseClass.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Exam Add Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Styles/style.css">

</head>
<body>
    <!-- User Aside -->
    <?php include "Includes/aside-outer.php"; ?>
    <!-- Navigation -->
    <?php include "Includes/navigation-outer.php"; ?>


    <section class="section-table col-10 offset-2">
        <h1 class="section-title">Add A New Exam</h1>
        <form action="LogicLayer/exam-add.php" method="POST">

            <div class="form-row">
                <label class="form-label" for="examKey">Exam Key:</label>
                <input class="form-text" type="text" name="examKey" id="examKey" required pattern="[0-9a-zA-Z]{6}">
            </div>
            <div class="form-row">
                <label class="form-label" for="examSubject">Subject:</label>
                <input class="form-text" type="text" name="examSubject" id="examSubject" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="examTerm">Term:</label>
                <input class="form-text" type="text" name="examTerm" id="examTerm" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="examDate">Date:</label>
                <input class="form-text" type="date" name="examDate" id="examDate" required>
            </div>
            <div class="form-row">
                <label class="form-label" for="examTime">Time:</label>
                <input class="form-text" type="time" name="examTime" id="examTime" required min="9:00" max="17:00">
            </div>
            <div class="form-row">
                <label class="form-label" for="examCapacity">Capacity:</label>
                <input class="form-text" type="number" name="examCapacity" id="examCapacity" max="100" required pattern="[0-9]">
            </div>

            <div class="form-row">
                <input class="btn btn-primary" name="staffSubmit" type="submit" value="Submit">
            </div>
        </form>
    </section>

    <!-- Bootstrap JS -->
    <script src="Bootstrap/JS/jquery.js"></script>
    <script src="Bootstrap/JS/bootstrap.min.js"></script>
</body>
</html>