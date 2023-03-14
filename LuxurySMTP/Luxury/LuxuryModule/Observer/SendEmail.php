<?php

namespace Luxury\LuxuryModule\Observer;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;

class SendEmail implements ObserverInterface
{
    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param RequestInterface $request
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        RequestInterface            $request,
        CustomerFactory             $customerFactory,
        TransportBuilder            $transportBuilder,
        StoreManagerInterface       $storeManager,
        StateInterface              $state
    )
    {
        $this->_request = $request;
        $this->customerRepository = $customerRepository;
        $this->_customerFactory = $customerFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws InputException
     * @throws LocalizedException
     * @throws InputMismatchException
     */
    public function execute(Observer $observer)
    {
        $luxury_tax = $observer->getEvent()->getLuxuryTax();

        $luxury_tax_group = $luxury_tax['customer_group'];

        $this->sendEmail($luxury_tax, $luxury_tax_group);
    }

    public function getCustomerCollection()
    {
        $collection = $this->_customerFactory->create()->getCollection()
            ->addAttributeToSelect("*")
            ->load();
        return $collection;
    }

    public function getEmailBody($luxury_tax)
    {
        $message = ' ';

        foreach ($luxury_tax as $key => $value) {
            $message .= $key . ":" . $value . "\n";
        }
        return $message;
    }

    public function sendEmail($luxury_tax, $luxury_tax_group)
    {
        $customers = $this->getCustomerCollection();

        if ($customers && count($customers) > 0) {
            foreach ($customers as $customer) {
                $customerGroup = $customer->getGroupId();
                if ($customerGroup == $luxury_tax_group) {

                    $customerEmail = $customer->getEmail();

                    $templateOptions = array('area' => Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId());
                    $templateVars = array(
                        'store' => $this->storeManager->getStore(),
                        'customer_name' => 'John Doe',
//                        'message' => implode(",", $luxury_tax)
                        'message' => $this->getEmailBody($luxury_tax)
                    );
                    $from = array('email' => "anatolii.bobyk@gmail.com", 'name' => 'Anatolii Bobyk');
                    $this->inlineTranslation->suspend();
                    $to = array($customerEmail);
                    $transport = $this->_transportBuilder->setTemplateIdentifier('hello_template')
                        ->setTemplateOptions($templateOptions)
                        ->setTemplateVars($templateVars)
                        ->setFrom($from)
                        ->addTo($to)
                        ->getTransport();
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                }
            }
        }
    }
}





