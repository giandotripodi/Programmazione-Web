<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/database.php';
include_once '../objects/store.php';
$database = new Database();
$db = $database->getConnection();

$store = new Store($db);
  
$store->id_negozio = isset($_GET['id_negozio']) ? $_GET['id_negozio'] : die();

if($store->readOne()){
  
    $store_arr = array(

            "id_negozio" => $store->id_negozio,
            "nome" => $store->nome,
            "via" => $store->via,
            "cap" => $store->cap,
            "citta" => $store->citta
            
    );
  
    http_response_code(200);
    echo json_encode($store_arr);
}
else{
    http_response_code(404);
    echo json_encode(array("message" => "Il negozio non esiste."));
}
?>