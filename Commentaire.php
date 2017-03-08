<?php 
class Commentaire {
	private $bdd;
	private $id;
	private $idAuteur;
	private $idModerateur;
	private $moderation;
	private $invisibleAuteur ;
	private $affiche;
	private $corps;
	private $idArticle;
	private $date_commentaire_fr;
	private $commentaireExiste = false;



	// Constructeur
	function __construct ($id, $bdd){
		if (is_numeric($id)){
			//include('connectionbdd.php');
			$this->bdd = $bdd;
			$this->id = $id;
			$this->commentaireExiste = $this->existeId();

			if ($this->commentaireExiste){
				$this->recupereDonnees();
			}
		}
	}


	// Fonctions necessaires au bon fonctionnement
	public function recupereDonnees (){
		$bdd = $this->bdd ;
		$req = $bdd->prepare('SELECT invisibleAuteur, idModerateur, moderation, affiche, idArticle, corps, idAuteur,   DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire_fr FROM `Commentaire` WHERE id = ? ORDER BY date_commentaire');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); 

		$this->corps =  $donnees['corps'];
		$this->idArticle =  $donnees['idArticle'];
		$this->idAuteur =  $donnees['idAuteur'];
		$this->date_commentaire_fr =  $donnees['date_commentaire_fr'];
		$this->idModerateur =  $donnees['idModerateur'];
		if ($donnees['moderation'] == 0){
			$this->moderation = false;
		} else {
			$this->moderation = true;
		}

		if ($donnees['affiche'] == 0){
			$this->affiche = false;
		} else {
			$this->affiche = true;
		}
		if ($donnees['invisibleAuteur'] == 0){
			$this->invisibleAuteur = false;
		} else {
			$this->invisibleAuteur = true;
		}

		
	}


	function existeId(){
		// recuperation du est ce que le commentaire existe selon un id
		$req = $this->bdd->prepare('SELECT COUNT(id) FROM `Commentaire` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){
			return false;
		}
		return true ;
	}

	static function ajouterCommentaire ($idAuteur, $idArticle, $corps){
		// return true si il a été envoyé et false sinon
		if (isset($idArticle) && isset($idAuteur)&&isset($corps)&& is_numeric($idAuteur)&& is_numeric($idArticle)){
			include('connectionbdd.php');
			$req = $bdd->prepare('INSERT INTO `Commentaire` (`id`, `idAuteur`, `idArticle`, `corps`, `date_commentaire`) VALUES (NULL, ?, ?, ?, NOW() )');
			$req->execute(array($idAuteur, $idArticle, $corps));
			$req->closeCursor();
			return true;
		}
		return false;
	}

	static function modifieModeration($bdd, $id, $mod){
		if ($mod)
			$modChiffre = 1;
		else{
			$modChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Commentaire SET moderation = ? WHERE id = ?');
		$req->execute(array($modChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieAffiche($bdd, $id, $affiche){
		if ($affiche)
			$afficheChiffre = 1;
		else{
			$afficheChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Commentaire SET affiche = ? WHERE id = ?');
		$req->execute(array($afficheChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieIdModerateur($bdd, $id, $idModerateur){
		$req = $bdd->prepare('UPDATE Commentaire SET idModerateur = ? WHERE id = ?');
		$req->execute(array($idModerateur, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieInvisibleAuteur($bdd, $id, $invisibleAuteur){ 
		if ($invisibleAuteur)
			$invisibleAuteurChiffre = 1;
		else{
			$invisibleAuteurChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Commentaire SET invisibleAuteur = ? WHERE id = ?');
		$req->execute(array($invisibleAuteurChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	// Les getters, comprend les fonctions suivantes :
	/* 	getId
		getCorps
		getIdAuteur
		getIdArticle
		getDateCommentaireFr
		getCommentaireExiste
		getModeration
		getAffiche
		getIdModerateur
	*/
	public function getId(){
		return $this->id;
	}

	public function getCorps(){
		return $this->corps;
	}

	public function getIdAuteur(){
		return $this->idAuteur;
	}

	public function getIdArticle(){
		return $this->idArticle;
	}

	public function getDateCommentaireFr(){
		return $this->date_commentaire_fr;
	}

	public function getCommentaireExiste(){
		return $this->commentaireExiste;
	}
	
	public function getModeration(){
		return $this->moderation;
	}

	public function getAffiche(){
		return $this->affiche;
	}

	public function getIdModerateur(){
		return $this->idModerateur;
	}
	
	public function getInvisibleAuteur (){
		return $this->invisibleAuteur;
	}
}

?>