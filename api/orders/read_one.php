<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../config/database.php';
include_once '../objects/orders.php';
  

$database = new Database();
$db = $database->getConnection();
$orders = new Orders($db);
  

$orders->id_ordine = isset($_GET['id_ordine']) ? $_GET['id_ordine'] : die();
  
$orders->readOne();
  
if($orders->articolo!=null){

    $orders_arr = array(

            "id_ordine" => $orders->id_ordine,
            "fornitore" => $orders->fornitore,
            "articolo" => $orders->articolo,
            "stato" => $orders->stato,
            
    );
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // stampo i valori in formato json
    echo json_encode($orders_arr);
}
  
else{
    // codice di risposta 404 - not found
    http_response_code(404);
    echo json_encode(array("message" => "L'ordine non esiste."));
}
?>