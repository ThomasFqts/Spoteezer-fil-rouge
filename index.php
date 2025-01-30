<?php
include('header.php');
$db = ConnexionBase();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['playlistsubmit'])) {
        $nomPlaylist = $_GET['nomPlaylist'];
        // Préparer et exécuter la requête SQL
        $stmt = $db->prepare("INSERT INTO playlist(name_playlist) VALUES (?)");
        $stmt->execute([$nomPlaylist]);
    }
}
?>

<!------------------------------- Boutons Main ------------------------------------------------->

<main id="partiePrincipale">

    <form action="search.php" method="GET" class="form-inline">
        <input id="barreDeRecherche" type="search" name="search" placeholder="Rechercher..." class="form-control mr-sm-2">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <article>
        <div class="colorbuton"> <!-- Boutton playlists par genre  -->
            <a href="playlist_default.php?genre=Rock">
                <button id="boutonMusiqueRock" style="width: 150px; height: 70px;">Rock</button>
            </a>
            <a href="playlist_default.php?genre=Pop">
                <button id="boutonMusiquePop" style="width: 150px; height: 70px;">PoP</button>
            </a>
            <a href="playlist_default.php?genre=Funk">
                <button id="boutonMusiqueFunk" style="width: 150px; height: 70px;">Funk</button>
            </a>
            <a href="playlist_default.php?genre=Lofi">
                <button id="boutonMusiqueLofi" style="width: 150px; height: 70px;">Lofi</button>
            </a>
            <a href="playlist_default.php?genre=Rap">
                <button id="boutonMusiqueRap" style="width: 150px; height: 70px;">Rap</button>
            </a>
            <a href="playlist_default.php?genre=RapUs">
                <button id="boutonMusiqueRapUs" style="width: 150px; height: 70px;">Rap Us</button>
            </a>
            <a href="playlist_default.php?genre=Workout">
                <button id="boutonMusiqueWorkout" style="width: 150px; height: 70px;">Workout</button>
            </a>
            <a href="playlist_default.php?genre=Dance">
                <button id="boutonMusiqueDance" style="width: 150px; height: 70px;">Dance</button>
            </a>
            <a href="playlist_default.php?genre=Electro">
                <button id="boutonMusiqueElectro" style="width: 150px; height: 70px;">Electro</button>
            </a>
        </div>
    </article>

    <!-- Liste playlists perso -->
    <h3>Vos playlists</h3>
    <article>
        <form>
            <button id="butCreer" class="Enregister" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modale"> Créer playlist </button>
        </form>
    </article>
    <section>
        <div class="modal fade" id="modale" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> Créer une playlist </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET">
                        <div class="modal-body">
                            <p>Veuillez saisir le nom que vous voulez donne à votre playlist !</p>
                            
                                <input type="text" name="nomPlaylist" id="">
                                <!-- php plus bas -->
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" name="playlistsubmit"> Créer </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php 
    $sql = $db->prepare("SELECT * FROM playlist")->fetch(PDO::FETCH_ASSOC);
    
    
    ?>


</main>

<footer>

    <article>
    </article>

    <article>
    </article>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="Script/scripts.js"></script>

</body>

</html>