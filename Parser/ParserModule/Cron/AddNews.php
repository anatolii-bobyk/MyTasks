<?php

namespace Parser\ParserModule\Cron;

use \Psr\Log\LoggerInterface;
use Parser\ParserModule\Model\NewsFactory;
use Parser\ParserModule\Block\ReadXml;


class AddNews
{

    /**
     * @var NewsFactory
     */
    private $newsFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     * @param NewsFactory $newsFactory
     */
    public function __construct(LoggerInterface $logger, NewsFactory $newsFactory)
    {
        $this->logger = $logger;
        $this->newsFactory = $newsFactory;
    }

    /**
     * Write to system.log
     *
     * @return void
     */

    public function execute()
    {
        $this->newsFactory->create()
            ->setTitle('cron title')
            ->setDescription('cron description')
            ->setImage('cron image')
            ->setUrl('cron url')
            ->save();

    }

}
