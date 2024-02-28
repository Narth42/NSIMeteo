<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class CommandeManager{
	
	private $db; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterCommande($commande) {
		// Ajout d'une commande dans la base de données
		$retour = -1;
		if($commande instanceof Commande){
			$req = $this->db->prepare('INSERT INTO commande (comm_date, comm_quantite, cli_id, prod_id, comm_etat)
										VALUES (:commDate, :commQuantite, :commCli, :commProd, :commEtat);');
			$req->bindValue(':commDate', $commande->getCommDate());
			$req->bindValue(':commQuantite', $commande->getCommQuantite());
			$req->bindValue(':commCli', $commande->getCommClient());
			$req->bindValue(':commProd', $commande->getCommProduit());
			$req->bindValue(':commEtat', $commande->getCommEtat());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function listerCommande(){
		// liste de toutes les commandes
		$listeCommande = array();
		$sql = 'SELECT * FROM commande';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($commande=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeCommande[]=new Commande($commande);
		}
		$requete->closeCursor();
		return $listeCommande ;
	}
	
	public function getNbCommande() {
		// Récupère le nombre de commande
		$sql = "SELECT COUNT(DISTINCT comm_id) AS nbCommande FROM commande";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbCommande = $valeur;
		}
		$requete->closeCursor();
		return $nbCommande;
	}
	public function getIdCommandeWithOther($commande){
		// Récupère l'id de la commande avec les autres paramètres
		$sql = "SELECT comm_id FROM commande WHERE comm_date = :commDate 
											   And comm_quantite = :commQuantite
											   AND cli_id = :commCli 
											   AND prod_id = :commProd
											   AND comm_etat = :commEtat";

		$req = $this->db->prepare($sql);
		$req->bindValue(':commDate', $commande->getCommDate());
		$req->bindValue(':commQuantite', $commande->getCommQuantite());
		$req->bindValue(':commCli', $commande->getCommClient());
		$req->bindValue(':commProd', $commande->getCommProduit());
		$req->bindValue(':commEtat', $commande->getCommEtat());
		
		$req->execute();
		
		$commande=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $commande['comm_id'] ;
	}

	public function getCommandeWithId($id){
		// Récupère les autres paramètres de la commande avec l'id
		$sql = "SELECT * FROM commande WHERE comm_id = :commId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':commId', $id);
		$req->execute();
		
		$commande=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $commande ;
	}
	
	public function supprimerCommande($commande) {
		// Supprime une commande de la base de données
		$retour = -1;
		if($commande instanceof Commande){
			$req = $this->db->prepare("DELETE FROM commande WHERE comm_id = :commId");
			$req->bindValue(':commId', $commande->getCommId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierCommande($commande) {
		// Modifie une commande de la base de données
		$retour = -1;
		if($commande instanceof Commande){
			$req = $this->db->prepare("UPDATE commande SET comm_date = :commDate, comm_quantite = :commQuantite, cli_id = :commCli, prod_id = :commProd, comm_etat = :commEtat WHERE comm_id = :commId;");
			$req->bindValue(':commDate', $commande->getCommDate());
			$req->bindValue(':commQuantite', $commande->getCommQuantite());
			$req->bindValue(':commCli', $commande->getCommClient());
			$req->bindValue(':commProd', $commande->getCommProduit());
			$req->bindValue(':commEtat', $commande->getCommEtat());
			$req->bindValue(':commId', $commande->getCommId());

			$retour = $req->execute();		
		}
		return $retour;
	}
}