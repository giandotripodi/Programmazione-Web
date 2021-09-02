<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/salesman.php';
$database = new Database();
$db = $database->getConnection();
$salesman = new Salesman($db);
$stmt = $salesman->read();
$num = $stmt->rowCount();

if($num>0){

    $salesman_arr=array();
    $salesman_arr["records"]=array();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $salesman_item=array(
            "id_addetto" => $id_addetto,
            "id_reparto" => $id_reparto,
            "reparto" => $reparto,
            "nome" => $nome,
            "cognome" => $cognome,
            "email" => $email
        );
  
        array_push($salesman_arr["records"], $salesman_item);
    }
    http_response_code(200);
    echo json_encode($salesman_arr);
}

else{
    
    http_response_code(404);
    echo json_encode(
        array("message" => "Nessun addetto vendita trovato.")
    );
}