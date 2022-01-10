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
$ed = new Education();

switch($method) {
    case 'GET':

        if(!isset($id)) {
            //"HTTP response status code"
            http_response_code(200); //Valid request

            //Get all education
            $response = $ed->getEd();


            if(count($response) == 0) {
                //Response message
                $response = array("message" => "Empty");
            }

        } else {
            //Get all education
            $response = $ed->getById($id);
        }
    break;




    case 'POST':
        //Reads the JSON and turns it into an object.
        $data = json_decode(file_get_contents("php://input"));


        //Checks if empty values
        if($data->school == "" || $data->name == "" || $data->startDate == "" || $data->endDate == "") {
            $response = array("message" => "Enter all fields!");

            http_response_code(400); //User error
        } else {
            //Adds education
            if($ed->addEd($data->school, $data->name, $data->startDate, $data->endDate)) {
                $response = array("message" => "Education added!");
    
                http_response_code(201); //Valid request
            } else {
                //Failed to add education message and code
                $response = array("message" => "Failed to add education!");
    
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

            //Update education
            if($ed->updateEd($id, $data->school, $data->name, $data->startDate, $data->endDate)) {
                http_response_code(200); //Valid request
                $response = array("message" => "Education with id=$id is updated");
            } else {
                //Update failed message & code
                $response = array("message" => "Failed to update education!");
    
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
            if($ed->deleteEd($id)) {
                http_response_code(200); //Valid request
                $response = array("message" => "Education with id=$id is deleted");
            } else {
                //Delete failed message & code
                $response = array("message" => "Failed to delete education!");
    
                http_response_code(500); //Server error
            }
        }
    break;
   
}

//Send response to user
echo json_encode($response);
//var_dump($response);