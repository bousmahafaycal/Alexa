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

$_SESSION['precedent']="superadmin.php?";

// Si pas connecte demander l'authentification
if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}

$moi = new Personne($_SESSION['id'],$bdd);


// Si y'a pas les droits suffisants (minimum droit 3 soit super admin)
if($moi->getDroit() < 3){
	header("location: droit.php");
	exit();
}


// Requete pour modifier les droits d'une personne, et dire que la personne a bien été administré
if (isset($_GET['droit']) && isset($_GET['id']) && is_numeric($_GET['id'] )){
	$per = new Personne($_GET['id'],$bdd);
	if ($per->getPersonneExiste()){
		Personne::modifieDroit($bdd,$per->getId(),$_GET['droit']);
		$idAdministre = $_GET['id'];
		$personne = true;
	}
		
	
	
}

	
	



?>


<!DOCTYPE html>
<html>
<head>
	<title>Alexa - Super-Administration</title>
	<?php include('link.php'); ?>
</head>
<body>

	<?php include('header.php');
	include('nav.php'); ?>

	<div class="moderation">
		<h1 class="titreInsc">Alexa - Super-Administration</h1>
	</div>
	
	<section class="moderation modoArticles">
		<div class="moderation2">

			<div style="padding-bottom: 14px;">
				<h3>Administration des personnes</h3>
			</div>

			<?php
				
				if (isset($idAdministre) && isset($personne)){
					$per = new Personne($idAdministre,$bdd);
					
					echo "<p>Vous avez changer les droits avec succès de la personne suivante :<p>" ?>
					<div style="margin-left: 25px; margin-top: 5px; margin-bottom: 5px;">
					<p class="bluehover">Nom Prenom : </p><?php echo" <p class=\"msgModo\">".$per->getNom()." ".$per->getPrenom().
					"<br></p>"; ?>
					<p class="bluehover">Droit : </p><?php echo" <p class=\"msgModo\">" ; if ($per->getDroit() == 3)echo "Super Administrateur"; elseif($per->getDroit() == 2) echo "Administrateur";  elseif($per->getDroit() == 1) echo "Modérateur"; elseif($per->getDroit() == 0) echo "Contribueur"; ?> </p>

					<?php echo "<br><p class=\"redhover\">Merci pour votre contribution !</p> </div>";
				}
			?>

			<?php
				if (isset($idSupprime)){ ?>
					<div style="margin-left: 25px; margin-top: 5px; margin-bottom: 5px;"><p class="bluehover">
				<?php
					echo "<p>Vous avez supprimé avec succès la personne avec l'id n°".$idSupprime." :<p>" ;
					echo "<p class=\"redhover\">Merci pour votre contribution !</p> </div>"; 
				}
			?>

			<p> Gestion des personnes  (Attention, les supressions sont définitives) :</p>
			<?php 
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` ');
				$req->execute();
				$donnees= $req->fetch();
				if ($donnees[0] == 0){ ?>
					
					<p class="nomodo">Aucune personne dans la base de données, normalement c'est pas possible !</p>
				
				<?php
				} else {
			?>
			<table class="modoTable">
			<tr class="toptr">
				<th>Id</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Pseudo</th>
				<th>Droit</th>
				<th>Rendre</th>
				<th>Rendre</th>
				<th>Supprimer</th>
			</tr>
				

			<?php
					// Récupération des persnnes
					$req = $bdd->prepare('SELECT id FROM `Personne` WHERE supprime = 0 AND droit < 3 ORDER BY id DESC  ');
					$req->execute();


					while ($donnees = $req->fetch()){
						$per = new Personne($donnees['id'],$bdd);



			?>
			<tr class="lignemodo">
				<td><?php  echo $per->getId(); ?></td>
				<td><?php  echo $per->getNom(); ?></td>
				<td><?php  echo $per->getPrenom(); ?></td>
				<td><?php  echo $per->getPseudo(); ?></td>
				<td><?php  if ($per->getDroit() == 3)echo "Super Administrateur"; elseif($per->getDroit() == 2) echo "Administrateur";  elseif($per->getDroit() == 1) echo "Modérateur"; elseif($per->getDroit() == 0) echo "Contribueur";?></td>
				
				<?php  if ($per->getDroit() == 2)  { ?> 
				<td class="vmr"><a href=<?php echo "\"superadmin.php?droit=1&id=".$per->getId()."\""?>>Modérateur</a></td>
				<?php } else { ?>
				<td class="vmv"><a href=<?php echo "\"superadmin.php?droit=2&id=".$per->getId()."\""?>>Administrateur</a></td>
				<?php  } if ($per->getDroit() == 0)  { ?>
				<td class="vmv"><a href=<?php echo "\"superadmin.php?droit=1&id=".$per->getId()."\""?>>Modérateur</a></td>
				<?php } else { ?>
				<td class="vmr"><a href=<?php echo "\"superadmin.php?droit=4&id=".$per->getId()."\""?>>Contibueur</a></td>
				<?php } ?>
				<td class="vmr"><a href=<?php echo "\"supprimePersonne.php?id=".$per->getId()."\""?>>Supprimer</a></td>
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
