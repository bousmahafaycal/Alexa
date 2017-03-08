<?php
// On crée la Session
if (!session_id()) session_start();

// On met à jour la page precedente
$_SESSION['precedent']="contact.php?";

// Si pas connecte demander l'authentification
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



?>
<!DOCTYPE html>
	<html lang="fr">
		<head>
			<?php include('link.php') ?>
			<title>Contact</title>
		</head>
		
		
		
                
		
		<body>

			<?php 
				include ('header.php');
				include('nav.php'); 

			?>


			<div class="container">

				<h2 class="titreInsc">Alexa - Formulaire de contact</h2>
				
				<div class="content-form">
					<form method="post" action="contact.php">
						<p class="help-block">
							Ce formulaire est mis à votre disposition si vous souhaitez nous laisser un avis ou si vous rencontrez un problème.<br>
							Nous serons ravis de répondre à toutes vos sollicitations.<br>
							<?php 

								include('mail.php');
								if (isset($_SESSION['connecte']) && ! empty($_POST['titre']) && ! empty($_POST['message']) ){
									$per = new Personne($_SESSION['id'],$bdd);
									fmail('faycal.bousmaha.fac@gmail.com','Mail de '.$per->getNom()." ".$per->getPrenom(),"Titre : ".$_POST['titre']."\nContenu : \n".$_POST['message'],$per->getEmail(),$per->getNom());
									//tmail();
									echo "<span style=\"color: #760001;\"></br>Votre message a bien été transmis. </br></span>";
									
										
								}

							?>
						</p>
						<fieldset class="insc">

							<div class="control-group">

								<label for="recipient" class="forminsc">Destinataire :</label><br>
								<input type="text" class="form-control widthHundred" name="username" id="username" placeholder="Administrateur" disabled>


							</div>

							<div class="control-group">
					
								<label for="titre" class="forminsc">Titre :</label><br>

								<input type="text" name="titre" id="titre" class="form-control widthHundred" value=
								<?php
								echo "\"";
								if (empty ($_POST['titre']) || empty ($_POST['message']) ) {

									if  (isset($_POST['titre'])){
										echo $_POST['titre'];
									}
								}
								echo "\"";

								?> 
								/>

								<?php 
									if (empty($_POST['titre']) && isset($_POST['validate'])){
										echo "<span style=\"color: #760001; margin-left: 10px;\">   Champ vide</span>";
									}
								?>

							</div>
							<div class="control-group">

								<p class="forminsc">Votre message :</p><br>
								<?php 
									if (empty($_POST['message']) && isset($_POST['validate'])){
											echo "<span style=\"color: #760001; margin-left: 10px;\">   Champ vide</span>";
										
									}
										
								?>
								</br> 
								<textarea name="message" class="form-control widthHundred" rows="10" cols="70" ><?php
								if (empty ($_POST['titre']) || empty ($_POST['message']) ) {
									if  (isset($_POST['message'])){
										echo $_POST['message'];
									}
								}

								?></textarea>
							</div>

							<p class="help-block">
								L’adresse de réponse à ce message sera votre adresse e-mail.
							</p><br>

						</fieldset>
						
						<fieldset class="validation_insc valContact">

							<input type="hidden" name="validate" id="validate" value="OK"/>  
							<input type="submit"  class="submit_but" value="Valider"  id="valider">

						</fieldset>


					</form>
				</div>

				

			</div>

			<?php include 'footer.php'; ?>

		</body>


		

		

</html>