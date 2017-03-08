<?php
if (!session_id()) session_start();


$_SESSION['precedent']="points.php?";


if (empty($_SESSION['connecte'])){
    header("location: authentification.php?message=true");
    exit();
  }

  

// Connection a la base de données
include('connectionbdd.php');
// Recuperation des classes
include('ArticleClass.php'); // Fonctions pour récuperer les articles
include('ArticlePaye.php'); // Fonctions pour récuperer les articles payes
include('Personne.php'); // Fonctions pour récuperer les personnes
include('Categorie.php'); // Fonctions pour récuperer les categories
include('Commentaire.php'); // Fonctions pour récuperer les commentaires
include('Pouce.php'); // Fonctions pour récuperer les pouce

$moi = new Personne($_SESSION['id'],$bdd); // Recuperer les données de la personne

if (isset($_POST['param'])) {
  
  $moi->incremente();
}

if (isset($_POST['getpoints'])){
  echo $moi->getPoint();
  exit();
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

      <?php include("header.php"); ?>

      <?php include("nav.php"); ?>

      <div id="main">
        
        <section id="part_index"> <!-- peut etre à enlever si je laisse une seule section -->
          <div class="left">
            <div class="video_points">
              <h2 class="titreInsc" style="text-align: left !important;">Alexa - Points</h2>
              
              <video id="videoPlayer" ontimeupdate="update(this)"  heigth="600" width="428" src="Video/magickingdommp4.mp4" poster="Video/magickingdommp4.jpg" autobuffer>
              </video> 
              <br>           
              <button id="control" class="submit_but" onclick="play('videoPlayer',this)">Play</button>
            </div>
            <div class="infos_points">
              <p class="pstyle">Ce site fonctionne à l'aide d'un système de points.</p></br>
              <p class="pstyle">Certains articles sont <strong class="cust2">Premium</strong>, et necessitent de "dépenser" 1 point pour pouvoir être consultés.</p></br>
              <p class="pstyle">En vous inscrivant, vous beneficiez de 200 points, et chaque fois que vous lisez la vidéo ci-dessus, vous gagnez <strong class="cust2">30 points supplémentaires</strong>.</p>
            </div>
          </div>
            <script>
              var test = false;
              var xhr = new XMLHttpRequest();
              var xhr2 = new XMLHttpRequest();
              function play (idPlayer, control){
                //var player = document.getElementById(idPlayer); devrait fonctionner aussi
                var player = document.querySelector('#'+idPlayer);
                test = false;
                if (player.paused){
                  player.play();
                  control.textContent = 'Pause';
                } else {
                  player.pause();
                  control.textContent = 'Play';
                }
              }

              function update (player){
                
                if (player.duration == player.currentTime &&  test != true){//(typeof test == "undefined" || (test != false && typeof test == "boolean"))){
                    test = true;
                    //alert('bonjour');
                    
                    xhr.open('POST','points.php');
                    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xhr.send('param=12');
                }
              }

              /*
              Ceci etait juste pour voir comment fonctionnait le retour */
              xhr.onreadystatechange = function() {
                if (xhr.readyState == 4){
                  /*alert(xhr.status);
                  alert(xhr.responseText);*/
                  xhr2.open('POST','points.php');
                  xhr2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                  xhr2.send('getpoints=12');
                }
              }

              xhr2.onreadystatechange = function() {
                if (xhr2.readyState == 4){
                  pointsInfos.textContent = xhr2.responseText+" points";
                }
              }
              
            </script>

          <!-- une autre div article? -->

          <div class="right">
            <?php include('rightPannelIndex.php'); ?>
          </div>
        </section>

      

      <?php include("footer.php"); ?>

    </body>
</html>