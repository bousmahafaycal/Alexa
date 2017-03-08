<?php

session_start();
$_SESSION['precedent'] = "aPropos.php?";

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
				<h1>A propos</h1>
			</section>

			<div class="container2 multicolumn" style="margin-top: 25px;">
				<div class="left">
					<div class="content">
						<p><strong>Qu'est ce qu'Alexa?</strong></p>
						<p>Sans aucun doute votre meilleure source d’information de la journée.<br>
						<em>Alexa</em> est né dans le but d'un projet Internet, en Mai 2016.</br>
						<strong>Paul Monties</strong> et <strong>Fayçal Bousmaha</strong> décident alors de créer leur propre site d'information.</p>
						<p><strong>Peut-on envoyer des idées à Alexa ?</strong></p>
						<p>Bien sûr! Vous pouvez vous même créer votre article, si vous avez envie de partager un sujet.</p>
						<p><strong>J’ai une idée de partenariat intéressant pour l'Alexa et nous pourrions bien devenir riches et célèbres.</strong></p>
						<p>Pour nous envoyer une proposition, utilisez la page de contact, trouvable dans le footer de la page. Toutes les propositions sont lues et examinées.</p>
						<p><strong>Existe-t-il un compte Twitter ou Facebook d'Alexa ?</strong></p>
						<p>Pas encore! Mais peut-être que si notre site devient réputé, nous y penserons...</p>
						<p><strong>Le site est-il gratuit?</strong></p>
						<p>Oui, malgré qu'un systeme de points soit en place pour certains articles! Les points sont faciles et rapides à obtenir, nous sommes des administrateurs généreux!</p>
						<p><strong>Alexa appartient-il à un groupe de presse ?</strong></p>
						<p>Non! Aux dernieres nouvelles, nous sommes indépendants.</p>
						<p><strong>Les commentaires des articles sont-ils écrits par vous ?</strong></p>
						<p>Non, les commentaires sont écrits par des lecteurs totalement libres de leurs mouvements. Notez que les commentaires sont néanmoins modérés pour éviter tout débordement. Les commentaires visés peuvent être supprimés.</p>
						<p><strong>Où le site est-il hébergé?</strong></p>
						<p>Sur OVH!</p>
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