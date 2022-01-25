<?php 

function PrintCellValue($Value){
    echo "<td>";
    echo $Value;
    echo "</td>";
}

function PrintCandidateHeading(){
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>JMBG</th>";
    echo "<th>Name</th>";
    echo "<th>Surname</th>";
    echo "<th>Birthday</th>";
    echo "<th>Address</th>";
    echo "<th>Points</th>";
    echo "<th>Subject</th>";
    echo "<th>Passed</th>";
    echo "</tr>";
}

function PrintExamHeading(){
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Exam Key</th>";
    echo "<th>Subject</th>";
    echo "<th>Term</th>";
    echo "<th>Date</th>";
    echo "<th>Time</th>";
    echo "<th>Capacity</th>";
    echo "</tr>";
}

function PrintExamCandidatesHeading(){
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>JMBG</th>";
    echo "<th>Name</th>";
    echo "<th>Surname</th>";
    echo "<th>Subject</th>";
    echo "<th>Term</th>";
    echo "<th>Points</th>";
    echo "<th>Passed</th>";
    echo "</tr>";
}

?>