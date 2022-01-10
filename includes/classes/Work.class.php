<?php 

class Work {
    private $db;
    private $company;
    private $title;
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



    //Add work
    public function addWork($company, $title, $startDate, $endDate) {
        //Control if correct values
        if(!$this->setCompany($company)){
            return false;
        }
        if(!$this->setTitle($title)){
            return false;
        }
        if(!$this->setStart($startDate)){
            return false;
        }
        if(!$this->setEnd($endDate)){
            return false;
        }


        $sql = "INSERT INTO work(company, title, startDate, endDate) VALUES ('$this->company', '$this->title', '$this->startDate', '$this->endDate')";
            
        return $result = $this->db->query($sql);
    }


    
    //Update work
    public function updateWork ($id, $company, $title, $startDate, $endDate) {
        //Control if correct values
        $id = intval($id);
        if(!$this->setCompany($company)){
            return false;
        }
        if(!$this->setTitle($title)){
            return false;
        }
        if(!$this->setStart($startDate)){
            return false;
        }
        if(!$this->setEnd($endDate)){
            return false;
        }


        $sql = "UPDATE work SET company='" . $this->company . "', title=' " . $this->title . "', startDate=' " . $this->startDate . "', endDate='" . $this->endDate . "' WHERE id=$id";
        
        return $result = $this->db->query($sql);
    }


    //Delete work by id
    public function deleteWork ($id) {
        $id = intval($id);

        $sql = "DELETE FROM work WHERE id=$id";

        return $this->db->query($sql);
    }


    //Getters ------------------------------------------------------------------------------------------------------

    //Get all work
    public function getWork () {
        $sql = "SELECT * FROM work ORDER BY company";
        $result = $this->db->query($sql);
            
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Get by id
    public function getById ($id) {
        $id = intval($id);

        $sql = "SELECT * FROM work WHERE id=$id";

        $result = $this->db->query($sql);
                
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } 


    //Setters ------------------------------------------------------------------------------------------------------

    //Set company
    public function setCompany ($company) {
        if($company != "") {
            $this->company = $this->db->real_escape_string($company);

            return true;
        }else {
            return false;
        }
    }


    //Set title
    public function setTitle ($title) {
        if($title != "") {
            $this->title = $this->db->real_escape_string($title);

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
?>