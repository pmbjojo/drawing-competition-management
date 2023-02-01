<?php
include ("menu.php");
include ("database.php");

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$age = $_POST["age"];
$adresse = $_POST["adresse"];
$login = $_POST["login"];
$motDePasse = $_POST["motDePasse"];
$numClub = $_POST["numClub"];
$dateInscription = date('Y-m-d');

$result = createUser($nom, $prenom, $age, $adresse, $login, $motDePasse, $numClub, $dateInscription);
echo $result;
?>

