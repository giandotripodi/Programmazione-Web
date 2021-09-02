<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/database.php';
include_once '../objects/salesman.php';
$database = new Database();
$db = $database->getConnection();
$salesman = new Salesman($db);
$salesman->id_addetto = isset($_GET['id_addetto']) ? $_GET['id_addetto'] : die();
$salesman->readOne();
  
if($salesman->id_addetto!=null){
    $salesman_arr = array(

            "id_addetto" => $salesman->id_addetto,
            "id_reparto" => $salesman->id_reparto,
            "reparto" => $salesman->reparto,
            "nome" => $salesman->nome,
            "cognome" => $salesman->cognome,
            "email" => $salesman->email
            
    );
    http_response_code(200);
    echo json_encode($salesman_arr);
}
  
else{
    http_response_code(404);
    echo json_encode(array("message" => "L'addetto vendita non esiste."));
}
?>