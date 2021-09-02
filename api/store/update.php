<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../config/database.php';
include_once '../objects/store.php';

$database = new Database();
$db = $database->getConnection();
$store = new Store($db);
  
$data = json_decode(file_get_contents("php://input"));

$store->id_negozio = $data->id_negozio;
$store->nome = $data->nome;
$store->via = $data->via;
$store->cap = $data->cap;
$store->citta = $data->citta;

if($store->update()){
  
    http_response_code(200);
    echo json_encode(array("message" => "Le informazioni sono state aggiornate."));
}
else{
    
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile aggiornare le informazioni."));
    
}
?>