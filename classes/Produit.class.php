<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class Produit{
	
	//Attribut
	private $prodId;
	private $prodNom;
	private $prodPrix;
	private $prodProvenance;
	private $prodStock;
	private $prodImg;
	private $prodDesc;
	private $prodType;
	private $prodNouveau;
	private $prodSpecial;
	
	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'prod_id':$this->setProdId($valeur);break;
				case 'prod_nom':$this->setProdNom($valeur);break;
				case 'prod_prix':$this->setProdPrix($valeur);break;
				case 'prod_provenance':$this->setProdProvenance($valeur);break;
				case 'prod_stock':$this->setProdStock($valeur);break;
				case 'prod_img':$this->setProdImg($valeur);break;
				case 'prod_desc':$this->setProdDesc($valeur);break;
				case 'type_id':$this->setProdType($valeur);break;
				case 'nouveau':$this->setProdNouveau($valeur);break;
				case 'special':$this->setProdSpecial($valeur);break;
			}
		}
	}
	
	//Getteurs et Setteurs
		//Numéro
	public function setProdId($id) {
		$this->prodId= $id;
	}
	
	public function getProdId()	{
		return $this->prodId;
	}
		//Nom
	public function setProdNom($nom)	{
		$this->prodNom = $nom;
	}
	
	public function getProdNom()	{
		return $this->prodNom;
	}
		//Prix Produit
	public function setProdPrix($prix) {
		$this->prodPrix = $prix;
	}
	
	public function getProdPrix() {
		return $this->prodPrix;
	}

		//Provenance Produit
	public function setProdProvenance($provenance) {
		$this->prodProvenance = $provenance;
	}
	
	public function getProdProvenance() {
		return $this->prodProvenance;
	}

		//Stock Produit
	public function setProdStock($stock) {
		$this->prodStock = $stock;
	}
	
	public function getProdStock() {
		return $this->prodStock;
	}

		//Image Produit
	public function setProdImg($img) {
		$this->prodImg = $img;
	}
		
	public function getProdImg() {
		return $this->prodImg;
	}

		//Description
	public function setProdDesc($desc)	{
		$this->prodDesc = $desc;
	}
	
	public function getProdDesc()	{
		return $this->prodDesc;
	}
	
		//Type ID 
	public function setProdType($type)	{
		$this->prodType = $type;

	}
	
	public function getProdType()	{
		return $this->prodType;
	}

	
		//Nouveau Produit
	public function setProdNouveau($nouveau) {
		$this->prodNouveau = $nouveau;
	}
	
	public function getProdNouveau() {
		return $this->prodNouveau;
	}

		//Produit Special
	public function setProdSpecial($special) {
		$this->prodSpecial = $special;
	}
	
	public function getProdSpecial() {
		return $this->prodSpecial;
	}
}