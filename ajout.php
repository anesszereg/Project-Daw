<?php
//on inclut le fichier qui fera connecter cette page à noter bdd:
//include('/config/bd_connect.php');

//on se connecte à notre base de donnée en insérant le host,le nom d'utilisateur le mot de passe ainsi que le nom de notre databse dans cet ordre
$conn = mysqli_connect('localhost', 'root', 'Aness_Zg', 'travelloo');

//Par la suite on verifie si l'on s'est bien connecté à la DB:
if (!$conn) {
    echo 'connection error: ' . mysqli_connect_error();
}




//on initialise nos vars dabs lesquels on recupere les données de l'utilisateur:
$ville = $description = $continent = $pays = $hotel = $gare = $aeroport = $resto = $nomsit = $photo = '';



//on fait un tableau dans lequel on stocke les erreurs si existantes:
$errors = array('ville' => '', 'description' => '', 'continent' => '', 'pays' => '', 'hotel' => '', 'gare' => '', 'resto' => '', 'aeroport' => '', 'nomsit' => '', 'photo' => '');



//ajout nouveau pays:


$nompays = $nomcontinent = '';
$errorss = array(
    'nompays' => '',
    'nomcontinent' => '',
);

if (isset($_POST['submitpays'])) {
    if (empty($_POST['nompays'])) {
        $errorss['nompays'] = "Entrez un nom de pays <br/>";
    } else {
        $nompays = $_POST['nompays'];
    }

    if (empty($_POST['nomcontinent'])) {
        $errorss['nomcontinent'] = "Entrez un nom de continent <br/>";
    } else {
        $nomcontinent = $_POST['nomcontinent'];
    }

    if (!array_filter($errorss)) {
        $nompays = mysqli_real_escape_string($conn, $_POST['nompays']);
        $nomcontinent = mysqli_real_escape_string($conn, $_POST['nomcontinent']);

        $idconn = "SELECT idcon FROM continent WHERE nomcon = '$nomcontinent';";

        $result = mysqli_query($conn, $idconn);
        if ($result) {
            $voyage = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $a = $voyage[0]['idcon'];

            // Insérer les données dans la table pays
            $insertQuery = "INSERT INTO pays (nompay, idcon) VALUES ('$nompays', '$a');";
            $insertResult = mysqli_query($conn, $insertQuery);
            if ($insertResult) {
                // Redirection vers la page souhaitée après l'insertion réussie
                header('Location: ajout.php');
                exit;
            } else {
                echo "Erreur lors de l'insertion des données : " . mysqli_error($conn);
            }
        } else {
            echo "Erreur lors de la récupération de l'ID du continent : " . mysqli_error($conn);
        }
    }
}















//ici on va verifier apres un click sur submit si les valeurs ont bien été tous insérés et avec le bon format pour chacun:

