<?php
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user" && $UserStatus != "prof" && $UserStatus != "guest"){
        $msg = "You can't access that page";
        header("Location:index.php?error=$msg");
    }
    
    $SiteTitle = "Exam Candidates";

    require "DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection Error";
        exit();
    }
    include "Utility/utilityFunctions.php";

    require "DataLayer/BaseClass.php";
    require "DataLayer/ExamClass.php";
    require "DataLayer/CandidateClass.php";

    $ExamList = new Exam($ConnectionObject, "ispit");
    $ExamList->GetAllExams();

    $CandidateList = new Candidate($ConnectionObject, "kandidat");

    if(isset($_POST["examID"])){
        $SelectedExam = $_POST["examID"];

        if(isset($_POST["submitExamCandidates"])){
            $CandidateList->GetCandidatesForExam($SelectedExam);
        }else if(isset($_POST["filterSubmit"])){
            $TargetJMBG = $_POST["filterJMBG"];

            if($TargetJMBG != ""){
                $CandidateList->GetCandidatesForExamByJMBG($SelectedExam, $TargetJMBG);
            }else {
                $CandidateList->GetCandidatesForExam($SelectedExam);
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Exam Candidates</title>

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


    <section class="col-10 offset-2">
        
        <form class="my-3" action="" method="POST">
            <h3 class="text-center">Pick an exam from the list</h3>
            
            <div class="mx-auto col-4 d-flex justify-content-around align-items-baseline">
                <label for="examID">Exam: </label>
                
                <select name="examID" id="examID">
                    <option value="" disabled hidden selected>Choose here</option>
                    <?php foreach($ExamList->itemsArray as $Index => $Row) { ?>
                        <option value="<?php echo $Row[0]; ?>"><?php echo $Row[2]; ?></option>
                    <?php }?>
                </select>
                    
                <input class="btn btn-primary" name="submitExamCandidates" type="submit" value="Confirm">
            </div>
        </form>

        <?php if(isset($_POST["submitExamCandidates"]) || isset($_POST["filterSubmit"])) {?>
            <h2 class="text-center mt-3">Candidates For : <?php echo $ExamList->itemsArray[$SelectedExam-1][2]; ?></h2>

            <form action="" method="POST">
                <div class="form-row">
                    <label class="h3" for="filterJMBG">Filter By JMBG</label>
                    <input type="hidden" name="examID" value="<?php echo $_POST["examID"]; ?>">
                    <input class="mx-2" type="text" name="filterJMBG" id="filterByJMBG" pattern="[0-9]{13}" maxlength="13">
                    <input class="btn btn-primary" type="submit" name="filterSubmit" value="Filter">
                </div>
            </form>

            <form class="d-flex justify-content-center" action="Pages/exam-candidate-print-page.php" method="post">
                <input type="hidden" name="examID" id="examID" value="<?php echo $_POST["examID"]; ?>">
                <input class="btn btn-primary" type="submit" value="Print This List">
            </form>

        <?php } ?>

        <table class="table-clients">
        <?php if($CandidateList->itemsCount === NULL){ ?>
            <h3 class="text-center my-3">Please pick an exam and click confirm</h3>

        <?php } else if($CandidateList->itemsCount == 0) { ?>
            <h3 class="text-center my-3">There is no data for the selected exam</h3>

        <?php } else {
            PrintExamCandidateTableHeading();
            $CandidateCounter = 0;

            foreach($CandidateList->itemsArray as $Index => $Row){
                echo "<tr>";
                $CandidateCounter++;
                PrintCellValue($CandidateCounter);

                foreach($Row as $Column => $Value){
                    if($Column != 6){
                        PrintCellValue($Value);
                    }else {
                        if($Value == 1){
                            PrintCellValue("Passed");
                        }else {
                            PrintCellValue("Failed");
                        }
                    }
                }
            }

        }?>
        </table>

    </section>

    <!-- Bootstrap JS -->
    <script src="Bootstrap/JS/jquery.js"></script>
    <script src="Bootstrap/JS/bootstrap.min.js"></script>    
</body>
</html>