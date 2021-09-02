<?php
class Store{
  
    // connessione al db e nome della tabella
    private $conn;
    private $table_name = "negozio";
  
    // proprietà dell'oggetto
    public $id_negozio;
    public $id_direttore;
    public $nome;
    public $via;
    public $cap;
    public $citta;
        
  
    //costruttore con $db come connessione al database
    public function __construct($db){
        $this->conn = $db;
    }

    // funzione per leggere i dati del negozio
    function read(){
        $query ="SELECT * 
                FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare($query); //preparo la query
        $stmt->execute(); //eseguo la query
    
        return $stmt;
    }

    //funzione che aggiorna i dati del negozio
    function update(){
  
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nome =:nome,
                    via =:via,
                    cap =:cap,
                    citta =:citta
                WHERE
                    id_negozio =:id_negozio";
      
        $stmt = $this->conn->prepare($query);

        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->via=htmlspecialchars(strip_tags($this->via));
        $this->cap=htmlspecialchars(strip_tags($this->cap));
        $this->citta=htmlspecialchars(strip_tags($this->citta));
        $this->id_negozio=htmlspecialchars(strip_tags($this->id_negozio));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':via', $this->via);
        $stmt->bindParam(':cap', $this->cap);
        $stmt->bindParam(':citta', $this->citta);
        $stmt->bindParam(':id_negozio', $this->id_negozio);


        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    //funzione che legge un singolo negozio
    function readOne(){
  
        $query = "SELECT * 
        FROM " . $this->table_name . "
                    WHERE id_negozio = ?";
      
        $stmt = $this->conn->prepare( $query );
      
        $stmt->bindParam(1, $this->id_negozio);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if($row){

            $this->id_negozio = $row['id_negozio'];
            $this->nome = $row['nome'];
            $this->via = $row['via'];
            $this->cap = $row['cap'];
            $this->citta = $row['citta'];
         
            return true;
        }
        return false;
    }


          
}

?>