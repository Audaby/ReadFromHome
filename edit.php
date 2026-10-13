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
    <main>
    <?php 
    $host="localhost";
    $user="root";
    $password="";
    $dbname="db_bibliotheque_en_ligne";
    

    $conn = mysqli_connect($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "<div class='books-details'>";
    echo "Détails du livre sélectionné :<br>";
    //voir les details des livres selon la recherche
    $auteur=$_POST['auteur'];
    $titre = $_POST['titre'];
    $sql = "SELECT * FROM livres WHERE auteur  like '%$auteur%' and titre LIKE '%$titre%'" ;
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        // afficher les resultats
        while($row = mysqli_fetch_array($result)) { 
        echo "Auteur: ".$row['auteur']."<br>Titre: ".$row['titre']."<br>Maison d'edition".$row['maison_edition']."<br>Description:".$row['description']."<br>Nombre d'exemplaire:".$row['nombre_exemplaire'];
        
        }
        } else {
        echo "0 résultats trouvés";
    } 
    echo "</div>";
    ?>
    </main>
    <footer>
        <p>© 2025 Audace. All rights reserved.</p>
        <p>Empowered by D-CLIC</p>
    </footer>
    
 
</body>
</html>