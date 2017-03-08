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


if (empty($_SESSION['precedent'])){
	$_SESSION['precedent']= "authentification.php";
}

if (isset($_POST['pseudo']) && isset($_POST['mdp'])){
	$pass_hache = sha1($_POST['mdp']);
	/*$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE pseudo = ? AND motDePasse = ?');
	$req->execute(array($_POST['pseudo'], $pass_hache));
	$donnees = $req->fetch();*/
	$id = Personne::authentification($_POST['pseudo'], $pass_hache);
	if ($id != 0) {
	/*if ($donnees[0] == 1){
		$req = $bdd->prepare('SELECT id FROM `Personne` WHERE pseudo = ? AND motDePasse = ?');
		$req->execute(array($_POST['pseudo'], $pass_hache));
		$donnees = $req->fetch(); 
		$_SESSION['id'] = $donnees['id'];
		$_SESSION['connecte'] = true; */
		$_SESSION['id'] = $id;
		$_SESSION['connecte'] = true;
		header("location: ".$_SESSION['precedent']);
		exit();
	}
	else  { // Si on ne trouve rien avec le pseudo alors on essaye avec l'email
		/*$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE email = ? AND motDePasse = ?');
		$req->execute(array($_POST['pseudo'], $pass_hache));
		$donnees = $req->fetch();*/
		$id = Personne::authentificationEmail($_POST['pseudo'], $pass_hache);
		if ($id != 0) {
		/*if ($id == 1){
			$req = $bdd->prepare('SELECT id FROM `Personne` WHERE email = ? AND motDePasse = ?');
			$req->execute(array($_POST['pseudo'], $pass_hache));
			$donnees = $req->fetch();
			$_SESSION['id'] = $donnees['id'];
			$_SESSION['connecte'] = true;*/
			$_SESSION['id'] = $id;
			$_SESSION['connecte'] = true;
			header("location: ".$_SESSION['precedent']);
			exit();
		}	
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
      <meta charset="utf-8">
      <link rel="icon" type="image/png" href="logo1/logo1_noir_decalque.png">
      <link rel="stylesheet" href="IO2_style1.css">
      <title>Alexa</title>
    </head>
	<body>
		<?php include("header.php");
		include("nav.php"); ?>

		<section id="ident">
		
			<div>
				<h2 class="titreInsc">Alexa - Authentification</h2>
			</div>

			
					
					<?php 
					if (isset($_GET['message'])) {  ?>
					<p class="IdAware">
						Vous avez tenté d'acceder à un espace qui nécéssite une authentification. <br>
						Si vous n'avez pas de compte, cliquez ci dessous pour vous inscrire, c'est gratuit!<br>
						<a href="inscription.php" class="sinslink spec">S'inscrire</a>
					</p>
					<?php 
						} 
						if (!(empty($_POST['pseudo']) || empty($_POST['mdp']))){

					 ?>
					 <p class="IdAware">Mauvais pseudo/email ou mot de passe</p>

					 <?php } ?>
					<form method="post" action="authentification.php" class="formId">

						<fieldset class="insc">
						<div class="rowinsc">

							<div class="containlab">
								<label for="pseudo" class="forminsc">Pseudo ou e-mail :</label>
								<input type="text" name="pseudo" class="form-control" id="pseudo"value= 
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
										echo "<span style=\"color: #760001; margin-left: 10px;\">   Champ vide</span>";
										
									}
								?>  
								<br>
							</div>
						
							<div class="containlab">
								<label for="mdp" class="forminsc">Mot de passe :</label>
								<input type="password" name="mdp"  class="form-control" id="mdp"/>
								<?php // Verification mdp
									if (empty($_POST['mdp']) && isset($_POST['validate'])) {
										echo "<span style=\"color: #760001; margin-left: 10px;\">   Champ vide</span>";
										
									}
								?>
								<br>
							</div>

						</div>
						</fieldset>
					
						<fieldset class="validation_insc">
							<input type="hidden" name="validate" id="validate" value="OK"/>
							<input type="submit" value="Valider"  class="submit_but" id="valider">
						</fieldset>
					</form>
				

				<p id="linkinsc">Vous n'avez pas de compte? <a class="sinslink" href="inscription.php">S'inscrire</a></p>

			
		</section>
		<?php include("footer.php"); ?>
	</body>
</html>



