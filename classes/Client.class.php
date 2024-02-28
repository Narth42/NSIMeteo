<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class Client{
	
	//Attribut
	private $cliId;
	private $cliNom;
	private $cliPrenom;
	private $cliAdresse;
	private $cliMail;
	private $cliTel;
	private $cliMdp;
	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'cli_id':$this->setCliId($valeur);break;
				case 'cli_nom':$this->setCliNom($valeur);break;
				case 'cli_prenom':$this->setCliPrenom($valeur);break;
				case 'cli_adresse':$this->setCliAdresse($valeur);break;
				case 'cli_mail':$this->setCliMail($valeur);break;
				case 'cli_tel':$this->setCliTel($valeur);break;
				case 'cli_mdp':$this->setCliMdp($valeur);break;
			}
		}
	}
	
	//Getteurs et Setteurs
		//Identifiant
	public function setCliId($id) {
		$this->cliId = $id;
	}
	
	public function getCliId()	{
		return $this->cliId;
	}
		//Nom
	public function setCliNom($nom)	{
		$this->cliNom = $nom;
	}
	
	public function getCliNom()	{
		return $this->cliNom;
	}
		//Prénom
	public function setCliPrenom($prenom) {
		$this->cliPrenom = $prenom;
	}
	public function getCliPrenom() {
		return $this->cliPrenom;
	}
	
		//Adresse
	public function setCliAdresse($adresse)	{
		$this->cliAdresse = $adresse;
	}
	public function getCliAdresse() {
		return $this->cliAdresse;
	}
	
		//Mail
	public function setCliMail($mail) {
		$this->cliMail = $mail;
	}
	public function getCliMail() {
		return $this->cliMail;
	}

		//Téléphone
	public function setCliTel($tel)	{
		$this->cliTel = $tel;
	}
	
	public function getCliTel()	{
		return $this->cliTel;
	}

		//Mot de passe
	public function setCliMdp($mdp)	{
		$this->cliMdp = $mdp;
	}

	public function getCliMdp()	{
		return $this->cliMdp;
	}
}