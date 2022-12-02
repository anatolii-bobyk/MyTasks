<?php

namespace Salesforce\SalesforceModule\Model;

class OrderItem
{
    /**
     * @var
     */
    private $priceBookEntryId;
    /**
     * @var
     */
    private $price;
    /**
     * @var
     */
    private $quantity;

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getPriceBookEntryId()
    {
        return $this->priceBookEntryId;
    }

    /**
     * @param mixed $priceBookEntryId
     */
    public function setPriceBookEntryId($priceBookEntryId): void
    {
        $this->priceBookEntryId = $priceBookEntryId;
    }
}
