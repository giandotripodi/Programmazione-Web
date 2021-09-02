<?php
class Shifts{
    
    private $conn;
    private $table_name = "orario_lavorativo";

    public $ruolo;
    public $id_orario_lav;
    public $id_magazziniere;
    public $nome;
    public $nome_magazziniere;
    public $id_addetto;
    public $id_orario;
    public $id_giorno;
    public $giorno;
    public $orario;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che legge gli orari dei magazzinieri e degli adetti vendita
    public function read(){
        $query = "SELECT 'addetto vendita' as ruolo, addetto_vendita.id_addetto, orario_lavorativo.id_orario_lav, addetto_vendita.nome as 'nome', giorno.giorno, orario.orario FROM addetto_vendita 
                  INNER JOIN orario_lavorativo ON addetto_vendita.id_addetto = orario_lavorativo.id_addetto 
                  INNER JOIN giorno ON orario_lavorativo.id_giorno = giorno.id_giorno 
                  INNER JOIN orario ON orario_lavorativo.id_orario = orario.id_orario
                  UNION SELECT 'magazziniere' as ruolo, magazziniere.id_magazziniere, orario_lavorativo.id_orario_lav, magazziniere.nome as 'nome', giorno.giorno, orario.orario FROM magazziniere 
                  INNER JOIN orario_lavorativo ON magazziniere.id_magazziniere = orario_lavorativo.id_magazziniere 
                  INNER JOIN giorno ON orario_lavorativo.id_giorno = giorno.id_giorno 
                  INNER JOIN orario ON orario_lavorativo.id_orario = orario.id_orario ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    //funzione che legge gli orari degli addetti vendita
    public function reads(){
        $query = "SELECT addetto_vendita.id_addetto, giorno.giorno, orario.orario FROM addetto_vendita 
                  INNER JOIN orario_lavorativo ON addetto_vendita.id_addetto = orario_lavorativo.id_addetto 
                  INNER JOIN giorno ON orario_lavorativo.id_giorno = giorno.id_giorno 
                  INNER JOIN orario ON orario_lavorativo.id_orario = orario.id_orario
                  WHERE orario_lavorativo.id_addetto=?
                  ORDER BY orario_lavorativo.id_giorno ASC";
                  
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_addetto);
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    //funzione che legge gli orari dei megazzinieri
    public function readw(){
        $query = "SELECT magazziniere.id_magazziniere, giorno.giorno, orario.orario FROM magazziniere 
                  INNER JOIN orario_lavorativo ON magazziniere.id_magazziniere = orario_lavorativo.id_magazziniere 
                  INNER JOIN giorno ON orario_lavorativo.id_giorno = giorno.id_giorno 
                  INNER JOIN orario ON orario_lavorativo.id_orario = orario.id_orario
                  WHERE orario_lavorativo.id_magazziniere=?
                  ORDER BY orario_lavorativo.id_giorno ASC";
                  
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_magazziniere);
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    //funzione che legge un singolo orario
    function readOne(){
        $query = "SELECT orario_lavorativo.id_orario_lav, orario_lavorativo.id_giorno, giorno.giorno, orario_lavorativo.id_orario, orario.orario
                  FROM ". $this->table_name . " INNER JOIN giorno 
                  ON orario_lavorativo.id_giorno = giorno.id_giorno
                  INNER JOIN orario ON orario_lavorativo.id_orario = orario.id_orario
                    WHERE orario_lavorativo.id_orario_lav = ?";
      

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_orario_lav);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if($row){

            $this->id_orario_lav = $row['id_orario_lav'];
            $this->id_giorno = $row['id_giorno'];
            $this->id_orario = $row['id_orario'];
            $this->giorno = $row['giorno'];
            $this->orario = $row['orario'];

        }
    }

    //funzione che crea un orario (addetti vendita)
    function creates(){
        $flag = 0;

        $query = "INSERT INTO " . $this->table_name . " SET id_orario=:id_orario, id_giorno=:id_giorno, id_addetto=:id_addetto";
      
        $stmt = $this->conn->prepare($query);
      
        $this->id_orario=htmlspecialchars(strip_tags($this->id_orario));
        $this->id_giorno=htmlspecialchars(strip_tags($this->id_giorno));
        $this->id_addetto=htmlspecialchars(strip_tags($this->id_addetto));
      
        // sostituisco i valori della query
        $stmt->bindParam(":id_orario", $this->id_orario);
        $stmt->bindParam(":id_giorno", $this->id_giorno);
        $stmt->bindParam(":id_addetto", $this->id_addetto);

        if($stmt->execute()){
            $flag = 1;
        }        

        if($flag == 1){
            return true;
        }
        else
            return false;

    }

    //funzione che crea un orario (magazzinieri)
    function createw(){

        $flag = 0;
        // query di inserimento
        $query = "INSERT INTO " . $this->table_name . " SET id_orario=:id_orario, id_giorno=:id_giorno, id_magazziniere=:id_magazziniere";
      
        $stmt = $this->conn->prepare($query);
      
        $this->id_orario=htmlspecialchars(strip_tags($this->id_orario));
        $this->id_giorno=htmlspecialchars(strip_tags($this->id_giorno));
        $this->id_magazziniere=htmlspecialchars(strip_tags($this->id_magazziniere));
      
        // sostituisco i valori della query
        $stmt->bindParam(":id_orario", $this->id_orario);
        $stmt->bindParam(":id_giorno", $this->id_giorno);
        $stmt->bindParam(":id_magazziniere", $this->id_magazziniere);

        if($stmt->execute()){
            $flag = 1;
        }        

        if($flag == 1){
            return true;
        }
        else
            return false;

    }


    //funzione che aggiorna un orario
    function update(){
            // update query
        $query = "UPDATE " . $this->table_name . " 
                  SET
                  id_orario = :id_orario,
                  id_giorno = :id_giorno
                  WHERE
                  id_orario_lav = :id_orario_lav";

    $stmt = $this->conn->prepare($query);
    
    $this->id_orario_lav=htmlspecialchars($this->id_orario_lav);
    $this->id_orario=htmlspecialchars($this->id_orario);
    $this->id_giorno=htmlspecialchars($this->id_giorno);

    $stmt->bindParam(':id_orario', $this->id_orario);
    $stmt->bindParam(':id_giorno', $this->id_giorno);
    $stmt->bindParam(':id_orario_lav', $this->id_orario_lav);

    if($stmt->execute()){
        return true;
    }
    return false;
    }

}



?>