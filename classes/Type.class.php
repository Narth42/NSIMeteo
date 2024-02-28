<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class Type{
	
	//Attribut
	private $typeId;
	private $typeNom;
	private $typeDesc;
	private $typeImg;

	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'type_id':$this->setTypeId($valeur);break;
				case 'type_nom':$this->setTypeNom($valeur);break;
				case 'type_desc':$this->setTypeDesc($valeur);break;
				case 'type_img':$this->setTypeImg($valeur);break;
				
			}
		}
	}
	
	//Getteurs et Setteurs
		//Identifiant
	public function setTypeId($id) {
		$this->typeId = $id;
	}
	
	public function getTypeId()	{
		return $this->typeId;
	}
		//Nom
	public function setTypeNom($nom)	{
		$this->typeNom = $nom;
	}
	
	public function getTypeNom()	{
		return $this->typeNom;
	}
		//Description
	public function setTypeDesc($desc) {
		$this->typeDesc = $desc;
	}
	public function getTypeDesc() {
		return $this->typeDesc;
	}

		//Image
	public function setTypeImg($img) {
		$this->typeImg = $img;
	}

	public function getTypeImg() {
		return $this->typeImg;
	}
		
}