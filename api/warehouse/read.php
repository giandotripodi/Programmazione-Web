<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/warehouse.php';
  
$database = new Database();
$db = $database->getConnection();

$warehouse = new Warehouse($db);

$stmt = $warehouse->read();
$num = $stmt->rowCount();
  
if($num>0){
  
    $warehouse_arr=array();
    $warehouse_arr["records"]=array();
  
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $warehouse_item=array(
            "id_magazziniere" => $id_magazziniere,
            "nome" => $nome,
            "cognome" => $cognome,
            "email" => $email
        );
  
        array_push($warehouse_arr["records"], $warehouse_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // visualizzo i dati in formato json
    echo json_encode($warehouse_arr);
}

else{
  
    // codice di risposta - 404 not found
    http_response_code(404);
  
    // stampo un messaggio di errore
    echo json_encode(
        array("message" => "Nessun magazziniere trovato.")
    );
}