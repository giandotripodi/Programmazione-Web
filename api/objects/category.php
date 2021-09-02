<?php
class Category{
    
    private $conn;
    private $table_name = "sotto_categoria";

    public $id_sottocategoria;
    public $sottocategoria;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che cerca le sottocategorie
    public function read(){
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_sottocategoria ASC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    

    function search($keywords){
        if($keywords == '1'){

            $query = "SELECT * FROM " . $this->table_name . " WHERE id_sottocategoria < 4";
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
            return $stmt;

        }
        elseif($keywords == '2'){

            $query = "SELECT * FROM " . $this->table_name . " WHERE id_sottocategoria >= 4";
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
            return $stmt;
        }
        else return false;
    
    }
}

?>