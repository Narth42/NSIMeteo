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

    # Page qui execute les modifications et ajouts de produits et types

    # Si l'utilisateur veux modifier un produit
    if ($_GET["page"] == "admin-modif-produit-exe") {

        # Si le formulaire a été envoyé
        if (isset($_POST['formsend'])) {

            # On récupère les données du formulaire
            $prod_id = $_POST['prod-id'];
            $prod_name = $_POST['nom'];
            $prod_prov = $_POST['prov'];
            $prod_prix = $_POST['prix'];
            $prod_img = $_POST['image'];
            $prod_stock = $_POST['stock'];
            $prod_type = $_POST['type'];
            $prod_nv = $_POST['nouveau'];
            $prod_sp = $_POST['special'];
            $prod_desc = $_POST['desc'];

            # On modifie le produit avec les nouvelles données du formulaire
            $type_id = new Type($typeManager->getTypeWithNom($prod_type));
            $type_id = $type_id->getTypeId();

            $produit = new Produit(array('prod_id' => $prod_id,
                                        'prod_nom'=> $prod_name,
                                        'prod_prix'=> $prod_prix,
                                        'prod_provenance'=> $prod_prov,
                                        'prod_stock'=> $prod_stock,
                                        'prod_img'=> $prod_img,
                                        'prod_desc'=> $prod_desc,
                                        'type_id'=> $type_id,
                                        'nouveau'=> $prod_nv,
                                        'special'=> $prod_sp));

            $produitManager->modifierProduit($produit);

            # On redirige l'utilisateur vers la page admin-produit
            header('Location: index.php?page=admin-produit');

        }

    # Si l'utilisateur veux modifier un type
    } elseif($_GET["page"] == "admin-modif-type-exe") {

        # Si le formulaire a été envoyé
        if (isset($_POST['formsend'])) {

            # On récupère les données du formulaire
            $type_id = $_POST['type-id'];
            $type_name = $_POST['nom'];
            $type_desc = $_POST['desc'];
            $type_img = $_POST['image'];

            # On modifie le type avec les nouvelles données du formulaire
            $type = new Type(array('type_id' => $type_id,
                                        'type_nom'=> $type_name,
                                        'type_desc'=> $type_desc,
                                        'type_img'=> $type_img));

            $typeManager->modifierType($type);

            # On redirige l'utilisateur vers la page admin-type
            header('Location: index.php?page=admin-type');

        }

    # Si l'utilisateur veux ajouter un produit
    } elseif($_GET["page"] == "admin-nv-produit-exe") {

        # Si le formulaire a été envoyé
        if (isset($_POST['formsend'])) {

            # On récupère les données du formulaire
            $prod_name = $_POST['nom'];
            $prod_prov = $_POST['prov'];
            $prod_prix = $_POST['prix'];
            $prod_img = $_POST['image'];
            $prod_stock = $_POST['stock'];
            $prod_type = $_POST['type'];
            $prod_nv = $_POST['nouveau'];
            $prod_sp = $_POST['special'];
            $prod_desc = $_POST['desc'];

            # On crée un nouveau produit avec les nouvelles données du formulaire
            $type_id = new Type($typeManager->getTypeWithNom($prod_type));
            $type_id = $type_id->getTypeId();

            $produit = new Produit(array('prod_nom'=> $prod_name,
                                        'prod_prix'=> $prod_prix,
                                        'prod_provenance'=> $prod_prov,
                                        'prod_stock'=> $prod_stock,
                                        'prod_img'=> $prod_img,
                                        'prod_desc'=> $prod_desc,
                                        'type_id'=> $type_id,
                                        'nouveau'=> $prod_nv,
                                        'special'=> $prod_sp));

            $produitManager->ajouterProduit($produit);

            # On redirige l'utilisateur vers la page admin-produit
            header('Location: index.php?page=admin-produit');

        }

    # Si l'utilisateur veux ajouter un type
    } elseif($_GET["page"] == "admin-nv-type-exe") {

        # Si le formulaire a été envoyé
        if (isset($_POST['formsend'])) {

            # On récupère les données du formulaire
            $type_name = $_POST['nom'];
            $type_desc = $_POST['desc'];
            $type_img = $_POST['image'];

            # On crée un nouveau type avec les nouvelles données du formulaire
            $type = new Type(array('type_nom'=> $type_name,
                                    'type_desc'=> $type_desc,
                                    'type_img'=> $type_img));

            $typeManager->ajouterType($type);

            # On redirige l'utilisateur vers la page admin-type
            header('Location: index.php?page=admin-type');

        }

    }
?>