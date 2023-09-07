<?php
include("core.php");

$sql = "SELECT * FROM Etudiant WHERE idEtu = " . $_SESSION['compte']['idEtu'];
$result = $mysqli->query($sql) or die($mysqli->error);
$row = $result->fetch_assoc();

if (isset($_POST['modification_submit']) && $_POST['modification_submit'] == 1) {
    if (!empty($_POST['mp']) && !empty($_POST['cmp'])) {
        if ($_POST['mp'] != $_POST['cmp']) {
            echo "Les mots de passe ne correspondent pas";
        } else {
            if($_POST['photo'] == "") {
                $_POST['photo'] = $row['photo'];
            }
            if($_POST['email'] == "") {
                $_POST['email'] = $row['email'];
            }
            if($_POST['fname'] == "") {
                $_POST['fname'] = $row['prenom'];
            }
            if($_POST['lname'] == "") {
                $_POST['lname'] = $row['nom'];
            }
            if($_POST['mp'] == "") {
                $_POST['mp'] = $row['motDePasse'];
            }
            $mail_escaped = $mysqli->real_escape_string(trim($_POST['email']));
            $password_escaped = $mysqli->real_escape_string(trim($_POST['mp']));
            $sql = "UPDATE Etudiant SET nom = '" . $_POST['lname'] . "', prenom= '" . $_POST['fname'] . "', email='" . $mail_escaped . 
            "', motDePasse='" . $password_escaped . "', photo='" . $_POST['photo'] . "' WHERE idEtu = " . $_SESSION['compte']['idEtu'];
            
            if ($mysqli->query($sql) === TRUE) {
                echo "les nouveaux enregistrements ajoutés avec succés";
                header("Location: modification.php");
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
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paramètres</title>
    <link rel="icon" type="image/icon" href="assets/logo.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/logo.png" width="30" height="30" alt="">ESEO RS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="accueil.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Mon Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Paramètres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://192.168.56.80/pwnd?logout=1">Déconnexion</a>
                </ul>
            </div>
        </div>
    </nav>
    <div class="Modification">
        <center><img class="pasimg" src=<?php echo $row['photo'] ?> alt="Image"><br></center>
        <h2>Modifier le profil</h2>
        <form method="post">
            <label for="fname">Prenom</label>
            <input type="text" id="fname" name="fname" value=<?php echo $row['prenom'] ?>><br><br>
            <label for="lname">Nom</label>
            <input type="text" id="lname" name="lname" value=<?php echo $row['nom'] ?>><br><br>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value=<?php echo $row['email'] ?>><br><br>
            <label for="mp">Mot de passe</label>
            <input type="password" id="mp" name="mp" value=""><br><br>
            <label for="cmp">Comfirmez mot de passe</label>
            <input type="password" id="cmp" name="cmp" value=""><br><br>
            <label for="photo">Choisir un lien de photo</label>
            <input type="text" id="photo" name="photo" value=""><br><br>
            <center><button class="button" name="modification_submit" value="1" type="submit"><span>Confirmer</span></button></center>
        </form> <br>
    </div>
    </div>
</body>

</html>