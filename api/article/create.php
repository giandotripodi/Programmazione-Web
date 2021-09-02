<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// includo database.php per la connessione al database
include_once '../config/database.php';
// includo article.php per istanziare un oggetto Article
include_once '../objects/article.php';
  
$database = new Database();
$db = $database->getConnection();
$article = new Article($db);
  
// ottengo i dati postati
$data = json_decode(file_get_contents("php://input"));
  
// verifico se i dati inseriti non sono vuoti
if(
    !empty($data->id_categoria) &&
    !empty($data->id_reparto) &&
    !empty($data->id_sottocategoria) &&
    !empty($data->nome_articolo) &&
    !empty($data->quantita) &&
    !empty($data->prezzo) &&
    !empty($data->taglia)
){
  
    // setto le proprietà dell'oggetto Article con i dati postati
    $article->id_reparto = $data->id_reparto;
    $article->id_categoria = $data->id_categoria;
    $article->id_sottocategoria = $data->id_sottocategoria;
    $article->nome_articolo = $data->nome_articolo;
    $article->quantita = $data->quantita;
    $article->prezzo = $data->prezzo;
    $article->taglia = $data->taglia;

  
    // creo l'articolo
    if($article->create()){
  
        // codice di risposta - 201 created
        http_response_code(201);
  
        // stampo un messaggio
        echo json_encode(array("message" => "L'articolo è stato creato correttamente."));
    }
  
    // se non è possibile creare l'oggetto
    else{
  
        // codice di risposta - 503 service unavailable
        http_response_code(503);
  
        // stampo un messaggio
        echo json_encode(array("message" => "Impossibile creare l'articolo."));
    }
}

elseif(
    empty($data->id_sottocategoria) &&
    !empty($data->id_categoria) &&
    !empty($data->id_reparto) &&
    !empty($data->nome_articolo) &&
    !empty($data->quantita) &&
    !empty($data->prezzo) &&
    !empty($data->taglia) 
){
    // setto le proprietà dell'oggetto Article con i dati postati
    $article->id_reparto = $data->id_reparto;
    $article->id_categoria = $data->id_categoria;
    $article->nome_articolo = $data->nome_articolo;
    $article->quantita = $data->quantita;
    $article->prezzo = $data->prezzo;
    $article->taglia = $data->taglia;

  
    // creo l'articolo
    if($article->createnocat()){
  
        // codice di risposta - 201 created
        http_response_code(201);
  
        // stampo un messaggio
        echo json_encode(array("message" => "L'articolo è stato creato correttamente."));
    }
  
    // se non è possibile creare l'oggetto
    else{
  
        // codice di risposta - 503 service unavailable
        http_response_code(503);
  
        // stampo un messaggio
        echo json_encode(array("message" => "Impossibile creare l'articolo."));
    }


}
else{
  
    // codice di risposta - 400 bad request
    http_response_code(400);
  
    // stampo un messaggio
    echo json_encode(array("message" => "Impossibile creare il prodotto. I dati sono incompleti."));
}
?>