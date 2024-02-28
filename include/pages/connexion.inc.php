<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<form class="connexion" action=<?php echo '"index.php?page=' . $_GET["page"] . '"'?> method="post">
    <?php
        # Si la page est la page de connexion
        if($_GET["page"] == "connexion"){
            # Creation d'un formulaire de connexion
            echo('<h1>Connexion</h1>
                <input class="champ-connexion" type="email" name="mail" id="mail" placeholder="Adresse courriel" required maxlength="50"><br/>
                <input class="champ-connexion" type="password" name="mdp" id="mdp" placeholder="Mot de passe" required maxlength="50"><br/>
                <input class="formbouton" type="submit" name="formsend" id="formsend" value="Connexion">
            <a href="index.php?page=inscription">Pas de compte ?</a>');
        
        # Si la page est la page d'inscription
        }elseif($_GET["page"] == "inscription") {
            # Creation d'un formulaire d'inscription
            echo('<h1>Inscription</h1>
                <p>Informations personnelles :</p>
                <div class="form-group">
                    <input class="champ-inscription" type="text" name="nom" id="nom" placeholder="Nom*" required maxlength="30">
                    <input class="champ-inscription" type="text" name="prenom" id="prenom" placeholder="Prenom*" required maxlength="30">
                    <input class="champ-inscription" type="email" name="mail" id="mail" placeholder="Adresse courriel*" required maxlength="50">
                </div>
            
                <div class="form-group">
                    <input class="champ-inscription" type="number" name="tel" id="tel" placeholder="Numéro de téléphone*" required maxlength="12">
                    <input class="champ-inscription" type="text" name="adresse" id="adresse" placeholder="Adresse*" required maxlength="170">
                    <input class="champ-inscription" type="text" name="adresse2" id="adresse2" placeholder="Adresse 2" maxlength="30">
                </div>

                <div class="form-group">
                    <input class="champ-inscription" type="text" name="ville" id="ville" placeholder="Ville*" required maxlength="30">
                    <input class="champ-inscription" type="text" name="pays" id="pays" placeholder="Pays*" required maxlength="30">
                    <input class="champ-inscription" type="text" name="codepostal" id="codepostal" placeholder="Code postal*" required maxlength="10">
                </div>
            
                <p>Sécurité du compte :</p>
                <div class="form-group">
                    <input class="champ-inscription" type="password" name="mdp" id="mdp" placeholder="Mot de passe*" required maxlength="50">
                    <input class="champ-inscription" type="password" name="mdpConfirme" id="mdpConfirme" placeholder="Confirmer le mot de passe*" required maxlength="50">
                </div>
                <p class="champsobligatoires">* Champs obligatoires</p>
                <input class="formbouton" type="submit" name="formsend" id="formsend" value="Inscription">
            <a href="index.php?page=connexion">Déjà un compte ?</a>');
        }
    ?>

</form>

<?php
    $pdo=new Mypdo();
    $clientManager = new ClientManager($pdo);

    # Options pour le hashage du mot de passe
    $options = [
        'cost' => 12,
    ];
    
    # Si le formulaire est envoyé
    if(isset($_POST['formsend'])) {

        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];

        # Si la page est la page d'inscription
        if($_GET["page"] == "inscription"){

            # Récupération des données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $adresse = $_POST['adresse'];
            $ville = $_POST['ville'];
            $pays = $_POST['pays'];
            $codepostal = $_POST['codepostal'];
            $tel = $_POST['tel'];
            $mdpConfirme = $_POST['mdpConfirme'];

            # Si les mots de passe sont identiques
            if($mdp == $mdpConfirme) {

                # Vide la session client
                if (!empty($_SESSION['client'])) {
					unset($_SESSION['client']);
				}

                # Création d'un nouveau client avec les données du formulaire dont le mot de passe est hashé
                $client = new Client(array(	'cli_nom'=> $nom,
                                                        'cli_prenom'=> $prenom,
                                                        'cli_adresse'=> $adresse . ", " . $ville . ", " . $codepostal . ", " . $pays,
                                                        'cli_mail'=> $mail,
                                                        'cli_tel'=> $tel,
                                                        'cli_mdp'=> password_hash($mdp, PASSWORD_BCRYPT, $options)));
                
                # Si le client n'existe pas déjà, on l'ajoute à la base de données
                if(empty($clientManager->existantClient($client))){
                    $clientManager->ajouterClient($client);
                    foreach ($clientManager->listerClient() as $client) {
                        # Connexion du client avec les données du formulaire
                        if($client->getCliMail() == $mail) {
                            $_SESSION['client'] = $client;
                        }
                    }
                    # Redirection vers la page des informations du client
                    header("Location: index.php?page=client-information");
                } else {
                    echo '<p class="erreur-connexion">Cette adresse mail est déjà utilisée !</p>';
                }
            } else {
                echo '<p class="erreur-connexion">Les mots de passe ne correspondent pas !</p>';
            }

        # Si la page est la page de connexion
        } elseif ($_GET["page"] == "connexion") {
            foreach ($clientManager->listerClient() as $client) {
                # Si le mail existe, on vérifie le mot de passe
                if($client->getCliMail() == $mail) {
                    $mailexiste = 1;
                    # Si le mot de passe est correct, on connecte le client
                    if(password_verify($mdp, $client->getCliMdp())) {
                        $_SESSION['client'] = $client;
                        # Redirection vers la page des informations du client
                        header("Location: index.php?page=client-information");
                    } else {
                        echo '<p class="erreur-connexion">Mot de passe incorrect !</p>';
                    }
                }
            }
            if(!isset($mailexiste)) {
                echo '<p class="erreur-connexion">Cette adresse mail n\'existe pas !</p>';
            }
        }
    }
?>
