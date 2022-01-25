<?php
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user" && $UserStatus != "prof" && $UserStatus != "guest"){
        $msg = "You can't access that page";
        header("Location:index.php?error=$msg");
    }

    include "Utility/utilityFunctions.php";

    if(isset($_GET["error"])){
        PrintErrorMessage($_GET["error"]);
    }

    $SiteTitle = "Candidate List Page";

    require "DatabaseLayer/ConnectionClass.php";

    $ConnectionObject = new Connection("DatabaseLayer/ConnectionParameters.xml");
    $ConnectionObject->Connect();

    if(!$ConnectionObject->ConnectionToDB){
        echo "Connection Error";
        exit();
    } 

    require "DataLayer/BaseClass.php";
    require "DataLayer/CandidateClass.php";
    require "DataLayer/ExamClass.php";

    $CandidateList = new Candidate($ConnectionObject, "kandidat");


    if(isset($_POST["filterSubmit"]) && isset($_POST["filterJMBG"]) ){
        if($_POST["filterJMBG"] != ""){
            $CandidateList->GetCandidateByJMBG($_POST["filterJMBG"]);
        }else {
            $CandidateList->GetAllCandidates();
        }
    }else {
        $CandidateList->GetAllCandidates();
    }

    $ExamObject = new Exam($ConnectionObject, "ispit");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Candidate List Page</title>

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


    <section class="offset-2 col-10 section-body">
        <h1 class="section-title">Candidate List</h1>

        <form action="candidate-list-page.php" method="POST">
            <div class="form-row">
                <label class="h3" for="filterJMBG">Filter By JMBG</label>
                <input class="mx-2" type="text" name="filterJMBG" id="filterByJMBG" pattern="[0-9]{13}" maxlength="13">
                <input class="btn btn-primary" type="submit" name="filterSubmit" value="Filter">
            </div>
        </form>

        <?php if($CandidateList->itemsCount == 0) {?> <!-- IF BEGINS -->
            <h1 class="text-center">Sorry, no data to display</h1>
        <?php } else { ?> <!-- IF ENDS ELSE BEGINS -->
            <table class="table-clients">
                <?php
                    if ($UserStatus == "admin" || $UserStatus == "user" || $UserStatus == "prof") {
                        PrintCandidateTableHeadingAdmin();
                    } else if ($UserStatus == "guest") {
                        PrintCandidateTableHeadingGuest();
                    }
                    
                    $CandidateCount = 1;

                    foreach ($CandidateList->itemsArray as $Index => $Row) {
                        echo "<tr>";
                        PrintCellValue($CandidateCount);
                        $CandidateCount++;
                        
                        foreach ($Row as $Column => $Value) {
                            if($Column != 0 && $Column != 7 && $Column != 8){
                                if(($Column == 1 || $Column == 5) && $UserStatus == "guest"){
                                    continue; // Skip to protect data from guest
                                }else {
                                    PrintCellValue($Value);
                                }
                            }else if ($Column == 0){
                                continue; // skip ID column
                            }else if($Column == 7){
                                $ExamObject->GetExamSubjectByID($Value);
                                $Subject = $ExamObject->itemsArray[0][0];
                                PrintCellValue($Subject);
                            }else if($Column == 8){
                                if($Value == 1){
                                    PrintCellValue("Passed");
                                }else {
                                    PrintCellValue("Failed");
                                }
                            }
                        }

                        if ($UserStatus == "admin" || $UserStatus == "user" || $UserStatus == "prof") {
                            ?>
                            <td class="td-adminControls">
                                <form action="Pages/candidate-edit-page.php" method="post">
                                    <input type="hidden" name="candidateID" value="<?php echo $Row[0]; ?>">
                                    <input class="btn btn-primary" type="submit" value="Edit">
                                </form>
                <?php   } ?>
                        <?php if ($UserStatus == "admin" || $UserStatus == "user") {?>
                                <form action="LogicLayer/candidate-delete.php" method="post">
                                    <input type="hidden" name="candidateID" value="<?php echo $Row[0]; ?>">
                                    <input class="btn btn-danger" type="submit" value="Delete">
                                </form>
                        <?php   } ?>
                            </td>
                        <?php
                    }
                ?>
            </table>
        <?php } ?> <!-- ELSE ENDS -->
    </section>

    <!-- Bootstrap JS -->
    <script src="Bootstrap/JS/jquery.js"></script>
    <script src="Bootstrap/JS/bootstrap.min.js"></script>
</body>
</html>