<?php
/**
 * FinancialMovements entity
 * It is a class that includes all the properties of a FinancialMovements
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

/**
 * Class FinancialMovements
 *
 * @category Entity
 * @package  App\Entity
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class FinancialMovements
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $bookingDate;

    /**
     * @var \DateTime
     */
    private $valueDate;

    /**
     * @var \App\Wallet
     */
    private $wallet;

    /**
     * @var Amount
     */
    private $amount;

    /**
     * @var string
     */
    private $description;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param  null|string $id
     * @return FinancialMovements
     */
    public function setId(?string $id): FinancialMovements
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBookingDate(): \DateTime
    {
        return $this->bookingDate;
    }

    /**
     * @param  \DateTime $bookingDate
     * @return FinancialMovements
     */
    public function setBookingDate(\DateTime $bookingDate): FinancialMovements
    {
        $this->bookingDate = $bookingDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValueDate(): \DateTime
    {
        return $this->valueDate;
    }

    /**
     * @param  \DateTime $valueDate
     * @return FinancialMovements
     */
    public function setValueDate(\DateTime $valueDate): FinancialMovements
    {
        $this->valueDate = $valueDate;
        return $this;
    }

    /**
     * @return \App\Wallet
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * @param  \App\Wallet $wallet
     * @return FinancialMovements
     */
    public function setWallet(?Wallet $wallet): FinancialMovements
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * @param  Amount $amount
     * @return FinancialMovements
     */
    public function setAmount(Amount $amount): FinancialMovements
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string $description
     * @return FinancialMovements
     */
    public function setDescription(string $description): FinancialMovements
    {
        $this->description = $description;
        return $this;
    }
}
