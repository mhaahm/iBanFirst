<?php
/**
 * Amount entity
 * It is a class that includes all the properties of a Amount
 *
 * PHP version 7.2
 *
 * @category Entity
 * @package  App\Entity
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
namespace App\Entity;

/**
 * Class Amount
 *
 * @category Entity
 * @package  App\Entity
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class Amount
{
    /**
     * @var float|null
     */
    private $value;
    /**
     * @var string|null
     */
    private $currency;

    /**
     * @var float|null 
     */
    private $uniqValue;

    /**
     * @return float|null
     */
    public function getUniqValue(): ?float
    {
        return $this->uniqValue;
    }

    /**
     * @param  float|null $rate
     * @return Amount
     */
    public function setUniqValue(?float $rate): Amount
    {
        $this->uniqValue = $this->value * $rate;
        return $this;
    }

    /**
     * @var string|null 
     */
    private $uniqCurrecy;

    /**
     * @return null|string
     */
    public function getUniqCurrecy(): ?string
    {
        return $this->uniqCurrecy;
    }

    /**
     * @param  null|string $uniqCurrecy
     * @return Amount
     */
    public function setUniqCurrecy(?string $uniqCurrecy): Amount
    {
        $this->uniqCurrecy = $uniqCurrecy;
        return $this;
    }


    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param  float|null $value
     * @return Amount
     */
    public function setValue(?float $value): Amount
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param  null|string $currency
     * @return Amount
     */
    public function setCurrency(?string $currency): Amount
    {
        $this->currency = $currency;
        return $this;
    }
}
