<?php
// Si le formulaire du modal a été posté
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // création ou mise à jour de la session
    $_SESSION['auth'] = [   'nom'=> trim(strip_tags($_POST['nom'])),
                            'prenom'=> trim(strip_tags($_POST['prenom'])),
                            'adresse'=> trim(strip_tags($_POST['adresse'])),
                            'code_postal'=> trim(strip_tags($_POST['code_postal'])),
                            'ville'=> trim(strip_tags($_POST['ville'])),
                            'telephone'=> trim(strip_tags($_POST['telephone'])),
                            'email'=> trim(strip_tags($_POST['email']))
                        ];
    if (isset($_POST)) {
        // récupération de l'id produit dans le champ invisible du modal
        $produit = $_POST['recipient'];
        // récupération des variables telephone et email
        $telephone =trim(strip_tags($_POST['telephone']));
        $email = trim(strip_tags($_POST['email']));
        // vérification de l'existance de l'utilisateur
        $db = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $requete=$db->prepare('SELECT id FROM client_eval WHERE (email=:email AND telephone=:telephone);');
        $requete->execute(array(':email' => $email, ':telephone' => $telephone));
        $donnees = $requete->fetch();
        $idexist=$donnees['id'];
        if($requete->rowCount()!=0) { // utilisateur existant
            //vérification si association utilisateur produit déjà existants dans la table souhaits
            $dbverif = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $requeteverif=$db->prepare('SELECT * FROM interet_eval WHERE (id_client=:id_client AND id_produit=:id_produit);');
            $requeteverif->execute(array(':id_client' => $idexist, ':id_produit' => $produit));
            if($requeteverif->rowCount()==0) { //aucune association existante
                // création d'une entrée dans la table interet avec l'id client existant
                $db = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $requete=$db->prepare('INSERT INTO interet_eval (id_client, id_produit) VALUES (:id_client, :id_produit)');
                $requete->execute(array(':id_client' => $idexist, ':id_produit' => $produit));
            }
        }
        else { // nouvel utilisateur
            // création de l'utilisateur dans la table client
            $nom = trim(strip_tags($_POST['nom']));
            $prenom = trim(strip_tags($_POST['prenom']));
            $adresse = trim(strip_tags($_POST['adresse']));
            $code_postal = trim(strip_tags($_POST['code_postal']));
            $ville = trim(strip_tags($_POST['ville']));
            $db = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $requete=$db->prepare('INSERT INTO client_eval (nom, prenom, adresse, code_postal, ville, telephone, email) VALUES (:nom, :prenom, :adresse, :code_postal, :ville, :telephone, :email)');
            $requete->execute(array(':nom' => $nom, ':prenom' => $prenom, ':adresse' => $adresse, ':code_postal' => $code_postal, ':ville' => $ville, ':telephone' => $telephone, ':email' => $email));
            // récupération de l'id de ce nouvel utilisateur
            $db = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $requete=$db->prepare('SELECT id FROM client_eval WHERE (email=:email AND telephone=:telephone);');
            $requete->execute(array(':email' => $email, ':telephone' => $telephone));
            $donnees = $requete->fetch();
            $idnouv=$donnees['id'];
            //vérification si association utilisateur produit déjà existants dans la table souhaits
            $dbverif = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $requeteverif=$db->prepare('SELECT * FROM interet_eval WHERE (id_client=:id_client AND id_produit=:id_produit);');
            $requeteverif->execute(array(':id_client' => $idnouv, ':id_produit' => $produit));
            if($requeteverif->rowCount()==0) { //aucune association existante
                // création d'une entrée dans la table interet avec le nouvel id client
                $db = new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $requete=$db->prepare('INSERT INTO interet_eval (id_client, id_produit) VALUES (:id_client, :id_produit)');
                $requete->execute(array(':id_client' => $idnouv, ':id_produit' => $produit));
            }
        }
    }
}
// création des variables pour préremplissage du formulaire si une session existe
if(isset($_SESSION['auth'])){
    $nom_session = $_SESSION['auth']['nom'];
    $prenom_session = $_SESSION['auth']['prenom'];
    $adresse_session = $_SESSION['auth']['adresse'];
    $code_postal_session = $_SESSION['auth']['code_postal'];
    $ville_session = $_SESSION['auth']['ville'];
    $telephone_session = $_SESSION['auth']['telephone'];
    $email_session = $_SESSION['auth']['email'];
} 
else {
    $nom_session = "";
    $prenom_session = "";
    $adresse_session = "";
    $code_postal_session = "";
    $ville_session = "";
    $telephone_session = "";
    $email_session = "";
}
?>