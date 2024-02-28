<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
    # Si le formulaire n'a pas été envoyé on redirige l'utilisateur vers la page d'accueil
    if (!isset($_POST['comm-id'])) {
        header("Location: index.php?page=accueil");
    }

    $id_commande = $_POST['comm-id'];
    
    $pdo=new Mypdo();
    $commandeManager = new CommandeManager($pdo);
    $produitManager = new ProduitManager($pdo);
    
    # On modifie l'état de la commande à "Annulé"
    $commande = new Commande($commandeManager->getCommandeWithId($id_commande));
    $commande->setCommEtat("Annulé");

    # On remet le stock du produit annulé
    $produit = new Produit($produitManager->getProduitWithId($commande->getCommProduit()));
    $produit->setProdStock($produit->getProdStock() + $commande->getCommQuantite());
    
    $commandeManager->modifierCommande($commande);
    $produitManager->modifierProduit($produit);

    # On redirige l'utilisateur vers la page client-commande
    header("Location: index.php?page=client-commande");
?>