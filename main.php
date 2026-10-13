<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bibliothèque en ligne moderne</title>
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
            <p>Découvrez une collection unique d'articles, d'histoires et de ressources soigneusement sélectionnées pour enrichir votre esprit et éveiller votre curiosité. Que vous soyez passionné par la littérature, la science, l'art ou la culture, notre plateforme vous offre un espace convivial pour explorer, apprendre et partager vos découvertes avec une communauté engagée.</p>
            
            <p>Plongez dans un univers où chaque lecture est une aventure, et chaque découverte une opportunité de grandir. Rejoignez-nous dès aujourd'hui et commencez votre voyage vers un monde de connaissances infinies !</p>
            <!-- description comment utiliser le biblitheque en ligne-->
             <p>Vous pouvez chercher les livers en taper soit l'auteur ou titre du livre</p>
            <h3> </h3>
        </div>

    </header>
    <main>
        <div class='important'><!-- Information importante sur l'utilisation de notre bibliotheque -->
            <h3> </h3>
            <ol>
                <li>Ajoutez votre nom via la page d'accueil afin de pouvoir ajouter des livres à votre liste de souhaits.</li>
                <li>Effectuez des recherches en utilisant le nom de l'auteur ou le titre du livre.</li>
                <li>Consultez les détails et ajoutez le livre à votre liste de souhaits.</li>
                <li>Vous trouverez plus d'informations dans le tableau de bord de l'administrateur.</li>
                <li>merci</li>
            </ol>

        </div>    
        <!-- Formulaire pour ajourter votre nom sur la liste des lecteurs -->
        <div class ='center-content'>
            <form action="main.php" method="POST" target="_self">
                <h3>Ajouter votre nom à la liste des lecteurs :<h3>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required><br><br>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required><br><br>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required><br><br>
                <input type="submit" name='user_info' value="Ajouter"><br><br>
            </form>
        <?php
            $host="localhost";
            $user="root";
            $password="";
            $dbname="db_bibliotheque_en_ligne";
                
            $conn = mysqli_connect($host, $user, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if (isset($_POST['user_info'])){

                $sql2 = "SELECT id from lecteurs where nom = '".$_POST['nom']."' and prenom = '".$_POST['prenom']."'";
                $result2 = mysqli_query($conn, $sql2);
                
                if ($result2->num_rows > 0) {
                    while($row = mysqli_fetch_array($result2)) {   
                        $reader_id = $row["id"];
                       
                    }
                    $reader_name= $_POST['nom'];

                }else{
                    $sql = "INSERT INTO lecteurs (id, nom, prenom, email) VALUES (NULL,'".$_POST['nom']."', '".$_POST['prenom']."', '".$_POST['email']."')";
                    mysqli_query($conn, $sql);
                    if (mysqli_query($conn, $sql)) {
                        echo $_POST['nom'],$_POST['prenom']."ajouté avec succès.<br>";
                    } else {
                        echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    $sql2 = "SELECT id from lecteurs where nom = '".$_POST['nom']."' and prenom = '".$_POST['prenom']."'";
                    $result2 = mysqli_query($conn, $sql2);
                    $reader_name= $_POST['nom'];
                }
                
                // formulaire de recherche
                echo "<form action='results.php' method='POST' target='_self'>";
                echo "<label for='search'>Rechercher un livre par auteur ou titre :</label><br>";
                echo "<input type='text' id='search' name='search' required>";
                echo "<input type='hidden' name='reader_name' value =".$_POST['nom'].">";
                echo "<input type='submit' name='search_query' value='Rechercher'>";
                echo "</form>";
                echo "</div>";

                //voir la liste des souhaits
                $sql3 = "SELECT * FROM liste_lecture where id_lecteur='$reader_id'";
                $result3 = mysqli_query($conn, $sql3);
                if ($result3->num_rows > 0) {
                    // afficher les resultats
                    echo "<div class='wishlist-section'><h2>".$reader_name.", votre liste de souhaits des lecture contient :</h2><ol>";
                    echo "<table border='1'><th><td>ID livre</td><td>ID lecteur</td><td>Date d'emprunt</td><td>Date de retour</td></th>";
                    while($row = mysqli_fetch_array($result3)) {    
                        echo "<tr><td>" . $row["id_livre"]. "</td><td>" . $row["id_lecteur"]. "</td><td>" . $row["date_emprunt"]. "</td><td>" . $row["date_retour"]. "</td>";
                        echo "<td><form action='main.php' method='POST' target='_self'> <input type = 'hidden' name='id_livre' value=".$row["id_livre"].">";
                        echo "<input type = 'hidden' name='id_lecteur' value=".$row["id_lecteur"].">";
                        echo "<input type = 'submit' value='delete'></form></td></tr>";
                    }
                    echo "</table></div>";
                    
                } else {
                    echo "Aucun livre trouve.";
                }
            }



        ?>   

    </main>
    <footer>
        <p>© 2025 Audace. All rights reserved.</p>
        <p>Empowered by D-CLIC</p>
    </footer>
</body>
</html>