<?php
//on inclut le fichier qui fera connecter cette page à noter bdd:
//include('/config/bd_connect.php');

//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost', 'root', 'Aness_Zg', 'travelloo');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if (!$conn) {
    echo 'connection error: ' . mysqli_connect_error();
}


// Vérifier si le formulaire de recherche a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les valeurs des champs de recherche
    $continent = $_POST['continent'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $site = $_POST['site'];

    // Construire la requête SQL de recherche en fonction des champs remplis
    $sql = "SELECT ville.idvil, ville.nomvil, pays.nompay FROM ville
        INNER JOIN pays ON ville.idpay = pays.idpay";


    // Ajouter les conditions de recherche en fonction des champs remplis
    if (!empty($continent)) {
        $sql .= " INNER JOIN continent ON pays.idcon = continent.idcon
                  WHERE continent.nomcon like '%$continent%'";
    }

    if (!empty($pays)) {
        $sql .= " AND pays.nompay like '%$pays%'";
    }


    if (!empty($ville)) {
        $sql .= " AND ville.nomvil like '%$ville%'";
    }

    if (!empty($site)) {
        $sql .= " INNER JOIN site ON ville.idvil = site.idvil
              WHERE site.nomsit LIKE '%$site%'";
    }

    // Exécuter la requête SQL
    $result = mysqli_query($conn, $sql);

    // Vérifier si la requête a renvoyé des résultats
    if (mysqli_num_rows($result) > 0) {
        // Récupérer les résultats sous forme de tableau associatif
        $villes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Aucune ville trouvée
        $villes = [];
    }
    //avoir les resultats comme array
    // $villes = mysqli_fetch_all($result,MYSQLI_ASSOC);

    // Libérer la mémoire du résultat
    mysqli_free_result($result);
}



// Suppression d'une ville
if (isset($_POST['delete'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete']);

    // Suppression des nécessaires en rapport avec la ville
    $sql = "DELETE FROM necessaire WHERE idvil = $id";
    mysqli_query($conn, $sql);

    // Suppression des sites en rapport avec la ville
    $sql = "DELETE FROM site WHERE idvil = $id";
    mysqli_query($conn, $sql);

    // Suppression de la ville
    $sql = "DELETE FROM ville WHERE idvil = $id";
    mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {
        // La suppression a réussi, rediriger vers la page d'accueil
        header('Location: home.php');
    } else {
        // En cas d'erreur, afficher un message d'erreur
        echo 'Erreur de suppression : ' . mysqli_error($conn);
    }
}


















// Fermer la connexion à la base de données
mysqli_close($conn);





?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav>
        <h2>Etudiants</h2>
        <hr>
        <div class="boutons">
            <input type="button" value="1" class="btn1">
            <input type="button" value="2" class="btn2">
        </div>
        <div class="etudiant-infos">
            <div class="info-bloc">
                <h3> <span>Nom</span> <br> <span class="nom">Zereg</span> </h3>
                <h3><span>Prénom</span> <br> <span class="prenom">Aness</span></h3>
            </div>
            <div class="info-bloc">
                <h3><span>Matricule</span> <br><span class="matricule"></span> </h3>
            </div>
            <div class="info-bloc">
                <h3><span>Spécialité</span><br> <span>L2 informatique</span></h3>
                <h3 class="groupe-pere"><span>Groupe</span> <br> <span class="groupe">4</span></h3>
            </div>
            <div class="info-bloc">
                <h3><span>Email</span> <br><a href="mailto:ramzybelaiboud@gmail.com"
                        class="mail">anesszereg1@gmail.com</a> </h3>
            </div>

            </h3>

            <hr>
        </div>
        <a href="./ajout.php" class="btn-ville">Ajouter une Ville</a>
    </nav>
    <div class="rigth">
        <header>
            <h1> Travelloo</h1>
        </header>

        <section class="partie-home">

            <div class="recherche-bloc">
                <h2>Dites nous ou vous voulez aller !</h2>
                <form action="home.php" method="POST">
                    <div class="part">
                        <div>
                            <label for="continent">Continent</label>
                            <input type="text" name="continent">
                        </div>
                        <div>
                            <label for="pays">Pays</label>
                            <input type="text" name="pays">
                        </div>
                    </div>
                    <div class="part">
                        <div>
                            <label for="ville">Ville</label>
                            <input type="text" name="ville">
                        </div>
                        <div>
                            <label for="site">Site</label>
                            <input type="text" name="site">
                        </div>
                    </div>
                    <button type="submit" value="submit" name=submit>Rechercher</button>

                </form>
            </div>
            <div class="resultat">
                <div class="affichage">
                    <h2>Villes trouvées</h2>
                    <div class="affichage-ville">
                        <?php if (!empty($villes)): ?>
                            <?php foreach ($villes as $ville): ?>
                                <div class="ville">
                                    <div class="ecriture">
                                        <h3> <a href="ville.php?id=<?php echo $ville['idvil'] ?> ">
                                                <?php echo htmlspecialchars($ville['nomvil']); ?>
                                            </a>
                                        </h3>
                                        <hr>
                                        <h5>
                                            <?php echo htmlspecialchars($ville['nompay']); ?>
                                        </h5>
                                    </div>
                                    <div class="icones">
                                        <img src="./btn-modifier.png" alt="modifier-btn">
                                        <form method="POST" class="delete-form">
                                            <input type="hidden" name="delete" value="<?php echo $ville['idvil']; ?>">
                                            <button type="submit" class="delete-btn"><img src="./delete-button.svg"
                                                    alt="supprimer-btn"></button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune ville trouvée.</p>
                        <?php endif; ?>
                    </div>

                </div>


            </div>
        </section>
    </div>

</body>

</html>