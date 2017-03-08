<?php
session_start();
if (empty($_SESSION['precedent']))
	exit();

if (empty($_SESSION['connecte'])){
	$_SESSION['precedent2existe'] = true;
	$_SESSION['precedent2'] = $_SESSION['precedent'];
	$_SESSION['precedent'] = "verifPouce.php?valeur=".$_GET['valeur']."&comment=".$_GET['comment'];
	header("location: authentification.php?message=true");
	exit();
}

if (isset($_SESSION['precedent2existe']) && $_SESSION['precedent2existe']){
	$_SESSION['precedent2existe'] = false ;
	$_SESSION['precedent'] = $_SESSION['precedent2'];
}

if (isset($_GET['comment']) && isset($_GET['valeur'])){
	include('Pouce.php');
	if (is_numeric($_GET['valeur']) && $_GET['valeur']==1)
		$res = Pouce::ajouterPouce($_GET['comment'], $_SESSION['id'], true);
	elseif (is_numeric($_GET['valeur']) && $_GET['valeur']==0)
		$res = Pouce::ajouterPouce($_GET['comment'], $_SESSION['id'], false);
		
	
}

header("location: ".$_SESSION['precedent']);
exit();

?>