<?php

namespace Acl\AclModule\Block\Adminhtml\Order\View;

use Magento\Backend\Block\Template\Context;
use Magento\CatalogInventory\Api\StockConfigurationInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Registry;
use Magento\Backend\Model\Auth\Session;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Acl\AclModule\Model\FilteredData;

use Magento\Sales\Block\Adminhtml\Order\View\Items as DefaultItems;

/**
 * Adminhtml order items grid
 *
 * @api
 * @since 100.0.2
 */
class Items extends DefaultItems
{
    /**
     * @var Session
     */
    protected $authSession;
    /**
     * @var CollectionFactory
     */
    protected $productCollection;
    /**
     * @var FilteredData
     */
    protected $filteredData;

    /**
     * @param FilteredData $filteredData
     * @param CollectionFactory $collectionFactory
     * @param Session $authSession
     * @param Context $context
     * @param StockRegistryInterface $stockRegistry
     * @param StockConfigurationInterface $stockConfiguration
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        FilteredData                $filteredData,
        CollectionFactory           $collectionFactory,
        Session                     $authSession,
        Context                     $context,
        StockRegistryInterface      $stockRegistry,
        StockConfigurationInterface $stockConfiguration,
        Registry                    $registry,
        array                       $data = []
    )
    {
        $this->filteredData = $filteredData;
        $this->productCollection = $collectionFactory;
        $this->authSession = $authSession;
        parent::__construct(
            $context,
            $stockRegistry,
            $stockConfiguration,
            $registry,
            $data
        );
    }

    /**
     * @return array|\Magento\Sales\Model\ResourceModel\Order\Item\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getItemsCollection()
    {
        $created_by_id = $this->filteredData->getAuthUserId();
        $userGroup = $this->filteredData->getAuthUserGroup();
        $productIdsArray = $this->filteredData->getFilteredProductIdsArray($created_by_id);

        if ($userGroup !== 'dealer') {
            $items = $this->getOrder()->getAllItems();
            $filteredItems = [];
            foreach ($items as $item) {
                if (in_array($item->getProductId(), $productIdsArray)) {
                    $filteredItems[] = $item;
                }
            }
            return $filteredItems;
        }

        return parent::getItemsCollection();
    }
}
