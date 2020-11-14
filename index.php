<?php 
session_start();
include("_variables.php");
$balise_titre="Accueil";
$balise_meta="Eco'Dom c'est la référence vendeur de matériel de production d'énergie renouvelables, pour les professionnels et les particuliers. VDécouvrez nos offres et participez à la sauvegarde de notre planète !";
include("_gestion_back.php")
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
                    $requete = $db->prepare("SELECT * FROM produit_eval ORDER BY RAND()");
                    $requete->execute();
                    $affmax=0;
                    while(($ligne = $requete->fetch()) && ($nb<3)) {
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
                    <?php $nb ++;
                    };?>
                </div>
            </section>
            <section class="container-fluid p-0">
                <div class="row m-0">
                    <div class="col-12 col-md-4 p-0 mb-5">
                        <img src="images/imgpresentation.jpg" class="img-fluid" alt="image de présentation">
                    </div>
                    <div class="col-12 col-md-8 p-0 mb-5">
                        <h2 class="text-success my-4">Eco'Dom</h2>
                        <h4 class="text-success">Qui sommes nous</h4>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis, vitae? Maiores asperiores, exercitationem similique ratione qui illo ad dolor tempora porro eum. Neque doloribus labore nulla suscipit magnam maiores totam?</p>
                        <h4 class="text-success">Nos engagements</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis fuga ab totam eius accusantium deserunt, beatae dicta molestias pariatur saepe explicabo temporibus natus autem iure ad et nihil enim nisi.</p>
                        <h4 class="text-success">Notre philosophie</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quis dolore veritatis aperiam impedit numquam asperiores provident unde, id non recusandae iure harum doloribus voluptates officiis, accusantium sed totam quibusdam?</p>
                    </div>
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