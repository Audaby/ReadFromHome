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
    echo "Détails du livre sélectionné :<br>";
    //voir les details des livres selon la recherche
    $auteur=$_POST['author'];
    $titre = $_POST['title'];
    
    $sql = "SELECT distinct* FROM livres WHERE auteur LIKE '%$auteur%' and titre LIKE '%$titre%'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        // afficher les resultats
        echo "<form action='wishlist.php' method='POST' target='_self'>";
        
        while($row = mysqli_fetch_array($result)) {   
            echo "Titre: " . $row["titre"]."<br> - Auteur: " . $row["auteur"]. " <br>- Maison d'edition: " . $row["maison_edition"]. " <br>- Description: " . $row["description"]." <br>- Nombre des livres: " . $row["nombre_exemplaire"] ."<br>";
        }
        $author = $_POST['author'];
        $title = $_POST['title'];
        $reader_name = $_POST['reader_name'];
        echo "<input type='hidden' name='author' value='".$author."'>";
        echo "<input type='hidden' name='title' value='".$title."'>";
        echo "<input type='hidden' name='reader_name' value = '".$reader_name."'>";
        echo "<input type='submit' value='Ajouter à la liste de souhaits'>";
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