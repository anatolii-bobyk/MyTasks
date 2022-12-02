<?php

namespace Salesforce\SalesforceModule\Model;

use Salesforce\SalesforceModule\Helper\Request;

class Product
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
     * @param $productName
     * @param $productSku
     * @return bool|string
     */
    public function createProduct($sessionId, $productName, $productSku)
    {
        $requestBody = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:enterprise.soap.sforce.com" xmlns:urn1="urn:sobject.enterprise.soap.sforce.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <soapenv:Header>
    <urn:SessionHeader>' .
            "<urn:sessionId>$sessionId</urn:sessionId>" .
            '</urn:SessionHeader>
  </soapenv:Header>
  <soapenv:Body>
    <urn:create>
      <urn:sObjects xsi:type="urn1:Product2">' .
            "<Name>$productName</Name>
       <ProductCode>$productSku</ProductCode>" .
            '</urn:sObjects>
    </urn:create>
  </soapenv:Body>
</soapenv:Envelope>';

        return $this->helper->createRequest($this->requestUrl, $requestBody, $this->Cookie);

    }

    /**
     * @param $sessionId
     * @param $productName
     * @param $productSku
     * @return mixed
     */
    public function getProductId($sessionId, $productName, $productSku)
    {
        $xmlParser = xml_parser_create();

        xml_parse_into_struct($xmlParser, $this->createProduct($sessionId, $productName, $productSku), $value, $index);

        return $value[13]['value'];
    }

    /**
     * @param $sessionId
     * @param $productId
     * @param $unitPrice
     * @return bool|string
     */
    public function createFirstTimePriceBookEntry($sessionId, $productId, $unitPrice)
    {
        $requestBody = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:enterprise.soap.sforce.com" xmlns:urn1="urn:sobject.enterprise.soap.sforce.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <soapenv:Header>
    <urn:SessionHeader>' .
            "<urn:sessionId>$sessionId</urn:sessionId>" .
            '</urn:SessionHeader>
  </soapenv:Header>
  <soapenv:Body>
    <urn:create>
      <urn:sObjects xsi:type="urn1:PriceBookEntry">
       <PriceBook2Id>01s7Q00000DXMEaQAP</PriceBook2Id>' .
            "<Product2Id>$productId</Product2Id>
       <IsActive>true</IsActive>
       <UnitPrice>$unitPrice</UnitPrice>" .
            '</urn:sObjects>
    </urn:create>
  </soapenv:Body>
</soapenv:Envelope>';

        return $this->helper->createRequest($this->requestUrl, $requestBody, $this->Cookie);
    }

    /**
     * @param $sessionId
     * @param $productId
     * @param $unitPrice
     * @return bool|string
     */
    public function createSecondTimePriceBookEntry($sessionId, $productId, $unitPrice)
    {
        $requestBody = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:enterprise.soap.sforce.com" xmlns:urn1="urn:sobject.enterprise.soap.sforce.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <soapenv:Header>
    <urn:SessionHeader>' .
            "<urn:sessionId>$sessionId</urn:sessionId>" .
            '</urn:SessionHeader>
  </soapenv:Header>
  <soapenv:Body>
    <urn:create>
      <urn:sObjects xsi:type="urn1:PriceBookEntry">
       <PriceBook2Id>01s7Q00000DXMEZQA5</PriceBook2Id>' .
            "<Product2Id>$productId</Product2Id>
        <IsActive>true</IsActive>
       <UnitPrice>$unitPrice</UnitPrice>" .
            '</urn:sObjects>
    </urn:create>
  </soapenv:Body>
</soapenv:Envelope>';

        return $this->helper->createRequest($this->requestUrl, $requestBody, $this->Cookie);

    }

    /**
     * @param $sessionId
     * @param $productId
     * @param $unitPrice
     * @return mixed
     */
    public function getPriceBookEntryId($sessionId, $productId, $unitPrice)
    {
        $this->createFirstTimePriceBookEntry($sessionId, $productId, $unitPrice);

        $xmlParser = xml_parser_create();

        xml_parse_into_struct($xmlParser, $this->createSecondTimePriceBookEntry($sessionId, $productId, $unitPrice), $value, $index);

        return $value[13]['value'];
    }

}
