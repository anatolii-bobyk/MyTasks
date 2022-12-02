<?php

namespace Salesforce\SalesforceModule\Model;

use Salesforce\SalesforceModule\Helper\Request;

class Contact
{

    /**
     * @var Request
     */
    protected $helper;

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
     * @param $firstName
     * @param $lastName
     * @param $email
     * @return void
     */
    public function createContact($sessionId, $firstName, $lastName, $email)
    {
        $requestUrl = "https://elogic-dev-ed.my.salesforce.com/services/Soap/c/56.0/00D7Q000008O3bm";

        $requestBody = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:enterprise.soap.sforce.com" xmlns:urn1="urn:sobject.enterprise.soap.sforce.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Header>
      <urn:SessionHeader>' .
            "<urn:sessionId>$sessionId</urn:sessionId>" .
            '</urn:SessionHeader>
   </soapenv:Header>
   <soapenv:Body>
      <urn:create>
         <urn:sObjects xsi:type="urn1:Account">' .
            "<Name>$firstName, $lastName, $email</Name>
            <OwnerId>0057Q000004zVDyQAM</OwnerId>" .
            '</urn:sObjects>
      </urn:create>
   </soapenv:Body>
</soapenv:Envelope>';

        $Cookie = "nRYLBmBJEe2lPVfgHHrx2g";

        $this->helper->createRequest($requestUrl, $requestBody, $Cookie);
    }

}
