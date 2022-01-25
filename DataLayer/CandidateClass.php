<?php
class Candidate extends BaseClass {
    // Constructor inherited

    // Public Methods

    // Add New Candidate
    public function AddNewCandidate($NewJMBG, $NewName, $NewSurname, $NewBirthday, $NewAddress, $NewPoints, $NewExamID, $NewPassed)
    {
        $AddCandidateSQL = "INSERT INTO `" . $this->dbName . "`.`" . $this->tableName . "` (KandidatJMBG, KandidatIme, KandidatPrezime, DatumRodjenja, KandidatAdresa, KandidatBodovi, PrijemniID, KandidatPolozio) VALUES ('$NewJMBG', '$NewName', '$NewSurname', '$NewBirthday', '$NewAddress', '$NewPoints', '$NewExamID', '$NewPassed')";
   
        $this->ExecuteUpdateQuery($AddCandidateSQL);
    }

    // Update Candidate Points
    public function UpdateCandidatePoints($TargetID, $NewPoints){
        $UpdateCandidatePointsSQL = "UPDATE `" . $this->dbName . "`.`" . $this->tableName . "` SET KandidatBodovi='$NewPoints' WHERE KandidatID=" . $TargetID;

        $this->ExecuteUpdateQuery($UpdateCandidatePointsSQL);
    }

    // Delete Candidate 
    public function DeleteCandidate($TargetID){
        $DeleteCandidateSQL = "DELETE FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE KandidatID=" . $TargetID;

        $this->ExecuteDeleteQuery($DeleteCandidateSQL);
    }

    // Get All Candidates
    public function GetAllCandidates()
    {
        $this->GetAll("KandidatID");
    }

    // Get Candidate by ID 
    public function GetCandidateByID($TargetID){
        $this->GetAllFiltered("KandidatID", $TargetID);
    }

     // Get Candidate by JMBG 
     public function GetCandidateByJMBG($TargetJMBG){
        $this->GetAllFiltered("KandidatJMBG", $TargetJMBG);
    }

    // Edit Candidate Column
    public function EditColumn($Column, $Value, $TargetID)
    {
        $EditColumnSQL = "UPDATE `" . $this->dbName . "`.`" . $this->tableName . "` SET `$Column`='" . $Value . "' WHERE KandidatID='" . $TargetID . "'";

        $this->ExecuteUpdateQuery($EditColumnSQL);
    }

    public function GetCandidatesForExam($ExamID){
        $GetCandidatesForExamSQL = "SELECT Kandidat.KandidatJMBG, Kandidat.KandidatIme, Kandidat.KandidatPrezime, Ispit.IspitPredmet, Ispit.IspitRok, Kandidat.KandidatBodovi, Kandidat.KandidatPolozio FROM `PrijemniIspit`.`Kandidat` INNER JOIN `PrijemniIspit`.`Ispit` ON Kandidat.PrijemniID = Ispit.IspitID WHERE Ispit.IspitID='" . $ExamID . "' ORDER BY Kandidat.KandidatBodovi DESC";
        
        $this->ExecuteSelectQuery($GetCandidatesForExamSQL);
    }
    public function GetCandidatesForExamByJMBG($ExamID, $TargetJMBG){
        $GetCandidatesForExamSQL = "SELECT Kandidat.KandidatJMBG, Kandidat.KandidatIme, Kandidat.KandidatPrezime, Ispit.IspitPredmet, Ispit.IspitRok, Kandidat.KandidatBodovi, Kandidat.KandidatPolozio FROM `PrijemniIspit`.`Kandidat` INNER JOIN `PrijemniIspit`.`Ispit` ON Kandidat.PrijemniID = Ispit.IspitID WHERE Ispit.IspitID='" . $ExamID . "' AND Kandidat.KandidatJMBG='" . $TargetJMBG . "' ORDER BY Kandidat.KandidatBodovi DESC";
        
        $this->ExecuteSelectQuery($GetCandidatesForExamSQL);
    }
    
    
    public function HasExam($ExamID){
        $HasExamSQL = "SELECT * FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE PrijemniID='" . $ExamID . "'";

        $this->ExecuteSelectQuery($HasExamSQL);

        if($this->itemsCount != 0){
            return true;
        }else {
            return false;
        }
    } 

    // Is JMBG Unique 
    public function IsJMBGUniqueInTerm($CandidateJMBG, $ExamTerm){
        
        $UniqueJMBGInTerm = "SELECT Kandidat.KandidatID, Kandidat.KandidatJMBG, Kandidat.PrijemniID, Ispit.IspitID, Ispit.IspitRok FROM `PrijemniIspit`.`Kandidat` INNER JOIN `PrijemniIspit`.`Ispit` ON Kandidat.PrijemniID = Ispit.IspitID WHERE Kandidat.KandidatJMBG='" . $CandidateJMBG . "' AND Ispit.IspitRok='" . $ExamTerm . "' ORDER BY Kandidat.KandidatID"; 

        $this->ExecuteSelectQuery($UniqueJMBGInTerm);

        if($this->itemsCount == 0){
            return true;
        }else {
            return false;
        }
    }

}
