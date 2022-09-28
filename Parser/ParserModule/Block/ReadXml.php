<?php

namespace Parser\ParserModule\Block;

use Magento\Framework\Convert\Xml;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Xml\Parser;
use SimpleXMLElement;
use Parser\ParserModule\Model\NewsFactory;
use Parser\ParserModule\Model\ResourceModel\News\CollectionFactory;

class ReadXml extends Template
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var Parser
     */
    protected $convertXml;
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var NewsFactory
     */
    private $newsFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Parser $parser
     * @param Xml $convertXml
     * @param Context $context
     * @param NewsFactory $newsFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Parser            $parser,
        Xml               $convertXml,
        Context           $context,
        NewsFactory       $newsFactory,
        CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->newsFactory = $newsFactory;
        $this->parser = $parser;
        $this->convertXml = $convertXml;
        parent::__construct($context);
    }

    /**
     * Read xml data from URL and convert it into array by using xmlToAssoc method of \Magento\Framework\Convert\Xml Class
     * @return array
     */
    public function readXmlData()
    {
        $filePath = "https://rss.unian.net/site/news_ukr.rss";
        $fileContent = file_get_contents($filePath);
        $xml = new SimpleXMLElement($fileContent);
        $xmlToArray = $this->convertXml->xmlToAssoc($xml);
        return $xmlToArray;
    }

    /**
     * Get parsed array from xml file's URL
     * @return array
     */
    public function readXmlDataByParser()
    {
        $filePath = "https://rss.unian.net/site/news_ukr.rss";
        $parsedArray = $this->parser->load($filePath)->xmlToArray();

        $news = $parsedArray['rss']['_value']['channel']['item'];

        foreach ($news as $new) {
            $title = $new['title'];
            $description = $new['description'];
            $url = $new['link'];
            $guid = $new['guid']['_value'];
            $image = '';
            if (isset($new['enclosure']) && isset($new['enclosure']['_attribute']) && isset($new['enclosure']['_attribute']['url'])) {
                $image = $new['enclosure']['_attribute']['url'];
            }

            if (!$this->checkGuid($guid)) {
//                $this->newsFactory->create()->setData($new)->save();
                $this->newsFactory->create()
                    ->setTitle($this->translit($title))
                    ->setDescription($description)
                    ->setImage($image)
                    ->setLink($url)
                    ->setGuid($guid)
                    ->save();
            }

//            echo $guid . "</br>";
//            echo $title . "</br>";
//            echo $description . "</br>";
//            echo $url . "</br>";
//            echo '<b>' . $image . "</b></br>";
//            echo $this->checkGuid("guid 1") . "</br>";
//            echo "************************************************" . "</br>";


        }

    }

    public function checkGuid($guid)
    {
        $collection = $this->newsFactory->create()->getCollection()
            ->addFieldToSelect("*")
            ->addFieldToFilter("guid", $guid)
            ->load();

        return $collection->getData();
    }

    public function translit($text)
    {
        if (function_exists('transliterator_transliterate')) {
            $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
        }
        $text = str_replace(' ', '-', $text);
        $from_replace = '--';
        $to_replace = '-';
        while (strpos($text, $from_replace) > 0) {
            $text = str_replace($from_replace, $to_replace, $text);
        }
        $text = preg_replace('/[^A-Za-z0-9\-]/', '', $text);
        return $text;
    }

}
