<?php 
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user" && $UserStatus != "prof" && $UserStatus != "guest"){
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

    include "../Utility/printPageFunctions.php";

    $CandidateList = new Candidate($ConnectionObject, "kandidat");
    $CandidateList->GetAllCandidates();

    $ExamObject = new Exam($ConnectionObject, "ispit");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Candidate Print Page</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/style-print.css">

</head>
<body>
    <h1 class="text-center my-5">List Of Candidates</h1>

    <table>
        <?php 
            PrintCandidateHeading();
            $CandidateCount = 0;
            $ExamCount = 0;

            foreach($CandidateList->itemsArray as $Index => $Row){
                echo "<tr>";
                $CandidateCount++;
                PrintCellValue($CandidateCount);

                foreach($Row as $Column => $Value){
                    if($Column != 0 && $Column != 7 && $Column != 8){
                        PrintCellValue($Value);
                    }else if($Column == 0){
                        continue;
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
                echo "</tr>";
            }
        ?>
    </table>

    <!-- Bootstrap JS -->
    <script src="Bootstrap/JS/jquery.js"></script>
    <script src="Bootstrap/JS/bootstrap.min.js"></script>
</body>
</html>