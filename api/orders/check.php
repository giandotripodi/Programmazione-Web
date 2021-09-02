<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/orders.php';
  
// istanzio l'oggetto database
$database = new Database();
$db = $database->getConnection();
  
// istanzio l'oggetto Ordine
$orders = new Orders($db);

// eseguo la query
$stmt = $orders->check();
$num = $stmt->rowCount();
  
// controllo se ho trovato risultati
if($num>0){
  
    // array ordini
    $orders_arr=array();
    $orders_arr["records"]=array();
  
    // eseguo un fetch per tirarmi fuori i risultati della query
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // estraggo la riga
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
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // visualizzo i dati in formato json
    echo json_encode($orders_arr);
}

else{
  
    // codice di risposta - 404 not found
    http_response_code(404);
  
    // stampo un messaggio di errore
    echo json_encode(
        array("message" => "Nessun ordine trovato.")
    );
}