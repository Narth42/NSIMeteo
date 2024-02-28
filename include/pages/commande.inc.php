<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="commande">
    <?php
        $pdo=new Mypdo();
        $commandeManager = new CommandeManager($pdo);
        $produitManager = new ProduitManager($pdo);

        # Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion
        if (!isset($_SESSION['client'])) {
            header("Location: index.php?page=connexion");
        } else {
            
            # récupération des données du formulaire
            $id_client = $_SESSION['client']->getCliId();
            $id_produit = $_POST['prod-id'];
            $quantite = $_POST['prod-quantite'];
            $date = date("Y-m-d");

            # vérification de la quantité
            if ($quantite <= 0) {
                $quantite = 1;
            }

            # création de la commande
            $commande = new Commande(array('comm_date'=> $date,
            'comm_quantite'=> $quantite,
            'cli_id'=> $id_client,
            'prod_id'=> $id_produit,
            'comm_etat'=> 'En attente'));

            $produit = new Produit($produitManager->getProduitWithId($id_produit));
            $produit->setProdStock($produit->getProdStock() - $quantite);

            # Message de confirmation
            echo('<h1>Confirmation de commande</h1>
                <hr class="ligne">
                <p>Nous sommes heureux de vous informer que votre commande a bien été enregistrée. Votre achat de ' . $quantite . ' ' . $produit->getProdNom() . ', d\'une valeur de ' . $produit->getProdPrix() * $quantite . '€, a été validé avec succès. Vous pouvez suivre l\'avancement de votre commande en vous connectant à votre compte client. Si vous avez des questions ou des préoccupations, n\'hésitez pas à nous contacter via la rubrique "Contact" de notre site web. Nous vous remercions pour votre achat et espérons que vous apprécierez votre produit.</p>
                <hr class="ligne">
                <form action="index.php?page=client-commande" method="post">
                    <input type="submit" value="Mes Commandes" class="bouton">
                </form>');

            # Mise à jour de la base de données
            $produitManager->modifierProduit($produit);
            $commandeManager->ajouterCommande($commande);
        }
    ?>
</div>