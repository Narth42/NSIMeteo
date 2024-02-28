<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php

	$pdo=new Mypdo();
    $produitManager = new ProduitManager($pdo);
    $typeManager = new TypeManager($pdo);

    # Si l'utilisateur a cliqué sur le bouton modifier ou ajouter et qu'il est admin
    if ((isset($_POST['modifier']) or isset($_POST['ajouter'])) and $_SESSION['client']->getCliMail() == 'admin@nsimeteo.fr') {
        
        # On récupère les images du dossier
        $image_directory = 'image/produit';
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
        $images = [];
        foreach ($allowed_extensions as $extension) {
            $pattern = "{$image_directory}/*.{$extension}";
            $found_images = glob($pattern);
            $images = array_merge($images, $found_images);
        }
        
        # Si le client a cliqué sur le bouton modifier et qu'il a sélectionné un produit
        if ($_GET["page"] == "admin-modif-produit" and isset($_POST['prod-id'])) {

            # On récupère les informations du produit
            $prod_id = $_POST['prod-id'];
            $produit = new Produit($produitManager->getProduitWithId($prod_id));
            $type_id = $produit->getProdType();
            $prod_type = new Type($typeManager->getTypeWithId($type_id));

            # On affiche le formulaire de modification
            echo ('<form class="admin-modif-form" action="index.php?page=admin-modif-produit-exe" method="post">
                <h1 class="admin-modif-title">Modifier un produit</h1>
                <div class="form-group">
                    <input type="hidden" name="prod-id" id="prod-id" value="' . $produit->getProdId() . '">
                    <input class="champ-admin-modif" type="number" value="' . $produit->getProdId() . '" disabled>
                    <input class="champ-admin-modif" type="text" name="nom" id="nom" placeholder="Nom" value="' . $produit->getProdNom() . '" required maxlength="50">
                    <input class="champ-admin-modif" type="text" name="prov" id="prov" placeholder="Provenance" value="' . $produit->getProdProvenance() . '" required maxlength="30">
                </div>
                <div class="form-group">
                    <select class="champ-admin-modif" name="image" id="image" required>
                    <option selected>' . $produit->getProdImg() . '</option>');
                    foreach ($images as $image){
                        echo("<option value=\"" . htmlspecialchars($image) . "\">" . htmlspecialchars($image) . "</option>");
                    }
                    echo('<input class="champ-admin-modif" type="number" name="prix" id="prix" placeholder="Prix" value="' . $produit->getProdPrix() . '" required maxlength="5">
                    <input class="champ-admin-modif" type="number" name="stock" id="stock" placeholder="Stock" value="' . $produit->getProdStock() . '" required maxlength="5">
                </div>
                <div class="form-group">
                    <select class="champ-admin-modif" name="type" id="type" required>
                    <option selected>' . $prod_type->getTypeNom() . '</option>');

            # Liste deroulante des types de produits
            foreach($typeManager->listerType() as $type){
                if ($type->getTypeNom() != $prod_type->getTypeNom()) {
                    echo ('<option>' . $type->getTypeNom() . '</option>');
                }
            }

            echo('</select>
                    <input class="champ-admin-modif" type="number" name="nouveau" id="nouveau" placeholder="Nouveau" value="' . $produit->getProdNouveau() . '" required min="0" max="1">
                    <input class="champ-admin-modif" type="number" name="special" id="special" placeholder="Special" value="' . $produit->getProdSpecial() . '" required min="0" max="1">
                </div>
                <div class="form-group">
                    <input class="champ-admin-modif" type="text" name="desc" id="desc" placeholder="Description" value="' . $produit->getProdDesc() . '" required minlength="90" maxlength="1000">
                </div>
                <input class="formbouton" type="submit" name="formsend" id="formsend" value="Modifier">
            </form>');
        
        # Si le client a cliqué sur le bouton modifier et qu'il a sélectionné un type
        } elseif ($_GET["page"] == "admin-modif-type"  and isset($_POST['type-id'])) {

            # On récupère les informations du type
            $type_id = $_POST['type-id'];
            $type = new Type($typeManager->getTypeWithId($type_id));

            # On affiche le formulaire de modification
            echo ('<form class="admin-modif-form" action="index.php?page=admin-modif-type-exe" method="post">
                <h1 class="admin-modif-title">Modifier un type</h1>
                <div class="form-group">
                    <input type="hidden" name="type-id" id="type-id" value="' . $type->getTypeId() . '">
                    <input class="champ-admin-modif" type="number" value="' . $type->getTypeId() . '" disabled>
                    <select class="champ-admin-modif" name="image" id="image" required>
                    <option selected>' . $type->getTypeImg() . '</option>');
                    foreach ($images as $image){
                        echo("<option value=\"" . htmlspecialchars($image) . "\">" . htmlspecialchars($image) . "</option>");
                    }
                    echo('<input class="champ-admin-modif" type="text" name="nom" id="nom" placeholder="Nom" value="' . $type->getTypeNom() . '" required maxlength="50">
                </div>
                <div class="form-group">
                    <input class="champ-admin-modif" type="text" name="desc" id="desc" placeholder="Description" value="' . $type->getTypeDesc() . '" required minlength="90" maxlength="1000">
                </div>
                <input class="formbouton" type="submit" name="formsend" id="formsend" value="Modifier">
            </form>');

        # Si le client a cliqué sur le bouton ajouter sur la page produit
        } elseif ($_GET["page"] == "admin-nv-produit") {

            # On affiche le formulaire d'ajout
            echo ('<form class="admin-modif-form" action="index.php?page=admin-nv-produit-exe" method="post">
            <h1 class="admin-modif-title">Ajouter un produit</h1>
            <div class="form-group">
                <input class="champ-admin-modif" type="text" name="nom" id="nom" placeholder="Nom" required maxlength="50">
                <input class="champ-admin-modif" type="text" name="prov" id="prov" placeholder="Provenance" required maxlength="30">
            </div>
            <div class="form-group">
                <select class="champ-admin-modif" name="image" id="image" required>');
                foreach ($images as $image){
                    echo("<option value=\"" . htmlspecialchars($image) . "\">" . htmlspecialchars($image) . "</option>");
                }
                echo('<input class="champ-admin-modif" type="number" name="prix" id="prix" placeholder="Prix" required maxlength="5">
                <input class="champ-admin-modif" type="number" name="stock" id="stock" placeholder="Stock" required maxlength="5">
            </div>
            <div class="form-group">
                <select class="champ-admin-modif" name="type" id="type" required>');

            # Liste deroulante des types de produits
            foreach($typeManager->listerType() as $type){
                echo ('<option>' . $type->getTypeNom() . '</option>');
            }

            echo('</select>
                    <input class="champ-admin-modif" type="number" name="nouveau" id="nouveau" placeholder="Nouveau" value="0" required min="0" max="1">
                    <input class="champ-admin-modif" type="number" name="special" id="special" placeholder="Special" value="0" required min="0" max="1">
                </div>
                <div class="form-group">
                    <input class="champ-admin-modif" type="text" name="desc" id="desc" placeholder="Description" required minlength="90" maxlength="1000">
                </div>
                <input class="formbouton" type="submit" name="formsend" id="formsend" value="Ajouter">
            </form>');       

        # Si le client a cliqué sur le bouton ajouter sur la page type
        } elseif ($_GET["page"] == "admin-nv-type") {

            # On affiche le formulaire d'ajout
            echo ('<form class="admin-modif-form" action="index.php?page=admin-nv-type-exe" method="post">
                <h1 class="admin-modif-title">Ajouter un type</h1>
                <div class="form-group">
                    <select class="champ-admin-modif" name="image" id="image" required>');
                    foreach ($images as $image){
                        echo("<option value=\"" . htmlspecialchars($image) . "\">" . htmlspecialchars($image) . "</option>");
                    }
                    echo('<input class="champ-admin-modif" type="text" name="nom" id="nom" placeholder="Nom" required maxlength="50">
                </div>
                <div class="form-group">
                    <input class="champ-admin-modif" type="text" name="desc" id="desc" placeholder="Description" required minlength="90" maxlength="1000">
                </div>
                <input class="formbouton" type="submit" name="formsend" id="formsend" value="Ajouter">
            </form>');
        }

    } else {

        # Si le client n'est pas connecté ou qu'il n'a pas sur le bouton modifier ou ajouter, on le redirige vers la page d'accueil
        header('Location: index.php?page=accueil');

    }

?>