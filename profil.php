<?php
include('core.php');
$sql = "SELECT * FROM Etudiant WHERE idEtu = " . $_SESSION['compte']['idEtu'];
$result = $mysqli->query($sql) or die($mysqli->error);
$row = $result->fetch_assoc();

if (isset($_POST['publication_submit']) && $_POST['publication_submit'] == 1) {
    if (!empty($_POST['publication_text'])) {
        $visibilite = $_POST['visibilite'];
        $sql = "INSERT INTO Article(idArt, contenu, dateCreation, visibilite, auteur) 
        VALUES (NULL, '" . $_POST['publication_text'] . "', NOW(),'" . $visibilite . "' , " . $_SESSION['compte']['idEtu'] . ")";
        if ($mysqli->query($sql) === TRUE) {
            echo "les nouveaux enregistrements ajoutés avec succés";
        } else {
            echo "Erreur: " . $sql . "
        " . $mysqli->error;
        }
    }
}

if (isset($_POST['modifier']) && $_POST['modifier'] == 1) {
    header('Location: modification.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/icon" href="assets/logo.ico">
    <title>Profil</title>
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
                        <a class="nav-link active" aria-current="page" href="#">Mon Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modification.php">Paramètres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://192.168.56.80/pwnd?logout=1">Déconnexion</a>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="card" style="background-color:rgb(255, 173, 205); margin-bottom: 8px; margin-top: 8px;">
                        <h2 style="text-align: center;">Mon profil</h2>
                        <br>
                        <img class="rounded mx-auto d-block" height='200' width='auto' src=<?php echo $row['photo'] ?>>
                        <br>
                    </div>
                    <div class="card" style="background-color:rgb(255, 173, 205);">
                        <h2 style="text-align: center;">Liste des inscrits</h2>
                        <div class="overflow-auto" style="height: 300px; width: 100%;">
                            <?php
                            $query = "SELECT * FROM Etudiant";
                            $result = $mysqli->query($query);
                            while ($row = $result->fetch_assoc()) {
                                if ($row['idEtu'] != $_SESSION['compte']['idEtu']) {
                                    echo "<div class='card' style='background-color:rgb(213,166,255); margin:8px 8px'><img  height='30' width='30' src="  . $row['photo'] . ">" . $row['prenom'] . " " . $row['nom'] . "</div>";
                                }
                            }
                            ?>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="background-color:rgb(255, 173, 205); margin-bottom: 8px; margin-top: 8px;width:100%">
                    <form method="post">
                        <div class="row"><h2 style="text-align: center">Raconte ta vie</h2></div>
                        <div class="row"><input class="form-control" name="publication_text" id="publication_text" style='margin-left:20px;width:90%;' placeholder="Aujourd'hui le train était en retard, satanée SNCF..."></textarea></div>
                        <select id="visibilite" name="visibilite">
                            <option value="public">Tout le monde</option>
                            <option value="amis">Seulement mes amis</option>
                        </select><br><br>
                        <button class="button" style="text-align:center" name="publication_submit" value="1" type="submit"><span>Publier</span></button>
                    </form> <br>
                </div>
            </div>
        </div>
</body>

</html>