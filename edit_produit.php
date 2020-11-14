<?php 
session_start();
include("_variables.php");
$balise_titre="Produit";
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
    if ($_POST['id']==0) {   // Nouveau produit
        $requete = $db->prepare("INSERT INTO produit_eval (nom, categorie, id_categorie, details, info_tech, prix, prix_promo) VALUES (:nom, :categorie, :id_categorie, :details, :info_tech, :prix, :prix_promo)");
        $requete->execute(array(':nom' => $_POST['nom'], ':categorie' => $_POST['categorie'], ':id_categorie' => $_POST['id_categorie'], ':details' => $_POST['details'], ':info_tech' => $_POST['info_tech'], ':prix' => $_POST['prix'], ':prix_promo' => $_POST['prix_promo']));
    } 
    else { // Produit existant
        $requete = $db->prepare("UPDATE produit_eval SET nom=:nom, categorie=:categorie, id_categorie=:id_categorie, details=:details, info_tech=:info_tech, prix=:prix, prix_promo=:prix_promo WHERE (id=:id);");
        $requete->execute(array(':nom' => $_POST['nom'], ':categorie' => $_POST['categorie'], ':id_categorie' => $_POST['id_categorie'], ':details' => $_POST['details'], ':info_tech' => $_POST['info_tech'], ':prix' => $_POST['prix'], ':prix_promo' => $_POST['prix_promo'], ':id' => $_POST['id']));
    }
    header('location: liste_produit.php');
}
else { //Accès à partir de la page liste
    if(!isset($_GET['id'])) { // Vérifie qu'il ya bien un paramètre id
        $nouveau = true;
    }
    else {// on a un id
        $id = $_GET['id'];
        $db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $requete = $db->prepare("SELECT * FROM produit_eval WHERE (id=:id);");
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
            <h2 class="text-center mb-5"><?php echo $nouveau ? 'Nouveau produit' : 'Modification du produit ' . $donnees['nom']; ?></h2>
            <form class="row mb-5" method="post">
                    <input type="hidden" name="id" class="form-control" value="<?php echo $nouveau ? 0 : $donnees['id']; ?>"/>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Nom</span>
                        <input type="text" name="nom" class="form-control" value="<?php echo $nouveau ? '' : $donnees['nom']; ?>">
                    </div>
                    <div class="input-group col-10 offset-1 col-lg-6 offset-lg-3 col-xl-2 offset-xl-3 mb-4">
                        <span class="input-group-text">Id Catégorie</span>
                        <input type="number" name="id_categorie" class="form-control" maxlength="2" min="0" value="<?php echo $nouveau ? '' : $donnees['id_categorie']; ?>">
                    </div>
                    <div class="input-group col-10 offset-1 col-lg-6 offset-lg-3 col-xl-4 offset-xl-0 mb-4">
                        <span class="input-group-text">Catégorie</span>
                        <input type="text" name="categorie" class="form-control" value="<?php echo $nouveau ? '' : $donnees['categorie']; ?>">
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Détails</span>
                        <input type="text" name="details" class="form-control" value="<?php echo $nouveau ? '' : $donnees['details']; ?>">
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Infos Techniques</span>
                        <textarea name="info_tech" class="form-control" rows="6" style="resize: none;"><?php echo $nouveau ? '' : $donnees['info_tech']; ?></textarea>
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Prix</span>
                        <input type="number" name="prix" class="form-control" min="1" value="<?php echo $nouveau ? '' : $donnees['prix']; ?>"/>
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 mb-4">
                        <span class="input-group-text">Prix Promo</span>
                        <input type="number" name="prix_promo" class="form-control" min="1" value="<?php echo $nouveau ? '' : $donnees['prix_promo']; ?>"/>
                    </div>
                    <div class="input-group col-10 col-lg-6 offset-1 offset-lg-3 d-flex justify-content-end">
                        <button id="enregistrer" name="enregistrer" class="btn btn-primary mt-4 ml-2">Enregistrer</button>
                        <a href="liste_produit.php" class="btn btn-warning mt-4 ml-2">Annuler</a>
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