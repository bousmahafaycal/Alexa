<?php

class Personne {
	private $bdd;
	private $id;
	private $nom;
	private $prenom;
	private $pseudo;
	private $droit ;
	private $sexe ;
	private $signature ;
	private $supprime;
	private $motDePasse ;
	private $style ;
	private $styleMobile ;
	private $points ;
	private $pointCumule;
	private $email ;
	private $image;
	private $personneExiste ;


	function __construct ($id, $bdd){
		//include('connectionbdd.php');
		$this->bdd = $bdd;
		$this->id = $id;
		$this->personneExiste = $this->existeId();

		if ($this->personneExiste){
			$this->recupereDonnees();
		}
	}

	static function authentification ($pseudo, $motDePasse){//Methode qui renvoie 0 si le login ou le mot de passe n'est pas bon et l'id sinon
		include('connectionbdd.php');

		$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE pseudo = ?  AND motDePasse = ? AND supprime = 0');
		$req->execute(array($pseudo, $motDePasse));
		$donnees = $req->fetch();
		$req->closeCursor();

		if ($donnees[0] == 0){
			return 0;
		}
		else {
			$req = $bdd->prepare('SELECT id  FROM `Personne` WHERE pseudo = ? AND motDePasse = ? AND supprime = 0');
			$req->execute(array($pseudo, $motDePasse));
			$donnees = $req->fetch();
			$req->closeCursor(); 
			return $donnees['id'];
		}
	}

	static function authentificationEmail ($email, $motDePasse){//Methode qui renvoie 0 si l'email ou le mot de passe n'est pas bon et l'id sinon
		include('connectionbdd.php');

		$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE email = ?  AND motDePasse = ? AND supprime = 0');
		$req->execute(array($email, $motDePasse));
		$donnees = $req->fetch();
		$req->closeCursor();

		if ($donnees[0] == 0){
			return 0;
		}
		else {
			$req = $bdd->prepare('SELECT id  FROM `Personne` WHERE email = ? AND motDePasse = ? AND supprime = 0');
			$req->execute(array($email, $motDePasse));
			$donnees = $req->fetch();
			$req->closeCursor(); 
			return $donnees['id'];
		}
	}
	


	// Fonctions necessaires au bon fonctionnement
	public function recupereDonnees (){
		$bdd = $this->bdd ;
		$req = $bdd->prepare('SELECT supprime,image, nom, prenom, pseudo, sexe, signature, email, points, pointCumule, motDePasse, droit, style, styleMobile  FROM `Personne` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); 

		$this->nom =  $donnees['nom'];
		$this->prenom =  $donnees['prenom'];
		$this->pseudo =  $donnees['pseudo'];
		$this->sexe =  $donnees['sexe'];
		$this->email =  $donnees['email'];
		$this->points =  $donnees['points'];
		$this->pointCumule =  $donnees['pointCumule'];
		$this->motDePasse =  $donnees['motDePasse'];
		$this->droit =  $donnees['droit'];
		$this->style =  $donnees['style'];
		$this->styleMobile =  $donnees['styleMobile'];
		$this->image = $donnees['image'];
		$this->signature = $donnees['signature'];
		$this->supprime = $donnees['supprime'];
	}


	function existeId(){
		// recuperation du est ce que la personne existe selon un id
		$req = $this->bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE id = ?');
		$req->execute(array($this->id));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){
			return false;
		}
		return true ;
	}

	function decremente (){
		$this->recupereDonnees();
		if ($this->points <= 0)
			return false;
		Personne::modifiePoints($this->bdd, $this->id, $this->points - 1);
		$this->recupereDonnees();
		return true;
	}

	function incremente (){
		$this->recupereDonnees();
		Personne::modifiePoints($this->bdd, $this->id, $this->points + 30);
		Personne::modifiePointCumule($this->bdd, $this->id, $this->pointCumule + 30);
		$this->recupereDonnees();
		return true;
	}

	static function existePseudo($pseudo){
		// recuperation du est-ce qu'un pseudo existe  dans la bdd
		include('connectionbdd.php');
		$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE pseudo = ?');
		$req->execute(array($pseudo));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){
			return false;
		}
		return true ;
	}

	static function existeEmail($mail){
		// recuperation du est-ce qu'un email existe  dans la bdd
		include('connectionbdd.php');
		$req = $bdd->prepare('SELECT COUNT(id) FROM `Personne` WHERE email = ?');
		$req->execute(array($mail));
		$donnees = $req->fetch();
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
		if ($donnees[0] == 0){
			return false;
		}
		return true ;
	}


	static function modifieImage($bdd, $id, $image){ 
		$req = $bdd->prepare('UPDATE Personne SET image = ? WHERE id = ?');
		$req->execute(array($image, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieSignature($bdd, $id, $signature){ 
		$req = $bdd->prepare('UPDATE Personne SET signature = ? WHERE id = ?');
		$req->execute(array($signature, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieStyle($bdd, $id, $style){ 
		if (!(is_numeric($style)) || $style != 1 && $style!=2)
			$style = 1;
		$req = $bdd->prepare('UPDATE Personne SET style = ? WHERE id = ?');
		$req->execute(array($style, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieEmail($bdd, $id, $email){ 
		$req = $bdd->prepare('UPDATE Personne SET email = ? WHERE id = ?');
		$req->execute(array($email, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieMotDePasse($bdd, $id, $email){ 
		$req = $bdd->prepare('UPDATE Personne SET motDePasse = ? WHERE id = ?');
		$req->execute(array($motDePasse, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieDroit($bdd, $id, $droit){
		if ( ! ($droit == 2) AND ! ($droit == 1) ){
			$droit = 0;
		}

		$req = $bdd->prepare('UPDATE Personne SET droit = ? WHERE id = ?');
		$req->execute(array($droit, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifieSupprime($bdd, $id, $supprime){ 
		$req = $bdd->prepare('UPDATE Personne SET supprime = ? WHERE id = ?');
		$req->execute(array($supprime, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	static function modifiePoints($bdd, $id, $points){ 
		$req = $bdd->prepare('UPDATE Personne SET points = ? WHERE id = ?');
		$req->execute(array($points, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}
	static function modifiePointCumule($bdd, $id, $points){ 
		$req = $bdd->prepare('UPDATE Personne SET pointCumule = ? WHERE id = ?');
		$req->execute(array($points, $id));
		$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
	}

	// Les getters, comprend les fonctions suivantes :
	/* 	getId
		getNom
		getPrenom
		getPseudo
		getMotDePasse
		getStyle
		getStyleMobile
		getSignature
		getPoint
		getPointCumule
		getEmail
		getDroit
		getSexe
		getPersonneExiste
		getImage
	*/
	public function getId(){
		return $this->id;
	}

	public function getNom(){
		return $this->nom;
	}

	public function getPrenom(){
		return $this->prenom;
	}

	public function getMotDePasse(){
		return $this->motDePasse;
	}

	public function getStyle(){
		return $this->style;
	}

	public function getStyleMobile(){
		return $this->styleMobile;
	}

	public function getPseudo(){
		return $this->pseudo;
	}
 // --------
	public function getSignature(){
		return $this->signature;
	}

	public function getPoint(){
		return $this->points;
	}

	public function getPointCumule(){
		return $this->pointCumule;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getDroit(){
		return $this->droit;
	}

	public function getSexe(){
		return $this->sexe;
	}

	public function getPersonneExiste(){
		return $this->personneExiste;
	}

	public function getImage (){
		return $this->image;
	}
	
	public function getSupprime (){
		return $this->supprime;
	}

}


?>