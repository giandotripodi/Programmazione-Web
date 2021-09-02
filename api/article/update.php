<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/article.php';
  
// connessione al Database
$database = new Database();
$db = $database->getConnection();

$article = new Article($db);
  
// id dell'articolo
$data = json_decode(file_get_contents("php://input"));

$article->id_articolo = $data->id_articolo;
  
// setto le proprietà dell'oggetto Article con i dati postati
$article->nome_articolo = $data->nome_articolo;
$article->prezzo = $data->prezzo;
$article->taglia = $data->taglia;

if($article->update()){
  
    // codice di risposta - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "L'articolo è stato aggiornato."));
}
else{
  
    // codice di risposta- 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile aggiornare il prodotto."));
}
?>