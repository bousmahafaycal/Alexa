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
	$art = new Article ($_GET['id'], $bdd);
	//echo "get est numerique, ".$_GET['id'];
	if ($art->getArticleExiste()){
		
		if ($moi->getId() == $art->getIdAuteur()){
			//echo "caché";
			// On le cache simplement à son auteur
			Article::modifieInvisibleAuteur($bdd, $_GET['id'], true);
			//echo("precedent: ".$_SESSION['precedent']);
			$_SESSION['precedent'] = $_SESSION['precedent']."&supprimeArticle=".$art->getId();
			//echo("precedent: ".$_SESSION['precedent']);
		}
		elseif (isset($admin)){
			if (file_exists("../uploadArticle/".$art->getImage()))
				unlink("../uploadArticle/".$art->getImage());

			//echo "veritable supression";
			// Veritable supression
			$req = $bdd->prepare('DELETE FROM `Article` WHERE `id` = ? ');
			$req->execute(array($_GET['id']));
			$donnees = $req->fetch();
			$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
			$_SESSION['precedent']=$_SESSION['precedent']."&supprimeArticle=".$art->getId()."&admin=true";
		}
	}
}

header("location: ".$_SESSION['precedent']);
exit();

?>