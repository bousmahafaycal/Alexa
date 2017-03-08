<?php
if (!session_id()) session_start();
// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce

$_SESSION['precedent']="preference.php?"; // On met à jour l'historique	

// Si pas connecte demander l'authentification
if (empty($_SESSION['connecte'])){
	header("location: authentification.php?message=true");
	exit();
}
$per = new Personne($_SESSION['id'],$bdd);


// requete pour modifier le mot de passe
if (! (empty($_POST['oldmdp']) || empty($_POST['mdp']) || empty ($_POST['mdp2'])) ){ 
	if ($per->getMotDePasse() == sha1($_POST['oldmdp']) ) {
		if ($_POST['mdp'] == $_POST['mdp2']  && strlen($_POST['mdp']) >= 8) {
			Personne::modifieMotDePasse($bdd,$per->getId(),sha1($_POST['mdp']));
			$modifie = true;
			$per = new Personne($_SESSION['id'],$bdd);
		}
			
	}
}



// requete pour changer de mail
if (isset($_POST['mail'])){
	Personne::modifieEmail($bdd,$per->getId(), $_POST['mail'] );
	$modifieMail = true;
	$per = new Personne($_SESSION['id'],$bdd);
}


// requete pour changer de signature
if ( isset($_POST['signature'])){
	Personne::modifieSignature($bdd,$per->getId(),$_POST['signature']);
	$per = new Personne($_SESSION['id'],$bdd);
	$modifieSignature = true;
}

// requete pour changer de style
if ( isset($_POST['style'])){
	Personne::modifieStyle($bdd,$per->getId(),$_POST['style']);
	$per = new Personne($_SESSION['id'],$bdd);
	$modifieStyle= true;
}


// requete pour changer de pdp
if ( isset($_FILES['monfichier']) AND  $_FILES['monfichier']['error'] == 0){
	//echo "fichier existe";
	// Extension à verif
	$infosfichier = pathinfo($_FILES['monfichier']['name']);
	$extension_upload = $infosfichier['extension'];
	$extension_autorisees = array('jpg','jpeg','png','gif');

	if (in_array($extension_upload, $extension_autorisees)){ // Si l'extension est autorisée
		$id = $_SESSION['id'];
		// On recupere l'extension du fichier
		$extension = strrchr(basename($_FILES['monfichier']['name']),'.'); 
		//echo "extension : ".$extension;
		// On valide le fichier en l'uploadant et le renommant avec id.extension
		move_uploaded_file($_FILES['monfichier']['tmp_name'], "uploadPersonne/".$id.$extension);

		// Puis on met le lien dans la base de donnée
		Personne::modifieImage($bdd,$id,$id.$extension);
		$modifieMdp = true;
	}
}


?>


