<?php

class Pouce {
	private $bdd;
	private $id;
	private $idAuteur;
	private $idCommentaire;
	private $valeur;
	private $pouceExiste;



	function __construct ($id, $bdd){
		//include('connectionbdd.php');
		$this->bdd = $bdd;
		$this->id = $id;
		$this->pouceExiste = $this->existeId();

		if ($this->pouceExiste){
			$this->recupereDonnees();
		}

	}


	// Fonctions necessaires au bon fonctionnement
	public function recupereDonnees (){
		$req = $this->bdd->prepare('SELECT id, idAuteur, idCommentaire, valeur  FROM `Pouce` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); 
		$this->idAuteur =  $donnees['idAuteur'];
		$this->idCommentaire =  $donnees['idCommentaire'];
		$this->valeur = $donnees['valeur'];
		$this->id = $donnees['id'];
	}

	function existeId(){
		$bdd = $this->bdd ;
		// recuperation du est ce que la personne existe selon un id
		$req = $bdd->prepare('SELECT COUNT(id) FROM `Pouce` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){
			return false;
		}
		return true ;
	}

	static function verifPouce ($idCommentaire, $idAuteur, $valeur){
		//  0 signifie l'utilisateur n'a pas encore voté, 1 signifie l'utilisateur a vote contrairement a son vote du moment et 2 signifie l'utilisateur a déja voté la meme chose. Le code 3 signifie qu'il y a une erreur quelque part.  Normalement on ne devrait jamais y acceder
		include('connectionbdd.php');
		if (is_numeric($idCommentaire) && is_numeric($idAuteur) && is_bool($valeur)){
			if ($valeur)
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Pouce` WHERE idAuteur = ? AND idCommentaire = ? AND valeur != ?');
			else 
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Pouce` WHERE idAuteur = ? AND idCommentaire = ? AND valeur = ?');

			

			$req->execute(array($idAuteur,$idCommentaire,0));
			$donnees = $req->fetch();
			$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
			if ($donnees[0] == 0){
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Pouce` WHERE idAuteur = ? AND idCommentaire = ? ');
				$req->execute(array($idAuteur,$idCommentaire));
				$donnees = $req->fetch();
				$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
				if ($donnees[0]==0){
					return 0;
				}
				else{
					return 1;
				}
			}
			elseif ($donnees[0] == 1) {
				return 2;
			}
			return 3;
		}
	}


	static function ajouterPouce($idCommentaire, $idAuteur, $valeur){ 
		// Fonction qui ajoute un pouce en faisant attention que chaque Personne n'a voté qu'une seule fois par Commentaire. Si le pouce existait déja, on le supprime. Si il n'existait pas,
		
		include('connectionbdd.php');
		include('Commentaire.php');
		include('Personne.php');
		if (is_numeric($idCommentaire) && is_numeric($idAuteur) && is_bool($valeur)){
			$ver = Pouce::verifPouce($idCommentaire, $idAuteur, $valeur);
			if ($ver == 0){ 
				//echo "ver = 0";
				$com = new Commentaire($idCommentaire, $bdd);
				$aut = new Personne($idAuteur, $bdd);
				if ($com->getCommentaireExiste() && $aut->getPersonneExiste()){
					$req = $bdd->prepare('INSERT INTO `Pouce` (`id`, `idAuteur`, `idCommentaire`, `valeur`) VALUES (NULL, ?, ?, ? )');
					if($valeur)
						$req->execute(array($idAuteur, $idCommentaire, 1));
					else
						$req->execute(array($idAuteur, $idCommentaire, 0));
					$req->closeCursor();
				}
				return 0;
			}
			elseif ($ver==1) { // Cela signifie que l'utilisateur a déja voté sur ce commentaire, mais qu'il souhaite rectifier son vote
				// Partie ou l'on supprime le precedent pouce
				$req = $bdd->prepare('SELECT id FROM `Pouce` WHERE idAuteur = ? AND idCommentaire = ? ');
				$req->execute(array($idAuteur,$idCommentaire));
				$donnees = $req->fetch();
				$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
				$ans = Pouce::supprimerPouce($donnees['id']);
				// Partie ou on ajoute le nouveau pouce
				$com = new Commentaire($idCommentaire, $bdd);
				$aut = new Personne($idAuteur, $bdd);
				if ($com->getCommentaireExiste() && $aut->getPersonneExiste()){
					$req = $bdd->prepare('INSERT INTO `Pouce` (`id`, `idAuteur`, `idCommentaire`, `valeur`) VALUES (NULL, ?, ?, ? )');
					if($valeur)
						$req->execute(array($idAuteur, $idCommentaire, 1));
					else
						$req->execute(array($idAuteur, $idCommentaire, 0));
					$req->closeCursor();
				}
				return 1;
			}
			

			elseif ($ver == 2) {
				// On doit alors supprimer le premier pouce
				$req = $bdd->prepare('SELECT id FROM `Pouce` WHERE idAuteur = ? AND idCommentaire = ? ');
				$req->execute(array($idAuteur,$idCommentaire));
				$donnees = $req->fetch();
				$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
				$ans = Pouce::supprimerPouce($donnees['id']);
				return 2;
			}
				
			
				
		}
		
		return 3;
		
			
	}

	static function supprimerPouce($id){ // renvoie true si cela a été supprimé et false sinon
		if (is_numeric($id)){
			include('connectionbdd.php');
			// Verification que le Pouce existe
			$pou = new Pouce($id, $bdd);

			if ($pou->getPouceExiste()){
				// Suppression du Pouce
				$req = $bdd->prepare('DELETE FROM `Pouce` WHERE `id` = ? ');
				$req->execute(array($id));
				$donnees = $req->fetch();
				$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
				return true;
			} 
			
		}
		return false;
	}
	

	static function nombrePouce ($idCommentaire, $valeur){

		if (is_numeric($idCommentaire) && is_bool($valeur)){
			include('connectionbdd.php');
			if ($valeur)
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Pouce` WHERE idCommentaire = ? AND valeur != ? ');
			else 
				$req = $bdd->prepare('SELECT COUNT(id) FROM `Pouce` WHERE idCommentaire = ? AND valeur = ? ');
		
			
			$req->execute(array($idCommentaire,0));
			$donnees = $req->fetch();
			$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
			return $donnees[0] ;
		}
			
	}
	// Getter
	/*
		getId
		getIdCommentaire
		getIdAuteur
		getValeur
	*/
	public function getId(){
		return $this->id;
	}

	public function getIdCommentaire(){
		return $this->idCommentaire;
	}

	public function getIdAuteur(){
		return $this->idAuteur;
	}

	public function getValeur(){ // true pour positif, false pour negatif
		if ($this->valeur == 0)
			return false;
		return true;
	}
	
	public function getPouceExiste(){
		return $this->pouceExiste;
	}
	
}


?>