<?php
// header richiesti
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//includo i file database e object
include_once '../config/database.php';
include_once '../objects/article.php';
  
// istanzio l'oggetto database
$database = new Database();
$db = $database->getConnection();
  
// istanzio l'oggetto articolo
$article = new Article($db);

// eseguo la query
$stmt = $article->read();
$num = $stmt->rowCount();
  
// controllo se ho trovato risultati
if($num>0){
  
    // array articolo
    $article_arr=array();
    $article_arr["records"]=array();
  
    // eseguo un fetch per tirarmi fuori i risultati della query
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // estraggo la riga
        extract($row);
  
        $article_item=array(

            "id_articolo" => $id_articolo,
            "nome_articolo" => $nome_articolo,
            "prezzo" => $prezzo,
            "taglia" => $taglia,
            "id_reparto" => $id_reparto,
            "reparto" => $reparto,
            
        );
  
        array_push($article_arr["records"], $article_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
  
    // visualizzo i dati in formato json
    echo json_encode($article_arr);
}

else{
  
    // codice di risposta - 404 not found
    http_response_code(404);
  
    // stampo un messaggio di errore
    echo json_encode(
        array("message" => "Nessun articolo trovato.")
    );
}