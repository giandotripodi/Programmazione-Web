<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// includo gli oggetti database e article
include_once '../config/database.php';
include_once '../objects/article.php';
  
// creo una nuova connessione al database
$database = new Database();
$db = $database->getConnection();
  
// creo un oggetto articolo
$article = new Article($db);
  
// Setto l'id dell'articolo da leggere
$article->id_articolo = isset($_GET['id_articolo']) ? $_GET['id_articolo'] : die();
  
// leggo i dettagli del prodotto da modificare
$article->readOne();
  
if($article->nome_articolo!=null){
    // creo un array
    $article_arr = array(

            "id_articolo" => $article->id_articolo,
            "id_categoria" => $article->id_categoria,
            "categoria" => $article->categoria,
            "id_sottocategoria" => $article->sottocategoria,
            "sottocategoria" => $article->sottocategoria,
            "id_reparto" => $article->id_reparto,
            "reparto" => $article->reparto,
            "nome_articolo" => $article->nome_articolo,
            "prezzo" => $article->prezzo,
            "taglia" => $article->taglia,
            
    );
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // stampo i valori in formato json
    echo json_encode($article_arr);
}
  
else{
    // codice di risposta 404 - not found
    http_response_code(404);
  
    // comunico all'utente che non esiste l'articolo
    echo json_encode(array("message" => "L'articolo non esiste."));
}
?>