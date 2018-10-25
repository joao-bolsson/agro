<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Harvest implements JsonSerializable{

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
    private $transport;

    /**
     * Harvest constructor.
     *
     * @param int $id_crop Crop id.
     * @param float $labor Labor cost.
     * @param float $machines Cost with machines.
     * @param float $transport Cost with transport.
     */
    public function __construct(int $id_crop, float $labor, float $machines, float $transport) {
        $this->id_crop = $id_crop;
        $this->labor = $labor;
        $this->machines = $machines;
        $this->transport = $transport;
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