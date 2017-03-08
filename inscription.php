<?php
session_start();
include('connectionbdd.php');
include('Personne.php');

if (empty($_SESSION['precedent'])){
	$_SESSION['precedent']= "index.php?";
}

$_SESSION['precedent'] = $_SESSION['precedent']."&&inscription=true";

// SI les variables existent alors on valide l'inscription 
if (isset($_POST['pseudo']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mdp']) && isset($_POST['mdp2']) && isset($_POST['mail']) && isset($_POST['sexe'])){
	if ($_POST['mdp2'] == $_POST['mdp'] && strlen($_POST['mdp']) >= 8){
		if (filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL) && is_numeric($_POST['sexe'])){
			if (! Personne::existePseudo($_POST['pseudo']) && ! Personne::existeEmail($_POST['mail'])){
				$pass_hache = sha1($_POST['mdp']);
				echo "L'Inscription est validée";
				$req = $bdd->prepare('INSERT INTO `Personne` (`id`, `nom`, `prenom`, `pseudo`, `email`, `sexe`, `droit`, `motDePasse`, `points`, `pointCumule`, `style`, `styleMobile`, `signature`, `image`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)'); // A changer pour que ca corresponde à la table personne
				$req->execute(array($_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['mail'], $_POST['sexe']-1,0, $pass_hache, 200, 200, 1,1,"","0.jpg"));
				$personne = true;
				// On recupere l'id de l'inscrit
				$req = $bdd->prepare('SELECT id FROM Personne WHERE pseudo = ? ');
				$req->execute(array($_POST['pseudo'] ));
				$donnees = $req->fetch();
				$id = $donnees['id'];
			}
				

		}
	}
}

if ( isset($personne) AND isset($_FILES['monfichier']) AND  $_FILES['monfichier']['error'] == 0){
	//echo "fichier existe";
	// Extension à verif
	$infosfichier = pathinfo($_FILES['monfichier']['name']);
	$extension_upload = $infosfichier['extension'];
	$extension_autorisees = array('jpg','jpeg','png','gif');

	if (in_array($extension_upload, $extension_autorisees)){ // Si l'extension est autorisée
		//echo "extension reconnue ";
		
		//echo "id : ".$id;

		// On recupere l'extension du fichier
		$extension = strrchr(basename($_FILES['monfichier']['name']),'.'); 
		//echo "extension : ".$extension;
		// On valide le fichier en l'uploadant et le renommant avec id.extension
		move_uploaded_file($_FILES['monfichier']['tmp_name'], "uploadPersonne/".$id.$extension);

		// Puis on met le lien dans la base de donnée
		Personne::modifieImage($bdd,$id,$id.$extension);
	}
}


if ( isset($personne) AND isset($_POST['signature'])){
	Personne::modifieSignature($bdd,$id,$_POST['signature']);
}

if (isset($personne)){  // Redirection lorsque l'inscription est faite
	header("location: ".$_SESSION['precedent']);
	exit();
}



?>

