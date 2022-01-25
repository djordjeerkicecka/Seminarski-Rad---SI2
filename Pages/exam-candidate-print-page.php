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

    include "../Utility/printPageFunctions.php";

    require "../DataLayer/BaseClass.php";
    require "../DataLayer/CandidateClass.php";
    require "../DataLayer/ExamClass.php";

    $ExamID = $_POST["examID"];

    $CandidateList = new Candidate($ConnectionObject, "kandidat");
    $CandidateList->GetCandidatesForExam($ExamID);

    $ExamObject = new Exam($ConnectionObject, "ispit");
    $ExamObject->GetExamByID($ExamID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Exam Candidates</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/style-print.css">

</head>
<body>
    <h1 class="text-center my-5">List Of Candidates For : <?php echo $ExamObject->itemsArray[0][2]; ?></h1>

    <table>
    <?php 
        PrintExamCandidatesHeading();
        $CandidateCount = 0;

        foreach($CandidateList->itemsArray as $Index => $Row){
            echo "<tr>";
            $CandidateCount++;
            PrintCellValue($CandidateCount);

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
            echo "</tr>";
        }

        $ConnectionObject->Disconnect();
    ?>
    </table>
</body>
</html>