<aside class="aside-user col-2 bg-dark">
    <ul class="navbar-nav">

        <?php if($UserStatus == "admin" || $UserStatus == "user"){ ?>
            <li class="nav-item"><a href="../exam-add-page.php" class="nav-link">Add Exam</a></li>
            <li class="nav-item"><a href="../exam-list-page.php" class="nav-link">Exam List</a></li>
            <li class="nav-item"><a href="../Pages/exam-print-page.php" class="nav-link">Print Exams</a></li>
            <hr class="nav-line">
            
            <li class="nav-item"><a href="../candidate-add-page.php" class="nav-link">Add Candidate</a></li>
        <?php }?>
        <li class="nav-item"><a href="../candidate-list-page.php" class="nav-link">Candidate List</a></li>
        <li class="nav-item"><a href="../Pages/candidate-print-page.php" class="nav-link">Print Candidates</a></li>
        <hr class="nav-line">

        <li class="nav-item"><a href="../exam-candidate-list-page.php" class="nav-link">Exam Candidates</a></li>
    </ul>
</aside>