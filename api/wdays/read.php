<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/wdays.php';
  
$database = new Database();
$db = $database->getConnection();
  
$wdays = new Wdays($db);

$stmt = $wdays->read();
$num = $stmt->rowCount();
if($num>0){

    $wdays_arr=array();
    $wdays_arr["records"]=array();
  
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $wdays_item=array(
            "id_giorno" => $id_giorno,
            "giorno" => $giorno,
        );
  
        array_push($wdays_arr["records"], $wdays_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // visualizzo i dati in formato json
    echo json_encode($wdays_arr);
}

else{
  
    // codice di risposta - 404 not found
    http_response_code(404);
  
    // stampo un messaggio di errore
    echo json_encode(
        array("message" => "Nessun giorno trovato.")
    );
}