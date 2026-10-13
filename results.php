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
        //selectionner les livres selon la recherche
        $search = $_POST["search"];
        $sql = "SELECT distinct titre,auteur FROM livres WHERE auteur LIKE '%$search%' OR titre LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            // afficher les resultats
            echo ("<form action='details.php' method='POST' target='_self'>");
            while($row = mysqli_fetch_array($result)) {
            
            $title = $row["titre"];
            $author = $row["auteur"];
            echo " Titre: " . $title. " - Auteur: " . $author ."<input type='hidden' name='author' value='$author'><input type='hidden' name='title' value='$title'><br>";  
            }
            $reader_name = $_POST['reader_name'];
            echo "<input type='hidden' name='reader_name' value = '".$reader_name."'>";
            echo "<input type='submit' value='Voir les détails'></form>";
        } else {
            echo "0 résultats trouvés";
        }    
        ?>
    </main>
    <footer>
        <p>© 2025 Audace. All rights reserved.</p>
        <p>Empowered by D-CLIC</p>
    </footer>
    
 
</body>
</html>