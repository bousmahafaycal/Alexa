<?php

// Developpement possible : noter qui a modérer l'article pour que les administrateurs le sachent en cas de problème

// On crée la Session
if (!session_id()) session_start();

// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce

$_SESSION['precedent']="admin.php?";

// Si pas connecte demander l'authentification
if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}

$per = new Personne($_SESSION['id'],$bdd);


// Si y'a pas les droits suffisants (minimum droit 2 soit admin)
if($per->getDroit() < 2){
	header("location: droit.php");
	exit();
}


// Requete pour modifier l'affichage ou pas d'un article, et dire que l'article a bien été administré
if (isset($_GET['affiche']) && isset($_GET['id']) && empty($_GET['commentaire']) && is_numeric($_GET['id'] )){
	$art = new Article($_GET['id'],$bdd);
	if ($art->getArticleExiste()){
		
		Article::modifieModeration($bdd,$_GET['id'],true);
		//Article::modifieIdModerateur($bdd,$_GET['id'],$_SESSION['id']);
		if ($_GET['affiche'] == 2 ){
			//echo "true pas comprehensible, value : ".$_GET['affiche'];
			Article::modifieInvisibleAuteur($bdd,$_GET['id'],false);
			Article::modifieAffiche($bdd,$_GET['id'],true);
		}
		else {
			Article::modifieAffiche($bdd,$_GET['id'],false);
		}
		$idAdministre = $_GET['id'];
		$article = true;
	}
		
	
	
}


// Requete pour la gestion du cout d'un article, et dire que l'article a bien été administré
if (isset($_GET['gratuit']) && isset($_GET['id']) && is_numeric($_GET['id'] )){
	$art = new Article($_GET['id'],$bdd);
	if ($art->getArticleExiste()){
		if ($_GET['gratuit'] == 2 ){
			Article::modifieGratuit($bdd,$_GET['id'],true);
		}
		else {
			Article::modifieGratuit($bdd,$_GET['id'],false);
		}
		$idAdministre = $_GET['id'];
		$article = true;
	}
		
	
	
}


