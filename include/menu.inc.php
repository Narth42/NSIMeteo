<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="menu">
	<nav>
		<!-- menu du haut de la page -->
		<li><a href="index.php?page=accueil" class="accueil-title">Accueil</a></li>
		<li><a href="index.php?page=chosemeteo">Météo</a></li>
		<li><a href="index.php?page=nos-produits">Produits</a></li>
		<li><a href="index.php?page=contact">Contact</a></li>
		<?php
			# On affiche le lien vers l'espace client si l'utilisateur est connecté et l'admin si l'utilisateur est l'admin
			if (isset($_SESSION['client'])) {
				echo '<li><a href="index.php?page=client-information">Espace Client</a></li>';
				if($_SESSION['client']->getCliMail() == 'admin@nsimeteo.fr') {
					echo '<li><a href="index.php?page=admin-client">Admin</a></li>';
				}
			} else {
				echo '<li><a href="index.php?page=connexion">Connexion</a></li>';
			}
		?>
	</nav>
</div>