<?php

session_start();
$_SESSION['precedent'] = "mentions_legales.php?";

// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('ArticlePaye.php'); // Fonctions pour récuperer les articles payes
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
      <?php include('link.php'); ?>
      <title>Alexa</title>
    </head>

    <body>

      	<?php include("header.php"); ?>
		<?php include("nav.php"); ?>

		<div id="main">
			<section class="headline container2">
				<h1>Mention légales</h1>
			</section>

			<div class="container2 multicolumn" style="margin-top: 25px;">
				<div class="left">
					<div class="content">
						<p><strong>Directeur de la publication</strong></p>
						<p>Fayçal Bousmaha</p>
						<p><strong>Hébergeur</strong></p>
						<p>OVH.</p>
						<p><strong>Données personnelles</strong></p>
						<p>Les informations vous concernant sont destinées à Alexa.</p>
						<p>Conformément aux dispositions de la loi du 6 janvier 1978 relative aux fichiers, à l’informatique et aux libertés, vous disposez d’un droit d’accès, de rectification et d’opposition aux données personnelles le concernant.</p>
						<p>N'hésitez pas à nous contacter via notre page de contact.</p>
					</div>
				</div>
				<div class="right">
					<?php include('rightPannelIndex.php'); ?>
				</div>
			</div>
		</div>

      	<?php include("footer.php"); ?>

    </body>
</html>