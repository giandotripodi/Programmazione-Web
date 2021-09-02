<?php
class Article{
  
    // connessione al db e nome della tabella
    private $conn;
    private $table_name = "articolo";
  
    // proprietà dell'oggetto
    public $id_articolo;
    public $sottocategoria;
    public $id_sottocategoria;
    public $categoria;
    public $id_categoria;
    public $reparto;
    public $id_reparto;
    public $id_ordine;
    public $nome_articolo;
    public $quantita;
    public $prezzo;
    public $taglia;
    public $data_vendita;
    public $id_mese;

    //costruttore con $db come connessione al database
    public function __construct($db){
        $this->conn = $db;
    }

    // funzione per leggere gli articoli
    function read(){
        $query ="SELECT articolo.id_articolo, articolo.nome_articolo, articolo.prezzo, articolo.taglia, reparto.id_reparto, reparto.nome as 'reparto' 
                FROM " . $this->table_name . " INNER JOIN reparto ON articolo.id_reparto = reparto.id_reparto 
                WHERE data_vendita IS NULL";
        //$query = "SELECT * FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare($query); //preparo la query
        $stmt->execute(); //eseguo la query
    
        return $stmt;
    }

    //funzione che legge gli articoli da sistemare
    function readArrange(){
        $query ="SELECT id_articolo, nome_articolo, taglia FROM articolo 
                 WHERE id_categoria IS NULL AND id_reparto IS NULL AND id_ordine IS NULL AND data_vendita IS NULL";
        //$query = "SELECT * FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare($query); //preparo la query
        $stmt->execute(); //eseguo la query
        return $stmt;
    }

    //funzione che inserisce gli articoli che hanno una sottocategoria
    function create(){

        $flag = 0;
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    id_categoria=:id_sottocategoria, id_reparto=:id_reparto,nome_articolo=:nome_articolo, quantita=1, prezzo=:prezzo, taglia=:taglia";
      
        $stmt = $this->conn->prepare($query);
      
        $this->id_categoria=htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_reparto=htmlspecialchars(strip_tags($this->id_reparto));
        $this->id_sottocategoria=htmlspecialchars(strip_tags($this->id_sottocategoria));
        $this->nome_articolo=htmlspecialchars(strip_tags($this->nome_articolo));
        $this->quantita=htmlspecialchars(strip_tags($this->quantita));
        $this->prezzo=htmlspecialchars(strip_tags($this->prezzo));
        $this->taglia=htmlspecialchars(strip_tags($this->taglia));
      
        // sostituisco i valori della query
        $stmt->bindParam(":id_sottocategoria", $this->id_sottocategoria);
        $stmt->bindParam(":id_reparto", $this->id_reparto);
        $stmt->bindParam(":nome_articolo", $this->nome_articolo);
        $stmt->bindParam(":prezzo", $this->prezzo);
        $stmt->bindParam(":taglia", $this->taglia);

        //eseguo la query
        for($x = 1; $x <= $this->quantita; $x++){
            $stmt->execute();
            $flag = 1;
        }

        if($flag == 1){
            return true;
        }
        else
            return false;

    }

    //funzione che inserisce gli articoli che non hanno una sottocategoria
    function createnocat(){
        $flag = 0;
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    id_categoria=:id_categoria, id_reparto=:id_reparto, nome_articolo=:nome_articolo, quantita=1, prezzo=:prezzo, taglia=:taglia";
      
        $stmt = $this->conn->prepare($query);
      
        $this->id_categoria=htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_reparto=htmlspecialchars(strip_tags($this->id_reparto));
        $this->nome_articolo=htmlspecialchars(strip_tags($this->nome_articolo));
        $this->quantita=htmlspecialchars(strip_tags($this->quantita));
        $this->prezzo=htmlspecialchars(strip_tags($this->prezzo));
        $this->taglia=htmlspecialchars(strip_tags($this->taglia));
      
        // sostituisco i valori della query
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":id_reparto", $this->id_reparto);
        $stmt->bindParam(":nome_articolo", $this->nome_articolo);
        $stmt->bindParam(":prezzo", $this->prezzo);
        $stmt->bindParam(":taglia", $this->taglia);

        //eseguo la query
        for($x = 1; $x <= $this->quantita; $x++){
            $stmt->execute();
            $flag = 1;
        }

