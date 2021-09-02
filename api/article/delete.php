<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// includo database.php e article.php
include_once '../config/database.php';
include_once '../objects/article.php';
  
// connessione al database
$database = new Database();
$db = $database->getConnection();
  
// creo un nuovo oggetto Articolo
$article = new Article($db);
  
// tiro fuori l'id articolo
$data = json_decode(file_get_contents("php://input"));
  
// setto id_articolo dell'oggetto article con l'id dell'articolo selezionato
$article->id_articolo = $data->id_articolo;
  
if($article->delete()){
    //codice di risposta 200 - OK
    http_response_code(200);
    echo json_encode(array("message" => "L'articolo è stato eliminato con successo."));

}
else{
  
    // codice di risposta 503 - SERVICE UNAVAIABLE
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile eliminare l'articolo."));
}
?>