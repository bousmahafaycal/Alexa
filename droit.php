<?php 
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



// Si pas connecte demander l'authentification
if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Alexa - Droits requis</title>
	<?php include('link.php'); ?>
</head>
<body>

	<?php include('header.php');
	include('nav.php'); ?>

	<section class="rights">

		<h1 class="titreInsc">Alexa - Vous n'avez pas les droits requis</h1>
		
		<p>
			<strong>Bonjour, vous avez tenté d'acceder à une page à laquelle vous n'avez pas les droits nécéssaires pour y acceder.</strong></br>
			<!--Si vous n'êtes pas authentifier, merci de le faire en cliquant ici : -->
		</p>
		<!--<div>
			<a href="authentification.php" class="sinslink_bis but_rights">Connexion</a>
		</div> -->
		<p>	
			Si vous êtes authentifié et pensez que cela est une erreur, merci de nous contacter avec le formulaire suivant :
		</p>
		<div>
			<a href="contact.php" class="sinslink_bis but_rights">Nous contacter</a>
		</div>
		<p>
			Pour revenir à l'accueil,
		</p>
		<div id="have_to_border_bottom">
			<a href="index.php" class="sinslink but_rights">Cliquez ici</a>
		</div>

	</section>

	<?php include('footer.php'); ?>

</body>
</html>