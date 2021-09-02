<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/category.php';
//connessione al database
$database = new Database();
$db = $database->getConnection();

$category = new Category($db);
  
// query
$stmt = $category->read();
$num = $stmt->rowCount();
  
// se ho trovato risultati
if($num>0){
  
    // creo un array
    $categories_arr=array();
    $categories_arr["records"]=array();
    //eseguo un fetch dedi risultati
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
  
        $category_item=array(
            "id_sottocategoria" => $id_sottocategoria,
            "sottocategoria" => $sottocategoria,
        );
  
        array_push($categories_arr["records"], $category_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
    echo json_encode($categories_arr);
}
  
else{
  
    // codice di risposta - 404 Not found
    http_response_code(404);
    echo json_encode(
        array("message" => "Nessuna sottocategoria trovata.")
    );
}
?>