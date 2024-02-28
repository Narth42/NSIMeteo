<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="produit">
    <!-- Menu de navigation des produits -->
    <nav class="produit-menu">
        <li><a href="index.php?page=nos-produits"><p>NOS PRODUITS</p></a></li>
		<li><a href="index.php?page=nouveaux-produits"><p>NOUVEAUX PRODUITS</p></a></li>
		<li><a href="index.php?page=edition-limitee"><p>ÉDITIONS LIMITÉES</p></a></li>
    </nav>
    
    <hr class=grande-ligne>

    
	<?php
		$pdo=new Mypdo();
        
        if (empty($_GET['id'])) {
            $produitManager = new ProduitManager($pdo);
            $produits = $produitManager->listerProduit();
            $typeManager = new TypeManager($pdo);

            foreach ($produits as $produit) {

                # On récupère les informations du produit
                $name = $produit->getProdNom();
                $prix = $produit->getProdPrix();
                $provenance = $produit->getProdProvenance();
                $stock = $produit->getProdStock();
                $image = $produit->getProdImg();
                $desc = $produit->getProdDesc();
                $nouveau = $produit->getProdNouveau();
                $special = $produit->getProdSpecial(); 

                # On affiche les produits
                if(($_GET["page"] == "nouveaux-produits" and $nouveau == 1) or ($_GET["page"] == "edition-limitee" and $special == 1) or ($_GET["page"] == "nos-produits")){
                    echo('
                        <div class="liste-produit">
                            <img src="' . $image . '" width="500" height="400"/>
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
                    
                    # On affiche les labels des produits
                    if($nouveau == 1) {
                        echo('<li><a href="index.php?page=nouveaux-produits"><p class="label-nouveau-produit">Nouveau</p></a></li>');
                    }
                    if($special == 1) {
                        echo('<li><a href="index.php?page=edition-limitee"><p class="label-editionlimitee-produit">Edition Limitée</p></a></li>');
                    }
                    if($stock == 0) {
                        echo('      <li><p class="label-rupture-produit">Rupture de Stock</p></li>
                                </ul>
                            </div>
                        </div>

                        <hr class=ligne>');
                    } else {
                        # On affiche le formulaire de commande
                        echo('      </ul>
                                <form action="index.php?page=commande" method="post">
                                    <label for="prod-quantite">Quantité:</label>
                                    <input type="number" id="prod-quantite" name="prod-quantite" min="1" max="' . $produit->getProdStock() . '" value="1" required class="quantitee-achat">
                                    <input type="hidden" name="prod-id" value="' . $produit->getProdId() . '">
                                    <input type="submit" value="Commander" class="bouton-achat">
                                </form>
                            </div>
                        </div>

                        <hr class=ligne>
                    ');
                    }

                } elseif ($_GET["page"] == "produit-conseille"){

                    $temp = $_POST['temp'];
                    $type_id = $produit->getProdType();
                    $prod_type = new Type($typeManager->getTypeWithId($type_id));

                    if ($temp == "Clear"){
                        $type = ["Casquette", "Lunettes de Soleil", "LogoPins"];
                    } elseif ($temp == "Clouds" or $temp == "Mist"){
                        $type = ["Veste", "LogoPins"];
                    } elseif ($temp == "Snow" or $temp == "Rain"){
                        $type = ["Parapluie", "Bottes de pluie", "Veste", "LogoPins"];
                    } else {
                        $type = [];
                    }

                    if (empty($type) or in_array($prod_type->getTypeNom(), $type)){

                        echo('
                        <div class="liste-produit">
                            <img src="' . $image . '" width="500" height="400"/>
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
                    
                        # On affiche les labels des produits
                        if($nouveau == 1) {
                            echo('<li><a href="index.php?page=nouveaux-produits"><p class="label-nouveau-produit">Nouveau</p></a></li>');
                        }
                        if($special == 1) {
                            echo('<li><a href="index.php?page=edition-limitee"><p class="label-editionlimitee-produit">Edition Limitée</p></a></li>');
                        }
                        if($stock == 0) {
                            echo('      <li><p class="label-rupture-produit">Rupture de Stock</p></li>
                                    </ul>
                                </div>
                            </div>

                            <hr class=ligne>');
                            } else {
                            # On affiche le formulaire de commande
                            echo('      </ul>
                                    <form action="index.php?page=commande" method="post">
                                        <label for="prod-quantite">Quantité:</label>
                                        <input type="number" id="prod-quantite" name="prod-quantite" min="1" max="' . $produit->getProdStock() . '" value="1" required class="quantitee-achat">
                                        <input type="hidden" name="prod-id" value="' . $produit->getProdId() . '">
                                        <input type="submit" value="Commander" class="bouton-achat">
                                    </form>
                                </div>
                            </div>

                            <hr class=ligne>
                        ');
                        }
                    }
                }
            }
        }
    ?>
</div>