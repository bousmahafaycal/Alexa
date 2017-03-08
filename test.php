<?php
	include('Article.php');
	include('Personne.php');
	include ('Pouce.php');
	$pou = new Pouce(3);
	$art = new Article (21);
	$valeur = $pou->getValeur();
	echo "valeur : ".$valeur;
	if ($valeur == false)
		echo "false";
	/*echo Personne::authentification ("Fawassel","fawassel");
	$per = new Personne(Personne::authentification ("Fawassel","fawassel"));
	echo $per->getNom();
	echo " ".$per->getPrenom();*/

?>