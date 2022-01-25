<?php 
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user"){
        $msg = "You can't access that page";
        header("Location:../exam-list-page.php?error=$msg");
    }

    if(isset($_GET["error"])){
        include_once "../Utility/utilityFunctions.php";
        PrintErrorMessage($_GET["error"]); 
    }

    $SiteTitle = "Exam Edit Page";

    $TargetID = $_POST["examID"];
?>

<html lang="en">
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
        <h1 class="section-title">Exam Edit Page</h1>

        <form action="../LogicLayer/exam-edit.php" method="post">

            <input type="hidden" name="examID" value="<?php echo $TargetID; ?>">

            <div class="form-row">
                <label class="form-label" for="examKey">Exam Key:</label>
                <input class="form-text" type="text" name="examKey" id="examKey">
            </div>
            <div class="form-row">
                <label class="form-label" for="examSubject">Exam Subject:</label>
                <input class="form-text" type="text" name="examSubject" id="examSubject">
            </div>
            <div class="form-row">
                <label class="form-label" for="examTerm">Exam Term:</label>
                <input class="form-text" type="text" name="examTerm" id="examTerm">
            </div>
            <div class="form-row">
                <label class="form-label" for="examDate">Exam Date:</label>
                <input class="form-text" type="date" name="examDate" id="examDate">
            </div>
            <div class="form-row">
                <label class="form-label" for="examTime">Exam Time:</label>
                <input class="form-text" type="time" name="examTime" id="examTime" min="9:00" max="17:00">
            </div>
            <div class="form-row">
                <label class="form-label" for="examCapacity">Exam Capacity: </label>
                <input class="form-text" type="text" name="examCapacity" id="examCapacity">
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