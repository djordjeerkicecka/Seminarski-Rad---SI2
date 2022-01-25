<?php
class Exam extends BaseClass{
    // Constructor Inherited
    // Public Methods

    // Add new exam
    public function AddNewExam($NewKey, $NewSubject, $NewTerm, $NewDate, $NewTime, $NewCapacity)
    {
        $AddExamSQL = "INSERT INTO `" . $this->dbName . "`.`" . $this->tableName . "` (IspitSifra, IspitPredmet, IspitRok, IspitDatum, IspitVreme, IspitKapacitet) VALUES ('$NewKey', '$NewSubject', '$NewTerm', '$NewDate', '$NewTime', '$NewCapacity')";

        $this->ExecuteUpdateQuery($AddExamSQL);
    }

    // Edit exam
    public function UpdateExam($TargetID, $NewKey, $NewSubject, $NewTerm, $NewDate, $NewTime, $NewCapacity){
        $UpdateExamSQL = "UPDATE `" . $this->dbName . "`.`" . $this->tableName . "` . SET IspitSifra='$NewKey', IspitPredmet='$NewSubject', IspitRok='$NewTerm', IspitDatum='$NewDate', IspitVreme='$NewTime', IspitKapacitet='$NewCapacity' WHERE IspitID=" . $TargetID;

        $this->ExecuteUpdateQuery($UpdateExamSQL);
    }

    // Delete exam
    public function DeleteExam($TargetID)
    {
        $DeleteExamSQL = "DELETE FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE IspitID=" . $TargetID;

        $this->ExecuteDeleteQuery($DeleteExamSQL);
    }

    // Is Key Unique 
    public function IsKeyUnique($InputKey){
        $IsKeyUniqueSQL = "SELECT * FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE IspitSifra='" . $InputKey . "'";

        $this->ExecuteSelectQuery($IsKeyUniqueSQL);

        if($this->itemsCount == 0){
            return true;
        }else {
            return false;
        }
    }
    
    // Get All Exams
    public function GetAllExams()
    {
        $this->GetAll("IspitID");
    }

    // Get Exam by ID
    public function GetExamByID($TargetID)
    {
        $this->GetAllFiltered("IspitID", $TargetID);
    }

    // Get Exam Subject By ID 
    public function GetExamSubjectByID($TargetID){
        $GetExamSubjectByIDSQL = "SELECT IspitPredmet FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE IspitID='" . $TargetID . "'";

        $this->ExecuteSelectQuery($GetExamSubjectByIDSQL);
    }

    // Get Exam by Date
    public function GetExamByDate($TargetDate){
        $this->GetAllFiltered("IspitDatum", $TargetDate);
    }

    // Get Exam by Time
    public function GetExamByTime($TargetTime){
        $this->GetAllFiltered("IspitVreme", $TargetTime);
    }

    // Check if subject is already in picked term
    public function IsExamSubjectInTerm($ExamSubject, $ExamTerm){
        $IsExamSubjectInTermSQL = "SELECT * FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE IspitPredmet='" . $ExamSubject . "' AND IspitRok='" . $ExamTerm . "'";

        $this->ExecuteSelectQuery($IsExamSubjectInTermSQL);

        if($this->itemsCount == 0){
            return false;
        }else {
            return true;
        }
    }

    // Edit Column 
    public function EditColumn($Column, $Value, $TargetID){
        $EditColumnSQL = "UPDATE `" . $this->dbName . "`.`" . $this->tableName . "` SET $Column='" . $Value . "' WHERE IspitID='" . $TargetID . "'";
        
        $this->ExecuteUpdateQuery($EditColumnSQL);
    }

}
?>