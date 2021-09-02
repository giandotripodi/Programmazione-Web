<?php
class Wdays{
    
    private $conn;
    private $table_name = "giorno";

    public $id_giorno;
    public $giorno;

    public function __construct($db){
        $this->conn = $db;
    }
    
    //funzione che legge i giorni della settimana
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    
}

?>