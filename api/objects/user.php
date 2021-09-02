<?php

class User {

    private $conn;
    
    public $email;
    public $password;
    public $nome;
    public $cognome;
    
    //addetto
    public $id_addetto;
    public $id_reparto;
    
    //fornitore
    public $id_fornitore;

    //magazziniere
    public $id_magazziniere;
    public $id_negozio;

    //direttore
    public $id_direttore;

    public $ruolo;

    public function __construct($db){
        $this->conn = $db;
    }
    
    //funzione che verifica se la mail esiste nel db
    function emailExists(){

        $email=htmlspecialchars(strip_tags($this->email));
        $sql = "SELECT * FROM direttore WHERE email LIKE ?";
        $stmt = $this->conn->prepare( $sql );
        $this->email=htmlspecialchars(strip_tags($this->email));
 
        $stmt->bindParam(1, $this->email);
 
        $stmt->execute();
 
        $num = $stmt->rowCount();
        if($num>0){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id_direttore = $row['id_direttore'];
            $this->id_negozio = $row['id_negozio'];
            $this->nome = $row['nome'];
            $this->cognome = $row['cognome'];
            $this->email = $row['email'];
            $this->password = $row['pass'];
            $this->ruolo = "direttore";
            return true;

        }

        $sql = "SELECT addetto_vendita.id_addetto, addetto_vendita.id_reparto, addetto_vendita.nome, addetto_vendita.cognome, addetto_vendita.email, addetto_vendita.pass
                FROM addetto_vendita WHERE addetto_vendita.email = ?";
        $stmt = $this->conn->prepare( $sql );
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num>0){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id_addetto = $row['id_addetto'];
            $this->id_reparto = $row['id_reparto'];
            $this->nome = $row['nome'];
            $this->cognome = $row['cognome'];
            $this->email = $row['email'];
            $this->password = $row['pass'];
            $this->ruolo = "addetto vendita";
            return true;

        }

        $sql = "SELECT magazziniere.id_magazziniere, magazziniere.id_negozio, magazziniere.nome, magazziniere.cognome, magazziniere.email, magazziniere.pass
                FROM magazziniere WHERE magazziniere.email = ?";
        $stmt = $this->conn->prepare( $sql );
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num>0){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id_magazziniere = $row['id_magazziniere'];
            $this->id_negozio = $row['id_negozio'];
            $this->nome = $row['nome'];
            $this->cognome = $row['cognome'];
            $this->email = $row['email'];
            $this->password = $row['pass'];
            $this->ruolo = "magazziniere";
            return true;

        }

        $sql = "SELECT fornitore.id_fornitore, fornitore.nome, fornitore.email, fornitore.pass 
                FROM fornitore WHERE fornitore.email = ?";
        $stmt = $this->conn->prepare( $sql );
        $stmt->bindParam(1, $this->email );
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num>0){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id_fornitore = $row['id_fornitore'];
            $this->nome = $row['nome'];
            $this->email = $row['email'];
            $this->password = $row['pass'];
            $this->ruolo = "fornitore";
            return true;
        }

    return false;

    }
}
?>