<?php

namespace Salesforce\SalesforceModule\Model;

use Salesforce\SalesforceModule\Helper\Request;

class Order
{
    /**
     * @var Request
     */
    protected $helper;

    /**
     * @var string
     */
    protected $requestUrl = "https://elogic-dev-ed.my.salesforce.com/services/Soap/c/50.0/00D7Q000008O3bm";

    /**
     * @var string
     */
    protected $Cookie = "nRYLBmBJEe2lPVfgHHrx2g";

    /**
     * @param Request $helper
     */
    public function __construct(
        Request $helper
    )
    {
        $this->helper = $helper;
    }

    /**
     * @param $sessionId
     * @param $description
     * @param $billingCity
     * @param $billingCountry
     * @param $shippingCity
     * @return bool|string
     */
    public function createEmptyOrder($sessionId, $description, $billingCity, $billingCountry, $shippingCity)
    {
        $requestBody = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:enterprise.soap.sforce.com" xmlns:urn1="urn:sobject.enterprise.soap.sforce.com">
   <soapenv:Header>
      <urn:SessionHeader>' .
            "<urn:sessionId>$sessionId</urn:sessionId>" .
            '</urn:SessionHeader>
   </soapenv:Header>
   <soapenv:Body>
      <urn:create>
		<urn1:sObjects xsi:type="Order" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
        <EffectiveDate>2022-11-11</EffectiveDate>' .
            "<Status>Draft</Status>
  <billingCity>$billingCity</billingCity>
  <accountId>0017Q00000gqPnoQAE</accountId>
  <billingCountry>$billingCountry</billingCountry>
<ShippingCity>$shippingCity</ShippingCity>
<Description>$description</Description>" .
            '<Pricebook2Id>01s7Q00000DXMEZQA5</Pricebook2Id>
         </urn1:sObjects>
      </urn:create>
   </soapenv:Body>
</soapenv:Envelope>';

        return $this->helper->createRequest($this->requestUrl, $requestBody, $this->Cookie);
    }

    /**
     * @param $sessionId
     * @param $description
     * @param $billingCity
     * @param $billingCountry
     * @param $shippingCity
     * @return mixed
     */
    public function getEmptyOrderId($sessionId, $description, $billingCity, $billingCountry, $shippingCity)
    {
        $xmlParser = xml_parser_create();

        xml_parse_into_struct($xmlParser, $this->createEmptyOrder($sessionId, $description, $billingCity, $billingCountry, $shippingCity), $value, $index);

        return $value[13]['value'];
    }

    /**
     * @param $sessionId
     * @param $orderId
     * @param $quantity
     * @param $unitPrice
     * @param $priceBookEntryId
     * @return void
     */
    public function createOrderItem($sessionId, $orderId, $quantity, $unitPrice, $priceBookEntryId)
    {
        $requestBody = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:enterprise.soap.sforce.com" xmlns:urn1="urn:sobject.enterprise.soap.sforce.com">
   <soapenv:Header>
      <urn:SessionHeader>' .
            "<urn:sessionId>$sessionId</urn:sessionId>" .
            '</urn:SessionHeader>
   </soapenv:Header>
   <soapenv:Body>
      <urn:create>
         <urn1:sObjects xsi:type="OrderItem" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' .
            "<PricebookEntryId>$priceBookEntryId</PricebookEntryId>
  <quantity>$quantity</quantity>
  <UnitPrice>$unitPrice</UnitPrice>
               <OrderId>$orderId</OrderId>
         </urn1:sObjects>" .
            '</urn:create>
   </soapenv:Body>
</soapenv:Envelope>';

        $this->helper->createRequest($this->requestUrl, $requestBody, $this->Cookie);
    }

}
