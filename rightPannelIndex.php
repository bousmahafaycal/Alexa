            <?php
              if (isset($_GET['inscription'])){
                echo "<p class=\"prevent_msg\" style=\"text-align: center;\">Votre inscription a été prise en compte !</p>";
              } 
              if (empty($_SESSION['connecte'])) { ?>
            
            <div class="rightind-pannel">  
              <p>
                Authentification :</br>
                <form method="post" action="authentification.php">
                  <label for="pseudo" class="forminsc auth-pannel">Pseudo ou e-mail :</label>
                  <input type="text" name="pseudo" class="form-control form_auth_pannel" id="pseudo"/>
                  <br>
                  <label for="mdp" class="forminsc auth-pannel">Mot de passe :</label>
                  <input type="password" name="mdp"  class="form-control form_auth_pannel" id="mdp"/>
                  <input type="hidden" name="validate" id="validate" value="OK"/>
                  <br>
                  <input type="submit" value="Valider"  class="submit_but" id="valider">
                </form>
                <br>
                Vous n'avez pas de compte ?
                <br>
                <a href="inscription.php" class="sinslink_bis">Inscription</a>
              </p>
            </div>

            <?php } else { 
              $per = new Personne ($_SESSION['id'],$bdd);
            ?>

            <div class="infosUserIndex">
              <div class="containerInfos1">
                <img src=<?php echo "\"uploadPersonne/".$per->getImage()."\""; ?>width="100px" height="100px">     <!-- logo-a-2.jpg -->
                <div class="centerPseudoInfos"> 
                  <p class="pseudoInfos"><?php echo $per->getPseudo(); ?> </p>
                </div>              
              </div>
              <p class="nomInfos"><?php echo $per->getPrenom(); ?> <?php echo $per->getNom(); ?></br>
                <strong class="gradePannel greyhover">
                  <?php
                    if ($per->getDroit()==0) {
                      echo "Contribueur";
                    }elseif ($per->getDroit()==1) {
                      echo "Modérateur";
                    }elseif ($per->getDroit()==2) {
                      echo "Administrateur";
                    }else{
                      echo "Super-administrateur";
                    }
                  ?>
                </strong>
              </p>
              <p id="pointsInfos" class="pointsInfos"><?php echo $per->getPoint(); ?> points </p>
              <div class="more-info">
                <div class="more-info-icon"><a href="points.php">?</a></div>
                <div class="more-info-tooltip">Les articles premium necessitent des points pour être consultés.</br>Cliquez pour en savoir plus.</div>
              </div>
              <div class="aInfosUser">  
                <a href="deconnection.php" class="sinslink_bisbis infosDex">Se deconnecter</a>      
              </div>
            </div>

            

           <div class="rightind-pannel">
              <p class="bb"> Pour ecrire un article :</br>
                <a href="creationArticle.php" class="sinslink_bis">Cliquez ici</a>
              </p>

              <p class="bb pt"> <!-- ATTENTION : Lien à modifier !! -->
                Pour gagner des points :</br>
                <a href="points.php" class="sinslink_bis">Cliquez ici</a>
              </p>
            
              <p class="bb pt"> <!-- ATTENTION : Lien à modifier !! -->
                Pour acceder à tous vos articles :</br>
                <a href="mesarticles.php" class="sinslink_bis">Mes articles</a>
              </p>

                      
              <p class="pt">
                Pour acceder à vos préférences :</br>
                <a href="preference.php" class="sinslink_bis">Préférences</a>
              </p>

            </div>
            <?php if ($per->getDroit() > 0){?>
            <div class="rightind-pannel">
            <?php if ($per->getDroit( )> 2){?>
              <p class="bb pt">
                Pour acceder à la super-administration :</br>
                <a href="superadmin.php" class="sinslink_bis">Super-administration</a>
              </p>
              <?php  } ?>

              <?php if ($per->getDroit() > 1){?>
              <p class="bb pt">
                Pour acceder à l'administration :</br>
                <a href="admin.php" class="sinslink_bis">Administration</a>
              </p>
              <?php  } ?>

              <p class="pt">
                Pour acceder à la modération :</br>
                <a href="moderation.php" class="sinslink_bis">Modération</a>
              </p>

            </div>

              <?php } } ?>

            