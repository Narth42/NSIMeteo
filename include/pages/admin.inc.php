<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
    # Si la session n'est pas définie ou que l'adresse mail de la session n'est pas celle de l'admin, on redirige vers la page d'accueil
    if (!isset($_SESSION['client']) OR $_SESSION['client']->getCliMail() != 'admin@nsimeteo.fr') {
        header("Location: index.php?page=accueil");
    }
?>

<!-- Affiche le menu administrateur -->
<div class="admin">
    <nav class="admin-menu">
        <li><a href="index.php?page=admin-client"><p>CLIENTS</p></a></li>
		<li><a href="index.php?page=admin-commande"><p>COMMANDES</p></a></li>
		<li><a href="index.php?page=admin-support"><p>SUPPORT</p></a></li>
		<li><a href="index.php?page=admin-produit"><p>PRODUITS</p></a></li>
		<li><a href="index.php?page=admin-type"><p>TYPES</p></a></li>
    </nav>
    <hr class=grande-ligne>

<?php

    $pdo = new Mypdo();
    $clientManager = new ClientManager($pdo);
    $produitManager = new ProduitManager($pdo);
    $typeManager = new TypeManager($pdo);
    $commandeManager = new CommandeManager($pdo);
    $supportManager = new SupportManager($pdo);

        # Si la page est admin-client, on affiche la liste des clients
        if ($_GET["page"] == "admin-client") {

            $clients = $clientManager->listerClient();

            # nombre de clients
            echo ('<h2>Nombre de clients : '. $clientManager->getNbClient() .'</h2>
            <hr class=ligne>');

            # liste des clients
            foreach ($clients as $client) {
                # Affiche les informations du client
                echo ('<div class="admin-client">
                        <table class="tableau">
                            <tr>  
                                <th class="partie-tableau-id">ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Adresse courriel</th>
                                <th class="partie-tableau-tel">Téléphone</th>
                                <th>Adresse</th>
                            </tr>
                            <tr>
                                <td class="partie-tableau-id">' . $client->getCliId() . '</td>
                                <td>' . $client->getCliNom() . '</td>
                                <td>' . $client->getCliPrenom() . '</td>
                                <td>' . $client->getCliMail() . '</td>
                                <td class="partie-tableau-tel">' . $client->getCliTel() . '</td>
                                <td>' . $client->getCliAdresse() . '</td>
                            </tr>
                        </table>');

                # Si l'adresse mail du client n'est pas celle de l'admin, on affiche le bouton "Se Connecter" et "Supprimer"
                if ($client->getCliMail() != "admin@nsimeteo.fr"){
                    echo('<form class="info-client-form" action="index.php?page=admin-client" method="post">
                            <input type="hidden" name="cli-id" value="' . $client->getCliId() . '">
                            <input class="formbouton" type="submit" name="supprimer" id="supprimer" value="Supprimer">
                        </form>');
                }

                echo('</div>
                    <hr class=ligne>');

            }
            
            # Si l'admin clique sur le bouton "Supprimer"
            if (isset($_POST['supprimer'])) {
                # Supprime le client
                $cli_id = $_POST['cli-id'];
                $cliSupr = new Client($clientManager->getClientWithId($cli_id));
                $clientManager->supprimerClient($cliSupr);?>
        	    <script type="text/javascript">
				    self.setTimeout("self.location.href = 'index.php?page=admin-client';", 150);
           	    </script>
                <?php
            }
        
        # Si la page est admin-commande, on affiche la liste des commandes
        } elseif ($_GET["page"] == "admin-commande" or $_GET["page"] == "admin-commande-enattente" or $_GET["page"] == "admin-commande-encours" or $_GET["page"] == "admin-commande-termine" or $_GET["page"] == "admin-commande-annuler") {
                if (empty($_GET['id'])) {
                    $commandes = $commandeManager->listerCommande();
    
                    # Affiche des bouton pour filtrer les commandes
                    echo ('<ul class="liste-label-commande">
                            <li><a href="index.php?page=admin-commande-enattente"><p class=orange>En attente</p></a></li>
                            <li><a href="index.php?page=admin-commande-encours"><p class=bleu>En cours</p></a></li>
                            <li><a href="index.php?page=admin-commande-termine"><p class=vert>Terminé</p></a></li>
                            <li><a href="index.php?page=admin-commande-annuler"><p class=rouge>Annulé</p></a></li>
                        </ul>
                        <h2>Nombre de commandes : '. $commandeManager->getNbCommande() .'</h2>
                        <hr class=ligne>');
                    
                    # liste des commandes
                    foreach ($commandes as $commande) {
    
                        # Affiche les commandes en fonction  de leur état
                        if(($_GET["page"] == "admin-commande") or ($_GET["page"] == "admin-commande-enattente" and $commande->getCommEtat() == "En attente") or ($_GET["page"] == "admin-commande-encours" and $commande->getCommEtat() == "En cours") or ($_GET["page"] == "admin-commande-termine" and $commande->getCommEtat() == "Terminé") or ($_GET["page"] == "admin-commande-annuler" and $commande->getCommEtat() == "Annulé")){
    
                            # Récupère les informations de la commande
                            $date = $commande->getCommDate();
                            $quantite = $commande->getCommQuantite();
                            $id_client = $commande->getCommClient();
                            $id_produit = $commande->getCommProduit();
                            $etat = $commande->getCommEtat();

                            # Récupère les informations du produit
                            $produit = new Produit($produitManager->getProduitWithId($id_produit));
                            $type = $produit->getProdType();
                            $name = $produit->getProdNom();
                            $desc = $produit->getProdDesc();
                            $img = $produit->getProdImg();
                            $prix = $produit->getProdPrix();
                            $provenance = $produit->getProdProvenance();

                            # Récupère les informations du client
                            $client = new Client($clientManager->getClientWithId($id_client));
                            $nom = $client->getCliNom();
                            $prenom = $client->getCliPrenom();
                            $mail = $client->getCliMail();
                            $adresse = $client->getCliAdresse();
                            $tel = $client->getCliTel();

                            # Affiche les informations de la commande
                            echo('<div class="liste-produit">
                                    <img src="' . $img . '" width="500" height="400"/>
                                    <div class="info-produit">
                                        <h2>' . $name . ' x' . $quantite . '</h2>
                                        <p class="desc">' . $desc . '</p>
                                        <hr>
                                        <ul class="liste-info-produit">
                                            <li><p class=gras>ID produit:</p> ' . $id_produit . '</li>
                                            <li><p class=gras>Prix Totale:</p> ' . $prix * $quantite. '€</li>
                                            <li><p class=gras>Quantité:</p> ' . $quantite . '</li>
                                            <li><p class=gras>Date de commande:</p> ' . $date . '</li>
                                        </ul>
                                        <hr>
                                        <ul class="liste-info-produit">
                                            <li><p class=gras>ID client:</p> ' . $id_client . '</li>
                                            <li><p class=gras>Nom:</p> ' . $nom . '</li>
                                            <li><p class=gras>Prenom:</p> ' . $prenom . '</li>
                                            <li><p class=gras>Numéros de téléphone:</p> ' . $tel . '</li>
                                        </ul>
                                        <hr>
                                        <ul class="liste-label-produit">');
                            
                            # Affiche l'état de la commande   
                            if ($etat == 'En attente') {
                                echo('<li><p class=orange>' . $etat . '</p></li>');
                            } if ($etat == 'En cours') {
                                echo('<li><p class=bleu>' . $etat . '</p></li>');
                            } if ($etat == 'Terminé') {
                                echo('<li><p class=vert>' . $etat . '</p></li>');
                            } if ($etat == 'Annulé') {
                                echo('<li><p class=rouge>' . $etat . '</p></li>');
                            }
                            # Affiche les boutons pour modifier l'état de la commande ou la supprimer
                            echo('  </ul>
    
                                    <form action="index.php?page=admin-commande" method="post">
                                        <input type="hidden" name="comm-id" value="' . $commande->getCommId() . '">
                                        <input type="submit" name="enattente" id="enattente" value="En attente" class="bouton">
                                        <input type="submit" name="encours" id="encours" value="En cours" class="bouton">
                                        <input type="submit" name="termine" id="termine" value="Terminé" class="bouton">
                                        <input type="submit" name="annule" id="annule" value="Annulé" class="bouton">
                                        <input type="submit" name="supprimer" id="supprimer" value="Supprimer" class="bouton">
                                    </form>
                                </div>
                            </div>
                
                            <hr class=ligne>');
                        
                        }
                    }
                
                # Si l'utilisateur clique sur le bouton "Supprimer"
                if (isset($_POST['supprimer'])) {
                    # Récupère l'id de la commande et supprime la commande
                    $comm_id = $_POST['comm-id'];
                    $commSupr = new Commande($commandeManager->getCommandeWithId($comm_id));
                    $commandeManager->supprimerCommande($commSupr);?>
                    <script type="text/javascript">
                        self.setTimeout("self.location.href = 'index.php?page=admin-commande';", 150);
                       </script>
                    <?php
                
                # Si l'utilisateur clique sur le bouton "En attente"
                } elseif (isset($_POST['enattente'])) {
                    # Récupère l'id de la commande et modifie l'état de la commande
                    $comm_id = $_POST['comm-id'];
                    $commEnAttente = new Commande($commandeManager->getCommandeWithId($comm_id));
                    $commEnAttente->setCommEtat('En attente');
                    $commandeManager->modifierCommande($commEnAttente);?>
                    <script type="text/javascript">
                        self.setTimeout("self.location.href = 'index.php?page=admin-commande';", 150);
                       </script>
                    <?php

                # Si l'utilisateur clique sur le bouton "En cours"
                } elseif (isset($_POST['encours'])) {
                    # Récupère l'id de la commande et modifie l'état de la commande
                    $comm_id = $_POST['comm-id'];
                    $commEnCours = new Commande($commandeManager->getCommandeWithId($comm_id));
                    $commEnCours->setCommEtat('En cours');
                    $commandeManager->modifierCommande($commEnCours);?>
                    <script type="text/javascript">
                        self.setTimeout("self.location.href = 'index.php?page=admin-commande';", 150);
                       </script>
                    <?php

                # Si l'utilisateur clique sur le bouton "Terminé"
                } elseif (isset($_POST['termine'])) {
                    # Récupère l'id de la commande et modifie l'état de la commande
                    $comm_id = $_POST['comm-id'];
                    $commTermine = new Commande($commandeManager->getCommandeWithId($comm_id));
                    $commTermine->setCommEtat('Terminé');
                    $commandeManager->modifierCommande($commTermine);?>
                    <script type="text/javascript">
                        self.setTimeout("self.location.href = 'index.php?page=admin-commande';", 150);
                       </script>
                    <?php

                # Si l'utilisateur clique sur le bouton "Annulé"
                } elseif (isset($_POST['annule'])) {
                    # Récupère l'id de la commande et modifie l'état de la commande
                    $comm_id = $_POST['comm-id'];
                    $commAnnule = new Commande($commandeManager->getCommandeWithId($comm_id));
                    $commAnnule->setCommEtat('Annulé');
                    $commandeManager->modifierCommande($commAnnule);?>
                    <script type="text/javascript">
                        self.setTimeout("self.location.href = 'index.php?page=admin-commande';", 150);
                    </script>
                    <?php
                }
            }
        
        # Si la page est la page admin-support, on affiche la liste des demandes
        } elseif ($_GET["page"] == "admin-support") {

            $supports = $supportManager->listerSupport();

            # Affiche le nombre de demandes
            echo ('<h2>Nombre de supports : '. $supportManager->getNbSupport() .'</h2>
            <hr class=ligne>');

            # Affiche les demandes
            foreach ($supports as $support) {

                # Récupère les informations de la demande
                $name = $support->getSupNom();
                $mail = $support->getSupMail();
                $objet = $support->getSupSujet();
                $message = $support->getSupMessage();

                # Affiche les informations de la demande
                echo('<div class="contact">
                    <form class="contact-form" action="index.php?page=admin-support" method="post">
                        <div class="form-group">
                            <input class="champ-contact" type="text" name="nom" id="nom" value="' . $name . '" disabled>
                            <input class="champ-contact" type="email" name="mail" id="mail" value="' . $mail . '" disabled>
                            <input class="champ-contact" type="text" name="objet" id="objet" value="' . $objet . '" disabled>
                        </div>
                        <div class="form-group">
                            <textarea class="champ-contact" name="message" id="message" placeholder="' . $message . '" disabled></textarea>
                        </div>
                        <input type="hidden" name="sup-id" value="' . $support->getSupId() . '">
                        <input class="formbouton" type="submit" name="supprimer" id="supprimer" value="Supprimer">
                    </form>
                </div>
                <hr class=ligne>');

                # Si l'utilisateur clique sur le bouton "Supprimer"
                if (isset($_POST['supprimer'])) {
                    # Récupère l'id de la demande et supprime la demande
                    $support_id = $_POST['sup-id'];
                    $supportSupr = new Support($supportManager->getSupportWithId($support_id));
                    $supportManager->supprimerSupport($supportSupr);
                }

            }

        # Si la page est la page admin-produit, on affiche la liste des produits
        } elseif ($_GET["page"] == "admin-produit") {

                $produits = $produitManager->listerProduit();
    
                # Affiche le nombre de produits et le bouton "Nouveau"
                echo ('<form class="admin-ajout-form" action="index.php?page=admin-nv-produit" method="post">
                        <input class="formbouton" type="submit" name="ajouter" id="ajouter" value="Nouveau">
                        </form>
                        <h2>Nombre de produits : '. $produitManager->getNbProduit() .'</h2>
                        <hr class=ligne>');

                # Liste les produits
                foreach ($produits as $produit) {
                    
                    # Récupère les informations du produit
                    $name = $produit->getProdNom();
                    $prix = $produit->getProdPrix();
                    $provenance = $produit->getProdProvenance();
                    $stock = $produit->getProdStock();
                    $img = $produit->getProdImg();
                    $desc = $produit->getProdDesc();
                    $nouveau = $produit->getProdNouveau();
                    $special = $produit->getProdSpecial(); 
                    
                    # Affiche les informations du produit
                    echo('<div class="liste-produit">
                            <img src="' . $img . '" width="500" height="400"/>
                            <div class="info-produit">
                                <h2>' . $name . '</h2>
                                <p class="desc">' . $desc . '</p>
                                <hr>
                                <ul class="liste-info-produit">
                                    <li><p class=gras>Prix:</p> ' . $prix . '€</li>
                                    <li><p class=gras>Provenance:</p> ' . $provenance . '</li>
                                    <li><p class=gras>Stock:</p> ' . $stock . '</li>
                                </ul>
                                <hr>
                                <ul class="liste-label-produit">');
                    
                    # Affiche les labels du produit
                    if($nouveau == 1) {
                        echo('<li><p class="label-nouveau-produit">Nouveau</p></li>');
                    }
                    if($special == 1) {
                        echo('<li><p class="label-editionlimitee-produit">Edition Limitée</p></li>');
                    }
                    if($stock == 0) {
                        echo('<li><p class="label-rupture-produit">Rupture de Stock</p></li>');
                    }

                    # Affiche le bouton "Modifier"
                    echo('      </ul>
                            <form action="index.php?page=admin-modif-produit" method="post">
                                <input type="hidden" name="prod-id" id="prod-id" value="' . $produit->getProdId() . '">
                                <input class="formbouton" type="submit" name="modifier" id="modifier" value="Modifier">
                            </form>
                        </div>
                    </div>
    
                    <hr class=ligne>');
                }
        # Si la page est la page admin-type, on affiche la liste des types
        } elseif ($_GET["page"] == "admin-type") {
            
            $types = $typeManager->listerType();

            # Affiche le nombre de types et le bouton "Nouveau"
            echo ('<form class="admin-ajout-form" action="index.php?page=admin-nv-type" method="post">
                    <input class="formbouton" type="submit" name="ajouter" id="ajouter" value="Nouveau">
                    </form>
            
                    <h2>Nombre de types : '. $typeManager->getNbType() .'</h2>
                    <hr class=ligne>');

            # Liste les types
            foreach ($types as $type) {

                # Récupère les informations du type
                $name = $type->getTypeNom();
                $desc = $type->getTypeDesc();
                $img = $type->getTypeImg();

                # Affiche les informations du type
                echo ('<div class="liste-type">
                        <img src="' . $img . '" width="500" height="400"/>
                        <div class="info-type">
                            <h2>' . $name . '</h2>
                            <p class="desc">' . $desc . '</p>
                            <hr>
                            <form action="index.php?page=admin-modif-type" method="post">
                                <input type="hidden" name="type-id" id="type-id" value="' . $type->getTypeId() . '">
                                <input class="formbouton" type="submit" name="modifier" id="modifier" value="Modifier">
                            </form>
                        </div>
                    </div>
                    <hr class=ligne>');
            }
    
        }

?>

</div>