<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Culture implements JsonSerializable {

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $id_type;

    /**
     * @var string
     */
    private $type_name;

    /**
     * @var string
     */
    private $name;

    /**
     * Culture constructor.
     * @param int $id
     * @param int $id_type
     * @param string $type_name
     * @param string $name
     */
    public function __construct(int $id, int $id_type, string $type_name, string $name) {
        $this->id = $id;
        $this->id_type = $id_type;
        $this->type_name = $type_name;
        $this->name = $name;
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