<?php
include 'app/Vehicles.php';

$data = new Vehicles;
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) 
{
    case '/' :
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            echo json_encode($data->retrieve($_GET));
        }else if($_SERVER['REQUEST_METHOD'] == "POST"){
            echo json_encode($data->store($_POST));
        }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
            echo json_encode($data->reset());
        }
        break;
    default:
        break;
}