// Requete pour modifier l'affichage ou pas d'un commentaire, et dire que le commentaire a bien été modéré
if (isset($_GET['affiche']) && isset($_GET['id']) && isset($_GET['commentaire']) && is_numeric($_GET['id'] )){
	$com = new Commentaire($_GET['id'],$bdd);
	if ($com->getCommentaireExiste()){
		
		Commentaire::modifieModeration($bdd,$_GET['id'],true);
		Commentaire::modifieIdModerateur($bdd,$_GET['id'],$_SESSION['id']);

		if ($_GET['affiche'] == 2){
			//echo "true pas comprehensible, value : ".$_GET['affiche'];
			Commentaire::modifieInvisibleAuteur($bdd,$_GET['id'],false);
			Commentaire::modifieAffiche($bdd,$_GET['id'],true);
		}
		else {
			Commentaire::modifieAffiche($bdd,$_GET['id'],false);
		}
		
		$idAdministre = $_GET['id'];
		$commentaire = true;
	}
	// ATTENTION : ceci ne fonctionne pas encore	
	
	
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Alexa - Administration</title>
	<?php include('link.php'); ?>
</head>
<body>

	<?php include('header.php');
	include('nav.php'); ?>

	<div class="moderation">
		<h1 class="titreInsc">Alexa - Administration</h1>
	</div>
	
	<section class="moderation modoArticles">
		<div class="moderation2">

			<div style="padding-bottom: 14px;">
				<h3>Administration des articles</h3>
			</div>

			<?php
				
				if (isset($idAdministre) && isset($article)){
					$art = new Article($idAdministre,$bdd);
					$per = new Personne ($art->getIdAuteur(),$bdd); 
					echo "<p>Vous avez administre avec succès l'article suivant :<p>" ?>
					<div style="margin-left: 25px; margin-top: 5px; margin-bottom: 5px;"><p class="bluehover">Titre : </p><?php echo " <p class=\"msgModo\">".htmlspecialchars($art->getTitre()).
					"<br></p><p class=\"bluehover\">Auteur : </p><p class=\"msgModo\">".htmlspecialchars($per->getNom())." ".htmlspecialchars($per->getPrenom()).
					"<br><p><p class=\"bluehover\">Lien : </p><p class=\"msgModo\"><a class=\"sinslink_bis linkartmodo\" href=\"article.php?billet=".$art->getId()."\">Article n°".$art->getId()."</a><br></p>";
					echo "<p class=\"redhover\">Merci pour votre contribution !</p> </div>";
				}
			?>
			<p> Gestion des articles  (Attention, les supressions sont définitives) :</p>
			<?php 
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Article` ');
				$req->execute();
				$donnees= $req->fetch();
				if ($donnees[0] == 0){ ?>
					
					<p class="nomodo">Aucun article n'est à administré, merci de votre passage !</p>
				
				<?php
				} else {
			?>
			<table class="modoTable">
			<tr class="toptr">
				<th class="titleModo">Titre</th>
				<th>Auteur</th>
				<th>Lien de l'article</th>
				<th>Visible</th>
				<th>Rendre</th>
				<th>Gratuit</th>
				<th>Rendre</th>
				<th>Modifier</th>
				<th>Supprimer</th>
			</tr>
				

			<?php
					// Récupération des articles non administrés
					$req = $bdd->prepare('SELECT id FROM `Article` ORDER BY id DESC  ');
					$req->execute();


					while ($donnees = $req->fetch()){
						$art = new Article($donnees['id'],$bdd);
						$per = new Personne ($art->getIdAuteur(),$bdd);

			?>
			<tr class="lignemodo">
				<td class="titleModo"><?php  echo htmlspecialchars($art->getTitre()); ?></td>
				<td><?php  echo htmlspecialchars($per->getNom()." ".$per->getPrenom()); ?></td>
				<td><a class="sinslink_bis" href=<?php echo "\"article.php?billet=".$art->getId()."\""?>>Article <?php echo htmlspecialchars($art->getId()); ?></a></td>
				<td><?php  if ($art->getAffiche() && ! $art->getInvisibleAuteur())echo "Oui"; else echo "Non"; ?></td>
				<?php if (!($art->getAffiche()) ||  $art->getInvisibleAuteur()) { ?>
				<td class="vmv"><a href=<?php echo "\"admin.php?affiche=2&id=".$art->getId()."\""?>>Visible</a></td>
				<?php } else { ?>
				<td class="vmr"><a href=<?php echo "\"admin.php?affiche=1&id=".$art->getId()."\""?>>Invisible</a></td>
				<?php } ?>
				<td><?php  if ($art->getGratuit())echo "Gratuit"; else echo "Payant"; ?></td>
				<?php if (!($art->getGratuit()) ) { ?>
				<td class="vmv"><a href=<?php echo "\"admin.php?gratuit=2&id=".$art->getId()."\""?>>Gratuit</a></td>
				<?php } else { ?>
				<td class="vmr"><a href=<?php echo "\"admin.php?gratuit=1&id=".$art->getId()."\""?>>Payant</a></td>
				<?php } ?>
				<td class="vmv"><a href=<?php echo "\"modifieArticle.php?billet=".$art->getId()."\""?>>Modifier</a></td>
				<td class="vmr"><a href=<?php echo "\"supprimeArticle.php?id=".$art->getId()."\""?>>Supprimer</a></td>
			</tr>

			<?php } $req->closeCursor();  ?>
				
			</table>
			<?php } ?>
		</div>
	</section>

	<section class="moderation modoComments">
		<div class="moderation2">

			<div style="padding-bottom: 14px;">
				<h3>Administration des commentaires </h3>
			</div>

			<?php
				
				if (isset($idAdministre) && isset($commentaire)){
					$com = new Commentaire($idAdministre,$bdd);
					$per = new Personne ($com->getIdAuteur(),$bdd);
					$art = new Article($com->getIdArticle(),$bdd);
					echo "<p>Vous avez administré avec succès le commentaire suivant :</p>" ?>
					<div style="margin-left: 25px; margin-top: 5px; margin-bottom: 5px;"><p class="bluehover">Commentaire : </p><?php echo" <p class=\"msgModo\"> ".htmlspecialchars($com->getCorps()).
					"<br></p><p class=\"bluehover\">Auteur : </p><p class=\"msgModo\">".htmlspecialchars($per->getNom()." ".$per->getPrenom()).
					"<br></p><p class=\"bluehover\">Lien : </p><p class=\"msgModo\"><a class=\"sinslink_bis linkartmodo\" href=\"article.php?billet=".$art->getId()."\">Article n°".$art->getId()."</a><br></p>";
					echo "<p class=\"redhover\">Merci pour votre contribution !</p> </div>";
				}
			?>
			<p> Voici une liste de tous les commentaires pas encore administés  :</p>
			<?php 
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Commentaire`  ');
				$req->execute();
				$donnees= $req->fetch();
				if ($donnees[0] == 0){ ?>

					<p class="nomodo">Aucun commentaire n'est à admninistré, merci de votre passage !</p>
				
				<?php
				} else {
			?>
			<table class="modoTable">
			<tr class="toptr">
				<th class="commentModo">Commentaire</th>
				<th>Pseudo</th>
				<!-- <th>Titre article</th> -->
				<th>Lien article</th>
				<th class="vmh">Visible ?</th>
				<th>Rendre</th>
				<th>Supprimer</th>
			</tr>
				

			<?php
					// Récupération des commentaires non administés
					$req = $bdd->prepare('SELECT id FROM `Commentaire` ORDER BY id DESC');
					$req->execute();


					while ($donnees = $req->fetch()){
						$com = new Commentaire($donnees['id'],$bdd);
						$art = new Article($com->getIdArticle(),$bdd);
						$per = new Personne ($com->getIdAuteur(),$bdd);

			?>
			<tr class="lignemodo">
				<td class="commentModo"><?php  echo htmlspecialchars($com->getCorps()); ?></td>
				<td><?php  echo htmlspecialchars($per->getPseudo()); ?></td>
				<!-- <td><?php  echo $art->getTitre(); ?></td> -->
				<td><a class="sinslink_bis" href=<?php echo "\"article.php?billet=".$art->getId()."\""?>>Article n°<?php echo $art->getId() ?></a></td>
				<td><?php  if ($com->getAffiche() && ! $com->getInvisibleAuteur())echo "Oui"; else echo "Non"; ?></td>
				<?php if (!($com->getAffiche()) ||  $com->getInvisibleAuteur()) { ?>
				<td class="vmv"><a href=<?php echo "\"admin.php?commentaire=true&affiche=2&id=".$com->getId()."\""?>>Visible</a></td>
				<?php } else { ?>
				<td class="vmr"><a href=<?php echo "\"admin.php?commentaire=true&affiche=1&id=".$com->getId()."\""?>>Invisible</a></td>
				<?php } ?>
				<td class="vmr"><a href=<?php echo "\"supprimeCommentaire.php?id=".$com->getId()."\""?>>Supprimer</a></td>
			</tr>

			<?php } $req->closeCursor();  ?>
				
			</table>
			<?php } ?>
		</div>
	</section>

	<fieldset class="validation_insc fieldmodo">
		<a class="sinslink_bis" href="index.php">Retour à l'accueil</a>
	</fieldset>

	<?php include('footer.php') ?>

</body>
</html>
