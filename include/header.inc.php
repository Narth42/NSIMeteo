<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>

	<meta http-equiv="content-type" content="text/html"; />
    <meta charset="UTF-8">

	<!-- On définit l'icon de la page -->
	<link href="image/icon.png" rel="icon"/>

	<?php 
	# On définit le titre de la page
	$title = "NSImeteo"; 
	?>
        
	<title>
		<?php 
		# On affiche le titre de la page
		echo $title 
		?>
	</title>

	<!-- On définit le lien vers le fichier css -->
	<link rel="stylesheet" type="text/css" href="css/style.css" width="30" height="30"/>

</head>

<body>
	<!-- Affichage de la banniere -->
	<div id="header">	
		<div id="entete">
			<div id="banniere">
				<a href="index.php?page=acceuil">
					<img src="image/banniere.png" alt="Banniere marque" title="Banniere NSImeteo" width="610" height="140"/>
				</a>
			</div>
		</div>
	</div>
</body>