<?php
class Department{
    
    private $conn;
    private $table_name = "reparto";

    public $id_reparto;
    public $nome;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che legge i reparti
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . " ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    
}

?>