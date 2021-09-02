<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);
  
// prendo le keywords digitate
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// query 
$stmt = $category->search($keywords);
$num = $stmt->rowCount();

if($num>0){
  
    $category_arr=array();
    $category_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $category_item=array(
            "id_sottocategoria" => $id_sottocategoria,
            "sottocategoria" => $sottocategoria,
        );
  
        array_push($category_arr["records"], $category_item);
    }
  
    // codice di risposta - 200 OK
    http_response_code(200);
    echo json_encode($category_arr);
}
  
else{
    // codice di risposta - 404 Not found
    http_response_code(404);
    echo json_encode(
        array("message" => "Nessuna sottocatgoria trovata.")
    );
}
?>