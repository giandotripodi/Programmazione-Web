<?php
class Tipology{

    private $conn;
    private $table_name = "categoria";

    public $id_categoria;
    public $categoria;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che legge le categorie
    function read(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_categoria > 7";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>