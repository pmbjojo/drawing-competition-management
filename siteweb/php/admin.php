<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/admin.css" rel="stylesheet">
    <title>Admin Board</title>
</head>
<body>
    <h1>Admin Board</h1>

    <?php
    include ("menu.php");
    session_start();
    if ($_SESSION['logged_in'] == true and $_SESSION['status'] == 'admin') {
    //     <div class='section' id='requete-section'>
    //     <h2>Requêtes libres</h2>
    //     <form action='query.php' method='post'>
    //         <label for='query'>Saisir votre requête SQL :</label>
    //         <textarea name='query' id='query'></textarea>
    //         <input type='submit' value='Exécuter'>
    //     </form>
    // </div>   
        echo "<div class='container'>
                <div class='section' id='creation-section'>
                    <h2>Création d'un utilisateur</h2>
                        <form action='create_user.php' method='post'>
                            <label for='nom'>Nom :</label>
                            <textarea name='nom' id='nom'></textarea>

                            <label for='prenom'>Prénom :</label>
                            <textarea name='prenom' id='prenom'></textarea>

                            <label for='age'>Age :</label>
                            <textarea name='age' id='age'></textarea>

                            <label for='adresse'>Adresse :</label>
                            <textarea name='adresse' id='adresse'></textarea>

                            <label for='login'>Login :</label>
                            <textarea name='login' id='login'></textarea>

                            <label for='motDePasse'>Mot de passe :</label>
                            <textarea name='motDePasse' id='motDePasse'></textarea>

                            <label for='numClub'>Numéro de club :</label>
                            <textarea name='numClub' id='numClub'></textarea>

                            <input type='submit' value='Créer'>
                        </form>  
                </div>
                <div class='section' id='droits-section'>
                    <h2>Accorder les droits administrateur</h2>";
                echo "<form action='grant-admin.php' method='post'>
                        <label for='query'>Saisir l'id de l'utilisateur :</label>
                        <textarea name='id' id='id'></textarea>
                        <input type='submit' value='Exécuter'>
                    </form>
                </div>
            </div>";
        }
        else {
            echo "Vous n’êtes pas un administrateur";
        }
    ?>
</body>
</html>