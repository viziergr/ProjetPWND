<!DOCTYPE html>
<html>

<head>
    <title>Notifications</title>
</head>

<body>
    <div id="contenuNotifications">
        Aucune notification pour le moment
    </div>
    <script>
        // déclarer ici votre fonction javascript updateNotifications
        function updateNotification() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_notifications.php', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("idEtudiant=9");
            xhr.onreadystatechange = function() {
                if (xhr.status == 200) {
                    document.getElementById("contenuNotifications").innerHTML = xhr.responseText;
                }
            }
        }
        // Mettez à jour les notifications initiales lors du chargement de la page
        // en appelant votre fonction updateNotifications
        updateNotification();
        // Mettez en place une boucle pour mettre à jour les notifications toutes les 10 secondes
        // ci-dessous (étape 5)
        setInterval(updateNotification, 10000);
    </script>
</body>

</html>