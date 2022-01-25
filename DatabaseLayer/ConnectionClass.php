<?php
class Connection{
    // Connection Attributes
    public $ConnectionSQL;
    public $ConnectionToDB;
    public $FullNameDB;

    // Connection Parameters Location
    private $parametersLocation;

    // Connection Parameters
    private $host;
    private $user;
    private $password;
    private $dbPrefix;
    private $dbName;


    // Constructor 
    public function __construct($NewParametersLocation)
    {
        $this->parametersLocation = $NewParametersLocation;
        $this->LoadConnectionParameters($this->parametersLocation);
    }

    // Load Connection Parameters From Location
    public function LoadConnectionParameters($parametersLocation){
        $parametersFile = simplexml_load_file($parametersLocation) or die("Error. Parameters file not found!");
   
        $this->host = $parametersFile->host;
        $this->user = $parametersFile->user;
        $this->password = $parametersFile->password;

        $this->dbPrefix = $parametersFile->database_prefix;
        $this->dbName = $parametersFile->database_name;

        $this->FullNameDB = $this->dbPrefix . $this->dbName;
    }

    // Connect to Database
    public function Connect()
    {
        $this->ConnectionToDB = mysqli_connect($this->host, $this->user, $this->password, $this->FullNameDB) or die("Error. Couldn't connect to database!");

        if($this->ConnectionToDB){
            mysqli_set_charset($this->ConnectionToDB, "utf8");
        }
    }

    // Disconnect from Database
    public function Disconnect()
    {
        mysqli_close($this->ConnectionToDB);
    }

}
?>