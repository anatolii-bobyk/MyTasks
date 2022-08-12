<?php

namespace Autologin\AutologinModule\Controller\Index;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Checkout\Model\SessionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ResponseInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Exception;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;


    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @var Magento\CatalogInventory\Api\StockStateInterface
     */
    protected $stockState;

    /** @var SessionFactory */
    protected $checkoutSession;

    /** @var CartRepositoryInterface */
    protected $cartRepository;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var Json */
    protected $json;

    /** @var Configurable */
    protected $configurableType;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var Product
     */
    protected $_product;

    /**
     * @var bool
     */
    protected bool $notEnoughQty = false;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ProductRepositoryInterface $productRepository
     * @param ProductFactory $productFactory
     * @param Session $session
     * @param Product $product
     * @param StockStateInterface $stockState
     * @param Json $json
     * @param SessionFactory $checkoutSession
     * @param CartRepositoryInterface $cartRepository
     * @param Configurable $configurableType
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Context                    $context,
        PageFactory                $resultPageFactory,
        ProductRepositoryInterface $productRepository,
        ProductFactory             $productFactory,
        Session                    $session,
        Product                    $product,
        StockStateInterface        $stockState,
        Json                       $json,
        SessionFactory             $checkoutSession,
        CartRepositoryInterface    $cartRepository,
        Configurable               $configurableType,
        CustomerFactory            $customerFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->_customerSession = $session;
        $this->_product = $product;
        $this->stockState = $stockState;
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
        $this->json = $json;
        $this->configurableType = $configurableType;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $hash = $this->_request->getParam('hash');

        $products = $this->_request->getParam('products');

        $this->loginCustomerByHash($hash);

        if (!$this->_customerSession->isLoggedIn()) {
            return $this->redirect('/');
        }

        $session = $this->checkoutSession->create();
        $quote = $session->getQuote();

        try {
            $this->addProductsToQuote($products, $quote);
        } catch (Exception $e) {
            return $this->redirect('/');
        }

        if ($this->notEnoughQty) {
            return $this->redirect('/');
        }

        $this->cartRepository->save($quote);
        $session->replaceQuote($quote)->unsLastRealOrderId();

        return $this->redirect('checkout/cart');
    }

    /**
     * @param $path
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function redirect($path)
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($path);
        return $resultRedirect;
    }

    /**
     * @param $productId
     * @return float
     */
    public function getStockQty($productId)
    {
        return $this->stockState->getStockQty($productId);
    }

    /**
     * @param $hash
     * @return mixed
     */
    public function loginCustomerByHash($hash)
    {
        $collection = $this->customerFactory->create()->getCollection()
            ->addAttributeToSelect("*")
            ->addAttributeToFilter("secret_hash", $hash)
            ->load();

        $customerData = $collection->getData();
        $customerId = $customerData[0]['entity_id'] ?? 0;
        $this->_customerSession->loginById($customerId);
    }

    public function addProductsToQuote($products, $quote)
    {
        $getProductsArray = explode('|', $products);

        foreach ($getProductsArray as $item) {
            $getProductFields = explode('_', $item);
            $productSku = $getProductFields[0];
            $productQuantity = $getProductFields[1];

            $existProduct = $this->productRepository->get($productSku);

            $existQty = !empty($existProduct->getId()) ? $this->getStockQty($existProduct->getId()) : 0;

            if ($existProduct && $productQuantity <= $existQty) {
                $quote->addProduct($existProduct, $productQuantity);
            } else {
                return $this->notEnoughQty = true;
            }
        }
    }
}
