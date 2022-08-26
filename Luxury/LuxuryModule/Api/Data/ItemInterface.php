<?php

namespace Luxury\LuxuryModule\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ItemInterface extends ExtensibleDataInterface
{
    const ENTITY_ID = 'id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @return mixed
     */
    public function getConditionAmount();

    /**
     * @return mixed
     */
    public function getTaxRate();

}
