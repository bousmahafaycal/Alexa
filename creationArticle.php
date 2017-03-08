<?php
if (!session_id()) session_start();
// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('ArticlePaye.php'); // Fonctions pour récuperer les articles payes
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce




// Si pas connecte demander l'authentification
if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}

$_SESSION['precedent']="creationArticle.php?";
$per = new Personne($_SESSION['id'],$bdd);

// requete pour créer l'article
if (! (empty($_POST['titre']) || empty($_POST['corps']) || empty ($_POST['categorie'])) &&  is_numeric($_POST['categorie'])){ 
			$cat = new Categorie($_POST['categorie'], $bdd);
			if ($cat->getCategorieExiste() && strlen($_POST['titre']) <= 65 ) {
					$req = $bdd->prepare('INSERT INTO `Article` (`id`, `titre`, `corps`, `idAuteur`, `idCategorie`, `image`,`date_creation`) VALUES (NULL, ?, ?, ? , ?, ?, NOW() )'); 
					$req->execute(array($_POST['titre'], $_POST['corps'], $_SESSION['id'], $_POST['categorie'], "0.jpg")) ;
					$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
					$article = true;
					// On recupere l'id du dernier article
					$req = $bdd->prepare('SELECT id FROM Article WHERE idAuteur = ? ORDER BY date_creation DESC LIMIT 0, 1');
					$req->execute(array($per->getId() ));
					$donnees = $req->fetch();
					$id = $donnees['id'];
					ArticlePaye::ajout($per->getId(),$id, $bdd);
			}
}

// requete pour ajouter le fichier si il exixte
if ( isset($article) AND isset($_FILES['monfichier']) AND  $_FILES['monfichier']['error'] == 0){
	//echo "fichier existe";
	// Extension à verif
	$infosfichier = pathinfo($_FILES['monfichier']['name']);
	$extension_upload = $infosfichier['extension'];
	$extension_autorisees = array('jpg','jpeg','png','gif');

	if (in_array($extension_upload, $extension_autorisees)){ // Si l'extension est autorisée
		//echo "extension reconnue";
		

		// On recupere l'extension du fichier
		$extension = strrchr(basename($_FILES['monfichier']['name']),'.'); 
		// On valide le fichier 
		move_uploaded_file($_FILES['monfichier']['tmp_name'], "uploadArticle/".$id.$extension);

		// Puis on met le lien dans la base de donnée
		Article::modifieImage($bdd,$id,$id.$extension);
	}
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="logo1/logo1_noir_decalque.png">
  <link rel="stylesheet" href="IO2_style1.css">
  <title>Alexa - Créer un article</title>
</head>
<body>

	<?php include("header.php"); ?>

    <?php include("nav.php"); ?>

    <div class="container">
    	<h2 class="titreInsc">Alexa - Création d'un article</h2>
	</div>

	<div class="container content-form creaRetouch" style="margin-bottom: 30px;">
	<section class="creation">
		<?php  // A partir de la, le code a été modifié Paul
			if (isset($article) && $article == true){
				echo "<p class=\"bluehover pstyle\" style=\"line-height: 40px;\">Votre article a été enregistré, voici le lien pour y acceder : ";

		?>
		<a class="sinslink_bis" href=<?php 
					$req = $bdd->prepare('SELECT id FROM `Article` WHERE idAuteur = ? ORDER BY id DESC');
					$req->execute(array($_SESSION['id']));
					$donnees = $req->fetch();
					$id = $donnees['id'];
					echo	"\"article.php?billet=".$id."\""; 

		?>
		/> <?php  echo	"Article n°".$id; ?>
		</a> </p>
		<?php }  // Fin modification du code Paul ?>
		
		<!-- <form method="post" action="index.php">  non et non mdrrr il faut detecter les erreurs de un et de deux il faut  
		laisser l'occasion à une personne qui veut écrire plusieurs article d'en ecrire plusieurs ! Par contre ca part d'un bon sentiment 
		et c'est pour ça que j'ai ajouté le message la haut donnant un lien vers l'aricle crée si la personne veut le voir en action 
		Du coup Css à revoir pour les messages d'erreur et de réussite -->

		<form method="post" action="creationArticle.php" enctype="multipart/form-data">
			<div class="rowcreation">
				<label for="titre" class="forminsc">Titre de votre article (65 caractères au maximum): </label>
				<input type="text" maxlength="65" placeholder="Veillez à garder un titre pertinent" name="titre" id="titre" class="creationInput" value= 
				<?php
					echo "\"";
					if (isset($_POST['validate'])) {
						if (isset($_POST['titre'])){
							echo $_POST['titre'];
						}
					}
					echo "\"";

				?> 
				/>  
				<?php // Verification titre
					if (empty($_POST['titre']) && isset($_POST['validate'])) {
						echo "<span class=\"champvide\">Champ vide</span>";
						
					}
					elseif (isset($_POST['titre']) && strlen($_POST['titre']) > 65 ){
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Maximum 65 caractères sont attendus !</span>";
					}
				?> 
				<br>
			</div>

			<div class="rowcreation">
				<label for="file" class="forminsc labcreation">Choisissez une image bannière pour votre article : (Facultatif)</label> 
				<?php
					// Verification fichier pas vide
					if (isset($_FILES['monfichier']) && $_FILES['monfichier']['error'] != 0 ){
						echo "<span class=\"champvide\">Champ vide</span>";
					}
				?>
				<br>
				<input type="file" name="monfichier"/>
				<br>
			</div>

			<div class="rowcreation">
				<label class="forminsc cccreate" for="corps">Le contenu de votre article : </label> 
				<?php // Verification corps
					if (empty($_POST['corps']) && isset($_POST['validate'])) {
						echo "<span class=\"champvide\">Champ vide</span>";
					
					}
				?> 
				<br>
				<textarea class="creationInputArea" placeholder="Corps de votre article" name="corps" rows="10" cols="70" ><?php
						if (isset($_POST['validate'])) {
							if (isset($_POST['corps'])){
								echo $_POST['corps'];
							}
						}
					?></textarea>
				<br>
			</div>

			<div class="rowcreation">
				<label for="categorie" class="forminsc labcreation">La catégorie de votre article : </label> 
				<select name="categorie" id="categorie" class="selectcreate">
					<?php 
						// Récupération des categories
						$req = $bdd->prepare('SELECT id , titre FROM `Categorie`');
						$req->execute();
						while ($donnees = $req->fetch()) {
							$cat = new Categorie ($donnees['id'], $bdd);						
					?>
							<option value=<?php echo "\"".$donnees['id']."\"";?> > <?php echo $donnees['titre']; ?> </option>
					<?php
						}
					?>
				</select>
				<br>
			</div>

			

			<fieldset class="validation_insc" style="width: 90% !important; margin: auto; margin-bottom: 17px !important;">
				<input type="hidden" name="validate" id="validate" value="OK"/>
				<input type="submit" value="Envoyer"  class="submit_but" id="valider">
				<br>
			</fieldset>

		</form>

		
	</section>
	</div>

	<?php include("footer.php"); ?>

</body>
</html> 