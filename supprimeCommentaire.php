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

if($moi->getDroit() >= 2){
	$admin = true;
}

if (isset($_GET['id']) && is_numeric($_GET['id']) ){
	$com = new Commentaire ($_GET['id'], $bdd);
	//echo "get est numerique, ";
	if ($com->getCommentaireExiste()){
		//echo "le commentaire existe, ";
		if ($moi->getId() == $com->getIdAuteur()){
			//echo "auteur";
			// On le cache simplement à son auteur
			Commentaire::modifieInvisibleAuteur($bdd, $_GET['id'], true);
			$_SESSION['precedent']=$_SESSION['precedent']."&supprimeCommentaire=".$com->getId();
		}
		elseif (isset($admin)){
			// Veritable supression
			//echo "admin";
			$req = $bdd->prepare('DELETE FROM `Commentaire` WHERE `id` = ? ');
			$req->execute(array($_GET['id']));
			$donnees = $req->fetch();
			$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
			$_SESSION['precedent']=$_SESSION['precedent']."&admin=true&supprimeCommentaire=".$com->getId();
		}
	}
}

header("location: ".$_SESSION['precedent']);
exit();

?>