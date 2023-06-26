<?php

//on inclut le fichier qui fera connecter cette page à noter bdd:
//include('/config/bd_connect.php');

//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost','root','Aness_Zg','travelloo');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}   


// Récupérer l'identifiant de la ville depuis l'URL
$idVille = $_GET['id'];

// Effectuer une requête pour récupérer les informations de la ville spécifiée
$sql = "SELECT ville.nomvil, pays.nompay, ville.descvil, gare.nomnec AS gare, hotel.nomnec AS hotel, aeroport.nomnec AS aeroport, site.cheminphoto
        FROM ville
        INNER JOIN necessaire AS gare ON ville.idvil = gare.idvil AND gare.typenec = 'gare'
        INNER JOIN necessaire AS hotel ON ville.idvil = hotel.idvil AND hotel.typenec = 'hotel'
        INNER JOIN necessaire AS aeroport ON ville.idvil = aeroport.idvil AND aeroport.typenec = 'aeroport'
        INNER JOIN pays ON ville.idpay = pays.idpay
        LEFT JOIN site ON ville.idvil = site.idvil
        WHERE ville.idvil = $idVille";
$result = mysqli_query($conn, $sql);

// Vérifier si la requête a renvoyé des résultats
if (mysqli_num_rows($result) > 0) {
    $ville = mysqli_fetch_assoc($result);
    $cheminphoto = $ville['cheminphoto'];
} else {
    // echo "Ville non trouvée.";
}


// Fermer le résultat de la requête
mysqli_free_result($result);

// Fermer la connexion à la base de données
mysqli_close($conn);
?>












<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Acceuil</title>
    <link rel="stylesheet" href="style.css" />
</head>
<!---on fait appel a header.php pour faire afficher le header--->
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
<section class="ville-info">
    <div class="ville-details">
        <h2>Informations sur la ville</h2>
        <div class="details">
            <h3>Nom de la ville : <?php echo htmlspecialchars($ville['nomvil']); ?></h3>
            <h4>Pays : <?php echo htmlspecialchars($ville['nompay']); ?></h4>
            <p>Description : <?php echo htmlspecialchars($ville['descvil']); ?></p>
            <p>Gare : <?php echo htmlspecialchars($ville['gare']); ?></p>
            <p>Hôtel : <?php echo htmlspecialchars($ville['hotel']); ?></p>
            <p>Aéroport : <?php echo htmlspecialchars($ville['aeroport']); ?></p>
        </div>
        <?php if (!empty($cheminphoto)): ?>
        <div class="image">
            <img src="<?php echo htmlspecialchars ($cheminphoto); ?>" alt="image de la ville">
        </div>
        <?php endif; ?>
    </div>
    <div class="actions">
        <a href="modifier.php?id=<?php echo $idVille; ?>">Modifier</a>
        <a href="supprimer.php?id=<?php echo $idVille; ?>">Supprimer</a>
    </div>
</section>
<script src="./index.js"></script>
</body>

</html>