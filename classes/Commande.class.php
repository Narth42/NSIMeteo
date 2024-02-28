<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class Commande{
	
	//Attribut
	private $commId;
	private $commDate;
	private $commQuantite;
	private $commCli;
	private $commProd;
	private $commEtat;

	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'comm_id':$this->setCommId($valeur);break;
				case 'comm_date':$this->setCommDate($valeur);break;
				case 'comm_quantite':$this->setCommQuantite($valeur);break;
				case 'cli_id':$this->setCommClient($valeur);break;
				case 'prod_id':$this->setCommProduit($valeur);break;
				case 'comm_etat':$this->setCommEtat($valeur);break;
			}
		}
	}
	
	//Getteurs et Setteurs
		//Identifiant
	public function setCommId($id) {
		$this->commId = $id;
	}
	
	public function getCommId()	{
		return $this->commId;
	}
		//Date
	public function setCommDate($date)	{
		$this->commDate = $date;
	}
	
	public function getCommDate()	{
		return $this->commDate;
	}

		//Quantité
	public function setCommQuantite($quantite) {
		$this->commQuantite = $quantite;
	}

	public function getCommQuantite() {
		return $this->commQuantite;
	}

		//Client
	public function setCommClient($client)	{
		$this->commCli = $client;
	}
	public function getCommClient() {
		return $this->commCli;
	}
	
		//Produit
	public function setCommProduit($produit) {
		$this->commProd = $produit;
	}
	public function getCommProduit() {
		return $this->commProd;
	}

		//Etat
	public function setCommEtat($etat) {
		$this->commEtat = $etat;
	}

	public function getCommEtat() {
		return $this->commEtat;
	}
	
}