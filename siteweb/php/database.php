<?php
    $host = "localhost";
    $db = "sitewebdb";
    $dbusername = "sitewebuser";
    $dbpassword = "sitewebpassword";

    $conn = new MySQLi($host, $dbusername, $dbpassword, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function isUser($username, $password) {
        global $conn;
        $query = "SELECT * FROM UTILISATEUR WHERE login='$username' AND motDePasse='$password';";
        $result = $conn->query($query);
        return $result->num_rows > 0;
    }

    function getNumUtilisateur($username, $password) {
        global $conn;
        $query = "SELECT * FROM UTILISATEUR WHERE login='$username' AND motDePasse='$password';";
        $result = $conn->query($query);
        return $result->fetch_assoc()['numUtilisateur'];
    }

    function isAdmin($numUtilisateur) {
        global $conn;
        $query = "SELECT * FROM ADMINISTRATEUR, UTILISATEUR WHERE numAdministrateur=$numUtilisateur;";
        $result = $conn->query($query);
        return $result;
    }

    function isReviewer($numUtilisateur) {
        global $conn;
        $query = "SELECT * FROM EVALUATEUR, UTILISATEUR WHERE numEvaluateur=$numUtilisateur;";
        $result = $conn->query($query);
        return $result;
    }

    function createUser($nom, $prenom, $age, $adresse, $login, $motDePasse, $numClub, $dateInscription){
        global $conn;
        $query = "INSERT INTO UTILISATEUR (nom, prenom, age, adresse, login, motDePasse, numClub, dateInscription) VALUES ('$nom', '$prenom', '$age', '$adresse', '$login', '$motDePasse', '$numClub', '$dateInscription');";
        $result = $conn->query($query);
        if (!$result) {
            die("Erreur : " . $conn->connect_error);
        }
        else {
            return "Utilisateur créé";
        }
    }

    function freeQuery($query) {
        global $conn;
        $result = $conn->query($query);
        return $result;
    }

    function grantAdmin($numUtilisateur) {
        global $conn;
        $date = date(Y-m-d);
        $query = "INSERT INTO ADMINISTRATEUR (numAdministrateur, dateDebut) VALUES ($numUtilisateur, $date);";
        $result = $conn->query($query);
        if (!$result) {
            die("Erreur : " . $conn->connect_error);
        }
        else {
            echo "L'utilisateur $numUtilisateur à été promu en tant qu'administrateur";
        }
    }

    $query1 = "SELECT 
        UTILISATEUR.nom, 
        UTILISATEUR.prenom, 
        UTILISATEUR.adresse, 
        UTILISATEUR.age, 
        CLUB.nomClub, 
        CLUB.departement, 
        CLUB.region,
        CONCOURS.descriptif,
        CONCOURS.dateDebut,
        CONCOURS.dateFin
        FROM COMPETITEUR, UTILISATEUR, PARTICIPE_COMPETITEUR, CONCOURS, CLUB
        WHERE YEAR(CONCOURS.dateDebut) = 2021 
        AND COMPETITEUR.numCompetiteur = UTILISATEUR.numUtilisateur 
        AND COMPETITEUR.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur
        AND PARTICIPE_COMPETITEUR.numConcours = CONCOURS.numConcours 
        AND UTILISATEUR.numClub = CLUB.numClub;";

    $query2 ="SELECT 
        DESSIN.numDessin, 
        EVALUATION.note, 
        UTILISATEUR.nom,
        UTILISATEUR.prenom,
        CONCOURS.descriptif,
        CONCOURS.theme
        FROM DESSIN,EVALUATION, COMPETITEUR, PARTICIPE_COMPETITEUR,CONCOURS, UTILISATEUR
        WHERE YEAR(EVALUATION.dateEvaluation) = 2022 
        AND DESSIN.numDessin = EVALUATION.numDessin 
        AND DESSIN.numCompetiteur = COMPETITEUR.numCompetiteur
        AND DESSIN.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur 
        AND PARTICIPE_COMPETITEUR.numConcours = CONCOURS.numConcours
        AND COMPETITEUR.numCompetiteur=UTILISATEUR.numUtilisateur
        ORDER BY EVALUATION.note ASC;";

    $query3="SELECT 
        DESSIN.numDessin,
        YEAR(EVALUATION.dateEvaluation) as annee,
        CONCOURS.descriptif,
        comp.nom,
        comp.prenom,
        eva.nom,
        eva.prenom,
        DESSIN.commentaire,
        EVALUATION.note,
        EVALUATION.commentaire
        FROM DESSIN, UTILISATEUR eva, UTILISATEUR comp, EVALUATION, COMPETITEUR, EVALUATEUR, PARTICIPE_COMPETITEUR, CONCOURS
        WHERE DESSIN.numDessin = EVALUATION.numDessin
        AND DESSIN.numCompetiteur = COMPETITEUR.numCompetiteur
        AND EVALUATION.numEvaluateur = EVALUATEUR.numEvaluateur
        AND DESSIN.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur
        AND PARTICIPE_COMPETITEUR.numConcours = CONCOURS.numConcours
        AND EVALUATEUR.numEvaluateur=eva.numUtilisateur
        AND COMPETITEUR.numCompetiteur=comp.numUtilisateur
        ORDER BY DESSIN.numDessin ASC;";

    $query4="SELECT 
        UTILISATEUR.nom, 
        UTILISATEUR.prenom,
        UTILISATEUR.age 
        FROM COMPETITEUR, UTILISATEUR,PARTICIPE_COMPETITEUR 
        WHERE COMPETITEUR.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur 
        AND COMPETITEUR.numCompetiteur=UTILISATEUR.numUtilisateur
        GROUP BY COMPETITEUR.numCompetiteur
        HAVING (
        SELECT COUNT(*) 
        FROM PARTICIPE_COMPETITEUR 
        WHERE PARTICIPE_COMPETITEUR.numCompetiteur=COMPETITEUR.numCompetiteur) = (SELECT COUNT(*) FROM CONCOURS);";

    $query5="SELECT 
        CLUB.region, 
        AVG(EVALUATION.note) as moyenne
        FROM DESSIN, EVALUATION, COMPETITEUR, CLUB, UTILISATEUR
        WHERE DESSIN.numDessin = EVALUATION.numDessin
        AND DESSIN.numCompetiteur = COMPETITEUR.numCompetiteur
        AND UTILISATEUR.numClub = CLUB.numClub
        AND COMPETITEUR.numCompetiteur=UTILISATEUR.numUtilisateur
        GROUP BY 
        CLUB.region
        ORDER BY 
        AVG(EVALUATION.note) DESC;";

    $query6="WITH best_region AS (SELECT 
        CLUB.region,
        CONCOURS.numConcours,
        AVG(EVALUATION.note) as moyenne,
        ROW_NUMBER() OVER (PARTITION BY CONCOURS.numConcours ORDER BY AVG(EVALUATION.note) DESC) as rank
        FROM DESSIN, EVALUATION, COMPETITEUR, CLUB, PARTICIPE_COMPETITEUR, CONCOURS, UTILISATEUR 
        WHERE DESSIN.numDessin = EVALUATION.numDessin
        AND DESSIN.numCompetiteur = COMPETITEUR.numCompetiteur
        AND COMPETITEUR.numCompetiteur=UTILISATEUR.numUtilisateur
        AND UTILISATEUR.numClub = CLUB.numClub
        AND DESSIN.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur
        AND PARTICIPE_COMPETITEUR.numConcours = CONCOURS.numConcours
        GROUP BY 
        CLUB.region,
        CONCOURS.numConcours)
        SELECT region, numConcours, moyenne
        FROM best_region
        WHERE rank = 1;";

    $query7="SELECT 
        UTILISATEUR.nom,
        UTILISATEUR.prenom,
        EVALUATION.numEvaluateur,
        COUNT(EVALUATION.numDessin) as nombreEvaluation,
        AVG(EVALUATION.note) as moyenneEvaluations
        FROM 
        EVALUATION, EVALUATEUR, UTILISATEUR
        WHERE  EVALUATION.numEvaluateur = EVALUATEUR.numEvaluateur AND EVALUATEUR.numEvaluateur=UTILISATEUR.numUtilisateur
        GROUP BY 
        EVALUATEUR.numEvaluateur;";

    $query8="SELECT 
        CLUB.nomClub, 
        COUNT(DISTINCT UTILISATEUR.numUtilisateur) as nbMembres, 
        AVG(EVALUATION.note) as moyenneNotes
        FROM CLUB, UTILISATEUR, COMPETITEUR, PARTICIPE_COMPETITEUR, DESSIN, EVALUATION
        WHERE CLUB.numClub = UTILISATEUR.numClub
        AND UTILISATEUR.numUtilisateur = COMPETITEUR.numCompetiteur
        AND COMPETITEUR.numCompetiteur = PARTICIPE_COMPETITEUR.numCompetiteur
        AND PARTICIPE_COMPETITEUR.numConcours = DESSIN.numConcours
        AND DESSIN.numDessin = EVALUATION.numDessin
        GROUP BY CLUB.nomClub;";
?>