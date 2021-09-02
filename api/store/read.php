<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/store.php';
$database = new Database();
$db = $database->getConnection();

$store = new Store($db);

$stmt = $store->read();
$num = $stmt->rowCount();
  
if($num>0){

    $store_arr=array();
    $store_arr["records"]=array();
  
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $store_item=array(
            "id_negozio" => $id_negozio,
            "nome" => $nome,
            "via" => $via,
            "cap" => $cap,
            "citta" => $citta
        );
  
        array_push($store_arr["records"], $store_item);
    }
  
    http_response_code(200);
    echo json_encode($store_arr);
}

else{

    http_response_code(404);
    echo json_encode(
        array("message" => "Nessun negozio trovato.")
    );
}