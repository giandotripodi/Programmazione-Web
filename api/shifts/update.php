<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/shifts.php';
  
$database = new Database();
$db = $database->getConnection();
  
$shifts = new Shifts($db);

$data = json_decode(file_get_contents("php://input"));
  
$shifts->id_orario_lav = $data->id_orario_lav;
$shifts->id_giorno = $data->id_giorno;
$shifts->id_orario = $data->id_orario;

if($shifts->update()){

    http_response_code(200);
    echo json_encode(array("message" => "L'orario è stato aggiornato."));
}

else{
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile aggiornare l'orario."));
}
?>