<?php

session_start();
$_SESSION['precedent'] = "cgu.php?";

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
				<h1>Conditions générales d'utilisation</h1>
			</section>

			<div class="container2 multicolumn" style="margin-top: 25px;">
				<div class="left">
					<div class="content">
						<p><strong>ALEXA – Conditions Générales d’Utilisation</strong></p>
						<p>Le directeur de la publication est Fayçal Bousmaha.</p>
						<p><strong>Conditions Générales</strong></p>
						<p>L’utilisation du site alexa.bousmaha.com est régie par les présentes conditions générales d’utilisation.</p>
						<p>Ce site est destiné à des fins de présentation du travail effectué par Paul Monties et Fayçal Bousmaha</p>
						<p>L’Editeur met à la disposition de ses utilisateurs le site alexainfo.ml, ainsi que les services disponibles sur le site et défini ci-après la manière par laquelle l’utilisateur accède au site et utilise ses services.</p>
						<p>En utilisant ce site, l’utilisateur reconnait avoir pris connaissance de ses conditions générales d’utilisation et les avoir acceptées.</p>
						<p><strong>Accessibilité du Site</strong></p>
						<p>L’Editeur s’efforce de permettre l’accès au site alexainfo.ml 24 heures sur 24, 7 jours sur 7, sauf en cas de force majeure ou d’un événement hors du contrôle de l’Editeur, et sous réserve des éventuelles pannes et interventions de maintenance nécessaires au bon fonctionnement du site et des services.</p>
						<p>Par conséquent, l’Editeur ne peut garantir une disponibilité du site et/ou des services, une fiabilité des transmissions et des performances en termes de temps de réponse ou de qualité. Il n’est prévu aucune assistance technique vis à vis de l’utilisateur que ce soit par des moyens électronique ou téléphonique.</p>
						<p>La responsabilité de l’Editeur ne saurait être engagée en cas d’impossibilité d’accès à ce site et/ou d’utilisation des services.</p>
						<p>Par ailleurs, l’Editeur peut être amené à interrompre le site ou une partie des services, à tout moment sans préavis, le tout sans droit à indemnités. L’utilisateur reconnaît et accepte que l’Editeur ne soit pas responsable des interruptions, et des conséquences qui peuvent en découler pour l’utilisateur ou tout tiers.</p>
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