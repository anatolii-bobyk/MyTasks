<?php

namespace Luxury\LuxuryModule\Model\Attribute\Source;

use Luxury\LuxuryModule\Model\ItemRepository;

class Vendors extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    private $itemRepository;

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
        foreach ($this->itemRepository->getList() as $item) {
            $this->_options[] =
                [
                    'label' => __($item->getName()),
                    'value' => __($item->getId())
                ];
        }
        return $this->_options;
    }
}
