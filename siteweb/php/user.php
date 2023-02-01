<?php
    include ("menu.php");
    include ("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/user.css" rel="stylesheet">
    <title>User Board</title>
</head>
<body>
    <h1>User Board</h1>
<?php
    session_start();
    if ($_SESSION['logged_in'] == true and ($_SESSION['status'] == 'user' or $_SESSION['status'] == 'admin')) {
    echo "<div class='container'>
            <div class='section' id='concours-section'>
                <h2> Le nom, l’adresse et l’âge de tous les compétiteurs qui ont participé dans un concours en 2021</h2>
                <form action='query.php' method='post'>
                    <input type='hidden' name='query' value='$query1'>
                    <input type='submit' value='Exécuter'>
                </form>
            </div>
            <div class='section' id='dessins-section'>
                <h2>L'ordre croissant de la note tous les dessins qui ont été évalués en 2022</h2>
                <form action='query.php' method='post'>
                    <input type='hidden' name='query' value='$query2'>
                    <input type='submit' value='Exécuter'>
                </form>
            </div>
            <div class='section' id='region-moyenne-section'>
                <h2>Le classement région qui a la meilleure moyenne des notes des dessins proposés</h2>
                <form action='query.php' method='post'>
                    <input type='hidden' name='query' value='$query5'>
                    <input type='submit' value='Exécuter'>
                </form>
            </div>
            <div class='section' id='moyenne-concours-section'>
                <h2>La région avec la meilleure moyenne par concours</h2>
                <form action='query.php' method='post'>
                    <input type='hidden' name='query' value='$query6'>
                    <input type='submit' value='Exécuter'>
                </form>
            </div>
            <div class='section' id='moyenne-evaluateur-section'>
                <h2>Le nom des évaluateurs avec la moyenne des dessins qu'ils sont notés</h2>
                <form action='query.php' method='post'>
                    <input type='hidden' name='query' value='$query7'>
                    <input type='submit' value='Exécuter'>
                </form>
            </div>
        </div>";
    }
    else {
        echo "Vous n’êtes pas un utilisateur";
    }
?>
</body>
</html>