if (isset($_POST['submit'])) {

    //On verifie la ville:
    if (empty($_POST['ville'])) {

        $errors['ville'] = "Veuillez insérer une ville! ";
    } else {
        $ville = htmlspecialchars($_POST['ville']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $ville)) {
            $errors['ville'] = "Veuillez insérer une ville valide! ";
        }
    }



    //On verifie la description:
    if (empty($_POST['description'])) {

        $errors['description'] = "Veuillez insérer une description! ";
    } else {
        $description = htmlspecialchars($_POST['description']);
        $description = html_entity_decode($description);
        if (!preg_match('/^[\p{L}0-9\s.,\'’\-!?"()]+$/u', $description)) {
            $errors['description'] = "Veuillez insérer une description valide! ";
        }
    }



    //On verifie le continent:
    if (empty($_POST['continent'])) {

        $errors['continent'] = "Veuillez choisir un continent! ";
    } else {
        $continent = trim(htmlspecialchars($_POST['continent']));
        if ($continent != 'Europe' && $continent != 'Amérique' && $continent != 'Asie' && $continent != 'Afrique' && $continent != 'Océanie') {
            $errors['continent'] = "Veuillez choisir un continent valide!";
        }
    }



    //On verifie le pays:
    if (empty($_POST['pays'])) {

        $errors['pays'] = "Veuillez insérer un pays! ";
    } else {
        $pays = htmlspecialchars($_POST['pays']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $pays)) {
            $errors['pays'] = "Veuillez insérer ou choisir un pays valide! ";
        }
    }



    //On verifie l'hotel:
    if (empty($_POST['hotelname'])) {

        $errors['hotel'] = "Veuillez insérer un hotel! ";
    } else {
        $hotel = htmlspecialchars($_POST['hotelname']);
        if (!preg_match('/^[a-zA-Z\s.,\'-]+$/', $hotel)) {
            $errors['hotel'] = "Veuillez insérer ou choisir un hotel valide! ";
        }
    }



    //On verifie la gare:
    if (empty($_POST['garename'])) {

        $errors['gare'] = "Veuillez insérer une gare! ";
    } else {
        $gare = htmlspecialchars($_POST['garename']);
        if (!preg_match('/^[a-zA-Z\s.,\'-]+$/', $gare)) {
            $errors['gare'] = "Veuillez insérer ou choisir une gare valide! ";
        }
    }



    //On verifie le resto:
    if (empty($_POST['restoname'])) {

        $errors['restoname'] = "Veuillez insérer un restaurant! ";
    } else {
        $resto = htmlspecialchars($_POST['restoname']);
        if (!preg_match('/^[a-zA-Z\s.,\'-]+$/', $resto)) {
            $errors['resto'] = "Veuillez insérer ou choisir un restaurant valide! ";
        }
    }


    //On verifie l'aeroport:
    if (empty($_POST['aeroportname'])) {

        $errors['aeroport'] = "Veuillez insérer un aeroport! ";
    } else {
        $aeroport = htmlspecialchars($_POST['aeroportname']);
        if (!preg_match('/^[a-zA-Z\s.,\'-]+$/', $aeroport)) {
            $errors['aeroport'] = "Veuillez insérer ou choisir un aeroport valide! ";
        }
    }



    //On verifie le site touristique:
    if (empty($_POST['nomsit'])) {

        $errors['nomsit'] = "Veuillez insérer un nom de site touristique valide! ";
    } else {
        $nomsit = htmlspecialchars($_POST['nomsit']);
        if (!preg_match('/^[\p{L}0-9\s.,\'’\-!?"()]+$/u', $nomsit)) {
            $errors['nomsit'] = "Veuillez insérer un nom de site touristique valide! ";
        }
    }



    //On verifie le lien de la photo:
    if (empty($_POST['photo'])) {

        $errors['photo'] = "Veuillez insérer une photo! ";
    } else {
        $photo = htmlspecialchars($_POST['photo']);
        /*   if(!preg_match('#\b(https?://\S+\.(?:png|jpe?g|gif)\S*)\b#i', $photo)){
              $errors['photo']="Veuillez insérer ou choisir une photo avec un format valide! ";*/
    }




    //Maintenant on récupére les valeurs insérés s'il y a pas d'erreurs:
    if (array_filter($errors)) {
        //Si c'est le cas, on renvoi les erreurs
    } else {
        //pas d'erreurs
        $ville = mysqli_real_escape_string($conn, $_POST['ville']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $continent = mysqli_real_escape_string($conn, $_POST['continent']);
        $pays = mysqli_real_escape_string($conn, $_POST['pays']);
        $gare = mysqli_real_escape_string($conn, $_POST['garename']);
        $hotel = mysqli_real_escape_string($conn, $_POST['hotelname']);
        $resto = mysqli_real_escape_string($conn, $_POST['restoname']);
        $aeroport = mysqli_real_escape_string($conn, $_POST['aeroportname']);
        $nomsit = mysqli_real_escape_string($conn, $_POST['nomsit']);
        $photo = mysqli_real_escape_string($conn, $_POST['photo']);



        //donner les commmandes sql pour inserer nos valeurs dans notre bdd:


        // Vérification de l'existence du pays
        $sql1 = "SELECT idpay FROM pays WHERE nompay = '$pays' AND idcon = (SELECT idcon FROM continent WHERE nomcon = '$continent')";
        $result = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($result) > 0) {
            // Le pays existe déjà, récupérer l'ID
            $row = mysqli_fetch_assoc($result);
            $idpay = $row['idpay'];
        } else {
            // Le pays n'existe pas, l'insérer dans la base de données
            $sql1 = "INSERT INTO pays (nompay, idcon) VALUES ('$pays', (SELECT idcon FROM continent WHERE nomcon = '$continent'))";
            mysqli_query($conn, $sql1);
            $idpay = mysqli_insert_id($conn);
        }





        // Insérer la ville
        $sql2 = "INSERT INTO ville (nomvil, descvil, idpay) SELECT '$ville', '$description', pays.idpay FROM pays JOIN continent ON pays.idcon = continent.idcon WHERE pays.nompay = '$pays' AND continent.nomcon = '$continent'";
        mysqli_query($conn, $sql2);
        $idvil = mysqli_insert_id($conn);





        // Insérer les éléments nécessaires (hôtel,gare,restaurant,aéroport)
//hotel:
        $sql3 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
        if (!empty($_POST['hotels'])) {
            foreach ($_POST['hotels'] as $value) {
                $value = ucwords($value);
                $sql3 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'hotel', '$value', '$idvil';";
                mysqli_query($conn, $sql3);
            }
        } else {
            // Si la liste est vide, insérer l'élément de l'input
            $value = ucwords($value);
            $sql3 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'hotel', '$value', '$idvil';";
            mysqli_query($conn, $sql3);
        }


        //gare:
        $sql4 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
        if (!empty($_POST['gare'])) {
            foreach ($_POST['gare'] as $value) {
                $value = ucwords($value);
                $sql4 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'gare', '$value', '$idvil';";
                mysqli_query($conn, $sql4);
            }
        } else {
            // Si la liste est vide, insérer l'élément de l'input
            $value = ucwords($value);
            $sql4 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'gare', '$value', '$idvil';";
            mysqli_query($conn, $sql4);
        }

        //restaurant:
        $sql5 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
        if (!empty($_POST['resto'])) {
            foreach ($_POST['resto'] as $value) {
                $value = ucwords($value);
                $sql5 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'restaurant', '$value', '$idvil';";
                mysqli_query($conn, $sql5);
            }
        } else {
            // Si la liste est vide, insérer l'élément de l'input
            $value = ucwords($value);
            $sql5 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'restaurant', '$value', '$idvil';";
            mysqli_query($conn, $sql5);
        }


        //aeroport:
        $sql6 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
        if (!empty($_POST['aeroport'])) {
            foreach ($_POST['aeroport'] as $value) {
                $value = ucwords($value);
                $sql6 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'aeroport', '$value', '$idvil';";
                mysqli_query($conn, $sql6);
            }
        } else {
            // Si la liste est vide, insérer l'élément de l'input
            $value = ucwords($value);
            $sql6 = "INSERT INTO necessaire (typenec, nomnec, idvil) SELECT 'aeroport', '$value', '$idvil';";
            mysqli_query($conn, $sql6);
        }





        // Insérer le site avec sa photo (à partir de l'input)
        if (!empty($nomsit) && !empty($photo)) {
            $sql7 = "INSERT INTO site (nomsit, cheminphoto, idvil) SELECT '$nomsit', '$photo', '$idvil' FROM dual";
            mysqli_query($conn, $sql7);
        }



        //sauvegarder dans la bdd et verifier:
        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3) && mysqli_query($conn, $sql4) && mysqli_query($conn, $sql5) && mysqli_query($conn, $sql6) && mysqli_query($conn, $sql7)) {
            //   echo "données enregistrées!";
            header('location: home.php'); /*si pas d'erreurs après submit aller vers autre page*/
        } else {
            echo 'query error:' . mysqli_error($conn);
        }

    }

} //end POST


