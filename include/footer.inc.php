<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="footer">
    <!-- bas de la page -->
    <p class="footer-background"></p>
    <nav>
        <!-- menu du bas de la page -->
        <li><p class="moyens-de-paiement">Moyens de paiement</p><img src="image/logo-paiement.png"/></li>
        <li><a href="index.php?page=acceuil"><p class="footer-menu">Accueil</p></a></li>
        <li><a href="index.php?page=chosemeteo"><p class="footer-menu">Météo</p></a></li>
        <li><a href="index.php?page=nos-produits"><p class="footer-menu">Produits</p></a></li>
        <li><a href="index.php?page=contact"><p class="footer-menu">Contact</p></a></li>
		<?php
            # On affiche le lien vers l'espace client si l'utilisateur est connecté et l'admin si l'utilisateur est l'admin
			if (isset($_SESSION['client'])) {
				echo '<li><a href="index.php?page=client-information"><p class="footer-menu">Espace Client</p></a></li>';
				if($_SESSION['client']->getCliMail() == 'admin@nsimeteo.fr') {
					echo '<li><a href="index.php?page=admin-client"><p class="footer-menu">Admin</p></a></li>';
				}
			} else {
				echo '<li><a href="index.php?page=connexion"><p class="footer-menu">Connexion</p></a></li>';
			}
		?>
    </nav>

    <p class="phrase-fin">
        Service de météo et de vente d'accessoire, à votre service, depuis avril 2023. <br /> LPO Léonard de Vinci <br /><br />
        
    <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a>
    <br />Ce(tte) œuvre est mise à disposition selon les termes de la <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Licence Creative Commons Attribution -  Partage dans les Mêmes Conditions 4.0 International</a>.
    </p>
</div>

</body>
</html>