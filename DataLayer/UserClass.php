<?php
class User extends BaseClass{
    // Constructor is inherited

    // Public Methods

    // Authenticate user 
    public function AuthenticateUser($InputUsername, $InputPassword)
    {
        $AuthenticateUserSQL = "SELECT * FROM `" . $this->dbName . "`.`" . $this->tableName . "` WHERE `KorisnikUsername`='" . $InputUsername . "' AND `KorisnikPassword`='" . $InputPassword . "'";

        $this->ExecuteSelectQuery($AuthenticateUserSQL);

        if($this->itemsCount == 1){
            return true;
        }else {
            return false;
        }
    }
    
}
?>