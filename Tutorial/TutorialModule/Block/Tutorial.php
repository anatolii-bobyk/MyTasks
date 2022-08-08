<?php

namespace Tutorial\TutorialModule\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;


class Tutorial extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var \Tutorial\TutorialModule\Helper\Data
     */
    protected $helperData;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param Template\Context $context
     * @param Registry $registry
     * @param \Tutorial\TutorialModule\Helper\Data $helperData
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Template\Context                     $context,
        Registry                             $registry,
        \Tutorial\TutorialModule\Helper\Data $helperData,
        ProductRepositoryInterface           $productRepository,
        array                                $data = []
    )
    {
        $this->productRepository = $productRepository;
        $this->registry = $registry;
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }


    /**
     * @return Product|mixed|null
     * @throws LocalizedException
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('current_product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }
        return $this->product;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->helperData->getMyLabel('upload_image_id');
    }

    /**
     * @param $sku
     * @return string|null
     */
    public function getProductUrlBySku($sku): ?string
    {
        try {
            $productUrl = $this->productRepository->get($sku)
                ->getProductUrl();

        } catch (NoSuchEntityException $noSuchEntityException) {
            $productUrl = null;
        }
        return $productUrl;
    }
}
