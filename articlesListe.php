<?php
session_start();
$_SESSION['precedent'] = "index.php?";
?>

<?php 

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

<?php
$messagesParPage=5;

//connection ouverte avant cette ligne
$retour_total=$bdd->query('SELECT COUNT(*) AS total FROM Article WHERE affiche=1 AND invisibleAuteur=0'); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total=$retour_total->fetch(); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
 
//Compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);
 
     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages, on ramene a la derniere page...
     {
          header("location: error404.php");                      /* --> redirige vers error404.php */
          /* $pageActuelle=$nombreDePages; */                    /* (une des deux solutions a garder, je prefere celle-ci) */
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1    
}

$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire pour la LIMIT dans la requête SQL

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

      <div class="category_banner">
        <div class="container">
          <h1>Tous les articles</h1>
        </div>
      </div>

      <div id="main">
        <section id="part_index"> <!-- peut etre à enlever si je laisse une seule section -->
          <div class="left">
            <div class="articles">

              <?php 
                // La requête sql pour récupérer les messages de la page actuelle.
                /*
                $retour_messages = $bdd->prepare('SELECT id, idAuteur, titre, idCategorie, corps, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM Article WHERE idCategorie=1 ORDER BY date_creation DESC LIMIT ?, ?');
                $retour_messages->execute(array($premiereEntree, $messagesParPage)); 
                La requête préparée ci dessus ne fonctionne pas pour une raison qui m'échappe FAYCAL VERIFIE STP*/
                $retourmessages = $bdd->prepare('SELECT id, idAuteur, titre, idCategorie, corps, DATE_FORMAT(date_creation, \'%d/%m/%Y\') AS date_creation_fr FROM Article WHERE affiche=1 AND invisibleAuteur=0 ORDER BY date_creation DESC LIMIT :debut, :nombre');
                $retourmessages->bindParam(':debut', $premiereEntree, PDO::PARAM_INT);
                $retourmessages->bindParam(':nombre', $messagesParPage, PDO::PARAM_INT);
                $retourmessages->execute();

                while ($donnees = $retourmessages->fetch())
                {

                $art = new Article ($donnees['id'],$bdd);
              ?>

              <article>
                <figure>
                  <a href="article.php?billet=<?php echo ($donnees['id']); ?>" title="Voir l'article"> <!-- lien vers l'article -->
                    <img width="350" height="165" src=<?php echo "\"uploadArticle/".$art->getImage()."\""; ?>alt="logo de l'article" title="logo de l'article">
                  </a>
                </figure>
                <h2>
                  <a href="article.php?billet=<?php echo ($donnees['id']); ?>" title="Voir l'article"> <!-- même balise que ci-dessus -->
                    <?php echo htmlspecialchars($donnees['titre']) ?>
                  </a>

                  <?php
                    include ("premium.php");?>
                  </br>
                  <p class="pstyle auteurArticle">Auteur : 
                    <strong class="bluehover">
                      <?php  
                        $pers = new Personne($donnees['idAuteur'], $bdd);
                        echo $pers->getNom()." ".$pers->getPrenom();
                      ?>
                    </strong></br>
                    <span class="pstyle">
                      Publié le <?php echo ($donnees['date_creation_fr']); ?>
                    </span>
                  </p>
                </h2>

                <a href="article.php?billet=<?php echo ($donnees['id']); ?>" class="comments">
                  <img src="bulle-comment.png" width="16px" height="16px;">
                  <?php 
                    echo ($art->getNbCommentaire()); ?> <!-- nbres de comments + ajouter l'id #comments (ou autre) dans le href pour aller direct aux commentaires et pas slmt la page -->
                </a>
              </article>

              <?php 
                }
                $retourmessages->closeCursor();
              ?>
              
            </div>

            <!-- pagination -->
            <div class="paginate">

              <?php
                echo '<ul align="center" style="margin-bottom: 20px;">'; //à restyliser avec une liste
                  for($i=1; $i<=$nombreDePages; $i++){
                       if($i==$pageActuelle){
                           echo '<li class="active"><p>'.$i.'</p></li>';   /* echo ' [ '.$i.' ] '; */
                       }  
                       else{
                            echo '<li><a href="articlesListe.php?page='.$i.'">'.$i.'</a></li>';
                       }
                  }
                  echo '</ul>';
              ?>

              <!-- <?php //old
                //echo '<p align="center" style="margin-bottom: 20px;">Page : '; //à restyliser avec une liste
                  //for($i=1; $i<=$nombreDePages; $i++){
                       //if($i==$pageActuelle){
                           //echo $i;   /* echo ' [ '.$i.' ] '; */
                       //}  
                       //else{
                            //echo ' <a href="articlesListe.php?page='.$i.'">'.$i.'</a> ';
                       //}
                  //}
                  //echo '</p>';
              ?> -->
              
            </div>
            <!-- fin pagination -->


          </div>

          <!-- une autre div article? -->

          <div class="right">

            <?php include('rightPannelIndex.php'); ?>

          </div>
          
        </section>
      </div>


      <?php include("footer.php"); ?>

    </body>
</html>