<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/orders.php';

$database = new Database();
$db = $database->getConnection();
$orders = new Orders($db);
$data = json_decode(file_get_contents("php://input"));
$orders->id_ordine = $data->id_ordine;

if($orders->complete()){

    http_response_code(200);
    echo json_encode(array("message" => "L'ordine è stato ricevuto con successo."));
}

else{

    http_response_code(503);
    echo json_encode(array("message" => "Impossibile ricevere l'ordine."));
}
?>