<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// includo gli oggetti database core e article
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/article.php';
  
// nuova connessione al database
$database = new Database();
$db = $database->getConnection();
  
// creo un nuovo oggetto Article
$article = new Article($db);
  
// prendo le lettere digitate
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// query
$stmt = $article->search($keywords);
$num = $stmt->rowCount();
  
// se ho trovato risultati
if($num>0){

    $article_arr=array();
    $article_arr["records"]=array();

    //eseguo un fetch dei risultati
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $article_item=array(
            "id_articolo" => $id_articolo,
            "reparto" => $reparto,
            "nome_articolo" => $nome_articolo,
            "prezzo" => $prezzo,
            "taglia" => $taglia,
        );
  
        array_push($article_arr["records"], $article_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
    // stampo i dati
    echo json_encode($article_arr);
}
  
else{
    // codice di risposta - 404 NOT FOUND
    http_response_code(404);
    
    echo json_encode(
        array("message" => "Nessun articolo trovato.")
    );
}
?>