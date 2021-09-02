<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/orders.php';
  
$database = new Database();
$db = $database->getConnection();
  
$orders = new Orders($db);

$stmt = $orders->readTask();
$num = $stmt->rowCount();
  
if($num>0){
  
    $orders_arr=array();
    $orders_arr["records"]=array();
  
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $orders_item=array(
            "id_ordine" => $id_ordine,
            "id_fornitore" => $id_fornitore,
            "articolo" => $articolo,
            "taglia" => $taglia,
            "stato" => $stato
        );
  
        array_push($orders_arr["records"], $orders_item);
    }
  

    http_response_code(200);
    echo json_encode($orders_arr);
}

else{
  
    http_response_code(404);
    echo json_encode(
        array("message" => "Nessun ordine trovato.")
    );
}