<!DOCTYPE html>
<html>
	<head>
		<title>Alexa - Inscription</title>
		<meta charset="utf-8">
	    <link rel="icon" type="image/png" href="logo1/logo1_noir_decalque.png">
	    <link rel="stylesheet" href="IO2_style1.css">
	</head>
	<body>
		
		<?php 
		include("header.php"); 
		include("nav.php"); ?>

		<section id="inscription">
			<div>
				<h2 class="titreInsc">Alexa - Inscription</h2>
			</div>
			
			<form method="post" action="inscription.php" enctype="multipart/form-data">

			<fieldset class="insc">
			<div id="pannelinsc">
			<div class="rowinsc">
				
				<div class="containlab">
				<label for="pseudo" class="forminsc">Pseudonyme : </label></br>
				<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="ExempleDePseudo" value= 
				<?php
					echo "\"";
					if (isset($_POST['validate'])) {
						if (isset($_POST['pseudo'])){
							echo $_POST['pseudo'];
						}
					}
					echo "\"";

				?> 
				/>  
				<?php // Verification pseudo
					if (empty($_POST['pseudo']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
						
					}
					
					elseif (isset($_POST['pseudo']) && Personne::existePseudo($_POST['pseudo'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Désolé, ce pseudo existe déja ! </span>";
					}
				?> 
				<br>
				</div>

				
				<div class="containlab">
				<label for="nom" class="forminsc">Nom : </label> </br>
				<input type="text" class="form-control" name="nom" id="nom" placeholder="Duprés, Bousmaha..." value= 
				<?php
					echo "\"";
					if (isset($_POST['validate'])) {
						if (isset($_POST['nom'])){
							echo $_POST['nom'];
						}
					}
					echo "\"";

				?> 
				/>  
				<?php // Verification nom
					if (empty($_POST['nom']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
						
					}
				?>
				<br>
				</div>

				<div class="containlab">
				<label for="prenom" class="forminsc">Prénom : </label></br>
				<input type="text" class="form-control" name="prenom" id="prenom" placeholder="Jean, Paul, Mohamed..." value= 
				<?php
					echo "\"";
					if (isset($_POST['validate'])) {
						if (isset($_POST['prenom'])){
							echo $_POST['prenom'];
						}
					}
					echo "\"";

				?> 
				/>  
				<?php // Verification prenom
					if (empty($_POST['prenom']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
						
					}
				?>
				<br>
				</div>

			</div>
			<div class="rowinsc">


				<div class="containlab">
				<label for="sexe" class="forminsc">Sexe : </label></br>
				<input type="radio" name="sexe" value="1" id="homme" <?php if(isset($_POST['sexe']) && $_POST['sexe'] == 1){ ?> checked="checked" <?php } ?> > </input>
				<label for="homme" class="forminsc2">Homme</label>
				<br>
				<input type="radio" name="sexe" value="2" id="femme" <?php if(isset($_POST['sexe']) && $_POST['sexe'] == 2){ ?> checked="checked" <?php } ?> > </input>
				<label for="femme" class="forminsc2">Femme</label>
				<?php // Verification sexe
					if (empty($_POST['sexe']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br><br>Aucune case n'a été cochée !</span>";		
					}
				?>
				<br>
				</div>
				
				<div class="containlab">
				<label for="mdp" class="forminsc">Mot de passe (minimum 8 caractères): </label><br>
				<input type="password" class="form-control" name="mdp" placeholder="Souvenez-vous en!" id="mdp"/>
				<?php // Verification mdp
					if (empty($_POST['mdp']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
						
					}
					elseif (isset($_POST['mdp']) && strlen($_POST['mdp']) < 8 ){
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Minimum 8 caractères sont attendus !</span>";
					}
				?>
				<br>
				</div>

				<div class="containlab">
				<label for="mdp2" class="forminsc">Tapez à nouveau le mot de passe : </label></br>
				<input type="password" class="form-control" name="mdp2" placeholder="---" id="mdp2"/>
				<?php // Verification mdp2
					if (empty($_POST['mdp2']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
						
					}
					elseif ( isset($_POST['validate']) && $_POST['mdp'] != $_POST['mdp2']) {
						echo "<span style=\"color: #760001; margin-left: 10px;\">   Les mots de passe ne correspondent pas !</span>";
					}
				?>
				<br>
				</div>

				

			</div>
			<div class="rowinsc">
				<div class="containlab">
				<label for="mail" class="forminsc">E-mail : </label></br><br>
				<input type="text" class="form-control" name="mail" id="mail" placeholder="exemple@gmail.com" value= 
				<?php
					echo "\"";
					if (isset($_POST['validate'])) {
						if (isset($_POST['mail'])){
							echo $_POST['mail'];
						}
					}
					echo "\"";

				?> 
				/>  
				<?php // Verification email
					if (empty($_POST['mail']) && isset($_POST['validate'])) {
						echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Champ vide</span>";
						
					}
					elseif (isset($_POST['mail'])) {
						if (! filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) {
							echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Adresse E-mail incorrecte</span>";
						}
						elseif (Personne::existeEmail($_POST['mail'])) {
							echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Désolé, cet adresse e-mail est déja utilisée ! </span>";
						}
					}
						
							
				?>
				<br>
				</div>

				


				<div class="containlab">
					<label for="momfichier" class="forminsc labcreation">Photo de profil (Facultatif) : </label> 
					<?php
						// Verification fichier pas vide
						if (isset($_POST['validate'])){
							echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Fichier inexistant ou inadmissible</span>";
						}
						
					?>
					
					<input type="file" name="monfichier"/>
					<br>		
				</div>

			
				<div class="containlab">
				<label for="signature" class="forminsc labcreation">Votre signature (Facultatif) :</label>
				<?php 
					if (empty($_POST['signature']) && isset($_POST['validate'])){
							echo "<span style=\"color: #760001; margin-left: 10px;\">Champ vide</span><br>";
						
					}
						
				?>
				
				<textarea name="signature" rows="4" cols="21" ><?php
				if  (isset($_POST['signature'])){
						echo $_POST['signature'];
					
				}

			  ?></textarea>
			</div>
			</div>
			</div>
			</fieldset>
			<fieldset class="validation_insc">
				<input type="hidden" name="validate" id="validate" value="OK"/>
				<input type="submit" value="Envoyer"  class="submit_but" id="valider">
			</fieldset>
			</form>
		</section>

		<?php include("footer.php") ?>
	</body>
</html>



