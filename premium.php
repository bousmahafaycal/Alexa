<?php 
if (isset($_SESSION['id']))
	$pers = new Personne($_SESSION['id'], $bdd);

if (isset ($art) && $art->getGratuit()==false ) { 
	if (isset($_SESSION['id']) &&  (ArticlePaye::existeArticlePaye($pers->getId(),$art->getId(),$bdd) || $pers->getDroit() > 0)) {} else { ?>
                      <img src="premium_logo.png" width="26" height="19">
<?php  } 
}
?>