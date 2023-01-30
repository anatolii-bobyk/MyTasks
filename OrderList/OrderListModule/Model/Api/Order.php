<?php

namespace OrderList\OrderListModule\Model\Api;

use Exception;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use OrderList\OrderListModule\Api\OrderInterface;

class Order implements OrderInterface
{
    /** @var PageFactory */
    protected $resultPageFactory;
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    public $_searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    public $_filterBuilder;

    /**
     * @var QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;


    /**
     * @param PageFactory $resultPageFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param QuoteFactory $quoteFactory
     * @param CartRepositoryInterface $cartRepository
     * @param array $data
     */
    public function __construct(
        PageFactory              $resultPageFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder    $searchCriteriaBuilder,
        FilterBuilder            $filterBuilder,
        QuoteFactory             $quoteFactory,
        CartRepositoryInterface  $cartRepository,
        array                    $data = []
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->orderRepository = $orderRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->quoteFactory = $quoteFactory;
        $this->cartRepository = $cartRepository;

    }


    /**
     * @param $orderid
     * @return array
     */
    public function getOrderById($orderid)
    {
        $response = ['success' => false];

        try {
            $order = $this->orderRepository->get($orderid);
            $object['order_info'] = $order->getData();
            $object['payment_info'] = $order->getPayment()->getData();
            $object['shipping_info'] = $order->getShippingAddress()->getData();
            $object['billing_info'] = $order->getBillingAddress()->getData();
            $resul = array();
            foreach ($order->getAllItems() as $item) {
//fetch whole item information
                $resul = $item->getData();

            }
            $object['items'] = $resul;

// $response = json_decode(json_encode($object), true);
            $response = $object;

        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];

        }

        return $response;
    }

    /**
     * @param $customerId
     * @return array|bool|null
     */
    public function getCustomerOrders($customerId)
    {
        $filters = [
            $this->_filterBuilder->setField('customer_id')->setValue($customerId)->create()
        ];
        $searchCriteria = $this->_searchCriteriaBuilder->addFilters($filters)->create();
        $customerOrders[] = $this->orderRepository->getList($searchCriteria);

        return $customerOrders[0]->getData();

    }

    /**
     * @param $customerId
     * @return array
     */
    public function getCustomerCart($customerId)
    {
        $quote = $this->quoteFactory->create()->loadByCustomer($customerId);
//        $quote = $this->cartRepository->getForCustomer($customerId);
        $items = $quote->getAllItems();
//        $items = $quote->getItems();
        $data = [];
        foreach ($items as $item) {
            $itemData = $item->getData();
            $data[] = $itemData;
        }
        return $data;
    }
}
