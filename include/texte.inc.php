<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="texte">
<?php

	if (!empty($_GET["page"])){
		$page=$_GET["page"];
	} else {
		$page="accueil";
	}

	# Redirection des lien vers les pages correspondantes
	switch ($page) {

		case "accueil":
			include_once('pages/accueil.inc.php');
			break;
		
		case "declarationconfidentialite":
			include_once('pages/declarationconfidentialite.inc.php');
			break;

		case "conditionsutilisation":
			include_once('pages/conditionsutilisation.inc.php');
			break;

		case "chosemeteo":
			include_once('pages/chosemeteo.inc.php');
			break;

		case "meteo":
			include_once('pages/meteo.inc.php');
			break;
		
		case "produit-conseille":
		case "nos-produits":
		case "nouveaux-produits":
		case "edition-limitee":
			include("pages/produit.inc.php");
			break;

		case "commande":
			include_once('pages/commande.inc.php');
			break;

		case "contact":
			include_once('pages/contact.inc.php');
			break;

		case "connexion":
		case "inscription":
			include("pages/connexion.inc.php");
			break;
			
		case "client-commande":
		case "client-commande-enattente":
		case "client-commande-encours":
		case "client-commande-termine":
		case "client-commande-annuler":
		case "client-information":
			include("pages/espaceClient.inc.php");
			break;

		case "annulation-commande":
			include("pages/annulation.inc.php");
		break;
			
		case "client-deconnexion":
			include("pages/logout.inc.php");
			break;

		case "admin-client":
		case "admin-produit":
		case "admin-type":
		case "admin-commande":
		case "admin-commande-enattente":
		case "admin-commande-encours":
		case "admin-commande-termine":
		case "admin-commande-annuler":
		case "admin-support":
			include("pages/admin.inc.php");
			break;

		case "admin-modif-produit":
		case "admin-modif-type":
		case "admin-nv-produit":
		case "admin-nv-type":
			include("pages/adminModif.inc.php");
			break;

		case "admin-nv-produit-exe":
		case "admin-nv-type-exe":
		case "admin-modif-produit-exe":
		case "admin-modif-type-exe":
			include("pages/adminModifexe.inc.php");
			break;
			
		default : 	include_once('pages/accueil.inc.php');
	}
	
?>
</div>
