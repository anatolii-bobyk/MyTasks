<?php

namespace Webkul\ProductFileAttribute\Block;

use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Popup extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    protected $storeManager;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param Template\Context $context
     * @param Registry $registry
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Template\Context           $context,
        Registry                   $registry,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface      $storeManager,
        Filesystem                 $filesystem,
        array                      $data = []
    )
    {
        $this->productRepository = $productRepository;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->_filesystem = $filesystem;
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

    public function getMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'catalog/product/file/';
    }

}
