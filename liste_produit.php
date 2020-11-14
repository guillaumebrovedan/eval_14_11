<?php
session_start();
include("_variables.php");
$balise_titre="Liste des produits";
// Déconnexion: Suppression de la variable admin de session
if (isset($_GET['logout']))
unset($_SESSION["admin"]);
// Admin non identifié: Redirection vers page de login
if (!isset($_SESSION['admin'])) {
    header('location: login_admin.php');
}
//Gestion de la suppression
if (isset ($_GET['del'])) {
        $idsuppr = $_GET['del'];
        $db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $requete = $db->prepare("DELETE FROM produit_eval WHERE (id=:id);");
        $requete->execute(array(':id' => $idsuppr));
}
// Affichage des produits
$db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$requete = $db->query("SELECT * FROM produit_eval;");
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
        <main>
            <div class="d-flex flex-wrap justify-content-center justify-content-md-between align-items-center">
                <div>
                    <a href="liste_client.php" class="text-success px-3">Liste des clients</a>
                    <a href="liste_produit.php" class="text-success px-3">Liste des produits</a>
                </div>
                <h4 class="text-right"><i class="fas fa-user-circle m-2"></i><?php if (isset($_SESSION['admin'])) echo $_SESSION['admin']['id_admin']; ?><a href="?logout" class="col-3 text-center text-success"><i class="fas fa-sign-out-alt mr-2"></i>Déconnexion</a></h4>
            </div>
            <h2 class="text-center"><?php echo $balise_titre ?></h2>
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-success text-white">
                        <tr class="text-center">
                            <th class="align-middle">Id</th>
                            <th class="align-middle">Nom</th>
                            <th class="align-middle">Catégorie</th>
                            <th class="align-middle">Id Catégorie</th>
                            <th class="align-middle">Détails</th>
                            <th class="align-middle">Informations techniques</th>
                            <th class="align-middle">Prix</th>
                            <th class="align-middle">Prix promo</th>
                            <th class="align-middle"><a class="btn btn-warning" href="edit_produit.php"><i class="fas fa-plus-circle mr-2"></i>Ajouter un produit</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($ligne = $requete->fetch()) { ?>
                        <tr class="rangee text-center">
                            <td class="align-middle"><?php echo $ligne['id']; ?></td>
                            <td class="align-middle"><?php echo $ligne['nom']; ?></td>
                            <td class="align-middle"><?php echo $ligne['categorie']; ?></td>
                            <td class="align-middle"><?php echo $ligne['id_categorie']; ?></td>
                            <td class="align-middle"><?php echo $ligne['details']; ?></td>
                            <td class="align-middle"><?php echo $ligne['info_tech']; ?></td>
                            <td class="align-middle"><?php echo $ligne['prix'] . ' '; ?>€</td>
                            <td class="align-middle"><?php echo $ligne['prix_promo']; ?></td>
                            <td class="align-middle">
                                <a href="edit_produit.php?id=<?php echo $ligne['id']; ?>" class="btn btn-primary"><i class="fas fa-pen-fancy"></i> Modifier</a>
                                <a href="?del=<?php echo $ligne['id']; ?>" class="btn btn-danger" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce produit ? <?php echo $ligne['nom']; ?> ' ))"><i class="fas fa-trash-alt"></i> Supprimer</a>
                            </td>
                        </tr>
                        <?php }
                        ?>  
                    </tbody>
                </table>
            </div>
        </main>
		<?php 
		include("_footer.php");
		?>
		<?php 
		include("_scripts.php");
        ?>
    </body>
</html>