<?php
/**
 * Class that represents a crop.
 *
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Crop implements JsonSerializable {

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $id_user;

    /**
     * @var int
     */
    private $id_culture;
    /**
     * @var string
     */
    private $start;

    /**
     * @var string
     */
    private $end;

    /**
     * @var int
     */
    private $production;
    /**
     * @var int
     */
    private $balance;

    /**
     * @var int
     */
    private $sale;

    /**
     * @var string
     */
    private $culture_name;

    /**
     * @var string
     */
    private $culture_type;

    /**
     * Crop constructor.
     *
     * @param int $id Crop id.
     * @param int $id_user Owner user id.
     * @param int $id_culture Culture id.
     * @param string $start Start date crop.
     * @param string $culture_name Culture name.
     * @param string $culture_type Culture type.
     */
    public function __construct(int $id, int $id_user, int $id_culture, string $start, string $culture_name, string $culture_type) {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_culture = $id_culture;
        $this->start = $start;
        $this->culture_name = $culture_name;
        $this->culture_type = $culture_type;
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
    public function getIdCulture(): int {
        return $this->id_culture;
    }

    /**
     * @return string
     */
    public function getStart(): string {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getEnd(): string {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getProduction(): int {
        return $this->production;
    }

    /**
     * @return int
     */
    public function getBalance(): int {
        return $this->balance;
    }

    /**
     * @return int
     */
    public function getSale(): int {
        return $this->sale;
    }

    /**
     * @return string
     */
    public function getCultureName(): string {
        return $this->culture_name;
    }

    /**
     * @return string
     */
    public function getCultureType(): string {
        return $this->culture_type;
    }

    /**
     * @param string $end
     */
    public function setEnd(string $end) {
        $this->end = $end;
    }

    /**
     * @param int $production
     */
    public function setProduction(int $production) {
        $this->production = $production;
    }

    /**
     * @param int $balance
     */
    public function setBalance(int $balance) {
        $this->balance = $balance;
    }

    /**
     * @param int $sale
     */
    public function setSale(int $sale) {
        $this->sale = $sale;
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