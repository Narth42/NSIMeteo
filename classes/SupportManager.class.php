<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class SupportManager{
	
	private $db; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterSupport($ent) {
		// Ajout d'une commande dans la base de données
		$retour = -1;
		if($ent instanceof Support){
			$req = $this->db->prepare('INSERT INTO support (sup_sujet, sup_message, sup_nom, sup_mail)
										VALUES (:supSujet, :supMessage, :supNom, :supMail);');
			$req->bindValue(':supSujet', $ent->getSupSujet());
			$req->bindValue(':supMessage', $ent->getSupMessage());
			$req->bindValue(':supNom', $ent->getSupNom());
			$req->bindValue(':supMail', $ent->getSupMail());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantSupport($ent){
		// Supprime un support de la base de données
		$sql = 'SELECT sup_id, sup_sujet FROM support WHERE sup_sujet=:supSujet';
		$req = $this->db->prepare($sql);
		$req->bindValue(':supSujet', $ent->getSupSujet());
		$req->execute();
		
		$entExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $entExist[0] ;
	}
	
	public function listerSupport(){
		// Retourne la liste des supports
		$listeSupport = array();
		$sql = 'SELECT * FROM support';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($ent=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeSupport[]=new Support($ent);
		}
		$requete->closeCursor();
		return $listeSupport ;
	}
	
	public function getNbSupport() {
		// Retourne le nombre de supports
		$sql = "SELECT COUNT(DISTINCT sup_id) AS nbSupport FROM support";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbSupport = $valeur;
		}
		$requete->closeCursor();
		return $nbSupport;
	}
	public function getIdSupportWithOther($ent){
		// Retourne l'id du support avec les autres informations
		$sql = "SELECT sup_id FROM support WHERE sup_sujet = :supSujet 
											   AND sup_message = :supMessage 
											   AND sup_nom = :supNom
											   AND sup_mail = :supMail";

		$req = $this->db->prepare($sql);
		$req->bindValue(':supSujet', $ent->getSupSujet());
		$req->bindValue(':supMessage', $ent->getSupMessage());
		$req->bindValue(':supNom', $ent->getSupNom());
		$req->bindValue(':supMail', $ent->getSupMail());
		
		$req->execute();
		
		$ent=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $ent['sup_id'] ;
	}
	
	public function getSupportWithId($id){
		// Retourne le support avec l'id
		$sql = "SELECT * FROM support WHERE sup_id = :supId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':supId', $id);
		$req->execute();
		
		$produit=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $produit ;
	}
	
	
	public function supprimerSupport($ent) {
		// Supprime un support de la base de données
		$retour = -1;
		if($ent instanceof Support){
			$req = $this->db->prepare("DELETE FROM support WHERE sup_id = :supId");
			$req->bindValue(':supId', $ent->getSupId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierSupport($ent) {
		// Modifie un support de la base de données
		$retour = -1;
		if($ent instanceof Support){
			$req = $this->db->prepare("UPDATE support SET sup_sujet = :supSujet, sup_message = :supMessage, sup_nom = :supNom, sup_mail = :supMail WHERE sup_id = :supId;");
			$req->bindValue(':supSujet', $ent->getSupSujet());
			$req->bindValue(':supMessage', $ent->getSupMessage());
			$req->bindValue(':supNom', $ent->getSupNom());
			$req->bindValue(':supMail', $ent->getSupMail());
			$req->bindValue(':supId', $ent->getSupId());

			$retour = $req->execute();		
		}
		return $retour;
	}
}