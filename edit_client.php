<?php 
session_start();
include("_variables.php");
$balise_titre="Client";
// Déconnexion: Suppression de la variable admin de session
if (isset($_GET['logout']))
unset($_SESSION["admin"]);
// Admin non identifié: Redirection vers page de login
if (!isset($_SESSION['admin'])) {
    header('location: login_admin.php');
}
$nouveau = false;   // Par defaut : modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    if ($_POST['id']==0) {   // Nouveau client
        $requete = $db->prepare("INSERT INTO client_eval (nom, prenom, adresse, code_postal, ville, telephone, email) VALUES (:nom, :prenom, :adresse, :code_postal, :ville, :telephone, :email)");
        $requete->execute(array(':nom' => $_POST['nom'], ':prenom' => $_POST['prenom'], ':adresse' => $_POST['adresse'], ':code_postal' => $_POST['code_postal'], ':ville' => $_POST['ville'], ':telephone' => $_POST['telephone'], ':email' => $_POST['email']));
    } 
    else { // Client existant
        $requete = $db->prepare("UPDATE client_eval SET nom=:nom, prenom=:prenom, adresse=:adresse, code_postal=:code_postal, ville=:ville, telephone=:telephone, email=:email WHERE (id=:id);");
        $requete->execute(array(':nom' => $_POST['nom'], ':prenom' => $_POST['prenom'], ':adresse' => $_POST['adresse'], ':code_postal' => $_POST['code_postal'], ':ville' => $_POST['ville'], ':telephone' => $_POST['telephone'], ':email' => $_POST['email'], ':id' => $_POST['id']));
    }
    header('location: liste_client.php');
}
else { //Accès à partir de la page liste
    if(!isset($_GET['id'])) { // Vérifie qu'il ya bien un paramètre id
        $nouveau = true;
    }
    else {// on a un id
        $id = $_GET['id'];
        $db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $requete = $db->prepare("SELECT * FROM client_eval WHERE (id=:id);");
        $requete->execute(array(':id' => $id));
        if ($requete->rowCount()==0)
                die("Pas d'enregistrement avec id = " . $id);
            $donnees = $requete->fetch();   
        }
    }
?>
<!doctype html>
<html lang="fr">
	<?php 
	include("_head.php");
	?>
	<body>
		<?php 
		include("_header.php");
		?>
		<?php 
		include("_navbar.php");
        ?>
        <main class="container-fluid">
            <div class="d-flex flex-wrap justify-content-center justify-content-md-between align-items-center">
                <div>
                    <a href="liste_client.php" class="text-success px-3">Liste des clients</a>
                    <a href="liste_produit.php" class="text-success px-3">Liste des produits</a>
                </div>
                <h4 class="text-right"><i class="fas fa-user-circle m-2"></i><?php if (isset($_SESSION['admin'])) echo $_SESSION['admin']['id_admin']; ?><a href="?logout" class="col-3 text-center text-success"><i class="fas fa-sign-out-alt mr-2"></i>Déconnexion</a></h4>
            </div>
            <h2 class="text-center mb-5"><?php echo $nouveau ? 'Nouveau client' : 'Modification du client ' . $donnees['prenom'] . " " . $donnees['nom']; ?></h2>
            <form class="row mb-5" method="post">
                    <input type="hidden" name="id" class="form-control" value="<?php echo $nouveau ? 0 : $donnees['id']; ?>"/>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Nom</span>
                        <input type="text" name="nom" class="form-control" value="<?php echo $nouveau ? '' : $donnees['nom']; ?>">
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Prénom</span>
                        <input type="text" name="prenom" class="form-control" value="<?php echo $nouveau ? '' : $donnees['prenom']; ?>">
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Adresse</span>
                        <textarea name="adresse" class="form-control" rows="6" style="resize: none;"><?php echo $nouveau ? '' : $donnees['adresse']; ?></textarea>
                    </div>
                    <div class="input-group col-10 offset-1 col-lg-6 offset-lg-3 col-xl-2 offset-xl-3 mb-4">
                        <span class="input-group-text">Code postal</span>
                        <input type="number" name="code_postal" class="form-control" maxlength="5" min="0" value="<?php echo $nouveau ? '' : $donnees['code_postal']; ?>">
                    </div>
                    <div class="input-group col-10 offset-1 col-lg-6 offset-lg-3 col-xl-4 offset-xl-0 mb-4">
                        <span class="input-group-text">Ville</span>
                        <input type="text" name="ville" class="form-control" value="<?php echo $nouveau ? '' : $donnees['ville']; ?>">
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Téléphone</span>
                        <input type="phone" name="telephone" class="form-control" value="<?php echo $nouveau ? '' : $donnees['telephone']; ?>"/>
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Email</span>
                        <input type="email" name="email" class="form-control" value="<?php echo $nouveau ? '' : $donnees['email']; ?>"/>
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 d-flex justify-content-end">
                        <button id="enregistrer" name="enregistrer" class="btn btn-primary mt-4 ml-2">Enregistrer</button>
                        <a href="liste_client.php" class="btn btn-warning mt-4 ml-2">Annuler</a>
                    </div>
            </form>
        </main>
		<?php 
		include("_footer.php");
		?>
		<?php 
		include("_scripts.php");
        ?>
    </body>
</html>