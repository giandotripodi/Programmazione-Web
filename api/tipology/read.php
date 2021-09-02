<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/tipology.php';

$database = new Database();
$db = $database->getConnection();

$tipology = new Tipology($db);


$stmt = $tipology->read();
$num = $stmt->rowCount();

if($num>0){
  
    $tipology_arr=array();
    $tipology_arr["records"]=array();

       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $tipology_item=array(
            "id_categoria" => $id_categoria,
            "categoria" => $categoria,
        );
  
        array_push($tipology_arr["records"], $tipology_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // visualizzo i dati in formato json
    echo json_encode($tipology_arr);
}

else{
  
    // codice di risposta - 404 not found
    http_response_code(404);
  
    // stampo un messaggio di errore
    echo json_encode(
        array("message" => "Nessuna categoria trovata.")
    );
}