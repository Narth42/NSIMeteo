<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php
    # Si la session n'est pas ouverte, on redirige vers la page de connexion
    if (!isset($_SESSION['client'])) {
        header("Location: index.php?page=connexion");
    }
?>

<div class="esp-client">
    <!-- Menu de navigation -->
    <nav class="esp-client-menu">
        <li><a href="index.php?page=client-information"><p>MES INFORMATIONS</p></a></li>
		<li><a href="index.php?page=client-commande"><p>MES COMMANDES</p></a></li>
		<li><a href="index.php?page=client-deconnexion"><p>DECONEXION</p></a></li>
    </nav>
    
    <hr class="grande-ligne">

    <?php
		$pdo=new Mypdo();
        $commandeManager = new CommandeManager($pdo);
        $produitManager = new ProduitManager($pdo);
        $clientManager = new ClientManager($pdo);
        
        # Si l'utilisateur a cliqué sur mes commandes
        if ($_GET["page"] == "client-commande" or $_GET["page"] == "client-commande-enattente" or $_GET["page"] == "client-commande-encours" or $_GET["page"] == "client-commande-termine" or $_GET["page"] == "client-commande-annuler"){
            if (empty($_GET['id'])) {
                $commandes = $commandeManager->listerCommande();

                # Affichage les différents états de commandes
                echo ('<ul class="liste-label-commande">
                        <li><a href="index.php?page=client-commande-enattente"><p class=orange>En attente</p></a></li>
                        <li><a href="index.php?page=client-commande-encours"><p class=bleu>En cours</p></a></li>
                        <li><a href="index.php?page=client-commande-termine"><p class=vert>Terminé</p></a></li>
                        <li><a href="index.php?page=client-commande-annuler"><p class=rouge>Annulé</p></a></li>
                    </ul>
                    <hr class=ligne>');

                foreach ($commandes as $commande) {
                    # Affichage des commandes en fonction de l'état
                    if(($_GET["page"] == "client-commande") or ($_GET["page"] == "client-commande-enattente" and $commande->getCommEtat() == "En attente") or ($_GET["page"] == "client-commande-encours" and $commande->getCommEtat() == "En cours") or ($_GET["page"] == "client-commande-termine" and $commande->getCommEtat() == "Terminé") or ($_GET["page"] == "client-commande-annuler" and $commande->getCommEtat() == "Annulé")){

                        # Récupération des informations de la commande
                        $date = $commande->getCommDate();
                        $quantite = $commande->getCommQuantite();
                        $id_client = $commande->getCommClient();
                        $id_produit = $commande->getCommProduit();
                        $etat = $commande->getCommEtat();
                        
                        # Si l'id du client correspond à l'id du client connecté
                        if($_SESSION['client']->getCliId() == $id_client){

                            # Récupération des informations du produit
                            $produit = new Produit($produitManager->getProduitWithId($id_produit));
                            $type = $produit->getProdType();
                            $name = $produit->getProdNom();
                            $desc = $produit->getProdDesc();
                            $img = $produit->getProdImg();
                            $prix = $produit->getProdPrix();
                            $provenance = $produit->getProdProvenance();

                            # Affichage des informations de la commande
                            echo('<div class="liste-produit">
                                    <img src="' . $img . '" width="500" height="400"/>
                                    <div class="info-produit">
                                        <h2>' . $name . ' x' . $quantite . '</h2>
                                        <p class="desc">' . $desc . '</p>
                                        <hr>
                                        <ul class="liste-info-produit">
                                            <li><p class=gras>Prix Totale:</p> ' . $prix * $quantite. '€</li>
                                            <li><p class=gras>Quantité:</p> ' . $quantite . '</li>
                                            <li><p class=gras>Provenance:</p> ' . $provenance . '</li>
                                            <li><p class=gras>Date de commande:</p> ' . $date . '</li>
                                        </ul>
                                        <hr>
                                        <ul class="liste-label-produit">');
                            
                            # Affichage des états de la commande
                            if ($etat == 'En attente') {
                                echo('<li><p class=orange>' . $etat . '</p></li>');
                            } if ($etat == 'En cours') {
                                echo('<li><p class=bleu>' . $etat . '</p></li>');
                            } if ($etat == 'Terminé') {
                                echo('<li><p class=vert>' . $etat . '</p></li>');
                            } if ($etat == 'Annulé') {
                                echo('<li><p class=rouge>' . $etat . '</p></li>
                                        </ul>
                                    </div>
                                </div>
                                <hr class=ligne>');
                            } else {
                                echo('</ul>
                                        <form action="index.php?page=annulation-commande" method="post">
                                            <input type="hidden" name="comm-id" value="' . $commande->getCommId() . '">
                                            <input type="submit" value="Annuler" class="bouton">
                                        </form>
                                    </div>
                                </div>
                
                                <hr class=ligne>');
                            }
                        }
                    }
                }
            }
        
        # Si l'utilisateur a cliqué sur mes informations
        } elseif($_GET["page"] == "client-information") {
            # Affichage des informations du client avec un formulaire pour les modifier
            echo ('<div class="info-client">
                    <form class="info-client-form" action="index.php?page=client-information" method="post">
                        <p>Informations personnelles :</p>
                        <div class="form-group">
                            <input class="champ-mondification" type="text" name="nom" id="nom" placeholder="Nom" value="' . $_SESSION['client']->getCliNom() . '" maxlength="30">
                            <input class="champ-mondification" type="text" name="prenom" id="prenom" placeholder="Prenom" value="' . $_SESSION['client']->getCliPrenom() . '" maxlength="30">
                            <input class="champ-mondification" type="number" name="tel" id="tel" placeholder="Numéro de téléphone" value="' . $_SESSION['client']->getCliTel() . '" maxlength="12">
                        </div>
                        
                        <div class="form-group">
                            <input class="champ-mondification" type="email" name="mail" id="mail" value="' . $_SESSION['client']->getCliMail() . '" disabled>
                            <input class="champ-mondification" type="text" name="adresse" id="adresse" placeholder="Adresse"value="' . $_SESSION['client']->getCliAdresse() . '" maxlength="255">
                        </div>
                        
                        <p>Sécurité du compte :</p>
                        <div class="form-group">
                        <input class="champ-mondification" type="password" name="mdp" id="mdp" placeholder="Mot de passe*" required maxlength="50">
                            <input class="champ-mondification" type="password" name="nv-mdp" id="nv-mdp" placeholder="Nouveau mot de passe" maxlength="50">
                            <input class="champ-mondification" type="password" name="nv-mdpConfirme" id="nv-mdpConfirme" placeholder="Confirmer le nouveau mot de passe"maxlength="50">
                        </div>
                        <input class="formbouton" type="submit" name="formsend" id="formsend" value="Modifier">
                        <input class="formbouton" type="reset" name="reset" id="reset" value="Réinitialiser">
                        <input class="formbouton" type="submit" name="delete" id="delete" value="Supprimer">
                    </form>
            ');

            # Si l'utilisateur a cliqué sur le bouton modifier
            if (isset($_POST['formsend'])) {

                # Options pour le hashage du mot de passe
                $options = [
                    'cost' => 12,
                ];
                
                # Récupération des données du formulaire
                $cli_nom = $_POST['nom'];
                $cli_prenom = $_POST['prenom'];
                $cli_tel = $_POST['tel'];
                $cli_adresse = $_POST['adresse'];
                $cli_mdp = $_POST['mdp'];
                $cli_nvmdp = $_POST['nv-mdp'];
                $cli_mdpConfirme = $_POST['nv-mdpConfirme'];
                $cli_mail = $_SESSION['client']->getCliMail();
                $cli_id = $_SESSION['client']->getCliId();

                # Vérification du mot de passe
                if(password_verify($cli_mdp, $_SESSION['client']->getCliMdp())){
                    
                    # Vérifi que les deux mots de passe sont identiques
                    if ($cli_nvmdp == $cli_mdpConfirme) {
                        if ($cli_nom == null) {
                            $cli_nom = $_SESSION['client']->getCliNom();
                        } if ($cli_prenom == null) {
                            $cli_prenom = $_SESSION['client']->getCliPrenom();
                        } if ($cli_tel == null) {
                            $cli_tel = $_SESSION['client']->getCliTel();
                        } if ($cli_adresse == null) {
                            $cli_adresse = $_SESSION['client']->getCliAdresse();
                        } if ($cli_mdp == null) {
                            $cli_mdp = $_SESSION['client']->getCliMdp();
                        } if ($cli_nvmdp == null) {
                            $cli_nvmdp = $_SESSION['client']->getCliMdp();
                        } else {
                            $cli_nvmdp = password_hash($cli_nvmdp, PASSWORD_BCRYPT, $options);
                        }

                        # modification des données du client
                        $_SESSION['client'] = new Client(array('cli_id' => $cli_id,
                        'cli_nom'=> $cli_nom,
                        'cli_prenom'=> $cli_prenom,
                        'cli_adresse'=> $cli_adresse,
                        'cli_mail'=> $cli_mail,
                        'cli_tel'=> $cli_tel,
                        'cli_mdp'=> $cli_nvmdp));

                        $client = $_SESSION['client'];
                    
                        $clientManager->modifierClient($client);?>

                        <!-- Rafraichissement de la page -->
                        <script type="text/javascript">
                            self.setTimeout("self.location.href = 'index.php?page=client-information';", 150);
                        </script>

                        <?php echo ('<p class="modif-succes">Modifications effectuées avec succès !</p>');

                    }else{
                        echo ('<p class="erreur-mdp">Les nouveaux mots de passe ne correspondent pas !</p>');
                    }

                } else {
                    echo ('<p class="erreur-mdp">Mot de passe incorrect !</p>');
                }
            } elseif (isset($_POST['delete'])) {
                # Si l'utilisateur a cliqué sur le bouton supprimer
                $clientManager->supprimerClient($_SESSION['client']);
                session_destroy();
                header('Location: index.php?page=accueil');
            }
            echo ('</div>');
        }
    ?>
</div>
