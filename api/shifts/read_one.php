<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/database.php';
include_once '../objects/shifts.php';
$database = new Database();
$db = $database->getConnection();
$shifts = new Shifts($db);
$shifts->id_orario_lav = isset($_GET['id_orario_lav']) ? $_GET['id_orario_lav'] : die();
  
// leggo i dettagli del prodotto da modificare
$shifts->readOne();
  
if($shifts->id_orario_lav!=null){
    // creo un array
    $shifts_arr = array(
            "id_orario_lav" => $shifts->id_orario_lav,
            "id_giorno" => $shifts->id_giorno,
            "giorno" => $shifts->giorno,
            "id_orario" => $shifts->id_orario,
            "orario" => $shifts->orario
    );
  
    http_response_code(200);
    echo json_encode($shifts_arr);
}
  
else{
    http_response_code(404);
    echo json_encode(array("message" => "L'orario non esiste."));
}
?>