<?php 
session_start();
include("_variables.php");
$balise_titre="Eolien";
$balise_meta="Eco'Dom vous propose toute une gamme de matériels éolien. Le vent est une ressource inépuisable et les éoliennes ont un impact environnemental minimum. Alors n'attendez plus et découvrez nos offres !";
include("_gestion_back.php");
?>
<!doctype html>
<html lang="fr">
	<?php 
	include("_head.php");
	?>
	<body>
        <script>
            // création d'une balise titre pour ajouter la classe active sur le lien du nav
            var titre = "<?php echo $balise_titre ?>";
        </script>
		<?php 
		include("_header.php");
		include("_navbar.php");
        ?>
        <main class="p-0">
            <section class="container-fluid p-0">
                <div class="card-deck row row-cols-1 col-10 row-cols-md-2 col-md-12 row-cols-xl-3 m-auto">
                    <?php
                    $db= new PDO("mysql:host=".HOST.";dbname=".BDD.";charset=utf8mb4", USER, PASSW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    $requete = $db->prepare("SELECT * FROM produit_eval WHERE id_categorie=2 ORDER BY prix ASC");
                    $requete->execute();
                    while($ligne = $requete->fetch()) {
                    ?>
                    <div class="col my-3">
                        <div class="card cardanim h-100 text-white">
                            <img src="images/<?php echo $ligne['categorie'];?>.jpg" class="img-fluid p-3 pt-4 bg-success" alt="image du produit">
                            <div class="card-header bg-success border-0">
                            <h3 class=""><?php echo $ligne['nom'];?></h3>
                            </div>
                            <div class="card-body bg-success border-0">
                            <p class="mb-3 p-3 text-center"><?php echo $ligne['details'];?></p>
                            </div>
                            <div class="card-footer bg-success d-flex flex-wrap justify-content-between border-0">
                                <button class="btn btn-warning" data-toggle="modal" data-target="#interet" data-id="<?php echo $ligne['id'];?>"><i class="fas fa-plus-circle px-2"></i>Ajouter à ma liste de souhaits</button>
                                <h4><?php echo $ligne['prix'];?> €</h4>    
                            </div>
                        </div>  
                    </div>
                    <?php
                    };?>
                </div>
            </section>
        </main>
        <?php
        include("_modal_interet.php");
		include("_modal_cookies.php");
		include("_footer.php");
		include("_scripts.php");
		include("_script_perso.php");
        ?>
    </body>
</html>