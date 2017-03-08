<?php

class ArticlePaye {
	private $bdd;
	private $id;
	private $idArticle = 0 ;
	private $idPersonne;
	private $idModerateur;
	private $articlePayeExiste = false ;
	

	// Constructeur
	public function __construct ($id, $bdd){
		//include('connectionbdd.php');
		$this->bdd = $bdd;
		$this->id = $id;
		$this->articlePayeExiste = $this->existe();

		if ($this->articlePayeExiste){
			$this->recupereDonnees();
		}
		

	}

	// Fonctions necessaires au bon fonctionnement
	public function recupereDonnees (){
		$req = $this->bdd->prepare('SELECT idPersonne, idArticle  FROM `ArticlePaye` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); 

		$this->titre =  $donnees['titre'];
		$this->idPersonne =  $donnees['idPersonne'];
		$this->idArticle =  $donnees['idArticle'];
		
	}


	public function existe (){

		// recuperation du est ce que l'article existe
		$req = $this->bdd->prepare('SELECT COUNT(id) FROM `ArticlePaye` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){ // Si l'id n'est pas dans la base de donnée, l'article n'existe pas
			return false;
		}
		return true ;
	}

	static function existeArticlePaye($idPersonne,$idArticle,$bdd){
		// recuperation du est ce que l'article est paye
		$req = $bdd->prepare('SELECT COUNT(id) FROM `ArticlePaye` WHERE idPersonne = ? AND idArticle = ?');
		$req->execute(array($idPersonne,$idArticle));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){ // Si ce n'est pas dans la basse de donnée, l'article n'a pas été payé
			return false;
		}
		return true ;
	}

	static function ajout ($idPersonne,$idArticle,$bdd){
		$req = $bdd->prepare('INSERT INTO `ArticlePaye` (`id`, `idPersonne`, `idArticle`) VALUES (NULL, ?, ? )');
		$req->execute(array($idPersonne, $idArticle));
		$req->closeCursor();
	}	

	// Les getters, comprend les fonctions suivantes :
	/* 	getId
		getIdArticle
		getIdPersonne
	*/
	public function getId(){
		return $this->id;
	}


	public function getIdArticle(){
		return $this->idArticle;
	}

	public function getIdPersonne(){
		return $this->idPersonne;
	}



}


?>