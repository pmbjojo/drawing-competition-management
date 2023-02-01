<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/reviewer.css" rel="stylesheet">
    <title>Reviewer Board</title>
</head>
<body>
    <h1>Reviewer Board</h1>
    <?php
    include ("menu.php");
    session_start();
    if ($_SESSION['logged_in'] == true and ($_SESSION['status'] == 'evaluateur' or $_SESSION['status'] == 'admin')) {
            echo "Vous êtes identifiée en tant qu'évaluateur";
        }
        else {
            echo "Vous n’êtes pas un évaluateur";
        }
    ?>
</body>
</html>
