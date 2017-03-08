<!DOCTYPE html>
<html lang="fr">
	<head>
    	<meta charset="utf-8">
      <link rel="icon" type="image/png" href="logo1/logo1_noir_decalque.png">
      <link rel="stylesheet" href="IO2_style1.css">
    	<title>Erreur 404</title>
  	</head>

  	<body>

  		<?php include("header.php");
      include("nav.php"); ?>

      <section class="errorBlock">
        <div id="centeredError404">
          <div id="table2colonnesError404">
            <div id="tableGaucheError">
              <a href="index.php">
                <img src="logo1/logo1_noir_decalque.png" title="Alexa - Retour à l'accueil" alt="Retour à l'accueil">
              </a>
            </div>
            <div id="tableDroiteError">
              <h1>Oops! 404!</h1>
              <h2>La page que vous recherchez n'existe pas (ou plus).</h2>
              <a id="retourAccueilError404" href="index.php">
                Retour à l'accueil
              </a>
              <a id="contactError404" href="error404.php"
            </div>
          </div>
        </div>
      </section>

      <?php include("footer.php"); ?>

  	</body>
</html>
