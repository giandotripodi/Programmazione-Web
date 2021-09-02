<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/shifts.php';
  

$database = new Database();
$db = $database->getConnection();
  
$shifts = new Shifts($db);

$shifts->id_magazziniere = isset($_GET['id_magazziniere']) ? $_GET['id_magazziniere'] : die();

$stmt = $shifts->readw();
$num = $stmt->rowCount();

if($num>0){
  
    $shifts_arr=array();
    $shifts_arr["records"]=array();
  
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $shifts_item=array(
            "id_magazziniere" => $id_magazziniere,
            "giorno" => $giorno,
            "orario" => $orario
        );
  
        array_push($shifts_arr["records"], $shifts_item);
    }
  
    http_response_code(200);
    echo json_encode($shifts_arr);
}

else{
    http_response_code(404);
    echo json_encode(
        array("message" => "Nessun orario trovato.")
    );
}