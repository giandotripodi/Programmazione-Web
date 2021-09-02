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
if(
    !empty($data->id_magazziniere) &&
    !empty($data->id_giorno) &&
    !empty($data->id_orario)
){
    $shifts->id_magazziniere = $data->id_magazziniere;
    $shifts->id_giorno = $data->id_giorno;
    $shifts->id_orario = $data->id_orario;

    if($shifts->createw()){
        http_response_code(201);
        echo json_encode(array("message" => "Il turno è stato creato correttamente"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare il turno."));
    }
}

else{
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile inserire il turno. I dati sono incompleti."));
}
?>