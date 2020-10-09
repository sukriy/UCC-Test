<?php
include 'app/Vehicles.php';

$data = new Vehicles;
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseUrl = '/WebProjects/UCC-Test/backend';

switch ($request) 
{
    case $baseUrl.'/' :
        if($_SERVER['REQUEST_METHOD'] != "GET"){
            echo json_encode([
                'success' => false,
                'message' => 'not support request method'
            ]);
            break;
        }
        echo json_encode($data->retrieve($_GET));
        break;
    case $baseUrl.'/reset' :
        if($_SERVER['REQUEST_METHOD'] != "GET"){
            echo json_encode([
                'success' => false,
                'message' => 'not support request method'
            ]);
            break;
        }
        echo json_encode($data->reset());
        break;
    case $baseUrl.'/store' :
        if($_SERVER['REQUEST_METHOD'] != "POST"){
            echo json_encode([
                'success' => false,
                'message' => 'not support request method'
            ]);
            break;
        }
        echo json_encode($data->store($_POST));
        break;
    default:
        break;
}