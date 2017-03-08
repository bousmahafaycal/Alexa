<?php

class Categorie {
	private $bdd;
	private $id;
	private $titre;
	private $accroche;
	private $categorieExiste;



	function __construct ($id, $bdd){
		//include('connectionbdd.php');
		$this->bdd = $bdd;
		$this->id = $id;
		$this->categorieExiste = $this->existeId();

		if ($this->categorieExiste){
			$this->recupereDonnees();
		}

	}


	// Fonctions necessaires au bon fonctionnement
	public function recupereDonnees (){
		$req = $this->bdd->prepare('SELECT titre,accroche  FROM `Categorie` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); 

		$this->titre =  $donnees['titre'];
		$this->accroche =  $donnees['accroche'];
		
	}

	function existeId(){
		$bdd = $this->bdd ;
		// recuperation du est ce que la personne existe selon un id
		$req = $bdd->prepare('SELECT COUNT(id) FROM `Categorie` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){
			return false;
		}
		return true ;
	}
	// Getter
	/*
		getId
		getTitre
		getCorps
	*/
	public function getId(){
		return $this->id;
	}

	public function getTitre(){
		return $this->titre;
	}

	public function getCorps(){
		return $this->corps;
	}
	
	public function getCategorieExiste(){
		return $this->categorieExiste;
	}
}


?>