<?php 
session_start();
include("_variables.php");
$balise_titre="Login";
$messageerreur="";
// Le formulaire de connection a été rempli et validé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST)) {
        $id_admin = trim(strip_tags($_POST['id_admin']));
        $mot_de_passe = MD5($_POST['mot_de_passe']);
        $db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $requete=$db->prepare('SELECT * FROM admin_eval WHERE (id_admin=:id_admin AND mot_de_passe=:mot_de_passe);');
        $requete->execute(array(':id_admin' => $id_admin, ':mot_de_passe' => $mot_de_passe));
        // Identifiant et mot de passe OK
        if( $resultat = $requete->fetch() ) {
            $_SESSION['admin'] = [  'id_admin' => $resultat['id_admin'],
                                    'mot_de_passe'=> $resultat['mot_de_passe']];
            // Redirection vers le back-office
            header('location: liste_client.php');
        } 
        // Echec de la connection
        else {
            $messageerreur="L'identifiant ou le mot de passe est incorrect.";
        }
        
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
            <form class="row p-2 pt-5" method='POST'>
            <h2 class="col-6 offset-3 text-center mb-4">Connexion</h2>
            <div class="form-group col-10 offset-1 col-md-4 offset-md-4">
                <label for="id_admin">Identifiant administrateur:</label>
                <input type="text" class="form-control" id="id_admin" name="id_admin" required>
            </div> 
            <div class="form-group col-10 offset-1 col-md-4 offset-md-4">
                <label for="mot_de_passe">Mot de passe administrateur:</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
            </div>    
            <div class="form-group col-10 offset-1 col-md-4 offset-md-4">
                <button class="btn btn-success m-auto" id="login"  name="login">Connexion</button>
            </div>
            <p class="message col-6 offset-3 text-center text-danger"><?php echo $messageerreur ?></p>
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