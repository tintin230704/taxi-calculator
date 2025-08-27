<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/TaxiFareCalculator.php';

class TaxiFareCalculatorTest extends TestCase {

    // Déclaration de variables pouvant être utilisées pour les calculs futurs
    private float $priseEnCharge = 2.6;
    private float $tarifA = 1.06;
    private float $tarifB = 1.32;
    private float $tarifC = 1.58;

    /**
     * Test zone urbaine, Tarif A (Lundi-Samedi, 10h00-17h00)
     */
    public function testZoneUrbaineTarifA(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifA * $distance;
        $result = TaxiFareCalculator::calculateFare(1, 12, 'urbaine', $distance, false); // Monday, 12:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone urbaine, Tarif B (Lundi-Samedi, 17h00-10h00)
     */
    public function testZoneUrbaineTarifBLundiSamediNight(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifB * $distance;
        $result = TaxiFareCalculator::calculateFare(2, 18, 'urbaine', $distance, false); // Tuesday, 18:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone urbaine, Tarif B (Dimanche, 07h00-00h00)
     */
    public function testZoneUrbaineTarifBDimanche(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifB * $distance;
        $result = TaxiFareCalculator::calculateFare(0, 12, 'urbaine', $distance, false); // Sunday, 12:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone urbaine, Tarif B (Jour férié, 00h00-24h00)
     */
    public function testZoneUrbaineTarifBFerie(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifB * $distance;
        $result = TaxiFareCalculator::calculateFare(1, 12, 'urbaine', $distance, true); // Monday, 12:00, holiday
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone urbaine, Tarif C (Dimanche, 00h00-07h00)
     */
    public function testZoneUrbaineTarifCDimancheEarly(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifC * $distance;
        $result = TaxiFareCalculator::calculateFare(0, 5, 'urbaine', $distance, false); // Sunday, 05:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone urbaine, Tarif C (Dimanche férié, 00h00-07h00)
     */
    public function testZoneUrbaineTarifCDimancheFerie(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifC * $distance;
        $result = TaxiFareCalculator::calculateFare(0, 5, 'urbaine', $distance, true); // Sunday, 05:00, holiday
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone suburbaine, Tarif B (Lundi-Samedi, 07h00-19h00)
     */
    public function testZoneSuburbaineTarifB(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifB * $distance;
        $result = TaxiFareCalculator::calculateFare(3, 12, 'suburbaine', $distance, false); // Wednesday, 12:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone suburbaine, Tarif C (Lundi-Samedi, 19h00-07h00)
     */
    public function testZoneSuburbaineTarifCNight(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifC * $distance;
        $result = TaxiFareCalculator::calculateFare(4, 20, 'suburbaine', $distance, false); // Thursday, 20:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test zone suburbaine, Tarif C (Dimanche)
     */
    public function testZoneSuburbaineTarifCDimanche(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifC * $distance;
        $result = TaxiFareCalculator::calculateFare(0, 12, 'suburbaine', $distance, false); // Sunday, 12:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }

    /**
     * Test hors-zone, Tarif C
     */
    public function testZoneHorsZoneTarifC(): void
    {
        $distance = 10.5;
        $expectedCost = $this->priseEnCharge + $this->tarifC * $distance;
        $result = TaxiFareCalculator::calculateFare(1, 12, 'hors-zone', $distance, false); // Monday, 12:00
        $this->assertEqualsWithDelta($expectedCost, $result, 0.01);
    }
}
?>