<?php
    // Ce fichier fait partie du projet "NSImétéo" et est distribué sous la licence GPL v3+.
    // Veuillez consulter le fichier LICENSE pour plus d'informations sur la licence.
    // Le projet "NSImétéo" est aussi distribué sous la licence Creative Commons Attribution-ShareAlike (CC BY-SA). 
    // Pour plus d'informations sur cette licence, veuillez consulter le lien suivant : https://creativecommons.org/licenses/by-sa/4.0/.
?>

<div class="meteo">
    <?php 
        // Récupérer la ville choisie
        $ville = $_POST['ville'];

        //Metre l'api pour la meteo
        $API = '';

        // Si la ville n'est pas renseignée, on affiche la météo de Paris
        if (empty($ville)) {
            $ville = "Paris";
        }

        try {
            // Récupérer les données de l'API OpenWeatherMap
            $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $ville . '&lang=fr&units=metric&appid=' . $API;
            $meteo_json = file_get_contents($url);

            // Vérifier si la réponse de l'API contient des données valides
            if (!$meteo_json) {
                throw new Exception("La ville que vous avez entrée est invalide. Veuillez réessayer en changeant de ville ou en vérifiant l'orthographe. Attention, le nom de la ville doit être dans la langue du pays où elle se trouve !"); 
            }

            $meteo = json_decode($meteo_json);
            
            echo('<h1>LA MÉTÉO DE ' . strtoupper($ville) . ' EN NUMÉRIQUE</h1>

            <hr class=grande-ligne>
        
            <!-- Affichage des données de la météo sous forme de tableau -->
            <div class="meteo-table">
                <table class="tableau">
                    <tr>  
                        <th><img src="image/meteo/temperature.png" alt="Température" class="meteo-logo" width="30" height="30"/> Température</th>
                        <th><img src="image/meteo/tempMin.png" alt="Température min" class="meteo-logo" width="30" height="30"/> Température min</th>
                        <th><img src="image/meteo/tempMax.png" alt="Température max" class="meteo-logo" width="30" height="30"/> Température max</th>
                        <th><img src="image/meteo/tempRessenti.png" alt="Température ressentie" class="meteo-logo" width="30" height="30"/> Température ressentie</th>
                        <th><img src="image/meteo/pression.png" alt="Pression" class="meteo-logo" width="30" height="30"/> Pression</th>
                    </tr>
                    <tr>
                        <td class="meteo-table-td">' . $meteo->main->temp . '°C</td>
                        <td class="meteo-table-td">' . $meteo->main->temp_min . '°C</td>
                        <td class="meteo-table-td">' . $meteo->main->temp_max . '°C</td>
                        <td class="meteo-table-td">' . $meteo->main->feels_like . '°C</td>
                        <td class="meteo-table-td">' . $meteo->main->pressure . ' hPa</td>
                    </tr>
                    <tr>
                        <th><img src="image/meteo/humidite.png" alt="Humidité" class="meteo-logo" width="30" height="30"/> Humidité</th>
                        <th><img src="image/meteo/vent.png" alt="Vitesse du vent" class="meteo-logo" width="30" height="30"/> Vitesse du vent</th>
                        <th><img src="image/meteo/ventDirection.png" alt="Direction du vent" class="meteo-logo" width="30" height="30"/> Direction du vent</th>
                        <th><img src="image/meteo/nuages.png" alt="Nuages" class="meteo-logo" width="30" height="30"/> Nuages</th>
                        <th><img src="image/meteo/temps.png" alt="Temps" class="meteo-logo" width="30" height="30"/> Temps</th>
                    </tr>
                    <tr>
                        <td class="meteo-table-td">' . $meteo->main->humidity . '%</td>
                        <td class="meteo-table-td">' . $meteo->wind->speed . ' m/s</td>
                        <td class="meteo-table-td">' . $meteo->wind->deg . '°</td>
                        <td class="meteo-table-td">' . $meteo->clouds->all . '%</td>
                        <td class="meteo-table-td">' . $meteo->weather[0]->description . '</td>
                    </tr>
                </table>
            </div>
            
            <hr class=ligne>

            <!-- Proposition des produits conseiller en fonction du temps -->
            <h2>LES PRODUITS CONSEILLÉS :</h2>
            
            <p> Pour voir la liste des produits recommandés par nos équipes, veuillez cliquer sur le bouton ci-dessous :</p>
            <form action="index.php?page=produit-conseille" method="post">
                <input type="hidden" name="temp" value="' . $meteo->weather[0]->main . '">
                <input type="submit" value="Produits Conseillés" class="bouton">
            </form>
            
            <hr class=ligne>

            <h2>LA METEO DE ' . strtoupper($ville) . ' EN IMAGE</h2>');
            
            $date = date("m");
            $hours = date("H");
            
            if ($meteo->weather[0]->main == "Clouds"){
                $temp = "Cloud";
            } elseif ($meteo->weather[0]->main == "Rain" or $meteo->weather[0]->main == "Snow"){
                $temp = "Rain";
            } else {
                $temp = "Clear";
            }

            if ($date >= 12 OR $date <= 03){
                $season = "winter";
            } else {
                $season = "other";
            }

            if ($hours >= 18 OR $hours <= 6){
                $time = "night";
            } else {
                $time = "day";
            }

            echo('<img src="image/generation_image/' . $temp . '_' . $season . '_' . $time . '.png" alt="Météo" class="meteo-image" width="1400" height="800"/>
            
            <p> Cette image a été pré-générée par un script Python créé par nos soins. Il permet de générer une image en fonction de la météo de la ville choisie. Pour exploiter toutes ses fonctionnalités, vous pouvez télécharger le script cliquant sur le lien ci-dessous :</p>
            <a href="weather-generator.zip" download>
                <button class="bouton">Télécharger le fichier ZIP</button>
            </a>
            <hr class=ligne>');
            
        } catch(Exception $e) {
            echo('<h1>ERREUR DE CHARGEMENT DE LA MÉTÉO</h1>

            <hr class=grande-ligne>
            
            <p>' . $e->getMessage() . '</p>');
        }
    ?>
</div>