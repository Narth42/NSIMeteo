<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="meteo">
    <div class='chosemeteo'>
        <h1>LA MÉTÉO EN NUMÉRIQUE</h1>

        <hr class=grande-ligne>

        <!-- Formulaire pour choisir la ville -->
        <p>Veuillez choisir une ville :</p>
        <form action="index.php?page=meteo" method="post">
            <input class="champ-meteo" type="text" name="ville" id="ville" placeholder="Ville" required>
            <input class="bouton" type="submit" value="Valider">
        </form>
    </div>
</div>