        if($flag == 1){
            return true;
        }
        else
            return false;
    }
    
    //funzione che legge un singolo articolo
    function readOne(){
  
        // query to read single record
        $query = "SELECT articolo.id_articolo, articolo.nome_articolo, articolo.prezzo, articolo.taglia, reparto.id_reparto, reparto.nome as 'reparto', categoria.id_categoria, categoria.categoria, sotto_categoria.id_sottocategoria, sotto_categoria.sottocategoria 
        FROM " . $this->table_name . " INNER JOIN reparto ON articolo.id_reparto = reparto.id_reparto 
        INNER JOIN categoria ON articolo.id_categoria = categoria.id_categoria 
        INNER JOIN sotto_categoria ON categoria.id_categoria = sotto_categoria.id_sottocategoria
        WHERE articolo.id_articolo = ?";
      
        $stmt = $this->conn->prepare( $query );
        //sostituisco i valori bindati
        $stmt->bindParam(1, $this->id_articolo);
        //eseguo la query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if($row){
            $this->id_categoria = $row['id_categoria'];
            $this->categoria = $row['categoria'];
            $this->id_sottocategoria = $row['id_sottocategoria'];
            $this->sottocategoria = $row['sottocategoria'];
            $this->id_reparto = $row['id_reparto'];
            $this->reparto = $row['reparto'];
            $this->id_articolo = $row['id_articolo'];
            $this->nome_articolo = $row['nome_articolo'];
            $this->prezzo = $row['prezzo'];
            $this->taglia = $row['taglia'];
        }
        else{ //se l'articolo non possiede una sottocategoria
            $query = "SELECT articolo.id_articolo, articolo.nome_articolo, articolo.prezzo, articolo.taglia, reparto.id_reparto, reparto.nome as 'reparto', categoria.id_categoria, categoria.categoria 
            FROM " . $this->table_name . " INNER JOIN reparto ON articolo.id_reparto = reparto.id_reparto 
            INNER JOIN categoria ON articolo.id_categoria = categoria.id_categoria 
            WHERE articolo.id_articolo = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id_articolo);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_categoria = $row['id_categoria'];
            $this->categoria = $row['categoria'];
            $this->id_reparto = $row['id_reparto'];
            $this->reparto = $row['reparto'];
            $this->id_articolo = $row['id_articolo'];
            $this->nome_articolo = $row['nome_articolo'];
            $this->prezzo = $row['prezzo'];
            $this->taglia = $row['taglia'];
        }
    }

    //funzione che aggiorna un articolo
    function update(){
  
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nome_articolo = :nome_articolo,
                    prezzo = :prezzo,
                    taglia = :taglia
                WHERE
                    id_articolo = :id_articolo";
      
        $stmt = $this->conn->prepare($query);
      
        $this->nome_articolo=htmlspecialchars(strip_tags($this->nome_articolo));
        $this->prezzo=htmlspecialchars(strip_tags($this->prezzo));
        $this->taglia=htmlspecialchars(strip_tags($this->taglia));
        $this->id_articolo=htmlspecialchars(strip_tags($this->id_articolo));
        // sostiusico i valori bindati
        $stmt->bindParam(':nome_articolo', $this->nome_articolo);
        $stmt->bindParam(':prezzo', $this->prezzo);
        $stmt->bindParam(':taglia', $this->taglia);
        $stmt->bindParam(':id_articolo', $this->id_articolo);
        // eseguo la query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    //funzione che elimina un articolo
    function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id_articolo = ?";
        $stmt = $this->conn->prepare($query);
        $this->id_articolo=htmlspecialchars(strip_tags($this->id_articolo));
        $stmt->bindParam(1, $this->id_articolo);
        $stmt->execute();

        if($stmt->rowCount() != 0){
            return true;
        }
        return false;
    }
    //funzione che cerca un articolo per nome
    function search($keywords){
    
    $query = "SELECT articolo.id_articolo, articolo.nome_articolo, articolo.prezzo, articolo.taglia, reparto.nome as 'reparto'
              FROM " . $this->table_name . " INNER JOIN reparto ON articolo.id_reparto = reparto.id_reparto
              WHERE nome_articolo LIKE ?";

    $stmt = $this->conn->prepare($query);

    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
    $stmt->bindParam(1, $keywords);
    $stmt->execute();

    return $stmt;

    }
    
    /*
    public function readPaging($from_record_num, $records_per_page){
  
        // select query
        $query = "SELECT * FROM " . $this->table_name . " LIMIT ?, ?";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
      
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
      
        // execute query
        $stmt->execute();
      
        // return values from database
        return $stmt;
    }
    
    public function count(){
        
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        return $row['total_rows'];
    }*/

    //funzione che aggiorna l'articolo
    function updateArrange(){
        // update query
        $query = "UPDATE
                " . $this->table_name . "
                SET
                id_categoria = :id_sottocategoria,
                id_reparto = :id_reparto,
                prezzo = :prezzo
                WHERE
                id_articolo = :id_articolo";
  

        $stmt = $this->conn->prepare($query);

        $this->id_categoria=htmlspecialchars($this->id_categoria);
        $this->id_sottocategoria=htmlspecialchars($this->id_sottocategoria);
        $this->reparto=htmlspecialchars($this->reparto);
        $this->prezzo=htmlspecialchars($this->prezzo);
        $this->id_articolo=htmlspecialchars($this->id_articolo);

        $stmt->bindParam(':id_sottocategoria', $this->id_sottocategoria);
        $stmt->bindParam(':id_reparto', $this->id_reparto);
        $stmt->bindParam(':prezzo', $this->prezzo);
        $stmt->bindParam(':id_articolo', $this->id_articolo);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
    //funzione che aggiorna l'articolo che non possiede una sottocategoria
    function updateArrangenoCat(){

        $query = "UPDATE
                " . $this->table_name . "
                SET
                id_categoria = :id_categoria,
                id_reparto = :id_reparto,
                prezzo = :prezzo
                WHERE
                id_articolo = :id_articolo";
 
        $stmt = $this->conn->prepare($query);

        $this->id_categoria=htmlspecialchars($this->id_categoria);
        $this->reparto=htmlspecialchars($this->reparto);
        $this->prezzo=htmlspecialchars($this->prezzo);
        $this->id_articolo=htmlspecialchars($this->id_articolo);

        $stmt->bindParam(':id_categoria', $this->id_categoria);
        $stmt->bindParam(':id_reparto', $this->id_reparto);
        $stmt->bindParam(':prezzo', $this->prezzo);
        $stmt->bindParam(':id_articolo', $this->id_articolo);

        if($stmt->execute()){
            return true;
        }
        return false;
    }


}

?>