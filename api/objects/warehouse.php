<?php
class Warehouse{

    private $conn;
    private $table_name = "magazziniere";

    public $id_magazziniere;
    public $nome;
    public $cognome;
    public $email;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che legge i dati dei magazzinieri
    function read(){
        $query = "SELECT id_magazziniere, nome, cognome, email 
                  FROM " . $this->table_name . " ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>