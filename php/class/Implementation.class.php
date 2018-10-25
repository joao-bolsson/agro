<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Implementation implements JsonSerializable{

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
     * @var float
     */
    private $fertilizing;

    /**
     * @var float
     */
    private $seeding;

    /**
     * Implementation constructor.
     *
     * @param int $id_crop Crop id.
     * @param float $labor Labor cost.
     * @param float $machines Cost with machines.
     * @param float $fertilizing Cost with fertilizers.
     * @param float $seeding Cost with seeding.
     */
    public function __construct(int $id_crop, float $labor, float $machines, float $fertilizing, float $seeding) {
        $this->id_crop = $id_crop;
        $this->labor = $labor;
        $this->machines = $machines;
        $this->fertilizing = $fertilizing;
        $this->seeding = $seeding;
    }

    /**
     * @return int
     */
    public function getIdCrop(): int {
        return $this->id_crop;
    }

    /**
     * @return float
     */
    public function getLabor(): float {
        return $this->labor;
    }

    /**
     * @return float
     */
    public function getMachines(): float {
        return $this->machines;
    }

    /**
     * @return float
     */
    public function getFertilizing(): float {
        return $this->fertilizing;
    }

    /**
     * @return float
     */
    public function getSeeding(): float {
        return $this->seeding;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}