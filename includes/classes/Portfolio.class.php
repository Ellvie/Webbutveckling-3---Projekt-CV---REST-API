<?php 

class Portfolio {
    private $db;
    private $title;
    private $url;
    private $description;

    

    //Constructor 
    public function __construct() {

        // Database connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connection_error);
        }
    }



    //Add portfolio
    public function addPortfolio($title, $url, $description) {
        //Control if correct values
        if(!$this->setTitle($title)){
            return false;
        }
        if(!$this->setURL($url)){
            return false;
        }
        if(!$this->setDescription($description)){
            return false;
        }


        $sql = "INSERT INTO portfolio(title, url, description) VALUES ('$this->title', '$this->url', '$this->description')";
            
        return $result = $this->db->query($sql);
    }


    
    //Update portfolio
    public function updatePortfolio ($id, $title, $url, $description) {
        //Control if correct values
        $id = intval($id);
        if(!$this->setTitle($title)){
            return false;
        }
        if(!$this->setURL($url)){
            return false;
        }
        if(!$this->setDescription($description)){
            return false;
        }


        $sql = "UPDATE portfolio SET title='" . $this->title . "', url=' " . $this->url . "', description=' " . $this->description . "' WHERE id=$id";
        
        return $result = $this->db->query($sql);
    }


    //Delete portfolio by id
    public function deletePortfolio ($id) {
        $id = intval($id);

        $sql = "DELETE FROM portfolio WHERE id=$id";

        return $this->db->query($sql);
    }


    //Getters ------------------------------------------------------------------------------------------------------

    //Get all portfolio
    public function getPortfolio () {
        $sql = "SELECT * FROM portfolio ORDER BY title";
        $result = $this->db->query($sql);
            
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    //Get by id
    public function getById ($id) {
        $id = intval($id);

        $sql = "SELECT * FROM portfolio WHERE id=$id";

        $result = $this->db->query($sql);
                
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } 

    //Setters ------------------------------------------------------------------------------------------------------

    //Set title
    public function setTitle ($title) {
        if($title != "") {
            $this->title = $this->db->real_escape_string($title);

            return true;
        }else {
            return false;
        }
    }


    //Set URL
    public function setURL ($url) {
        if($url != "") {
            $this->url = $this->db->real_escape_string($url);

            return true;
        }else {
            return false;
        }
    }


    //Set description
    public function setDescription ($description) {
        if($description != "") {
            $this->description = $this->db->real_escape_string($description);

            return true;
        }else {
            return false;
        }
    }
}
?>