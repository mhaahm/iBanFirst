<?php
/**
 * Wallet entity:
 * It is a class that includes all the properties of a wallet
 *
 * PHP version 7.2
 *
 * @category Entity
 * @package  App\Entity
 * @author   MHA <moham.hassen@gmail.com
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * Class Wallet
 *
 * @category Entity
 * @package  App\Entity
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class Wallet
{
    /**
     * @var string|null
     */
    private $id;
    /**
     * @var string|null
     */
    private $tag;
    /**
     * @var string|null
     */
    private $currency;
    /**
     * @var \DateTime|null
     */
    private $dateLastFinancialMovement;

    /**
     * @var \App\Entity\Amount
     */
    private $bookingAmount;

    /**
     * @var \App\Entity\Amount
     */
    private $valueAmount;

    /**
     * @var ArrayCollection
     */
    private $financialMouvements;

    /**
     * @return ArrayCollection
     */
    public function getFinancialMouvements(): ArrayCollection
    {
        return $this->financialMouvements;
    }

    /**
     * @param  ArrayCollection $financialMouvements
     * @return Wallet
     */
    public function setFinancialMouvements(ArrayCollection $financialMouvements): Wallet
    {
        $this->financialMouvements = $financialMouvements;
        return $this;
    }

    public function __construct()
    {
        $this->financialMouvements = new ArrayCollection();
    }
    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param  null|string $id
     * @return Wallet
     */
    public function setId(?string $id): Wallet
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param  null|string $tag
     * @return Wallet
     */
    public function setTag(?string $tag): Wallet
    {
        $this->tag = $tag;
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
     * @return Wallet
     */
    public function setCurrency(?string $currency): Wallet
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateLastFinancialMovement(): ?\DateTime
    {
        return $this->dateLastFinancialMovement;
    }

    /**
     * @param  \DateTime|null $dateLastFinancialMovement
     * @return Wallet
     */
    public function setDateLastFinancialMovement(?\DateTime $dateLastFinancialMovement): Wallet
    {
        $this->dateLastFinancialMovement = $dateLastFinancialMovement;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getBookingAmount(): Amount
    {
        return $this->bookingAmount;
    }

    /**
     * @param  Amount $bookingAmount
     * @return Wallet
     */
    public function setBookingAmount(Amount $bookingAmount): Wallet
    {
        $this->bookingAmount = $bookingAmount;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getValueAmount(): Amount
    {
        return $this->valueAmount;
    }

    /**
     * @param  Amount $valueAmount
     * @return Wallet
     */
    public function setValueAmount(Amount $valueAmount): Wallet
    {
        $this->valueAmount = $valueAmount;
        return $this;
    }

    /**
     * @param  FinancialMovements $financialMovement
     * @return Wallet
     */
    public function addFinancialMouvements(FinancialMovements $financialMovement): self
    {
        if (!$this->financialMouvements->contains($financialMovement)) {
            $this->financialMouvements[] = $financialMovement;
        }
        return $this;
    }

    /**
     * @param  FinancialMovements $financialMovement
     * @return Wallet
     */
    public function removeFinancialMouvements(FinancialMovements $financialMovement): self
    {
        if ($this->financialMouvements->contains($financialMovement)) {
            $this->financialMouvements->removeElement($financialMovement);
        }
        return $this;
    }
}
