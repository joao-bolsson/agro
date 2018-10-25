<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Product implements JsonSerializable {

    /**
     * @var int Product id.
     */
    private $id;

    /**
     * @var int Id of the user owner of this product.
     */
    private $id_user;

    /**
     * @var int Product type.
     */
    private $id_type;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string Code
     */
    private $cod;

    /**
     * @var string Description.
     */
    private $description;

    /**
     * @var string Product unit.
     */
    private $unit;

    /**
     * @var int Quantity.
     */
    private $qtd;

    /**
     * @var float Unit value.
     */
    private $vl_unit;

    /**
     * @var float Total value.
     */
    private $vl_total;

    /**
     * Product constructor.
     *
     * @param int $id_user Id of the user owner of this product.
     * @param int $id_type Product type id.
     * @param string $type Product type name.
     * @param string $cod Product code.
     * @param string $descr Description.
     * @param string $unit Unit.
     * @param int $qtd Quantity.
     * @param float $vl_unit Value by unit.
     * @param float $vl_total Total value.
     */
    public function __construct(int $id_user, int $id_type, string $type, string $cod, string $descr, string $unit, int $qtd, float $vl_unit, float $vl_total) {
        $this->id_user = $id_user;
        $this->id_type = $id_type;
        $this->type = $type;
        $this->cod = $cod;
        $this->description = $descr;
        $this->unit = $unit;
        $this->qtd = $qtd;
        $this->vl_unit = $vl_unit;
        $this->vl_total = $vl_total;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIdUser(): int {
        return $this->id_user;
    }

    /**
     * @return int
     */
    public function getIdType(): int {
        return $this->id_type;
    }

    /**
     * @return string
     */
    public function getCod(): string {
        return $this->cod;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUnit(): string {
        return $this->unit;
    }

    /**
     * @return int
     */
    public function getQtd(): int {
        return $this->qtd;
    }

    /**
     * @return float
     */
    public function getVlUnit(): float {
        return $this->vl_unit;
    }

    /**
     * @return float
     */
    public function getVlTotal(): float {
        return $this->vl_total;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) {
        $this->id = $id;
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