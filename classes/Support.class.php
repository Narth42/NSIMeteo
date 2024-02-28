<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class Support{
	
	//Attribut
	private $supId;
	private $supSujet;
	private $supMessage;
	private $supNom;
	private $supMail;

	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'sup_id':$this->setSupId($valeur);break;
				case 'sup_sujet':$this->setSupSujet($valeur);break;
				case 'sup_message':$this->setSupMessage($valeur);break;
				case 'sup_nom':$this->setSupNom($valeur);break;
				case 'sup_mail':$this->setSupMail($valeur);break;
			}
		}
	}
	
	//Getteurs et Setteurs
		//Identifiant
	public function setSupId($id) {
		$this->supId = $id;
	}
	
	public function getSupId()	{
		return $this->supId;
	}
		//Sujet
	public function setSupSujet($sujet)	{
		$this->supSujet = $sujet;
	}
	
	public function getSupSujet()	{
		return $this->supSujet;
	}

		//Message
	public function setSupMessage($message)	{
		$this->supMessage = $message;
	}
	public function getSupMessage() {
		return $this->supMessage;
	}
	
		//Nom
	public function setSupNom($nom) {
		$this->supNom = $nom;
	}
	public function getSupNom() {
		return $this->supNom;
	}

		//Mail
	public function setSupMail($mail) {
		$this->supMail = $mail;
	}
	public function getSupMail() {
		return $this->supMail;
	}
	
}