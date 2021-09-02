<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/department.php';
  
$database = new Database();
$db = $database->getConnection();

$department = new Department($db);
  
// query 
$stmt = $department->read();
$num = $stmt->rowCount();
  
// controllo se ho trovato risultati
if($num>0){
  
    // creo un array
    $department_arr=array();
    $department_arr["records"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $department_item=array(
            "id_reparto" => $id_reparto,
            "nome" => $nome,
        );
  
        array_push($department_arr["records"], $department_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
    echo json_encode($department_arr);
}
  
else{
  
    // codice di risposta - 404 NOT FOUND
    http_response_code(404);
      echo json_encode(
        array("message" => "Nessun reparto trovato.")
    );
}
?>