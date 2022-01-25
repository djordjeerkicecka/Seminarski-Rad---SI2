<?php

function PrintExamTableHeading(){
    echo "<tr>";
    echo "<th>Exam Key</th>";
    echo "<th>Subject</th>";
    echo "<th>Term</th>";
    echo "<th>Date</th>";
    echo "<th>Time</th>";
    echo "<th>Capacity</th>";
    echo "<th class=\"td-adminControls\">Controls</th>";
    echo "</tr>";
}
function PrintCandidateTableHeadingAdmin(){
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>JMBG</th>";
    echo "<th>Name</th>";
    echo "<th>Surname</th>";
    echo "<th>Birthday</th>";
    echo "<th>Address</th>";
    echo "<th>Points</th>";
    echo "<th>Exam</th>";
    echo "<th>Passed</th>";
    echo "<th class=\"td-adminControls\">Controls</th>";
    echo "</tr>";
}
function PrintCandidateTableHeadingProfessor(){
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>JMBG</th>";
    echo "<th>Name</th>";
    echo "<th>Surname</th>";
    echo "<th>Birthday</th>";
    echo "<th>Address</th>";
    echo "<th>Points</th>";
    echo "<th>Exam</th>";
    echo "</tr>";
}

function PrintCandidateTableHeadingGuest() {
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Name</th>";
    echo "<th>Surname</th>";
    echo "<th>Birthday</th>";
    echo "<th>Points</th>";
    echo "<th>Exam</th>";
    echo "<th>Passed</th>";
    echo "</tr>";
}

function PrintExamCandidateTableHeading(){
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

function PrintCellValue($Value){
    echo "<td>";
    echo $Value;
    echo "</td>";
}

function PrintErrorMessage($Message){
    echo "<h3 class=\"access-message access-denied\">" . $Message . "</h3>";
}

