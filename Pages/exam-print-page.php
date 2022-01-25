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
    include "../Utility/printPageFunctions.php";

    require "../DataLayer/BaseClass.php";
    require "../DataLayer/ExamClass.php";

    $ExamList = new Exam($ConnectionObject, "ispit");
    $ExamList->GetAllExams();

    $ConnectionObject->Disconnect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Exam List</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../Bootstrap/CSS/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/style-print.css">

</head>
<body>
    <h1 class="text-center my-5">List Of Exams</h1>

    <table>
        <?php
            PrintExamHeading();
            $ExamCount = 0;

            foreach($ExamList->itemsArray as $Index => $Row){
                echo "<tr>";
                $ExamCount++;
                PrintCellValue($ExamCount);

                foreach($Row as $Column => $Value){
                    if($Column == 0){
                        continue; // Skip ID Column
                    }
                    PrintCellValue($Value);
                }
            }
        ?>
    </table>
</body>
</html>


