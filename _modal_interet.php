<div class="modal fade" id="interet" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-success">Vous êtes intéréssé(e) par ce produit ?</h3>
                <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="text-success mb-4">Laissez nous vos coordonnées:</h5>
                <form class="container-fluid" method="POST">
                    <div class="row">
                        <div class="passeid d-none">
                            <input type="text" class="form-control" name="recipient">
                        </div>
                        <div class="input-group col-12 mb-4">
                            <span class="input-group-text">Nom</span>
                            <input type="text" name="nom" class="form-control" value="<?php echo $nom_session ?>" required>
                        </div>
                        <div class="input-group col-12 mb-4">
                            <span class="input-group-text">Prénom</span>
                            <input type="text" name="prenom" class="form-control" value="<?php echo $prenom_session ?>" required>
                        </div>
                        <div class="input-group col-12 mb-4">
                            <span class="input-group-text">Adresse</span>
                            <textarea name="adresse" class="form-control" rows="6" style="resize: none;" required><?php echo $adresse_session ?></textarea>
                        </div>
                        <div class="input-group col-12 col-lg-4 mb-4">
                            <span class="input-group-text">Code postal</span>
                            <input type="number" name="code_postal" class="form-control" maxlentgh="5" min="0" value="<?php echo $code_postal_session ?>" required>
                        </div>
                        <div class="input-group col-12 col-lg-8 mb-4">
                            <span class="input-group-text">Ville</span>
                            <input type="text" name="ville" class="form-control" value="<?php echo $ville_session ?>" required>
                        </div>
                        <div class="input-group col-12 mb-4">
                            <span class="input-group-text">Téléphone</span>
                            <input type="phone" name="telephone" class="form-control" value="<?php echo $telephone_session ?>" required>
                        </div>
                        <div class="input-group col-12 mb-4">
                            <span class="input-group-text">Email</span>
                            <input type="email" name="email" class="form-control" value="<?php echo $email_session ?>" required>
                        </div>
                        <p id="prgpd" class="col-12 mb-4">
                            Dans le respect de la règlementation générale sur la protection des données, Eco'Dom s'engage à garder vos informations strictement confidentielles. Leur utilisation par notre site se limite à la gestion de notre clientèle et aux opérations associées.
                        </p>
                        <div class="input-group col-12 d-flex justify-content-end">
                            <button id="annuler" name="annuler" class="btn btn-warning mt-4 ml-2" data-dismiss="modal">Annuler</button>
                            <button id="enregistrer" name="enregistrer" class="btn btn-success mt-4 ml-2">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>