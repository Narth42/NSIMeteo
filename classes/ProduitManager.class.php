<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class ProduitManager{
	
	private $db; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterProduit($produit) {
		// Ajout d'un produit dans la base de données
		$retour = -1;
		if($produit instanceof Produit){
			$req = $this->db->prepare('INSERT INTO produit (prod_nom, prod_prix, prod_provenance, prod_stock, prod_img, prod_desc, type_id, nouveau, special)
										VALUES (:prodNom, :prodPrix, :prodProvenance, :prodStock, :prodImg, :prodDesc, :prodType, :prodNouveau, :prodSpecial);');
			$req->bindValue(':prodNom', $produit->getProdNom());
			$req->bindValue(':prodPrix', $produit->getProdPrix());
			$req->bindValue(':prodProvenance', $produit->getProdProvenance());
			$req->bindValue(':prodStock', $produit->getProdStock());
			$req->bindValue(':prodImg', $produit->getProdImg());
			$req->bindValue(':prodDesc', $produit->getProdDesc());
			$req->bindValue(':prodType', $produit->getProdType());
			$req->bindValue(':prodNouveau', $produit->getProdNouveau());
			$req->bindValue(':prodSpecial', $produit->getProdSpecial());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantProduit($produit){
		// Vérifie si le produit existe déjà dans la base de données
		$sql = 'SELECT prod_nom FROM produit WHERE prod_nom=:prodNom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':prodNom', $produit->getProdNom());
		$req->execute();
		
		$produitExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $produitExist[0] ;
	}
	
	public function listerProduit(){
		// Liste tous les produits de la base de données
		$listeProduit = array();
		$sql = 'SELECT * FROM produit';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($produit=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeProduit[]=new Produit($produit);
		}
		$requete->closeCursor();
		return $listeProduit ;
	}
	
	public function getNbProduit() {
		// Retourne le nombre de produits dans la base de données
		$sql = "SELECT COUNT(DISTINCT prod_id) AS nbProduit FROM produit";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbProduit = $valeur;
		}
		$requete->closeCursor();
		return $nbProduit;
	}
	public function getIdProduitWithOther($produit){
		// Retourne l'id du produit avec les autres informations
		$sql = "SELECT prod_id FROM produit WHERE prod_nom = :prodNom 
											   AND prod_prix = :prodPrix ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':prodNom', $produit->getProdNom());
		$req->bindValue(':prodPrix', $produit->getProdPrix());
	
		$req->execute();
		
		$produit=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $produit['prod_id'] ;
	}

	public function getProduitWithId($id){
		// Retourne le produit grace à son id
		$sql = "SELECT * FROM produit WHERE prod_id = :prodId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':prodId', $id);
		$req->execute();
		
		$produit=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $produit ;
	}
	
	public function supprimerProduit($produit) {
		// Supprime un produit de la base de données
		$retour = -1;
		if($produit instanceof Produit){		
			$req = $this->db->prepare("DELETE FROM produit WHERE prod_id = :prodId");
			$req->bindValue(':prodId', $produit->getProdId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierProduit($produit) {
		// Modifie un produit de la base de données
		$retour = -1;
		if($produit instanceof Produit){
			$req = $this->db->prepare("UPDATE produit SET prod_nom = :prodNom, prod_prix = :prodPrix, prod_provenance = :prodProvenance, prod_stock = :prodStock, prod_img = :prodImg, prod_desc = :prodDesc, type_id = :prodType, nouveau = :prodNouveau, special = :prodSpecial WHERE prod_id = :prodId;");
			$req->bindValue(':prodNom', $produit->getProdNom());
			$req->bindValue(':prodPrix', $produit->getProdPrix());
			$req->bindValue(':prodProvenance', $produit->getProdProvenance());
			$req->bindValue(':prodStock', $produit->getProdStock());
			$req->bindValue(':prodImg', $produit->getProdImg());
			$req->bindValue(':prodDesc', $produit->getProdDesc());
			$req->bindValue(':prodType', $produit->getProdType());
			$req->bindValue(':prodNouveau', $produit->getProdNouveau());
			$req->bindValue(':prodSpecial', $produit->getProdSpecial());
			$req->bindValue(':prodId', $produit->getProdId());
			
			$retour = $req->execute();		
		}
		return $retour;
	}

}