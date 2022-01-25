<?php 
    session_start();

    $UserStatus = $_SESSION["UserStatus"];

    if($UserStatus != "admin" && $UserStatus != "user"){
        $msg = "You can't access that page";
        header("Location:index.php?error=$msg");
    }

    include "Utility/utilityFunctions.php";

    if(isset($_GET["error"])){
        PrintErrorMessage($_GET["error"]);
    }

    $SiteTitle = "Exam List Page";

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
    
    <title>Exam List Page</title>

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

    <section class="section-table offset-2 col-10">
        <h1 class="section-title">Exam List</h1>
        
        <?php if($ExamList->itemsCount == 0) {?>

            <h1 class="text-center">Sorry, no data to display</h1>

        <?php } else { ?>

            <table class="table-clients">
                <?php
                    PrintExamTableHeading();
                    $ExamCount = 1;

                    foreach($ExamList->itemsArray as $Index => $Row){
                        echo "<tr>";
                        foreach($Row as $Column => $Value){
                            if($Column == 0){
                                continue; // Skip ID column
                            }
                            PrintCellValue($Value);
                        }
                ?>
                    <!-- Table Cell Start -->
                    <td class="td-adminControls">
                        <form action="Pages/exam-edit-page.php" method="post">
                            <input type="hidden" name="examID" value="<?php echo $Row[0]; ?>">
                            <input class="btn btn-primary" type="submit" value="Edit">
                        </form>
                        <form action="LogicLayer/exam-delete.php" method="post">
                            <input type="hidden" name="examID" value="<?php echo $Row[0]; ?>">
                            <input class="btn btn-danger" type="submit" value="Delete">
                        </form>
                    </td>
                    <!-- Table Cell End -->
                <?php
                        $ExamCount++;
                        echo "</tr>";
                    }
                ?>
            </table>
            
        <?php }?>
    </section>

    <!-- Bootstrap JS -->
    <script src="Bootstrap/JS/jquery.js"></script>
    <script src="Bootstrap/JS/bootstrap.min.js"></script>    
</body>
</html>