?>





<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajouter une ville</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body >
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
    <section class="ajout-ville">

        <form class="box" method="POST" action="ajout.php" enctype="multipart/form-data">
            <h1>Ajouter une ville</h1>
            <div class="ajout-groupe">
                <div class="card">
                    <label for="ville">Ville :</label>
                    <input type="text" name="ville" value="<?php echo htmlspecialchars($ville) ?>" required>
                    <br>
                    <div>
                        <?php echo $errors['ville'] ?>
                    </div>
                </div>


                <div class="card">
                    <label for="description">Description :</label>
                    <input type="text" name="description" value="<?php echo htmlspecialchars($description) ?>" required>
                    <br>
                    <div>
                        <?php echo $errors['description'] ?>
                    </div>

                </div>
            </div>








            <div class="ajout-groupe">
                <div class="card">
                    <label for="continent">Continent :</label>
                    <div class="aligner">
                        <select id="continent" name="continent" required>
                            <option value="<?php echo htmlspecialchars($continent) ?>">Sélectionnez un continent
                            </option>
                            <!-- Code PHP pour charger les continents-->
                            <?php
        $continents = array("Europe", "Amérique", "Asie", "Afrique", "Océanie");
        foreach ($continents as $continent) {
          echo "<option value=\"$continent\">$continent</option>";
        }
      ?>
                        

                        </select>
                        <button type="button" class="btnplus" id="nouveauContinentBtn"> <span>+</span> </button>
                    </div>

                    <br>
                    <div>
                        <?php echo $errors['continent'] ?>
                    </div>


                </div>








                <div class="card">
                    <label for="pays">Pays :</label>
                    <div class="aligner">
                        <select id="pays" name="pays" value="<?php echo htmlspecialchars($pays) ?>" required>
                            <option value="">Sélectionnez un pays</option>
                            <!-- Code PHP pour charger les pays -->
                         
                            <?php
    // Connectez-vous à votre base de données ici

    // Exécutez la requête pour récupérer les pays
    $query = "SELECT nompay FROM pays";
    $result = mysqli_query($conn, $query);

    // Parcourez les résultats et affichez les options du menu déroulant
    while ($row = mysqli_fetch_assoc($result)) {
        $pays = $row['nompay'];
        echo "<option value=\"$pays\">$pays</option>";
    }

    // Fermez la connexion à la base de données ici

    ?>
                        </select>
                        <button type="button" class="btnplus" id="nouveauPaysBtn"><span>+</span></button>
                    </div>

                    <br>
                    <div>
                        <?php echo $errors['pays'] ?>
                    </div>

                </div>
            </div>
















            <div class="ajout-groupe">
                <div>
                    <h2>Hôtels :</h2>
                    <div class="aligner">
                        <input type="text" id="hotel" name="hotelname" placeholder="Nom de l'hôtel"
                            value="<?php echo htmlspecialchars($hotel) ?>">
                        <button type="button" class="btn-ajouter" id="addHotel"
                            onclick="ajouter(event,'hotel_list','hotel')">Ajouter</button>
                    </div>

                    <br>
                    <select id="hotel_list" name="hotel[]" multiple>
                         <?php
                        if (isset($_GET["nomvilmod"])) {
                            foreach ($updateHotels as $value) {
                                echo "<option>" . $value . "</option>";
                            }
                        }
                        ?> 

                    </select>
                    <div>
                        <!-- <?php echo $errors['hotel'] ?> -->
                    </div>

                </div>




                <div>
                    <h2>Gares :</h2>
                    <div class="aligner">
                        <input type="text" id="gare" name="garename" placeholder="Nom de la gare"
                            value="<?php echo htmlspecialchars($gare) ?>">
                        <button type="button" class="btn-ajouter" id="addGare"
                            onclick="ajouter(event,'gares_list','gare')">Ajouter</button>
                    </div>

                    <br>
                    <select id="gares_list" name="gares[]" multiple>
                         <?php
                        if (isset($_GET["nomvilmod"])) {
                            foreach ($updateGares as $value) {
                                echo "<option>" . $value . "</option>";
                            }
                        }
                        ?> 
                    </select>
                    <div>
                        <!-- <?php echo $errors['gare'] ?> -->
                    </div>

                </div>

            </div>






            <div class="ajout-groupe">
                <div>
                    <h2>Aéroports :</h2>
                    <div class="aligner">
                        <input type="text" id="aeroport" name="aeroportname" placeholder="Nom de l'aéroport"
                            value="<?php echo htmlspecialchars($aeroport) ?>">
                        <button type="button" class="btn-ajouter" id="addAeroport"
                            onclick="ajouter(event,'aeroports_list','aeroport')">Ajouter</button>
                    </div>

                    <br>
                    <select id="aeroports_list" name="aeroports[]" multiple>
                         <?php
                        if (isset($_GET["nomvilmod"])) {
                            foreach ($updateAeroports as $value) {
                                echo "<option>" . $value . "</option>";
                            }
                        }
                        ?> 
                    </select>
                    <div>
                        <!-- <?php echo $errors['aeroport'] ?> -->
                    </div>

                </div>



                <div>
                    <h2>Restaurants :</h2>
                    <div class="aligner">
                        <input type="text" id="restaurant" name="restoname" placeholder="Nom de l'aéroport"
                            value="<?php echo htmlspecialchars($resto) ?>">
                        <button type="button" class="btn-ajouter" id="addResto"
                            onclick="ajouter(event,'restaurants_list','restaurant')">Ajouter</button>
                    </div>

                    <br>
                    <select id="restaurants_list" name="restaurants[]" multiple>
                         <?php
                        if (isset($_GET["nomvilmod"])) {
                            foreach ($updateRestaurant as $value) {
                                echo "<option>" . $value . "</option>";
                            }
                        }
                        ?> 
                    </select>
                    <div>
                         <?php echo $errors['resto'] ?> 
                    </div>

                </div>

            </div>


            <div class="ajout-groupe">



                <div>
                    <h3 for="nomsit">Site Touristique:</h3>
                    <div class="aligner">
                        <input type="text" name="nomsit" value="<?php echo htmlspecialchars($nomsit) ?>">
                        <button type="button" class="btn-ajouter" id="addSite"
                            onclick="ajouter(event,'sites_list','site')">Ajouter</button>
                    </div>
                    <select id="sites_list" name="sites[]" multiple>
                         <?php
                        if (isset($_GET["nomvilmod"])) {
                            foreach ($updateSite as $value) {
                                echo "<option>" . $value . "</option>";
                            }
                        }
                        ?> 
                    </select>


                    <div>
                        <!-- <?php echo $errors['nomsit'] ?> -->
                    </div>
                </div>





                <div>
                    <h2>Photos :</h2>
                    <div class="aligner"> <input type="text" id="inputPhoto" name="photo"
                            placeholder="Chemin de la photo" value="<?php echo htmlspecialchars($photo) ?>">
                        <button type="button" class="btn-ajouter" id="addPhoto"
                            onclick="ajouter(event,'photos_list','photo')">Ajouter</button>
                    </div>

                    <select id="photos_list" name="photos[]" multiple>
                         <?php
                        if (isset($_GET["nomvilmod"])) {
                            foreach ($updatePhoto as $value) {
                                echo "<option>" . $value . "</option>";
                            }
                        }
                        ?> 
                    </select>
                    <div>
                        <!-- <?php echo $errors['photo'] ?> -->
                    </div>
                </div>
            </div>



            <button type="submit" value="submit" name=submit>Ajouter</button>

        </form>
    </section>
    <section id="modalSection">
        <h4 class="center">Ajouter un pays</h4>
        <form action="ajout.php" method="post">
            <div>
                <label for="continent">Continent :</label>
                <select id="continent" name="nomcontinent" required>
                    <option value="<?php echo htmlspecialchars($nomcontinent) ?>">Sélectionnez un continent
                    </option>
                    <!-- Code PHP pour charger les continents -->
                    <?php
                    $continents = array("Europe", "Amérique", "Asie", "Afrique", "Océanie");
                    foreach ($continents as $nomcontinent) {
                        echo "<option value=\"$nomcontinent\">$nomcontinent</option>";
                    }
                    ?> 
                </select>
            </div>




            <label>Nom de pays :</label>
            <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays) ?>">
            <div class="red-text">
                <!-- <?php echo $errorss['nompays'] ?> -->
            </div>
            <div class="center">
                <input type="submit" value="Submit" name="submitpays" class="btn brand z-depth-0">
            </div>


            <button id="closeModalButton">fermer</button>
        </form>
    </section>
    <script src="./index.js"></script>
</body>

</html>