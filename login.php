<?php
include_once("includes/config.php");

/*Settings for the REST API*/

//What domains have access to the REST API
header('Access-Control-Allow-Origin: *');

//What type of content the REST API is sending. JSON-format
header('Content-Type: application/json');

//What methods that are accepted
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//What headers are allowed from the client side
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Stores what request method is being used in a variable
$method = $_SERVER['REQUEST_METHOD'];



//New instance of the course class
$login = new Login();

switch($method) {

        case 'POST':
            //Reads the JSON and turns it into an object.
            $data = json_decode(file_get_contents("php://input"));
        
        
            //Checks if empty values
            if($data->user == "" || $data->pw == "") {
                $response = array("message" => "Enter all fields!");
        
                http_response_code(400); //User error
            } else {

                //Submit login
                $response = $login->getByUser($data->user, $data->pw);
        
        
                if(count($response) == 0) {

                    //Failed to login message and code
                    $response = array("message" => "Failed to login!");

                    http_response_code(500); //Server error
    
                } else {
                    http_response_code(200); //Valid response
                    $response;
                }
            }
    break;
}



//Send response to user
echo json_encode($response);
//var_dump($response);