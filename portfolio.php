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

//Get parameter ID from the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//New instance of the course class
$pf = new Portfolio();

switch($method) {
    case 'GET':

        if(!isset($id)) {
            //"HTTP response status code"
            http_response_code(200); //Valid request

            //Get all portfolio
            $response = $pf->getPortfolio();

            if(count($response) == 0) {
                //Response message
                $response = array("message" => "Empty");
            }
        } else {
            //Get all from portfolio
            $response = $pf->getById($id);
        }
    break;




    case 'POST':
        //Reads the J-SON and turns it into an object.
        $data = json_decode(file_get_contents("php://input"));


        //Checks if empty values
        if($data->title == "" || $data->url == "" || $data->description == "") {
            $response = array("message" => "Enter all fields!");

            http_response_code(400); //User error
        } else {
            //Adds Portfolio
            if($pf->addPortfolio($data->title, $data->url, $data->description)) {
                $response = array("message" => "Portfolio added!");
    
                http_response_code(201); //Valid request
            } else {
                //Failed to add portfolio message and code
                $response = array("message" => "Failed to add portfolio!");
    
                http_response_code(500); //Server error
            }
        }
    break;



    case 'PUT':
        //Checks for ID
        if(!isset($id)) {
            http_response_code(400); //User error
            $response = array("message" => "No id sent");
         
        } else {
            $data = json_decode(file_get_contents("php://input"));

            //Update Portfolio
            if($pf->updatePortfolio($id, $data->title, $data->url, $data->description)) {
                http_response_code(200); //Valid request
                $response = array("message" => "Portfolio with id=$id is updated");
            } else {
                //Update failed message & code
                $response = array("message" => "Failed to update portfolio!");
    
                http_response_code(500); //Server error
            }
        }
    break;


    case 'DELETE':
        //Checks for ID
        if(!isset($id)) {
            //No ID error message & code
            http_response_code(400); //User error
            $response = array("message" => "No id sent");  
        } else {
            //Delete education
            if($pf->deletePortfolio($id)) {
                http_response_code(200); //Valid request
                $response = array("message" => "Portfolio with id=$id is deleted");
            } else {
                //Delete failed message & code
                $response = array("message" => "Failed to delete portfolio!");
    
                http_response_code(500); //Server error
            }
        }
    break;
   
}

//Send response to user
echo json_encode($response);