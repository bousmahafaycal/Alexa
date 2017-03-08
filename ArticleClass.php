<?php

class Article {
	private $bdd;
	private $id;
	private $idAuteur = 0 ;
	private $titre;
	private $corps;
	private $image;
	private $idCategorie;
	private $idModerateur;
	private $invisibleAuteur ;
	private $date_creation_fr;
	private $moderation;
	private $gratuit;
	private $affiche;
	private $nbCommentaire;
	private $articleExiste = false ;
	private $extrait;
	private $extraitLong;


	// Constructeur
	public function __construct ($id, $bdd){
		//include('connectionbdd.php');
		$this->bdd = $bdd;
		$this->id = $id;
		$this->articleExiste = $this->existe();

		if ($this->articleExiste){
			$this->recupereDonnees();
		}
		

	}

	// Fonctions necessaires au bon fonctionnement
	public function recupereDonnees (){
		$req = $this->bdd->prepare('SELECT gratuit, image, invisibleAuteur, idModerateur, moderation, affiche , titre, idAuteur, idCategorie, corps, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr   FROM `Article` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); 

		$this->titre =  $donnees['titre'];
		$this->idAuteur =  $donnees['idAuteur'];
		$this->idModerateur =  $donnees['idModerateur'];
		$this->idCategorie =  $donnees['idCategorie'];
		$this->corps =  $donnees['corps'];
		$this->extrait =  $this->creationExtrait($this->corps,15); // Fixé arbitrairement à 15 mots dans l'extrait pour le moment.
		$this->extraitLong =  $this->creationExtrait($this->corps,35); // Fixé arbitrairement à 35 mots dans l'extrait pour le moment.

		$this->image =  $donnees['image'];
		/*
		if (isset($donnees['image'])) {
			$this->image =  $donnees['image'];
		}else{
			$this->image = "default.jpg";
		}
		*/

		$this->date_creation_fr =  $donnees['date_creation_fr'];
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
			//echo "false";
			$this->invisibleAuteur = false;
		} else {
			//echo "true";
			$this->invisibleAuteur = true;
		}
		if ($donnees['gratuit'] == 0){
			$this->gratuit = false;
		} else {
			$this->gratuit = true;
		}

		// Recuperer le nombre de commentaire liés à cet article
		$req = $this->bdd->prepare('SELECT COUNT(id) FROM `Commentaire` WHERE idArticle = ? AND affiche = ?');
		$req->execute(array($this->id, "1"));
		$donnees = $req->fetch();
		$req->closeCursor();
		$this->nbCommentaire = $donnees[0];
	}


	public function existe (){

		// recuperation du est ce que l'article existe
		$req = $this->bdd->prepare('SELECT COUNT(id) FROM `Article` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){ // Si l'id n'est pas dans la base de donnée, l'article n'existe pas
			return false;
		}
		return true ;
	}

	public function creationExtrait($texte,$maxMots){
		$texte = str_replace('  ', ' ', $texte); // Supprimer les double (ou plus) espaces
		$tab = explode(' ', $texte); // Coupe une chaine en un tableau
		if (count($tab)>$maxMots && $maxMots > 0){
			$extrait  = implode(' ', array_slice($tab, 0, $maxMots))." ..."; // Rasssemble les éléments d'un tableau en une chaine , array_slice permet d'extraire une partie du tableau
			return $extrait;
		}
		return $texte;//"Il y a un problème. Merci de nous contacter pour nous le signaler (Voir le lien au bas de la page)";
	}

	// Fonction de modification, j'aurais pu les appeler setModeration par exemple mais c'est trop tard
	/*
		Liste des fonctions :
			modifieModeration
			modifieAffiche
			modifieIdModerateur
			modifieInvisibleAuteur
			modifieImage
			modifieTitre
			modifieCorps
			modifieIdCategorie
			modifieGatuit

	*/

	static function modifieModeration($bdd, $id, $mod){
		if ($mod)
			$modChiffre = 1;
		else{
			$modChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Article SET moderation = ? WHERE id = ?');
		$req->execute(array($modChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieAffiche($bdd, $id, $affiche){
		if ($affiche)
			$afficheChiffre = 1;
		else{
			$afficheChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Article SET affiche = ? WHERE id = ?');
		$req->execute(array($afficheChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}
	
	static function modifieIdModerateur($bdd, $id, $idModerateur){
		$req = $bdd->prepare('UPDATE Article SET idModerateur = ? WHERE id = ?');
		$req->execute(array($idModerateur, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieInvisibleAuteur($bdd, $id, $invisibleAuteur){ 
		if ($invisibleAuteur)
			$invisibleAuteurChiffre = 1;
		else{
			$invisibleAuteurChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Article SET invisibleAuteur = ? WHERE id = ?');
		$req->execute(array($invisibleAuteurChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieImage($bdd, $id, $image){ 
		$req = $bdd->prepare('UPDATE Article SET image = ? WHERE id = ?');
		$req->execute(array($image, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieCorps($bdd, $id, $corps){ 
		$req = $bdd->prepare('UPDATE Article SET corps = ? WHERE id = ?');
		$req->execute(array($corps, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieTitre($bdd, $id, $titre){ 
		$req = $bdd->prepare('UPDATE Article SET titre = ? WHERE id = ?');
		$req->execute(array($titre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieIdCategorie($bdd, $id, $idCategorie){
		$req = $bdd->prepare('UPDATE Article SET idCategorie = ? WHERE id = ?');
		$req->execute(array($idCategorie, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieGratuit($bdd, $id, $gratuit){
		if ($gratuit)
			$gratuitChiffre = 1;
		else{
			$gratuitChiffre = 0;
		}
		$req = $bdd->prepare('UPDATE Article SET gratuit = ? WHERE id = ?');
		$req->execute(array($gratuitChiffre, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	// Les getters, comprend les fonctions suivantes :
	/* 	getId
		getTitre
		getCorps
		getIdAuteur
		getIdCategorie
		getDateCreationFr
		getArticleExiste
		getAffiche
		getModeration
		getIdModerateur
		getInvisibleAuteur
		getImage
		getGratuit
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

	public function getIdAuteur(){
		return $this->idAuteur;
	}

	public function getIdCategorie(){
		return $this->idCategorie;
	}

	public function getDateCreationFr(){
		return $this->date_creation_fr;
	}

	public function getArticleExiste(){
		return $this->articleExiste;
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


	public function getNbCommentaire (){
		return $this->nbCommentaire;
	}

	public function getImage (){
		return $this->image;
	}
	public function getGratuit (){
		return $this->gratuit;
	}
	public function getExtrait (){
		return $this->extrait;
	}

	public function getExtraitLong (){
		return $this->extraitLong;
	}

}


?>