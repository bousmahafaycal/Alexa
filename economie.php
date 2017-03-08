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
          <h1>Economie</h1>
        </div>
      </div>

      <div id="main">
        <section id="part_index"> <!-- peut etre à enlever si je laisse une seule section -->
          <div class="left">
            <div class="last_article">

              <?php
                $req = $bdd->query('SELECT id, idAuteur, titre, idCategorie, corps, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM Article WHERE idCategorie=1 AND affiche=1 AND invisibleAuteur=0 ORDER BY date_creation DESC LIMIT 0, 1');

                while ($donnees = $req->fetch())
                {
                
                $art = new Article ($donnees['id'],$bdd);
              ?>

              <article>
                <a class="main_link" href="article.php?billet=<?php echo ($donnees['id']); ?>" style="text-decoration: none;">
                  <h2><?php echo htmlspecialchars($donnees['titre']) ?>
                    <?php
                      include ("premium2.php");?>
                  </h2>
                  <figure>
                    <img src=<?php echo "\"uploadArticle/".$art->getImage()."\""; ?>alt="logo de l'article" title="logo de l'article" height="300" width="165"> <!-- 420x232 px -->
                  </figure>
                </a>
                <div class="infosLastArticle">
                  <p style="margin-bottom: 15px;"><?php echo nl2br(htmlspecialchars($art->getExtrait())) ?> <a class="readmore" href="article.php?billet=<?php echo ($donnees['id']); ?>">Lire la suite</a></p>
                  <p class="pstyle">Auteur: 
                    <?php  
                      $pers = new Personne($donnees['idAuteur'], $bdd);
                      echo $pers->getNom()." ".$pers->getPrenom();
                    ?>
                  </p>
                  <a href="article.php?billet=<?php echo ($donnees['id']); ?>" class="comments">
                    <img src="bulle-comment.png" width="16px" height="16px;">
                    <?php 
                    echo ($art->getNbCommentaire()); ?> <!-- Nombres de commentaires sur l'article -> PHP -->
                  </a>
                  <p class="publDateMain">Publié le <?php echo nl2br(htmlspecialchars($donnees['date_creation_fr'])) ?></p>
                </div>
              </article>

                <?php 
                }
                  $req->closeCursor(); 
                ?>

            </div>

            <div class="articles">
              <!-- pareil que précédemment avec le main article, sauf qu'on doit afficher  les 3 derniers articles (sans compter le tout dernier qui est deja en main link)  PHP -->

              <?php 
                $req = $bdd->query('SELECT id, idAuteur, titre, idCategorie, corps, DATE_FORMAT(date_creation, \'%d/%m/%Y\') AS date_creation_fr FROM Article WHERE idCategorie=1 AND affiche=1 AND invisibleAuteur=0 ORDER BY date_creation DESC LIMIT 1, 4');

                while ($donnees = $req->fetch())
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
                    $pers = new Personne($_SESSION['id'], $bdd);
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
                  <?php $art = new Article ($donnees['id'],$bdd);
                    echo ($art->getNbCommentaire()); ?> <!-- nbres de comments + ajouter l'id #comments (ou autre) dans le href pour aller direct aux commentaires et pas slmt la page -->
                </a>
              </article>

              <?php 
                }
                $req->closeCursor();
              ?>
              
            </div>
          </div>

          <!-- une autre div article? -->

          <div class="right">

            <?php include('rightPannelIndex.php'); ?>

          </div>
          
        </section>
      </div>

      <div class="container accesListe">
        <a class="sinslink_bis linkListe" href="economieListe.php">Acceder à la liste de tous les articles de cette catégorie</a>
      </div>

      <?php include("footer.php"); ?>

    </body>
</html>