<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<!-- Creation du formulaire de contact -->

<div class="contact">
    <form class="contact-form" action="index.php?page=contact" method="post">
        <h1 class="contact-title">Contactez-nous</h1>
        <div class="form-group">
            <input class="champ-contact" type="text" name="nom" id="nom" placeholder="Nom" required maxlength="30">
            <input class="champ-contact" type="email" name="mail" id="mail" placeholder="Adresse courriel" required maxlength="50">
            <input class="champ-contact" type="text" name="objet" id="objet" placeholder="Objet" required maxlength="255">
        </div>
        <div class="form-group">
            <textarea class="champ-contact" name="message" id="message" placeholder="Saisissez ici..." required maxlength="1000"></textarea>
        </div>
        <input class="formbouton" type="submit" name="formsend" id="formsend" value="Envoyer">
    </form>
</div>


<?php
    $pdo=new Mypdo();
    $supportManager = new SupportManager($pdo);

    # Si le formulaire est envoyé
    if(isset($_POST['formsend'])) {

        # On récupère les données du formulaire
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $objet = $_POST['objet'];
        $message = $_POST['message'];

        # On crée un nouveau support et on l'ajoute à la base de données
        $support = new Support(array(
            'sup_nom' => $nom,
            'sup_mail' => $mail,
            'sup_sujet' => $objet,
            'sup_message' => $message
        ));

        $supportManager->ajouterSupport($support);
    }
?>