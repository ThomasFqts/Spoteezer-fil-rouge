<?php
include('header.php');
$db = ConnexionBase(); // Connexion à la base de données

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userType = $_SESSION['user_type'];

    // Récupére les playlists de l'utilisateur connecté
    $stmt = $db->prepare("SELECT * FROM playlist p JOIN playlist_users pu ON p.id_playlist = pu.id_playlist WHERE pu.id_user = ?");
    $stmt->execute([$userId]);
    $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Limite pour les utilisateurs "Free"
    $maxPlaylistsFree = 5;
    $canCreatePlaylist = ($userType !== 'Free') || (count($playlists) < $maxPlaylistsFree);
} else {
    $playlists = [];
    $canCreatePlaylist = false;
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['playlistsubmit']) && $canCreatePlaylist) {
        $nomPlaylist = $_GET['nomPlaylist'];
        // Préparer et exécuter la requête SQL
        $stmt = $db->prepare("INSERT INTO playlist(name_playlist) VALUES (?)"); // Variable qui contient la préparation de la requête SQL
        $stmt->execute([$nomPlaylist]);
        $playlistId = $db->lastInsertId();
        // Associer la playlist à l'utilisateur connecté
        $stmt = $db->prepare("INSERT INTO playlist_users(id_user, id_playlist) VALUES (?, ?)");
        $stmt->execute([$userId, $playlistId]);
        header("Location: page_playlist.php?name_playlist=$nomPlaylist");
    }
}
?>

<!------------------------------- Boutons Main ------------------------------------------------->

<main id="partiePrincipale">

    <form action="search.php" method="GET" class="form-inline">
        <input id="barreDeRecherche" type="search" name="search" placeholder="Rechercher..." class="form-control mr-sm-2">
        <input type="hidden" name="recherche_music" value="Rechercher">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <article>
        <div class="colorbuton"> <!-- Bouttons playlist par genre  -->
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
    <?php if (isset($_SESSION['user_id'])): ?>
        <h3>Vos playlists</h3>
        <article>
            <form>
                <?php if ($canCreatePlaylist): ?>
                    <button id="butCreer" class="Enregister" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modale"> Créer playlist </button>
                <?php else: ?>
                    <p>Vous avez atteint la limite de playlists pour votre abonnement</p>
                <?php endif ?>
            </form>
        </article>
        <section> <!-- Modale pour création de playlist -->
            <div class="modal fade" id="modale" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 phrase_modal_playlist" id="exampleModalLabel"> Créer une playlist </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="GET">
                            <div class="modal-body">
                                <p class="phrase_modal_playlist">Veuillez saisir le nom que vous voulez donner à votre playlist :</p>

                                <input type="text" name="nomPlaylist" id="">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Fermer </button>
                                <button type="submit" class="btn btn-primary" name="playlistsubmit"> Créer </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <article>
            <?php foreach ($playlists as $playlist): ?> <!-- Entrée dans la boucle pour sortir les playlists-->
                <a href="page_playlist.php?name_playlist=<?= $playlist['name_playlist'] ?>" class="btn btn-primary me-2"><?= $playlist['name_playlist'] ?></a>
            <?php endforeach ?> <!-- Sortie de la boucle -->
        </article>
    <?php endif ?>

</main>

<footer>
    <h3>Artiste du moment</h3>

    <article>
    </article>

    <article>
    </article>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="Script/scripts.js"></script>

</body>
</html>