<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
class ClientManager{
	
	private $db; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterClient($client) {
		// Ajout d'un client dans la base de données
		$retour = -1;
		if($client instanceof Client){
			$req = $this->db->prepare('INSERT INTO client (cli_nom, cli_prenom, cli_adresse, cli_mail, cli_tel, cli_mdp)
										VALUES (:cliNom, :cliPrenom, :cliAdresse, :cliMail, :cliTel, :cliMdp);');
			$req->bindValue(':cliNom', $client->getCliNom());
			$req->bindValue(':cliPrenom', $client->getCliPrenom());
			$req->bindValue(':cliAdresse', $client->getCliAdresse());			
			$req->bindValue(':cliMail', $client->getCliMail());
			$req->bindValue(':cliTel', $client->getCliTel());
			$req->bindValue(':cliMdp', $client->getCliMdp());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantClient($client){
		// Vérifie si un client existe déjà dans la base de données
		$sql = 'SELECT cli_mail FROM client WHERE cli_mail=:cliMail';
		$req = $this->db->prepare($sql);
		$req->bindValue(':cliMail', $client->getCliMail());
		$req->execute();
		
		$clientExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $clientExist[0] ;
	}
	
	public function listerClient(){
		// Liste tous les clients de la base de données
		$listeClient = array();
		$sql = 'SELECT * FROM client';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($client=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeClient[]=new Client($client);
		}
		$requete->closeCursor();
		return $listeClient ;
	}
	
	public function getNbClient() {
		// Récupère le nombre de clients dans la base de données
		$sql = "SELECT COUNT(DISTINCT cli_id) AS nbClient FROM client";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbClient = $valeur;
		}
		$requete->closeCursor();
		return $nbClient;
	}
	public function getIdClientWithOther($client){
		// Récupère l'id d'un client à partir de ses autres informations
		$sql = "SELECT cli_id FROM client WHERE cli_nom = :cliNom 
											   AND cli_prenom = :cliPrenom 
											   AND cli_tel = :cliTel
											   AND cli_mail = :cliMail
											   AND cli_mdp = :cliMdp";

		$req = $this->db->prepare($sql);
		$req->bindValue(':cliNom', $client->getCliNom());
		$req->bindValue(':cliPrenom', $client->getCliPrenom());
		$req->bindValue(':cliTel', $client->getCliTel());
		$req->bindValue(':cliMail', $client->getCliMail());
		$req->bindValue(':cliMdp', $client->getCliMdp());
		
		$req->execute();
		
		$client=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $client['cli_id'] ;
	}

	public function getClientWithId($id){
		// Récupère un client à partir de son id
		$sql = "SELECT * FROM client WHERE cli_id = :cliId";
		$req = $this->db->prepare($sql);
		$req->bindValue(':cliId', $id);
		$req->execute();
		
		$client=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $client ;
	}
	
	public function supprimerClient($client) {
		// Supprime un client de la base de données
		$retour = -1;
		if($client instanceof Client){
			$req = $this->db->prepare("DELETE FROM client WHERE cli_id = :cliId");
			$req->bindValue(':cliId', $client->getCliId());
			$retour = $req->execute();
		}
		return $retour;
	}
	
	
	public function modifierClient($client) {
		// Modifie un client de la base de données
		$retour = -1;
		if($client instanceof Client){
			$req = $this->db->prepare("UPDATE client SET cli_nom = :cliNom, cli_prenom = :cliPrenom, cli_adresse = :cliAdresse, cli_mail = :cliMail, cli_tel = :cliTel, cli_mdp = :cliMdp WHERE cli_id = :cliId;");
			$req->bindValue(':cliNom', $client->getCliNom());
			$req->bindValue(':cliPrenom', $client->getCliPrenom());
			$req->bindValue(':cliAdresse', $client->getCliAdresse());			
			$req->bindValue(':cliMail', $client->getCliMail());
			$req->bindValue(':cliTel', $client->getCliTel());
			$req->bindValue(':cliMdp', $client->getCliMdp());
			$req->bindValue(':cliId', $client->getCliId());
			

			$retour = $req->execute();		
		}
		return $retour;
	}
}