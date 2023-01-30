<?php
//
//namespace OrderList\OrderListModule\Controller\Index;
//
//use Magento\Framework\App\Action\Action;
//use Magento\Framework\App\Action\Context;
//use Magento\Framework\View\Result\PageFactory;
//use Magento\Sales\Api\OrderRepositoryInterface;
//
//class Index extends Action
//{
//
//    /** @var PageFactory */
//    protected $resultPageFactory;
//    protected $_orderCollectionFactory;
//    protected $orderRepository;
//    protected $data;
//
//
//    public function __construct(
//        Context                  $context,
//        OrderRepositoryInterface $orderRepository,
//        array                    $data = []
//    )
//    {
//        $this->orderRepository = $orderRepository;
//        $this->data = $data;
//
//        parent::__construct($context);
//    }
//
//    public function execute()
//    {
//        $orderid = 2; // it called increment id
//        $order = $this->orderRepository->get($orderid);
//        $object['order_info'] = $order->getData();
//        $object['payment_info'] = $order->getPayment()->getData();
//        $object['shipping_info'] = $order->getShippingAddress()->getData();
//        $object['billing_info'] = $order->getBillingAddress()->getData();
//        $object['incrementid'] = $order->getIncrementId();
//        $object['grandtotal'] = $order->getGrandTotal();
//        $object['subtotal'] = $order->getSubtotal();
//        $object['customerid'] = $order->getCustomerId();
//        $object['customeremail'] = $order->getCustomerEmail();
//        $object['customerfirstname'] = $order->getCustomerFirstname();
//        $object['customerlastname'] = $order->getCustomerLastname();
//
////        print_r($object);
//        var_dump($object);
//// print_r(json_decode(json_encode($object), true));
//
//        die();
//
//    }
//
//}


namespace OrderList\OrderListModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\ResourceModel\Quote;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;

class Index extends Action
{

    /**
     * @var FilterBuilder
     */
    public $_filterBuilder;
    protected $resultPageFactory;
    protected $orderRepository;
    protected $data;
    private $order;
    protected $quoteFactory;

    protected $quoteModel;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;


    public function __construct(
        Context                  $context,
        OrderRepositoryInterface $orderRepository,
        Order                    $order,
        SearchCriteriaBuilder    $searchCriteriaBuilder,
        FilterBuilder            $filterBuilder,
        QuoteFactory             $quoteFactory,
        Quote                    $quoteModel,
        array                    $data = []
    )
    {
        $this->orderRepository = $orderRepository;
        $this->data = $data;
        $this->order = $order;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->quoteFactory = $quoteFactory;
        $this->quoteModel=$quoteModel;
        parent::__construct($context);
    }

    public function execute()
    {
//        var_dump($this->test());
//        var_dump($this->test2());
//        var_dump($this->test3()[0]->getData());
        var_dump($this->test4());
    }

    public function test()
    {
        $order = $this->order->getCollection()->addAttributeToFilter('customer_id', 1);
        $data = [];
        $i = 0;
        foreach ($order as $orderDetails) {
            $data[$i]['increment_id'] = $orderDetails->getIncrementId();
            $data[$i]['created_at'] = $orderDetails->getCreatedAt();
//            $data[$i]['ship_to'] = $this->getShipTo($orderDetails->getId());
            $data[$i]['grand_total'] = $orderDetails->getGrandTotal();
            $data[$i]['status'] = $orderDetails->getStatus();
            $data[$i]['id'] = $orderDetails->getId();
            $i++;
        }
        return $data;
    }

    public function test2()
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('customer_id', 1, 'eq')->create();
        $orders = $this->orderRepository->getList($searchCriteria);
        return $orders;
    }

    public function test3()
    {
        $filters = [
            $this->_filterBuilder->setField('customer_id')->setValue(3)->create()
        ];
        $searchCriteria = $this->searchCriteriaBuilder->addFilters($filters)->create();
//            $searchCriteria->setCurrentPage($this->_request->getParam('page', 1));
//            $searchCriteria->setPageSize($this->_request->getParam('show', 20));
        $customerOrders[] = $this->orderRepository->getList($searchCriteria);

        return $customerOrders;
    }

    public function test4()
    {
        $quote = $this->quoteFactory->create()->loadByCustomer(1);
        $items = $quote->getAllItems();
        $data = [];
        foreach ($items as $item) {
            $itemData = $item->getData();
            $data[] = $itemData;
        }
        return $data;
    }

}
