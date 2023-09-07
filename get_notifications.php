<?php
include("core.php");

/*Récupérez l'ID de l'étudiant à partir des données POST envoyées par AJAX ($_POST['idEtudiant']).*/
if (isset($_POST['idEtudiant'])) {
    $idEtudiant = $_POST['idEtudiant'];

    $sql = "SELECT * FROM Notification WHERE idEtudiant = $idEtudiant";
    $result = $mysqli->query($sql) or die($mysqli->error);
    
    $sqlReceveur = "SELECT prenom, nom FROM Etudiant WHERE idEtu = $idEtudiant";
    $resultReceveur = $mysqli->query($sqlReceveur) or die($mysqli->error);
    $receveur = $resultReceveur->fetch_assoc();

    while ($row = $result->fetch_assoc()) {
        echo "<h3>" . $row['type'] . "</h3>";
        $sqlEmetteur = "SELECT prenom, nom FROM Etudiant WHERE idEtu = " . $row['idEmetteur'];
        $resultEmetteur = $mysqli->query($sqlEmetteur) or die($mysqli->error);
        $emetteur = $resultEmetteur->fetch_assoc();
        echo "<p>Message envoyé par " . $emetteur['prenom'] . " " . $emetteur['nom'] . " à " . $receveur['prenom'] . " " . $receveur['nom'] . "</p>";
        echo "<br>";
    }
}