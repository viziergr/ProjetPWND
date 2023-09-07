<?php
include 'core.php';

$_TITRE_PAGE = 'Accueil projet RS ESEO';

$anneeScolaire = "SELECT * FROM AnneeScolaire ORDER BY idAnneeScolaire asc";
$qwery = $mysqli->query($anneeScolaire);

if (isset($_POST['connexion_submit']) && $_POST['connexion_submit'] == 1) {
    if (!empty($_POST['password']) && !empty($_POST['mail'])) {
        $mail_escaped = $mysqli->real_escape_string(trim($_POST['mail']));
        $password_escaped = $mysqli->real_escape_string(trim($_POST['password']));
        $sql = "SELECT *
                FROM Etudiant
                WHERE email = '" . $mail_escaped . "'
                AND motDePasse = '" . $password_escaped . "'";
        $result = $mysqli->query($sql);
        if (!$result) {
            exit($mysqli->error);
        }
        $nb = $result->num_rows;
        if ($nb) {
            //récupération de l’id de l’étudiant
            $row = $result->fetch_assoc();
            $_SESSION['compte'] = $row;
        } else {
            echo "Identifiants incorrects";
        }
    }
}

if (isset($_POST['inscription_submit']) && $_POST['inscription_submit'] == 1) {
    if (!empty($_POST['mdp_inscription']) && !empty($_POST['mail_inscription'])) {
        if ($_POST['mdp_inscription'] != $_POST['mdp_inscription_confirm']) {
            echo "Erreur: mdp et mdp confimation different";
        } else {
            $mail_escaped = $mysqli->real_escape_string(trim($_POST['mail_inscription']));
            $password_escaped = $mysqli->real_escape_string(trim($_POST['mdp_inscription']));
            $sql = "INSERT INTO Etudiant (idEtu,email,motDePasse,nom,prenom,anneeScolaire)
                VALUES (NULL,'" . $mail_escaped . "','" . $password_escaped . "','" . $_POST['nom_inscription'] . "','" . $_POST['prenom_inscription'] . "','" . $_POST['AnneeScolaire'] . "')";

            if ($mysqli->query($sql) === TRUE) {
                echo "les nouveaux enregistrements ajoutés avec succés";
            } else {
                echo "Erreur: " . $sql . "
            " . $mysqli->error;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title><?php echo $_TITRE_PAGE ?></title>
    <link rel="icon" type="image/icon" href="assets/logo.ico">
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <div class="container">
        <center>
            <h2>Bienvenue sur RS ESEO</h2>
        </center>
        <?php
        if (empty($_SESSION['compte'])) {
        ?>
            <div class="row">
                <form method="post">
                    <div id='Connexion'>
                        <center>
                            <h2 class='h2_a'>Connexion</h2>
                        </center>
                        <p>
                            <input id="idmail" class="form-control" placeholder="Saisir email" name="mail" type="text">
                        </p>
                        <p>
                            <input name="password" class="form-control" placeholder="Saisir mot de passe" type="password" id="defaultLoginFormPassword">
                        </p>
                        <center><button class="button" name="connexion_submit" value="1" type="submit">Connexion</button></center>
                    </div>
                    <div id="Inscription">
                        <center>
                            <h2 class='h2_a'>Inscription</h2>
                        </center>
                        <label for="nom_inscription">Nom</label><br>
                        <input type="text" id="nom_inscription" name="nom_inscription" value=""><br><br>
                        <label for="prenom_inscription">Prenom</label><br>
                        <input type="text" id="prenom_inscription" name="prenom_inscription" value=""><br><br>
                        <label for="AnneeScolaire">Annee scolaire </label><br>
                        <select id="AnneeScolaire" name="AnneeScolaire">
                            <?php while ($row = $qwery->fetch_assoc()) { ?>
                                <option value="<?php echo $row['idAnneeScolaire'] ?>">
                                    <?php echo $row['nom']; ?></option>
                            <?php
                            }
                            ?>
                        </select><br><br>
                        <label for="mail_inscription">Email</label><br>
                        <input type="text" id="mail_inscription" name="mail_inscription" value=""><br><br>
                        <label for="mdp_inscription">Mot de passe</label><br>
                        <input type="password" id="mdp_inscription" name="mdp_inscription" value=""><br><br>
                        <label for="mdp_inscription_confirm">Comfirmez mot de passe</label><br>
                        <input type="password" id="mdp_inscription_confirm" name="mdp_inscription_confirm" value=""><br><br>
                        <button class="button" name="inscription_submit" value="1" type="submit"><span>Inscription</span></button>
                    </div>
                </form>
            <?php
        } else {
            header("Location: accueil.php");
        }
            ?>
            </div>
</body>

</html>