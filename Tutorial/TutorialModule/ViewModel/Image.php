<?php

namespace Tutorial\TutorialModule\ViewModel;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;


class Image implements ArgumentInterface
{

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var \Tutorial\TutorialModule\Helper\Data
     */
    protected $helperData;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param \Tutorial\TutorialModule\Helper\Data $helperData
     * @param Registry $registry
     */
    public function __construct(
        \Tutorial\TutorialModule\Helper\Data $helperData,
        Registry                             $registry

    )
    {
        $this->helperData = $helperData;
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->helperData->getMyLabel('upload_image_id');

    }

    /**
     * @return Product|mixed|null
     * @throws LocalizedException
     * //     */

}
