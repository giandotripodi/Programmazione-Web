<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/wtime.php';
  
$database = new Database();
$db = $database->getConnection();
  
$wtime = new Wtime($db);

$stmt = $wtime->read();
$num = $stmt->rowCount();
  
if($num>0){
    $wtime_arr=array();
    $wtime_arr["records"]=array();

       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $wtime_item=array(
            "id_orario" => $id_orario,
            "orario" => $orario,
        );
  
        array_push($wtime_arr["records"], $wtime_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // visualizzo i dati in formato json
    echo json_encode($wtime_arr);
}

else{
  
    // codice di risposta - 404 not found
    http_response_code(404);
  
    // stampo un messaggio di errore
    echo json_encode(
        array("message" => "Nessun turno trovato.")
    );
}