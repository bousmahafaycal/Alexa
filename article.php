<?php
if (!session_id()) session_start();


$_SESSION['precedent']="article.php?";

if (isset($_GET['billet']))
	$_SESSION ['precedent'] = $_SESSION ['precedent']."&billet=".$_GET['billet'] ;




	

// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('ArticlePaye.php'); // Fonctions pour récuperer les articles payes
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce

if (isset($_GET['billet']) && is_numeric($_GET['billet'])){ // Si la variable issue de GET billet existe, on enregistre les données liées au nombre contenu par cette variable
	$art = new Article ($_GET['billet'],$bdd);
}
else { // SINON on redirige vers page non trouvée
	header("location: error404.php");
	exit();
}
if ($art->getGratuit()){
	$gratuit = true;
}

if (isset($gratuit) && empty($_SESSION['connecte'])){
	if (! ($art->getArticleExiste()) OR  ! ($art->getAffiche()) ) { // Si l'article n'existe pas ou l'article existe mais qu'il n'esst pas affichable on passe à 404.php
		header("location: error404.php");
		exit();
	}
}
else {
	if (empty($_SESSION['connecte'])){
		header("location: authentification.php?message=true");
		exit();
	}
	$moi = new Personne($_SESSION['id'],$bdd); // Recuperer les données de la personne
	if($moi->getDroit() >= 1){
		$moderateur= true;
	}

	if($moi->getDroit() >= 2){
		$admin= true;
	}
	if ($moi->getId() == $art->getIdAuteur() && ! $art->getInvisibleAuteur() ){
		$auteur = true;
	}

	if (! ($art->getArticleExiste()) OR (empty($auteur) && empty($moderateur) && ! $art->getAffiche()) OR (empty($auteur) && empty($admin) && $art->getModeration() && ! $art->getAffiche()) ) { // Si l'article n'existe pas ou l'article existe mais qu'il n'esst pas affichable on passe à 404.php
		header("location: error404.php");
		exit();
	}

	if (empty($gratuit) && empty($admin) && empty($moderateur) && empty($auteur)){
		if (isset($_GET['paye'])){
			if ($moi->decremente()){
				ArticlePaye::ajout($moi->getId(),$art->getId(), $bdd);
			}
		}
		
		if (! ArticlePaye::existeArticlePaye($moi->getId(),$art->getId(),$bdd)) {
			$paspaye=true;		
		}
	
	}

	

}

$modere = $art->getModeration();
$affiche = $art->getAffiche();
$per = new Personne ($art->getIdAuteur(),$bdd);
$cat = new Categorie ($art->getIdCategorie(),$bdd);

?>


