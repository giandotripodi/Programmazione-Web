<?php
class Wtime{
    
    private $conn;
    private $table_name = "orario";

    public $id_orario;
    public $orario;

    public function __construct($db){
        $this->conn = $db;
    }
    
    //funzione che legge i turni lavorativi
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    
}

?>