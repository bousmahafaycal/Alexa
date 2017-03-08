<?php
if (!session_id()) session_start();
// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce


if (empty($_SESSION['precedent']))
	exit();

if (isset($_SESSION['connecte']) && isset($_POST['idArticle']) && ! (empty($_POST['corps'])) && empty($_POST['id'])){
	if ($_SESSION['connecte']){
		if (is_numeric($_POST['idArticle']))
			$res = Commentaire::ajouterCommentaire($_SESSION['id'],$_POST['idArticle'], $_POST['corps']);

		
		
	}
}

// Pas une bonne idée  de modifier les commentaires 
/*
if (isset($_SESSION['connecte']) && isset($_POST['idArticle']) && isset($_POST['corps']) && isset(($_POST['id'])){
	if ($_SESSION['connecte']){
		include('Commentaire.php');
		if (is_numeric($_POST['idArticle']) && is_numeric($_POST['id'])){
			$com = new Commentaire($_POST['id'],$bdd)
		
			if ($com->getCommentaireExiste())
				$com->modifieCorps($bdd,$com->getId(),$_POST['corps']);

			
		}

		
		
	}
} */

header("location: ".$_SESSION['precedent']);
exit();

?>