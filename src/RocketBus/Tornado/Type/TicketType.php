<?php

namespace RocketBus\Tornado\Type;

use InvalidArgumentException;

/**
 * Class TicketType
 * @package RocketBus\Tornado\Type
 */
class TicketType
{
    const PERCENTAGE    = 'P';
    const DECIMAL       = 'D';
    const FIX           = 'F';

    /**
     * @var array
     */
    public static $discountTypes = [
        self::PERCENTAGE,
        self::DECIMAL,
        self::FIX
    ];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var float
     */
    protected $discount;

    /**
     * @var string
     */
    protected $discountType;

    /**
     * @param string $discountType
     */
    public function setDiscountType($discountType)
    {
        if (!in_array(strtoupper($discountType), self::$discountTypes)) {
            $message = sprintf(
                'Invalid discount type. The allowed types are %s',
                implode(', ', self::$discountTypes)
            );

            throw new InvalidArgumentException($message);
        }

        $this->discountType = strtoupper($discountType);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return string
     */
    public function getDiscountType()
    {
        return $this->discountType;
    }

    /**
     * @return bool
     */
    public function isPercentage()
    {
        return self::PERCENTAGE === $this->discountType;
    }

    /**
     * @return bool
     */
    public function isDecimal()
    {
        return self::DECIMAL === $this->discountType;
    }

    /**
     * @return bool
     */
    public function isFix()
    {
        return self::FIX === $this->discountType;
    }

    public function getSeatPrice($ticketPrice)
    {
        $seatPrice = 0;
        if ($this->isPercentage()) {
            $seatPrice = $ticketPrice -($ticketPrice * $this->getDiscount()/100);
        } elseif ($this->isDecimal()) {
            $seatPrice = $ticketPrice - $this->getDiscount();
        } elseif ($this->isFix()) {
            $seatPrice =  $this->getDiscount();
        }

        return $seatPrice;
    }
}
