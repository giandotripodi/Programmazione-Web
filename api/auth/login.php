<?php
header("Access-Control-Allow-Origin: http://localhost/prog3/api/auth");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/user.php';

include_once '../config/core.php';
include_once '../jwt/BeforeValidException.php';
include_once '../jwt/ExpiredException.php';
include_once '../jwt/SignatureInvalidException.php';
include_once '../jwt/JWT.php';
use \Firebase\JWT\JWT;
 
// connessione al database
$database = new Database();
$db = $database->getConnection();
 
// istanzio oggetto user
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
$email_exists = $user->emailExists();
$password = md5($data->password);

if($email_exists && $password == $user->password){
    if($user->ruolo == "direttore"){
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id_direttore" => $user->id_direttore,
                "id_negozio" => $user->id_negozio,
                "nome" => $user->nome,
                "cognome" => $user->cognome,
                "email" => $user->email,
                "ruolo" => $user->ruolo
            )
        );
    }
    elseif($user->ruolo == "addetto vendita"){
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id_addetto" => $user->id_addetto,
                "id_reparto" => $user->id_reparto,
                "nome" => $user->nome,
                "cognome" => $user->cognome,
                "email" => $user->email,
                "ruolo" => $user->ruolo
            )
        );
    }
    elseif($user->ruolo == "magazziniere"){
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id_magazziniere" => $user->id_magazziniere,
                "id_negozio" => $user->id_negozio,
                "nome" => $user->nome,
                "cognome" => $user->cognome,
                "email" => $user->email,
                "ruolo" => $user->ruolo
            )
        );
    }
    else{
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id_fornitore" => $user->id_fornitore,
                "nome" => $user->nome,
                "email" => $user->email,
                "ruolo" => $user->ruolo
            )
        );
    }

    http_response_code(200);

    //genero jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
        array(
            "messagge" => "Login riuscito.",
            "jwt" => $jwt,
            "token" => $token
        )
    );
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Login fallito"));
}
?>
