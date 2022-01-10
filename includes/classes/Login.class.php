<?php 

class Login {
    private $db;
    private $user;
    private $pw;
    

    //Constructor 
    public function __construct() {

        // Database connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        //Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connection_error);
        }
    }


    //Getters ------------------------------------------------------------------------------------------------------

    //Get by username
    public function getByUser ($user, $pw) {

        $sql = "SELECT username FROM user WHERE username='$user' AND password='$pw'";

        $result = $this->db->query($sql);
                
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } 


    //Setters ------------------------------------------------------------------------------------------------------

    //Set username
    public function setUser ($user) {
        if($user != "") {
            $this->user = $this->db->real_escape_string($user);

            return true;
        }else {
            return false;
        }
    }


    //Set password
    public function setPW ($pw) {
        if($pw != "") {
            $this->pw = $this->db->real_escape_string($pw);

            return true;
        }else {
            return false;
        }
    }
}