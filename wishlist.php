<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projet-final</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="main.php">Accueil</a></li>
                <li><a href="admin_dashboard.php">Tableau de bord utilisateur</a></li>
            </ul>
        </nav>
        <h1>Bienvenue dans votre nouvel espace de lecture et de découverte !</h1>
        <div class ="description">
        </div>
        
    </header>

    <?php 
    $host="localhost";
    $user="root";
    $password="";
    $dbname="db_bibliotheque_en_ligne";
    

    $conn = mysqli_connect($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT id FROM livres WHERE auteur = '".$_POST['author']."' AND titre = '".$_POST['title']."'";
    $result = mysqli_query($conn, $sql);
    //ajouter a la liste de souhaits
    if ($result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {   
            $book_id = $row["id"];
        }
    }
    $sql2 = "SELECT id from lecteurs where nom = '".$_POST['reader_name']."'";
    $result2 = mysqli_query($conn, $sql2);
    $reader_name= $_POST['reader_name'];
    if ($result2->num_rows > 0) {
        while($row = mysqli_fetch_array($result2)) {   
            $reader_id = $row["id"];
        }
    }
    $sql3 = "INSERT INTO liste_lecture (id_livre, id_lecteur, date_emprunt, date_retour) VALUES ('$book_id', '$reader_id', current_date(), date_add(current_date(), interval 14 day))";
    if (mysqli_query($conn, $sql3)) {
        echo $reader_name."Votre livre ajouté à la liste de souhaits avec succès.";
    } else {
        echo "Erreur: " . $sql3 . "<br>" . mysqli_error($conn);
    }

    $sql4 = "SELECT * FROM liste_lecture where id_lecteur = '$reader_id'";
    $result4 = mysqli_query($conn, $sql4);
    if ($result4->num_rows > 0) {
        // afficher les resultats
        echo "<table border='1'><tr><th>ID Livre</th><th>ID Lecteur</th><th>Date d'emprunt</th><th>Date de retour</th></tr>";
        while($row = mysqli_fetch_array($result4)) {  
            echo "<tr><td>" . $row["id_livre"]. "</td><td>" . $row["id_lecteur"]. "</td><td>" . $row["date_emprunt"]. "</td><td>" . $row["date_retour"]. "</td></tr>"; 
        }
        echo "</table>";
        echo "Retournez à la page principale et actualisez la page.";
    } else {
        echo "0 résultats trouvés";
    }   
    
    
    ?>
    <footer>
        <p>© 2025 Audace. All rights reserved.</p>
        <p>Empowered by D-CLIC</p>
    </footer>
    
 
</body>
</html>