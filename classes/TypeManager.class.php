<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class TypeManager{
	
	private $db; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterType($type) {
		// Ajout d'un type dans la base de données
		$retour = -1;
		if($type instanceof Type){
			$req = $this->db->prepare('INSERT INTO type (type_nom, type_desc, type_img)
										VALUES (:typeNom, :typeDesc, :typeImg);');
			$req->bindValue(':typeNom', $type->getTypeNom());
			$req->bindValue(':typeDesc', $type->getTypeDesc());
			$req->bindValue(':typeImg', $type->getTypeImg());
						
			$retour = $req->execute();
		}
		return $retour;
	}
	
	public function existantType($type){
		// Vérifie si un type existe déjà dans la base de données
		$sql = 'SELECT type_id, type_nom FROM type WHERE type_nom=:typeNom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':typeNom', $type->getTypeNom());
		$req->execute();
		
		$typeExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $typeExist[0] ;
	}
	
	public function listerType(){
		// Retourne la liste des types
		$listeType = array();
		$sql = 'SELECT * FROM type';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($type=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeType[]=new Type($type);
		}
		$requete->closeCursor();
		return $listeType ;
	}
	
	public function getNbType() {
		// Retourne le nombre de types
		$sql = "SELECT COUNT(DISTINCT type_id) AS nbType FROM type";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbType = $valeur;
		}
		$requete->closeCursor();
		return $nbType;
	}
		
	public function getIdTypeWithOther($type){
		// Retourne l'id d'un type à partir de son nom et de sa description
		$sql = "SELECT type_id FROM type WHERE type_nom = :typeNom 
											   AND type_desc = :typeDesc 
											   AND type_img = :typeImg ";

		$req = $this->db->prepare($sql);
		$req->bindValue(':typeNom', $type->getTypeNom());
		$req->bindValue(':typeDesc', $type->getTypeDesc());
		$req->bindValue(':typeImg', $type->getTypeImg());
		
		$req->execute();
		
		$type=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $type['type_id'] ;
	}

	public function getTypeWithId($id){
		// Retourne un type à partir de son id
		$sql = "SELECT * FROM type WHERE type_id = :typeId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':typeId', $id);
		$req->execute();
		
		$produit=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $produit ;
	}

	public function getTypeWithNom($nom){
		// Retourne un type à partir de son nom
		$sql = "SELECT * FROM type WHERE type_nom = :typeNom ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':typeNom', $nom);
		$req->execute();
		
		$produit=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $produit ;
	}
		
	public function supprimerType($type) {
		// Supprime un type de la base de données
		$retour = -1;
		if($type instanceof Type){
			$req = $this->db->prepare("DELETE FROM type WHERE type_id = :typeId");
			$req->bindValue(':typeId', $type->getTypeId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierType($type) {
		// Modifie un type dans la base de données
		$retour = -1;
		if($type instanceof Type){
			$req = $this->db->prepare("UPDATE type SET type_nom = :typeNom, type_desc = :typeDesc, type_img = :typeImg WHERE type_id = :typeId;");
			$req->bindValue(':typeNom', $type->getTypeNom());
			$req->bindValue(':typeDesc', $type->getTypeDesc());
			$req->bindValue(':typeImg', $type->getTypeImg());
			$req->bindValue(':typeId', $type->getTypeId());

			$retour = $req->execute();		
		}
		return $retour;
	}
}