<!DOCTYPE html>                 <!-- DEBUT DE LA PAGE -->
<html>
    <head>
   		<?php include('link.php'); ?>
        <title>Alexa</title>
    </head>
        
    <body>

    	<?php include('header.php');
    	include('nav.php'); ?>

    	<div id="main">
 
	        <?php 
	        	if(! $modere ){
	        		echo "<h3 class=\"prevent_msg2 cust_style\">Attention, cet article n'a toujours pas été modéré ! </h3>";
	        	}
	        	elseif ($modere && ! $affiche  ) {
	        		echo "<h3 class=\"prevent_msg2 cust_style\">Attention, cet article n'est pas visible aux yeux du public ! </h3>";
	        	}
		    ?>

	    

			<div class="corpsDeArticle"> <!-- juste pour visualiser, pas necessaire au css ou autre -->

				<section class="headline container2">
			    	<h1>
			        	<?php echo nl2br(htmlspecialchars($art->getTitre())); ?>
			    	</h1>
				</section>

				<section class="metas container2">
					<span class="context">
			    		Publié le <?php echo nl2br(htmlspecialchars($art->getDateCreationFr())); ?> par <strong><?php echo nl2br(htmlspecialchars($per->getNom().' '.$per->getPrenom())); 
			    	if (isset($auteur)){
			    		echo " (Moi)";
			    	}
			    	?></strong> - <?php echo nl2br(htmlspecialchars($cat->getTitre())); ?>
					</span>
				</section>

				<div class="container2 multicolumn">

					<div class="left">

					    <figure class="main_picture">
					    	<img src=<?php echo "\"uploadArticle/".$art->getImage()."\""; ?>alt="logo de l'article" title="logo de l'article" width="800" height="422">
					    </figure>

					    <div class="content">
					    	<div class="pre-extrait">
					    		<p style="font-weight: 700;">
					    			<?php echo htmlspecialchars($art->getExtrait()); ?>
					    		</p>
					    	</div>

						    <p>
						    <?php
						    if (isset($paspaye)){
						    	echo nl2br(htmlspecialchars($art->getExtraitLong()));
						    	echo nl2br("<p>Ceci est un extrait d'un article qui est plus long. Cet article est premium, c'est à dire qu'il faut échanger un point pour pouvoir consulter cet article. \nPour en savoir plus sur les points, <a href=\"points.php\">cliquez ici</a> \nAfin d'échanger un point contre cet article, cliquez ici : <a href=\"".$_SESSION['precedent']."&paye\"> Lien </a></p>");
						    } else {
						    	echo nl2br(htmlspecialchars($art->getCorps()));
						    }
						    ?>
						    </p>
						    <?php if (! $modere && isset($moderateur)){ ?>
						    <div class="flex-comments modo-on-comments">
						    	<a style="width: 50%;" class="modo-on-comments sinslink_bisbisbis" href=<?php echo "moderation.php?id=".$art->getId()."&affiche=2"; ?>>Valider cet article</a>  <!-- ICCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCI -->
							    <a style="width: 50%;" class="modo-on-comments sinslink_bisbis" href=<?php echo "moderation.php?id=".$art->getId()."&affiche=1"; ?>>Refuser cet article</a>
							</div>
							<div class="flex-comments modo-on-comments">
							    <a class="modo-on-comments sinslink_bis" href="moderation.php">Revenir à la modération sans valider ni refuser cet article</a>
						    </div>
						    <?php } 
						    	
						    	// ATTENTION : ajouter liens pour modifier et supprimer articles si on a les droits
						    	if (isset($admin) OR isset($moi) && $art->getIdAuteur() == $moi->getId() ) {
						    ?>
						    <div class="flex-comments modo-on-comments">
						    	<a style="width: 50%;" class="modo-on-comments sinslink_bis" href=<?php echo "\"modifieArticle.php?billet=".$art->getId()."\""?>>Modifier cet</br>article</a>
						    	<a style="width: 50%;" class="modo-on-comments sinslink_bisbis" href=<?php echo "\"supprimeArticle.php?id=".$art->getId()."\""?>>Supprimer cet article</a>
						    </div>

						    <?php  } ?>

						</div>

					</div>
					<div class="right">

						<?php include('rightPannelIndex.php'); ?>

					</div>

				</div>

				<div class="same_category container2">
					<h4>Egalement dans <a href="<?php echo mb_strtolower(nl2br(htmlspecialchars($cat->getTitre()))); ?>.php"><?php echo nl2br(htmlspecialchars($cat->getTitre())); ?></a></h4>
					<div class="contain_recent_article">

						<?php
                			$req = $bdd->prepare('SELECT id, idAuteur, titre, idCategorie, corps, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM Article WHERE idCategorie = ? AND affiche = ? AND invisibleAuteur = ? ORDER BY date_creation DESC LIMIT 0, 4');
                			$req->execute(array($art->getIdCategorie(),"1","0"));

                			while ($donnees = $req->fetch()){
                  				$art2 = new Article ($donnees['id'],$bdd);
              			?>

						<article>
							<figure>
								<a href="article.php?billet=<?php echo ($donnees['id']); ?>" title="Voir l'article">
									<img src=<?php echo "\"uploadArticle/".$art2->getImage()."\""; ?> alt="logo de l'article" title="logo de l'article" width="350" height="165">
								</a>
							</figure>
							<h2><a href="article.php?billet=<?php echo ($donnees['id']); ?>"><?php echo htmlspecialchars($art2->getTitre()); ?></a></h2>
						</article>

						<?php 
			                }
			                $req->closeCursor(); 
			            ?>

					</div>
				</div>
				    
			</div>

			<section class="commentaires"> <!-- Ici commencent les commentaires  -->
			<div class="container2 flex-comments">
				
				<div class="comments-area">

					<h2><?php echo $art->getNbCommentaire(); ?> commentaires</h2>
					
						<?php 

					// Récupération des commentaires
					$req = $bdd->prepare('SELECT id FROM `Commentaire` WHERE idArticle = ? ORDER BY date_commentaire');
					$req->execute(array($_GET['billet']));


					while ($donnees = $req->fetch()) {
						$com = new Commentaire($donnees['id'],$bdd);
						$per = new Personne ($com->getIdAuteur(),$bdd);
						$commentaireAffiche = $com->getAffiche();
						$modere = $com->getModeration();
						if (isset($moi) && $moi->getId() == $com->getIdAuteur() && ! $com->getInvisibleAuteur() ){
							$auteur = true;
						}else {
							$auteur = false;
						}
						if ( ($commentaireAffiche && ! $com->getInvisibleAuteur())  OR (isset($moderateur)  && ! $modere && ! $com->getInvisibleAuteur()) OR isset($admin) OR ( isset($moi) && $moi->getId() == $com->getIdAuteur() && ! $com->getInvisibleAuteur())){
							// Si le commentaire est montre comme affichable et que l'auteur ne l'a pas supprimé, si il ya un moderateur et que le commentaire n'est pas encore modere et que l'auteur ne l'a pas supprimer, si un administateur est la ou si l'auteur le voit et qu'il ne l'a pas supprime, alors on affiche le commentaire
							// inviibleAuteur pour pallier au cas si il est supprimé avant modération, que les auteurs n'aient pas à le modéré
							// utile surtout car on a pas mis d'assistant à la modification de commentaire
					?>
					<article class="comm">

						<div class="left-part">
							<figure>
								<img src=<?php echo "\"uploadPersonne/".$per->getImage()."\""; ?>alt="photo de profil" title="photo de profil" heigth="100px" width="100px">
							</figure>
						</div>

						<div class="right-part">
							<h4><?php echo nl2br(htmlspecialchars($per->getPseudo())); ?> <span class="date"><?php  echo nl2br(htmlspecialchars($com->getDateCommentaireFr())); ?></span></h4>
							<p><?php echo nl2br(htmlspecialchars($com->getCorps())); ?></p>
						</div>
						
						<div class="vote-comment">

							<div>
							<!-- Pouces verts : --> <strong style="color: #2BA3D4;"><?php echo Pouce::nombrePouce($com->getId(),true); ?></strong><?php
							if (isset($moi) && Pouce::verifPouce ($com->getId(), $_SESSION['id'], true) != 2) {?> 
							<a href=
							<?php echo "\"verifPouce.php?valeur=1&comment=".$com->getId()."\""; ?>>
								<img class="pouce_vote" src="pouces_de_couleur/les_pouces/les_vrais_pouces/pouce_bleu.png" width="25" height="25">
							</a>
							<?php 
								}elseif (isset($_SESSION['id'])){
									if (Pouce::verifPouce ($com->getId(), $_SESSION['id'], true) == 2){ ?>
									<a href=
									<?php echo "\"verifPouce.php?valeur=1&comment=".$com->getId()."\""; ?>>
										<img class="pouce_vote" src="pouces_de_couleur/les_pouces/les_vrais_pouces/pouce_bleu_2.png" width="25" height="25">
									</a>
							<?php	}}	?>
							</div>

							<div>
							<!-- Pouces rouge : --> <strong style="color: #CC0000;"><?php echo Pouce::nombrePouce($com->getId(),false); ?></strong><?php
							if (isset($moi) && Pouce::verifPouce ($com->getId(), $_SESSION['id'], false) != 2) { ?>
							<a href=
							<?php echo "\"verifPouce.php?valeur=0&comment=".$com->getId()."\""; ?>>
								<img class="pouce_vote" src="pouces_de_couleur/les_pouces/les_vrais_pouces/pouce_rouge_inverse.png" width="25" height="25">
							</a>
							<?php 
								}elseif (isset($_SESSION['id'])){
									if (Pouce::verifPouce ($com->getId(), $_SESSION['id'], false) == 2){ ?>
									<a href=
									<?php echo "\"verifPouce.php?valeur=0&comment=".$com->getId()."\""; ?>>
										<img class="pouce_vote" src="pouces_de_couleur/les_pouces/les_vrais_pouces/pouce_rouge_2_inverse.png" width="25" height="25">
									</a>
							<?php	}}	?>
							</div>

						</div>
							 
							 <?php 
							if ($com->getInvisibleAuteur()){
								echo "<h4 class=\"prevent_msg2 cust_style\">Attention : ce commentaire a été supprimé par son auteur.</h4>";
							 }
							elseif (! $modere ) {
								echo "<h4 class=\"prevent_msg2 cust_style\">Attention : ce commentaire est en cours de modération.";
								if ($moi->getId() == $com->getIdAuteur())
									echo " Il n'est visible que par vous meme et les modérateurs pour le moment.";
								echo "</h4>";
								
							}
							elseif ((isset($admin) || isset($auteur)) && $modere && empty($commentaireAffiche) ) {
								echo "<h4 class=\"prevent_msg2 cust_style\">Attention : ce commentaire n'a pas été jugé digne d'être publié.</h4>";
								// ajouter la possibilité de modifier le commentaire et le rendre valable ou de les supprimer definitivement
							}


							// ATTENTION : ajouter les fonctionnalités de modération si on a les droits
							 if (! $modere && isset($moderateur)){ ?>
							 	<div class="flex-comments modo-on-comments">
							    	<a class="modo-on-comments sinslink_bisbisbis" href=<?php echo "moderation.php?commentaire=true&id=".$com->getId()."&affiche=2"; ?>>Valider ce commentaire</a> <br>
								    <a class="modo-on-comments sinslink_bisbis" href=<?php echo "moderation.php?commentaire=true&id=".$com->getId()."&affiche=1"; ?>>Refuser ce commentaire</a> <br>
								</div>
								<div class="flex-comments modo-on-comments">
								    <a href="moderation.php" class="modo-on-comments sinslink_bis">Revenir à la modération sans valider ni refuser cet article</a>
								</div>
					    <?php } 
					   

					    	// ATTENTION : ajouter liens pour modifier et supprimer articles si on a les droits
							
							   
							// ATTENTION : ajouter les fonctionnalités de modification de commentaire
							if (isset($admin) OR isset($moi) && $moi->getId() == $com->getIdAuteur() ){ // Permet la supression du commentaire si on a les droits d'administrateur ou qu'on est l'auteur du commentaire
						?>
							<div class="flex-comments modo-on-comments">	
								<a style="width: 100%;" class="modo-on-comments sinslink_bisbis" href=<?php echo"\"supprimeCommentaire.php?id=".$com->getId()."\""; ?>>Supprimer le commentaire</a>
							</div>
						<?php

						 } ?>

						 	<div class="sign_comment">
						 		<p><em><?php echo htmlspecialchars($per->getSignature()); ?></em></p>
						 	</div>
					</article>


					<?php
							} // Fin du if commentaire affiche ou if moderateur ou if auteur
						} // Fin de la boucle des commentaires
						$req->closeCursor(); // Avant il était à la fin !!
					?>

				</div>

				<div class="rightcom">
				<div class="comment-respond" style="margin-top: 0px;">

					<?php  if (isset($_SESSION['connecte'])) { //Si l'utilisateur est connecte il a accès à la partie mettre son commentaire ?>
					<h3 class="titreInsc">Laisser un avis</h3> <!-- ancienne classe de ce titre : comment-reply-title -->

					<form method="post" action="ajoutCommentaire.php"> 

							<div class="comment-form-comment">
							<label for="corps">Votre message :</label>
							<br>
							<textarea name="corps" rows="8" cols="45" ></textarea>
						</div>

						<br>

						<div class="form-submit">
							<input type="hidden" name="idArticle" value= <?php echo "\"".$art->getId()."\""; ?> ></input>
							<input type="submit" value="Envoyer" class="submit_but" id="valider">
						</div>

					</form>

					<?php } else { ?>
					<div>
						<p class="prevent_msg2">Afin de pouvoir ajouter un commentaire ou donner votre avis en attribuant des votes positifs ou négatifs aux commentaires, merci de bien vouloir vous identifier. Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez vous</a>, c'est gratuit !</p>
					</div> <?php } ?>

				</div>
				</div>

			</div>
			</section>

		</div>

<?php include('footer.php'); ?>

</body>
</html>
