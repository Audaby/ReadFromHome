<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blibliotheque en ligne</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Tableau de bord</a></li>
                <li><a href="main.php">Accueil</a></li>
            </ul>
        </nav>
        <h1>Tableau de bord administrateur</h1>
    </header>
    <main>
    <?php 
    $host="localhost";
    $user="root";
    $password="";
    $dbname="db_bibliotheque_en_ligne";
    $conn = mysqli_connect($host, $user, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //Voir la liste des lecteurs
    
    $sql = "SELECT distinct nom,prenom,email FROM lecteurs";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        // afficher les resultats
        echo "<div class='readers-section'><h2>Liste des Lecteurs :</h2><ol>";
        while($row = mysqli_fetch_array($result)) {    
            echo "<li>".$row["nom"]. " " . $row["prenom"]. " - " . $row["email"]. "</li>";
        }
        echo "</ol></div>";
    } else {
        echo "Aucun lecteur trouvé.";
    }


    //voir la liste des livres dans la bibliotheque
    //la formulaire pour ajouter des livres dans le bubiloteque
    echo "<div class='books-section'><h2>Liste des livres dans la bibliothèque :</h2><ol>";
    echo "<form action='admin_dashboard.php' method='POST' target='_self'>";
    echo "<label>Titre: </label>";
    echo "<input type='text' name='title'><br><br>";
    echo "<label>Auteur: </label>";
    echo "<input type='text' name='author'><br><br>";
    echo "<label>Maison d'edition: </label>";
    echo "<input type='text' name='maison_edition'><br><br>";
    echo "<label>Description: </label>";
    echo "<textarea name='description' rows='2' cols='30'></textarea><br><br>";
    echo "<label>Nombre d'exemplaire: </label>";
    echo "<input type='number' name='nombre_exemplaire' min='0'>";  
    echo "<input name='update_book' type='submit' value='Ajouter'>";
    echo "</form>";
    //ajouter des livres dans la bibliotheque
    if (isset($_POST['update_book'])){
        $auteur = trim($_POST['author']);
        $titre = trim($_POST['title']);
        $n_exemplaire = intval($_POST['nombre_exemplaire']);
        $description = trim($_POST['description']);
        $maison_edition = trim($_POST['maison_edition']);

        // Use a prepared statement to safely insert the new book
        $stmt = mysqli_prepare($conn, "INSERT INTO livres (titre, auteur, description, maison_edition, nombre_exemplaire) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $titre, $auteur, $description, $maison_edition, $n_exemplaire);
            if (mysqli_stmt_execute($stmt)) {
                echo htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') . " ajouté avec succès. Actualisez la page pour voir le résultat<br></div>";
            } else {
                echo "Erreur lors de l'ajout : " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Erreur de préparation de la requête : " . mysqli_error($conn);
        }
    }

    $sql2 = "SELECT distinct titre,auteur,maison_edition,nombre_exemplaire FROM livres";
    $result2 = mysqli_query($conn, $sql2);
    if ($result2->num_rows > 0) {
        // afficher les resultats
        echo "<table border='1'><tr><th>Titre</th><th>Auteur</th><td>Maison_edition</th><th>Nombre examplaire</th><th>Details</th></tr>";
        echo "<div class='books-section'><h2>Liste des Livres :</h2><ol>";
        while($row = mysqli_fetch_array($result2)) {    
            echo "<tr><td>" . $row["titre"]. "</td><td> " . $row["auteur"]. "</td><td>" . $row["maison_edition"]. "</td><td>" . $row["nombre_exemplaire"]. "</td>";
            $titre=$row['titre'];
            $auteur =$row['auteur'];
            echo "<td><form action='edit.php' method='POST' target='_self'>";
            echo "<input type = 'hidden' name='titre' value=".$titre.">";
            echo "<input type = 'hidden' name='auteur' value=".$row["auteur"].">";
            echo "<input type = 'submit' value='Voir les details'></form></td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "Aucun livre trouvé.";
    }



    //voir la liste des souhaits
    $sql3 = "SELECT Distinct* FROM liste_lecture";
    $result3 = mysqli_query($conn, $sql3);
    if ($result3->num_rows > 0) {
        // afficher les resultats
        echo "<div class='wishlist-section'><h2>Liste des Souhaits :</h2><ol>";
        echo "<table border='1'><tr><th>ID livre</th><th>ID lecteur</th><th>Date d'emprunt</th><th>Date de retour</th><th>Suppression</th></tr>";
        while($row = mysqli_fetch_array($result3)) {    
            echo "<tr><td>" . $row["id_livre"]. "</td><td>" . $row["id_lecteur"]. "</td><td>" . $row["date_emprunt"]. "</td><td>" . $row["date_retour"]. "</td>";
            echo "<td><form action='admin_dashboard.php' method='POST' target='_self'> <input type = 'hidden' name='id_livre' value=".$row["id_livre"].">";
            echo "<input type = 'hidden' name='id_lecteur' value=".$row["id_lecteur"].">";
            echo "<input name ='btn_delete' type = 'submit' value='Supprimer'></form></td></tr>";
        }
        echo "</table></div>";
        
    } else {
        echo "Aucun souhait trouvé.";
    }
    //Supprimer un element sur la list des souhaits
    if (isset($_POST['btn_delete'])){
        $id_livre = $_POST['id_livre'];
        $id_lecteur = $_POST['id_lecteur'];
        $sql4="DELETE from liste_lecture where id_livre =$id_livre and id_lecteur=$id_lecteur";
        mysqli_query($conn, $sql4);
    }

    
    ?>
    </main>
    <footer>
        <p>© 2025 Audace. All rights reserved.</p>
        <p>Empowered by D-CLIC</p>
    </footer>

    
</body>
</html>