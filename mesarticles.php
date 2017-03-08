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

$_SESSION['precedent']="mesarticles.php?";

// Si pas connecte demander l'authentification
if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}

$moi = new Personne($_SESSION['id'],$bdd);


if (isset($_GET['supprimeArticle']) && is_numeric($_GET['supprimeArticle']))
	$idSupprime = $_GET['supprimeArticle'];

?>


<!DOCTYPE html>
<html>
<head>
	<title>Alexa - Mes articles</title>
	<?php include('link.php'); ?>
</head>
<body>

	<?php include('header.php');
	include('nav.php'); ?>

	<div class="moderation">
		<h1 class="titreInsc">Alexa - Mes articles</h1>
	</div>
	
	<section class="moderation modoArticles">
		<div class="moderation2">

			<div style="padding-bottom: 14px;">
				<h3>Mes articles</h3>
			</div>

			<?php
				if (isset($idSupprime)){ ?>
					<div style="margin-left: 25px; margin-top: 5px; margin-bottom: 5px;"><p class="bluehover">
				<?php
					echo "<p>Vous avez supprimé avec succès l'article n°".$idSupprime." :<p>" ;
					echo "<p class=\"redhover\">Merci pour votre contribution !</p> </div>"; 
				}
			?>
			<p> Gestion des articles  (Attention, les supressions sont définitives) :</p>
			<?php 
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Article` WHERE idAuteur = ? AND `invisibleAuteur` = ?');
				$req->execute(array($moi->getId(), 0 ));
				$donnees= $req->fetch();
				if ($donnees[0] == 0){ ?>
					
					<p class="nomodo">Vous n'avez encore écrit aucun article !</p>
				
				<?php
				} else {
			?>
			<table class="modoTable">
			<tr class="toptr">
				<th class="titleModo">Titre</th>
				<th>Auteur</th>
				<th>Lien de l'article</th>
				<th>Visible</th>
				<th>Modéré</th>
				<th>Modifier</th>
				<th>Supprimer</th>
			</tr>
				

			<?php
					// Récupération des articles ecrit par la personne connecte
					$req = $bdd->prepare('SELECT id FROM `Article` WHERE idAuteur = ? AND `invisibleAuteur` = ? ORDER BY id DESC  ');
					$req->execute(array($moi->getId(), 0 ));


					while ($donnees = $req->fetch()){
						$art = new Article($donnees['id'],$bdd);
						$per = new Personne ($art->getIdAuteur(),$bdd);

			?>
			<tr class="lignemodo">
				<td class="titleModo"><?php  echo $art->getTitre(); ?></td>
				<td><?php  echo $per->getNom()." ".$per->getPrenom(); ?></td>
				<td><a class="sinslink_bis" href=<?php echo "\"article.php?billet=".$art->getId()."\""?>>Article <?php echo $art->getId() ?></a></td>
				<td><?php  if ($art->getAffiche() )echo "Oui"; else echo "Non"; ?></td>
				<td><?php  if ($art->getModeration() )echo "Oui"; else echo "Non"; ?></td>
				<td class="vmv"><a href=<?php echo "\"modifieArticle.php?billet=".$art->getId()."\""?>>Modifier</a></td>
				<td class="vmr"><a href=<?php echo "\"supprimeArticle.php?id=".$art->getId()."\""?>>Supprimer</a></td>
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
