<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Defensive {

    /**
     * @var int Product id.
     */
    private $id;

    /**
     * @var int Number of applications.
     */
    private $applications;

    /**
     * This field can be calculated automatically in the future by getting the unit value of the product.
     *
     * @var float Product unit value * applications.
     */
    private $value;

    /**
     * Defensive constructor.
     *
     * @param int $id Product id.
     * @param int $applications Number of applications.
     * @param float $value Product unit value * applications.
     */
    public function __construct(int $id, int $applications, float $value) {
        $this->id = $id;
        $this->applications = $applications;
        $this->value = $value;
    }

    /**
     * @return int Product id.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int Number of applications.
     */
    public function getApplications(): int {
        return $this->applications;
    }

    /**
     * @return float Value.
     */
    public function getValue(): float {
        return $this->value;
    }


}