<!DOCTYPE html>
<html>
	<head>
	<?php include ('link.php'); ?>
	<title>Alexa - Préférences</title>
	</head>
	<body>
		<?php include('header.php'); 
			  include ('nav.php'); ?>

		<div class="container">
			<h2 class="titreInsc">Alexa - Preferences</h2>
			<div class="content-form">
				<div class="contain_pref first_contain">
					<div class="pref-part uppref">
						<h2 class="bluehover">Modification de mot de passe</h2>
						<?php if (isset($modifie) && $modifie == true){ ?>
						<p class="pstyle">Vous avez modifie votre mot de passe avec succès !</p>
						<?php } ?>
						<form method="post" cible="preference.php">
							<div class="marg_label">
								<label for="oldmdp">Tapez votre ancien mot de passe :</label>
							</div>
								<input type="password" class="form-control input_pref" name="oldmdp" id="oldmdp"/>
								<?php // Verification mdp
									if (empty($_POST['oldmdp']) && isset($_POST['validate'])) {
										echo "<span style=\"color: #760001; margin-left: 10px;\"> Champ vide</span>";
										
									}
								?>
								<br>

							<div class="marg_label">
								<label for="mdp">Tapez votre nouveau mot de passe :</label>
							</div>
								<input type="password" class="form-control input_pref" name="mdp" id="mdp"/>
								<?php // Verification mdp
									if (empty($_POST['mdp']) && isset($_POST['validate'])) {
										echo "<span style=\"color: #760001; margin-left: 10px;\">   Champ vide</span>";
										
									}
									elseif (isset($_POST['mdp']) && strlen($_POST['mdp']) < 8 ){
										echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Minimum 8 caractères sont attendus !</span>";
									}
								?>
								<br>

							<div class="marg_label">	
								<label for="mdp2">Tapez à nouveau votre nouveau mot de passe :</label>
							</div>
								<input type="password" class="form-control input_pref" name="mdp2" id="mdp2"/>
								<?php // Verification mdp2
									if (empty($_POST['mdp2']) && isset($_POST['validate'])) {
										echo "<span style=\"color: #760001; margin-left: 10px;\">   Champ vide</span>";
										
									}
									elseif ( isset($_POST['validate']) && $_POST['mdp'] != $_POST['mdp2']) {
										echo "<span style=\"color: #760001; margin-left: 10px;\">   Les mots de passe ne correspondent pas !</span>";
									}
								?>
								<br>
								<input type="hidden" name="validate" id="validate" value="OK"/>
								<input type="submit" value="Modifier"  class="submit_but" id="valider">
						</form>
						<br>
					</div>
				
					<div class="pref-part uppref">
						<h2 class="bluehover">Modification d'adresse Email</h2>
						<?php if (isset($modifieMail) && $modifieMail == true){ ?>
						<p class="prevent_msg">Vous avez modifié votre email avec succès !</p>
						<?php } ?>
						<p class="pstyle">
							Voici votre adresse e-mail : <?php echo $per->getEmail(); ?> <br>
							<form method="post" cible="preference.php">
								<div class="marg_label">
									<label for="mail">Nouvelle adresse e-mail :</label>
								</div>
									<input type="text" class="form-control input_pref " name="mail" id="mail"/>
									<?php // Verification mdp
										if (empty($_POST['mail']) && isset($_POST['validate2'])) {
											echo "<span style=\"color: #760001; margin-left: 10px;\"> Champ vide</span>";
											
										}
									?>
									<br>
									<input type="hidden" name="validate2" id="validate2" value="OK"/>
									<input type="submit" value="Modifier"  class="submit_but" id="valider">
						</form>
						</p>
						<br>
					</div>
				</div>
				<div class="contain_pref first_contain">
					<div class="pref-part uppref">
						<h2 class="bluehover">Modification de la signature</h2>
						<?php if (isset($modifieSignature) ){ ?>
									<p>Vous avez modifie votre signature avec succès !</p>
						<?php } ?>
						<p class="pstyle">
							Voici votre précedente signature :<br><strong><?php  echo $per->getSignature();?></strong>
						</p>
						<form method="post" cible="preference.php">
							<div class="marg_label">
								<label for="signature">Votre signature (Facultatif) :</label>
							</div>
								<?php 
									if (empty($_POST['signature']) && isset($_POST['validate3'])){
											echo "<span style=\"color: #760001; margin-left: 10px;\">Champ vide</span><br>";						
									}		
									?>
									
									<textarea name="signature" rows="5" cols="40" ><?php
									if  (isset($_POST['signature'])){
											echo $_POST['signature'];
										
									}
									elseif (! empty($per->getSignature())){
										echo $per->getSignature();
									}

								  ?></textarea>
								  <br>
									<input type="hidden" name="validate3" id="validate3" value="OK"/>
									<input type="submit" value="Modifier"  class="submit_but" id="valider">
						</form>
						<br>
					</div>
				

					<div class="pref-part uppref">
						<h2 class="bluehover">Modification de la photo de profil</h2>
						<?php if (isset($modifieMdp) ){ ?>
									<p class="prevent_msg">Vous avez modifie votre image de profil avec succès !</p>
						<?php } ?>
						<p class="pstyle">
							Voici votre précedente image de profil :<br>
							<img src=<?php echo "\"uploadPersonne/".$per->getImage()."\""; ?>alt="Ma photo de profil" title="Ma photo de profil" heigth="100px" width="100px">
						</p>
						<form method="post" cible="preference.php" enctype="multipart/form-data">
							<label for="momfichier" class="forminsc labcreation">Photo de profil (Facultatif) :</label> 
								<?php
									// Verification fichier pas vide
									if (isset($_POST['validate4']) && $_FILES['monfichier']['error'] != 0){
										echo "<span style=\"color: #760001; margin-left: 10px;\"><br>Fichier inexistant ou inadmissible</span>";
									}						
								?>
							
							<input type="file" style="margin-bottom: 20px; margin-top: 3px;" name="monfichier"/> <!-- laisser sans style ici, c'est plus beau -->
							<br>		
							<input type="hidden" name="validate4" id="validate4" value="OK"/>
							<input type="submit" value="Modifier"  class="submit_but" id="valider">
						</form>
					</div>

				

				<!-- ggg -->
				</div>
				<div class="contain_pref">
					<div class="pref-part2">
						<h2 class="bluehover">Choix du style</h2>
						<?php if (isset($modifieStyle) ){ ?>
										<p class="prevent_msg">Vous avez modifie votre style avec succès !</p>
						<?php } ?>
						<form method="post" cible="preference.php">
							<label for="style" class="forminsc">Apparence graphique : </label></br>
							<div class="style_input" style="margin-right: 7px;">
								<input type="radio" name="style" value="1" id="style1" <?php if($per->getStyle() == 1 ){ ?> checked="checked" <?php } ?> > </input>
								<label for="style1" class="forminsc2">Style 1</label>
							</div>
							<div class="style_input" style="margin-left: 7px;">
								<input type="radio" name="style" value="2" id="style2" <?php if($per->getStyle() == 2 ){ ?> checked="checked" <?php } ?> > </input>
								<label for="style2" class="forminsc2">Style 2</label>
							</div>
							<?php // Verification style
								if (empty($_POST['style']) && isset($_POST['validate5'])) {
									echo "<span style=\"color: #760001; margin-left: 10px;\"><br><br>Aucune case n'a été cochée !</span>";		
								}
							?>
							<br>
							<input type="hidden" name="validate5" id="validate5" value="OK"/>
							<div class="sub_style">
								<input type="submit" value="Modifier"  class="submit_but" id="valider">
							</div>
						</form>
					</div>
				</div>

			</div>


			<div class="linkcontact">
				<p class="pstyle">Un problème? <a class="sinslink_bis" href="contact.php">Contactez-nous</a></p>
			</div>

		</div>

		<?php include('footer.php'); ?>
	</body>
</html>