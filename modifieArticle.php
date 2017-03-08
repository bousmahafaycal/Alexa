<?php
if (!session_id()) session_start();


$_SESSION['precedent']="modifieArticle.php?";

if (isset($_GET['billet']))
	$_SESSION ['precedent'] = $_SESSION ['precedent']."&billet=".$_GET['billet'] ;


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
	$admin= true;
}

if (isset($_GET['billet']) && is_numeric($_GET['billet'])){ // Si la variable issue de GET billet existe, on enregistre les données liées au nombre contenu par cette variable
	$art = new Article ($_GET['billet'],$bdd);
	if ($moi->getId() == $art->getIdAuteur() && ! $art->getInvisibleAuteur() ){
		$auteur = true;
	}

	

	if (! ($art->getArticleExiste()) OR (empty($auteur) && empty($admin)) ) { // Si l'article n'existe pas ou l'article existe mais qu'il n'esst pas affichable on passe à 404.php
		header("location: error404.php");
		exit();
	}

	$modere = $art->getModeration();
	$affiche = $art->getAffiche();
}
else { // SINON on redirige vers page non trouvée
	header("location: error404.php");
	exit();
}

$per = new Personne ($art->getIdAuteur(),$bdd);
$cat = new Categorie ($art->getIdCategorie(),$bdd);


// requete pour modifier l'article
if (! (empty($_POST['titre']) || empty($_POST['corps']) || empty ($_POST['categorie'])) ){ 
		if (strlen($_POST['titre']) <= 65  &&  is_numeric($_POST['categorie']))
			$cat = new Categorie($_POST['categorie'], $bdd);
			if ($cat->getCategorieExiste()) {
					Article::modifieTitre($bdd,$art->getId(),$_POST['titre']);
					Article::modifieCorps($bdd,$art->getId(),$_POST['corps']);
					Article::modifieIdCategorie($bdd,$art->getId(),$_POST['categorie']);
					$article = true;
					// On recupere l'id de l'article qui vient d'etre modifié
					$id = $_GET['billet'];
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
		// On supprime l'ancien fichier
		if (file_exists("uploadArticle/".$art->getImage()))
				unlink("uploadArticle/".$art->getImage());
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
  <title>Alexa - Modifier un article</title>
</head>
<body>

	<?php include("header.php"); ?>

    <?php include("nav.php"); ?>

    <div class="container">
    	<h2 class="titreInsc">Alexa - Modifier un article</h2>
	</div>

	<div class="container content-form creaRetouch" style="margin-bottom: 30px;">
	<section class="creation">
		<?php  
			if (isset($article) && $article == true){
				echo "<p class=\"prevent_msg\">Votre article a bien été modifié, voici le lien pour y acceder :";

		?>
		<a class="sinslink_bis" href=<?php 
					echo	"\"article.php?billet=".$id."\""; 
		?>
		/> <?php  echo	"Article n°".$id; ?>
		</a> </p> <br>
		<?php }  // Fin modification du code Paul?>
		
		<!-- <form method="post" action="index.php">  non et non mdrrr il faut detecter les erreurs de un et de deux il faut  laisser l'occasion à une personne qui veut écrire plusieurs article d'en ecrire plusieurs ! Par contre ca part d'un bon sentiment et c'est pour ça que j'ai ajouté le message la haut donnant un lien vers l'aricle crée si la personne veut le voir en action 
		Du coup Css à revoir pour les messages d'erreur et de réussite -->

		<form method="post" action=<?php echo "\"".$_SESSION['precedent']."\""; ?> enctype="multipart/form-data">
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
					else {
						echo $art->getTitre();
					}
					echo "\"";

				?> 
				/>  
				<?php // Verification titre
					if (empty($_POST['titre']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"> Champ vide</span>";
						
					}
					elseif (isset($_POST['titre']) && strlen($_POST['titre']) > 65 ){
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Maximum 65 caractères sont attendus !</span>";
					}
				?> 
				<br>
			</div>

			<div class="rowcreation">
				<label for="file" class="forminsc labcreation">Choisissez une photo bannière pour votre article (Facultatif) : </label> 
				<p class="pstyle">
					Voici votre précedente image bannière :<br>
					<img src=<?php echo "\"uploadArticle/".$art->getImage()."\""; ?>alt="Ma photo de profil" title="Ma photo de profil" heigth="420px" width="232px">
				</p>
				
				<?php
					// Verification fichier pas vide
					/* On verra si on le remet la notifcation que l'image n'a pas été modifiée plus tard ..
					if (isset($_FILES['monfichier']) && $_FILES['monfichier']['error'] != 0 ){
						echo "<span style=\"color: #760001; margin-left: 10px;\">Champ vide</span>";
					} */
				?>
				<br>
				<input type="file" name="monfichier"/>
				<br>
			</div>

			<div class="rowcreation">
				<label class="forminsc cccreate" for="corps">Le contenu de votre article : </label> 
				<?php // Verification corps
					if (empty($_POST['corps']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
					}
				?> 
				<br>
				<textarea class="creationInputArea" placeholder="Corps de votre article" name="corps" rows="10" cols="70" ><?php
						if (isset($_POST['validate'])) {
							if (isset($_POST['corps'])){
								echo $_POST['corps'];
							}
						}
						else {
							echo $art->getCorps();
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
							<option value=<?php 
								echo "\"".$donnees['id']."\"";
								if($art->getIdCategorie() == $cat->getId())
									echo " selected=\"selected\"";
							?> ><?php echo $donnees['titre']; ?></option>
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