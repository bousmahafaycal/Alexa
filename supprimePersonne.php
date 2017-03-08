<?php
if (!session_id()) session_start();


if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}

// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce



$moi = new Personne($_SESSION['id'],$bdd); // Recuperer les données de la personne

// Si y'a pas les droits suffisants (minimum droit 3 soit super admin)
if($moi->getDroit() < 3){
	header("location: droit.php");
	exit();
}


if (isset($_GET['id']) && is_numeric($_GET['id']) ){
	$per = new Personne ($_GET['id'], $bdd);

	if ($per->getDroit() < 3) {
		//echo "get est numerique, ".$_GET['id'];
		Personne::modifieSupprime($bdd, $_GET['id'], 1);
		//echo("precedent: ".$_SESSION['precedent']);
		$_SESSION['precedent'] = $_SESSION['precedent']."&supprimePersonne=".$per->getId();
		//echo("precedent: ".$_SESSION['precedent']);
	}
		
}


header("location: ".$_SESSION['precedent']);
exit();

?>