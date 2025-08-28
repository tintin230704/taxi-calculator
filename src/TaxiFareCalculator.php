<?php

class TaxiFareCalculator
{

    /**
     * Calcule le prix d'une course de taxi en fonction d'un ensemble de paramètres.
     *
     * @param integer $jourSemaine Le jour de la semaine (0 == dimanche, 1 == lundi... 6 = samedi)
     * @param integer $hour L'heure de la course
     * @param string $zone La zone concernée par la course ("urbaine", "suburbaine", "hors-zone")
     * @param float $distance La distance de la course
     * @param boolean $estFerie true la course s'effectue en jour fériée, false si non.
     * @return float Le prix de la course
     */
    public static function calculateFare(int $jourSemaine, int $hour, string $zone, float $distance, bool $estFerie): float
    {

        // Déclaration de quelques variables utiles
        $priseEnCharge = 2.6;
        $tarifA = 1.06;
        $tarifB = 1.32;
        $tarifC = 1.58;
        $prix = 0;

        // vérification de la zone
        if ($zone == "urbaine") {
            // vérification si c'est dimanche
            if ($jourSemaine == 0) {

                // vérification de 7h du matin à minuit (24)
                if ($hour >= 7 && $hour <= 24) {
                    $prix = 1.32 * $distance + 2.6;
                }
            }

            // vérification si du lundi au samedi
            if ($jourSemaine >= 1 && $jourSemaine <= 6) {
                //vérification de 17h du soir a 10h du matin
                if (
                    $hour >= 17 && $hour <= 24 ||
                    $hour >= 0  && $hour <= 10
                ) {
                    //TarifB multiplier par la distance en KM plus 2.6 euro de départ
                    $prix = 1.32 * $distance + 2.6;
                } else {
                    $prix = 1.06 * $distance + 2.6;
                }
            }
            // vérifie si c'est un jour fériée
            if ($estFerie == true) {
                //vérification de 0h a 24h
                if ($hour >= 0 && $hour <= 24) {
                    //TarifB multiplier par la distance en KM plus 2.6 euro de départ
                    $prix = 1.32 * $distance + 2.6;
                }
            }
        }

        return $prix;
    }
}
