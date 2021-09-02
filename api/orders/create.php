<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Hearder, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/orders.php';

//crea l'istanza del database
$database = new Database();
$db = $database->getConnection();

//crea l'istanza dell'Ordine
$orders = new Orders($db);

//prende i dati inviati con il metodo post
$data = json_decode(file_get_contents("php://input"));

//controlla se i dati sono vuoti
if(!empty($data->articolo) && !empty($data->quantita) && !empty($data->taglia)) {
    $orders->articolo = $data->articolo;
    $quantita = $data->quantita;
    $orders->taglia = $data->taglia;
    $flag = true;
    for($i = 0; $i < $quantita; $i++) {
        if($orders->create()) {
            if($orders->lastOrder()){
                if($orders->createArticleOrd()) {
                    $flag = true;
                } else {
                $flag = false;
            }
        } else {
            $flag = false;
        }
    } else {
        $flag = false;
    }

}

    if($flag) {
        http_response_code(201); //response code - 201 created 

        echo json_encode(array("message" => "L'ordine è stato creato correttamente."));
    } else {
        http_response_code(503); //response code 

        echo json_encode(array("message" => "Impossibile creare l'ordine."()));
    }
} else {

    http_response_code(400); //response code - 400 bad request 

    echo json_encode(array("message" => "Impossibile aggiungere l'ordine. Dati incompleti"));
}

?>