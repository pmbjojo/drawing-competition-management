<?php
    include ("database.php");
    session_start();
    unset($_SESSION['logged_in']);
    unset($_SESSION['username']);
    unset($_SESSION['status']);

    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isUser($username, $password)) {
        // Utilisateur existe, vérification de son statut
        $numUtilisateur = getNumUtilisateur($username, $password);
        $status = 'user';
        
        $resultEvaluateur = isReviewer($numUtilisateur);
        if ($resultEvaluateur->num_rows > 0) {
            $status = 'evaluateur';
        }

        $resultAdmin = isAdmin($numUtilisateur);
        if ($resultAdmin->num_rows > 0) {
            $status = 'admin';
        }

        // Stockage des informations de connexion dans des variables de session
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['status'] = $status;

        // Redirection en fonction du statut de l'utilisateur
        switch ($status) {
            case 'admin':
                header("Location: admin.php");
                break;
            case 'evaluateur':
                header("Location: reviewer.php");
                break;
            case 'user':
                header("Location: user.php");
                break;
        }
    } else {
        // Utilisateur n'existe pas ou mauvais mot de passe
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
    $conn->close();
?>
