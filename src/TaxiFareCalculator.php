<?php

class TaxiFareCalculator {

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
    public static function calculateFare(int $jourSemaine, int $hour, string $zone, float $distance, bool $estFerie): float {

        // Déclaration de quelques variables utiles
        $priseEnCharge = 2.6;
        $tarifA = 1.06;
        $tarifB = 1.32;
        $tarifC = 1.58;

        // TODO compléter la fonction
        
        return 0.0;
    }
}