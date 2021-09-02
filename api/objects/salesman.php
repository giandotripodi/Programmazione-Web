<?php
class Salesman{

    private $conn;
    private $table_name = "addetto_vendita";

    public $id_addetto;
    public $id_reparto;
    public $reparto;
    public $nome;
    public $cognome;

    public function __construct($db){
        $this->conn = $db;
    }

    //funzione che legge gli addetti vendita presenti nel db
    function read(){
        $query = "SELECT addetto_vendita.id_addetto, addetto_vendita.id_reparto, reparto.nome as 'reparto', addetto_vendita.nome, addetto_vendita.cognome, addetto_vendita.email 
                  FROM " . $this->table_name . " INNER JOIN reparto ON addetto_vendita.id_reparto = reparto.id_reparto";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //funzione che legge i dati di un singolo addetto vendita
    function readOne(){

        $query = "SELECT addetto_vendita.id_addetto, addetto_vendita.id_reparto, reparto.nome as 'reparto', addetto_vendita.nome, addetto_vendita.cognome, addetto_vendita.email 
        FROM " . $this->table_name . " INNER JOIN reparto ON addetto_vendita.id_reparto = reparto.id_reparto
                    WHERE addetto_vendita.id_addetto = ?";
              
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_addetto);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){

            $this->id_addetto = $row['id_addetto'];
            $this->id_reparto = $row['id_reparto'];
            $this->reparto = $row['reparto'];
            $this->nome = $row['nome'];
            $this->cognome = $row['cognome'];
            $this->email = $row['email'];

        }
    }

    //funzione che aggiorna il reparto di un addetto vendita
    function update(){
            $query = "UPDATE " . $this->table_name . " 
                    SET
                    id_reparto = :id_reparto
                    WHERE
                    id_addetto = :id_addetto";


            $stmt = $this->conn->prepare($query);
            $this->id_reparto=htmlspecialchars($this->id_reparto);
            $this->id_addetto=htmlspecialchars($this->id_addetto);
            $stmt->bindParam(':id_reparto', $this->id_reparto);
            $stmt->bindParam(':id_addetto', $this->id_addetto);

            if($stmt->execute()){
                return true;
            }
            return false;
    }

}

?>