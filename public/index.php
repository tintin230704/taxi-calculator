<?php
// chargement du autoloader (va venir chercher tous les fichiers PHP contenus dans "src")
require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/TaxiFareCalculator.php';

// récupération des valeurs du formulaire (si c'est bien envoyé)
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // on teste si on a reçu une requête POST

    // déclaration de toutes les variables qui serviront plus tard
    $jourSemaine = -1;
    $hour = -1;
    $zone = "";
    $distance = -1;
    $estFerie = false;

    // la date a-t-elle bien été envoyée ?
    // si oui, on la récupère
    if (isset($_POST['date'])) {
        // on récupère la date
        $dateInput = $_POST['date'];
        // on extrait le jour de la semaine
        $date = new DateTime($dateInput);

        // récupération du jour de la semaine en indice entier
        // 0 dimanche
        // 1 lundi
        // 2 mardi
        // ... 6 samedi
        $jourSemaine = (int) $date->format('w');
    }

    // l'heure a-t-elle bien été envoyée ?
    if (isset($_POST['time'])) {
        $timeInput = $_POST['time'];

        // on récupère l'heure (on laisse les minutes)
        // et on transforme ça en entier
        // comme le format est du style "15:10" on peut séparer les informations avec ':'
        $timeStrings = explode(":", $timeInput ); 

        // $timeStrings est un tableau de 2 chaînes de caractères, on prend la première pour obtenir l'heure
        // (int) permet de transformer la chaîne de caractères en entier
        $hour = intval($timeStrings[0]);
    }

    // la zone a-t-elle été bien envoyée ?
    if (isset($_POST['zone'])) {
        // si oui on la recupère
        $zone = $_POST['zone'];
    }

    // la distance a-t-elle été bien envoyée ?
    if (isset($_POST['distance'])) {
        $distance = isset($_POST['distance']);
    }

    // le fait que ça soit un jour fériée a-t-il été bien envoyée ?
    if (isset($_POST['ferie'])) {
        $estFerie = true;
    } else { // si on a pas "ferie" dans la super globale $_POST c'est que personne n'a cliqué sur la checkbox
        $estFerie = false;
    }

    // On appelle la fonction de calcul
    // on se servira du résultat plus tard (dans le html)
    $result = TaxiFareCalculator::calculateFare($jourSemaine, $hour, $zone, $distance, $estFerie);
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculateur de prix de course de taxi</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Calculateur de prix de course de taxi</h1>
        <section class="prices-info">
            <h2>Tarifs en vigueur</h2>
            <div id="prices">
                <p><strong>Prise en charge :</strong> 2,60 €</p>
                <p><strong>Tarif A :</strong> 1,06 €/km</p>
                <p><strong>Tarif B :</strong> 1,32 €/km</p>
                <p><strong>Tarif C :</strong> 1,58 €/km</p>
            </div>
        </section>
        <form id="taxiForm" method="post" action="/">

            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>

            <div class="checkbox">
                <input type="checkbox" id="ferie" name="ferie" value="true">
                <label for="ferie">Jour férié</label>
            </div>

            <label for="time">Heure :</label>
            <input type="time" id="time" name="time" required>

            <fieldset>
                <legend>Zone :</legend>
                <div class="radio-group">
                    <input type="radio" id="urbaine" name="zone" value="urbaine" required>
                    <label for="urbaine" class="radio-button">Zone urbaine</label>
                    <input type="radio" id="suburbaine" name="zone" value="suburbaine">
                    <label for="suburbaine" class="radio-button">Zone suburbaine</label>
                    <input type="radio" id="hors-zone" name="zone" value="hors-zone">
                    <label for="hors-zone" class="radio-button">Hors zone suburbaine</label>
                </div>
            </fieldset>

            <label for="distance">Distance (en km) :</label>
            <input type="number" id="distance" min="0" step="0.1" name="distance" required>

            <button type="submit">Calculer</button>
        </form>
    
        <?php
        // on affiche le résultat si la variable a été remplie !
        if (isset($result)) {
            echo '<div id="result"><p>'.$result.'</p></div>';
        }
        ?>
    </div>
</body>

</html>