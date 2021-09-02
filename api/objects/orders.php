<?php
class Orders{
    
    private $conn;
    private $table_name = "ordine";

    public $id_ordine;
    public $id_fornitore;
    public $fornitore;
    public $articolo;
    public $ultimo_ord;
    public $quantita;
    public $stato;
    public $taglia;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che legge gli ordini
    public function read(){
        $query = "SELECT ordine.id_ordine, ordine.id_fornitore, fornitore.nome as fornitore, ordine.articolo, articolo.taglia, ordine.stato 
                  FROM " . $this->table_name . " LEFT JOIN fornitore ON ordine.id_fornitore = fornitore.id_fornitore INNER JOIN articolo ON ordine.id_ordine = articolo.id_ordine";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    //funzione che legge gli ordini da prendere incarico (fornitore)
    public function readTask(){
        $query = "SELECT ordine.id_ordine, ordine.id_fornitore, fornitore.nome as fornitore, ordine.articolo, articolo.taglia, ordine.stato 
                  FROM " . $this->table_name . " LEFT JOIN fornitore ON ordine.id_fornitore = fornitore.id_fornitore 
                  INNER JOIN articolo ON ordine.id_ordine = articolo.id_ordine 
                  WHERE stato = 1";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    //funzione che legge gli ordini da completare (fornitore)
    public function readTaskc(){
        $query = "SELECT ordine.id_ordine, ordine.id_fornitore, fornitore.nome as fornitore, ordine.articolo, articolo.taglia, ordine.stato 
                  FROM " . $this->table_name . " LEFT JOIN fornitore ON ordine.id_fornitore = fornitore.id_fornitore 
                  INNER JOIN articolo ON ordine.id_ordine = articolo.id_ordine WHERE stato = 2";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    //funzione che legge gli ordini da confermare (magazziniere)
    public function check(){
        $query = "SELECT ordine.id_ordine, ordine.id_fornitore, fornitore.nome as fornitore, ordine.articolo, articolo.taglia, ordine.stato 
                  FROM " . $this->table_name . " LEFT JOIN fornitore ON ordine.id_fornitore = fornitore.id_fornitore 
                  INNER JOIN articolo ON ordine.id_ordine = articolo.id_ordine WHERE stato = 3";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    //funzione che completa un ordine
    public function complete(){

        $flag = 0;
        
        $query = "SET foreign_key_checks = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query1 = "DELETE FROM " . $this->table_name . "
                  WHERE id_ordine=?";
        $stmt1 = $this->conn->prepare($query1);
        $this->id_ordine=htmlspecialchars($this->id_ordine);
        $stmt1->bindParam(1, $this->id_ordine);
        $stmt1->execute();
        if($stmt1){
            $query2 = "UPDATE articolo set id_ordine = NULL 
                       WHERE id_ordine=?";

            $stmt2 = $this->conn->prepare($query2);
            $this->id_ordine=htmlspecialchars($this->id_ordine);
            $stmt2->bindParam(1, $this->id_ordine);
            $stmt2->execute();

            if($stmt2){

                $query3 = "SET foreign_key_checks = 1";
                $stmt3 = $this->conn->prepare($query3);
                $stmt3->execute();
                if($stmt3)
                    return true;
            }
        }
        else
            return false;
    }

    //funzione che prende in carico un ordine (fornitore)
    public function getTask(){
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                  stato = 2,
                  id_fornitore = :id_fornitore
                  WHERE id_ordine = :id_ordine";
      

        $stmt = $this->conn->prepare($query);
        $this->id_ordine=htmlspecialchars(strip_tags($this->id_ordine));
        $this->id_fornitore=htmlspecialchars(strip_tags($this->id_fornitore));
        $stmt->bindParam(":id_ordine", $this->id_ordine);
        $stmt->bindParam(":id_fornitore", $this->id_fornitore);

        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    //funzione che completa un incarico (fornitore)
    public function completeTask(){
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                  stato = 3
                  WHERE id_ordine = :id_ordine";
 
        $stmt = $this->conn->prepare($query);

        $this->id_ordine=htmlspecialchars(strip_tags($this->id_ordine));

        $stmt->bindParam(":id_ordine", $this->id_ordine);

        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    //funzione che crea un ordine
    public function create(){

        $flag = 0;
        $query = "INSERT INTO " . $this->table_name . " SET articolo=:articolo, stato = 1";
      
        $stmt = $this->conn->prepare($query);
      
        $this->articolo=htmlspecialchars(strip_tags($this->articolo));

        $stmt->bindParam(":articolo", $this->articolo);
        $stmt->execute();
        $flag = 1;

        if($flag == 1){
            return true;
        }
        else
            return false;

    }

    //funzione che ritorna l'id dell'ultimo ordine creato
    public function lastOrder(){

        $query = "SELECT id_ordine FROM " . $this->table_name . " ORDER BY id_ordine DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->ultimo_ord = $row['id_ordine'];
        }
        return true;
    }

    //funzione che crea una copia dell'ordine nella tabella articolo
    public function createArticleOrd(){

        $flag = 0;
        
        $query = "SET foreign_key_checks = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query1 = "INSERT INTO articolo SET id_ordine=:ultimo_ord, nome_articolo=:articolo, quantita = 1, taglia=:taglia";
        $stmt1 = $this->conn->prepare($query1);
        $this->ultimo_ord=htmlspecialchars(($this->ultimo_ord));
        $this->articolo=htmlspecialchars(strip_tags($this->articolo));
        $this->quantita=htmlspecialchars(strip_tags($this->quantita));
        $this->quantita=htmlspecialchars(strip_tags($this->taglia));

        $stmt1->bindParam(":ultimo_ord", $this->ultimo_ord);
        $stmt1->bindParam(":articolo", $this->articolo);
        $stmt1->bindParam(":taglia", $this->taglia);
        $stmt1->execute();

        if($stmt1){
            return true;
        }
        else
            return false;
    }

    //funzione che legge un singolo ordine
    function readOne(){

        $query = "SELECT ordine.id_ordine, ordine.articolo, fornitore.nome as 'fornitore', ordine.stato 
                  FROM ". $this->table_name . " INNER JOIN fornitore 
                    ON ordine.id_fornitore = fornitore.id_fornitore
                    WHERE ordine.id_ordine = ?";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_ordine);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($row){

            $this->id_ordine = $row['id_ordine'];
            $this->articolo = $row['articolo'];
            $this->fornitore = $row['fornitore'];
            $this->stato = $row['stato'];

        }
        else{

            $query = "SELECT ordine.id_ordine, ordine.articolo, ordine.stato 
                  FROM ". $this->table_name . " WHERE ordine.id_ordine = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id_ordine);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                $this->id_ordine = $row['id_ordine'];
                $this->articolo = $row['articolo'];
                $this->stato = $row['stato'];
            }
        }
    }
    
}

?>