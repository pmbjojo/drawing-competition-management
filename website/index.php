<?php
    $database="sitewebdb";
    $username="sitewebuser";
    $password="sitewebpassword";
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=$database;charset=utf8", $username, $password);
        $stmt = $pdo->prepare("SELECT * FROM UTILISATEUR;");
        $stmt->execute();
        $utilisateurs = $stmt->fetchall(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>AdminBoard</h1>
    <table>
        <tbody>
            <tr>
                <td>id</td>
                <td>nom</td>
                <td>prenom</td>
            </tr>
            <?php foreach($utilisateurs as $utilisateur): ?>
            <tr>
                <td><?= $utilisateus['numUtilisateur'] ?></td>
                <td><?= $utilisateus['nom'] ?></td>
                <td><?= $utilisateus['prenom'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>