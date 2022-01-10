<?php 

class Education {
    private $db;
    private $school;
    private $name;
    private $startDate;
    private $endDate;
    

    //Constructor 
    public function __construct() {

        // Database connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connection_error);
        }
    }



    //Add education
    public function addEd($school, $name, $startDate, $endDate) {
        //Control if correct values
        if(!$this->setSchool($school)){
            return false;
        }
        if(!$this->setName($name)){
            return false;
        }
        if(!$this->setStart($startDate)){
            return false;
        }
        if(!$this->setEnd($endDate)){
            return false;
        }


        $sql = "INSERT INTO education(school, name, startDate, endDate) VALUES ('$this->school', '$this->name', '$this->startDate', '$this->endDate')";
            
        return $result = $this->db->query($sql);
    }


    
    //Update education
    public function updateEd ($id, $school, $name, $startDate, $endDate) {
        //Control if correct values
        $id = intval($id);
        if(!$this->setSchool($school)){
            return false;
        }
        if(!$this->setName($name)){
            return false;
        }
        if(!$this->setStart($startDate)){
            return false;
        }
        if(!$this->setEnd($endDate)){
            return false;
        }


        $sql = "UPDATE education SET school='" . $this->school . "', name=' " . $this->name . "', startDate=' " . $this->startDate . "', endDate='" . $this->endDate . "' WHERE id=$id";
        
        return $result = $this->db->query($sql);
    }


    //Delete education by id
    public function deleteEd ($id) {
        $id = intval($id);

        $sql = "DELETE FROM education WHERE id=$id";

        return $this->db->query($sql);
    }


    //Getters ------------------------------------------------------------------------------------------------------

    //Get all education
    public function getEd () {
        $sql = "SELECT * FROM education ORDER BY name";
        $result = $this->db->query($sql);
        
        //$test = mysqli_fetch_all($result);
        //return $test;
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }

    //Get by id
    public function getById ($id) {
        $id = intval($id);

        $sql = "SELECT * FROM education WHERE id=$id";

        $result = $this->db->query($sql);
                
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } 


    //Setters ------------------------------------------------------------------------------------------------------

    //Set school
    public function setSchool ($school) {
        if($school != "") {
            $this->school = $this->db->real_escape_string($school);

            return true;
        }else {
            return false;
        }
    }


    //Set name
    public function setName ($name) {
        if($name != "") {
            $this->name = $this->db->real_escape_string($name);

            return true;
        }else {
            return false;
        }
    }


    //Set startDate
    public function setStart ($startDate) {
        if($startDate != "") {
            $this->startDate = $this->db->real_escape_string($startDate);

            return true;
        }else {
            return false;
        }
    }


    //Set endDate
    public function setEnd ($endDate) {
        if($endDate != "") {
            $this->endDate = $this->db->real_escape_string($endDate);

            return true;
        }else {
            return false;
        }
    }
}
