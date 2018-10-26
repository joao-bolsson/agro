<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 26.
 */

include_once 'Defensive.class.php';

class Maintenance {

    /**
     * @var int
     */
    private $id_crop;

    /**
     * @var float
     */
    private $labor;

    /**
     * @var float
     */
    private $machines;

    /**
     * @var array Defensive
     */
    private $defensives;

    /**
     * @var float
     */
    private $total;

    /**
     * Maintenance constructor.
     * @param int $id_crop
     * @param float $labor
     * @param float $machines
     */
    public function __construct(int $id_crop, float $labor, float $machines) {
        $this->id_crop = $id_crop;
        $this->labor = $labor;
        $this->machines = $machines;
    }

    /**
     * @param array $defensives
     */
    public function setDefensives(array $defensives) {
        $this->defensives = $defensives;
    }

    /**
     * Update total value.
     */
    public function update() {
        $total_defensives = 0;
        foreach ($this->defensives as $defensive) {
            if ($defensive instanceof Defensive) {
                $total_defensives += $defensive->getValue();
            }
        }
        $this->total = $total_defensives + $this->labor + $this->machines;
    }

    /**
     * @return float
     */
    public function getTotal(): float {
        $this->update();
        return $this->total;
    }


}