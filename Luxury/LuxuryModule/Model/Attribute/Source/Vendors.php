<?php

namespace Luxury\LuxuryModule\Model\Attribute\Source;

use Luxury\LuxuryModule\Model\ItemRepository;

class Vendors extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var array
     */
    protected $_options = [];

    /**
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [];
        foreach ($this->itemRepository->getAllItems() as $item) {
            $this->_options[] =

                [
                    'label' => __($item->getName()),
                    'value' => __($item->getCustomerGroup())
                ];
        }
        return $this->_options;
    }
}
