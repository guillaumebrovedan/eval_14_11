<script>
    /////////////// modal pré-rempli//////////////////
    $('#interet').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var recipient = button.data('id')
    var modal = $(this)
    modal.find('.passeid input').val(recipient)
    });
    ////// opacité arrivée sur la page d'accueil/////
    setTimeout(function () {
    $("body").css("opacity", "1");
    }, 100);
    // ajout de la classe active sur le lien du nav
    $("#"+titre).addClass("active");
    ////// modal rgpd cookies/////
    <?php if (!isset($_SESSION['user'])) { ?>
        setTimeout(function () {
            $('#cookies').modal('show');
        }, 3000);
    <?php } 
    $_SESSION['user'] = ['newuser' => "newuser"];
    ?>
</script>