<?php
include('core.php');
$sql = "SELECT * FROM Etudiant WHERE idEtu = " . $_SESSION['compte']['idEtu'];
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/icon" href="assets/logo.ico">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
                        <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Mon Profil</a>
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
                        <div class="overflow-hidden" style="width: 100%;">
                            <?php
                            $query = "SELECT * FROM Etudiant";
                            $result = $mysqli->query($query);
                            while ($row = $result->fetch_assoc()) {
                                if ($row['idEtu'] != $_SESSION['compte']['idEtu']) { ?>
                                    <div class='card' style='background-color:rgb(213,166,255); margin:8px'>
                                        <div class="row">
                                            <div class="col-2"><img class='rounded-circle' height='30' width='30' src="<?php echo $row['photo'] ?>"></div>
                                            <div class="col-10 pt-1 h6"><?php echo $row['prenom'] . " " . $row['nom'] ?></div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="background-color:rgb(255, 173, 205); margin-top: 8px;">
                    <h2 style="text-align: center;">Regarde la vie des autres</h2>
                    <div class="overflow-auto" style=" width: 100%;">
                        <?php
                        $queryArticle = "SELECT Article.*,Etudiant.photo,Etudiant.nom,Etudiant.prenom FROM Article,Etudiant WHERE Article.auteur = Etudiant.idEtu";
                        $resultArticle = $mysqli->query($queryArticle);
                        while ($row = $resultArticle->fetch_assoc()) { ?>
                            <div class='card' style='background-color:rgb(213,166,255); margin:8px'>
                                <div class='card'>
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-2"><img class="rounded-circle" height='50' width='50' src="<?php echo $row['photo']?>"></div>
                                            <div class="col-10 pt-2 h4"><?php echo $row['prenom'] . " " . $row['nom'] ?></div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $row['contenu'] ?>
                                    </div>
                                    <div class="card-footer text-left small">
                                        <?php echo $row['dateCreation'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>