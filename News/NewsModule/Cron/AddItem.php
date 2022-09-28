<?php

namespace News\NewsModule\Cron;

use News\NewsModule\Model\ItemFactory;
use News\NewsModule\Model\Config;

class AddItem
{
    private $itemFactory;

    private $config;

    public function __construct(ItemFactory $itemFactory, Config $config)
    {
        $this->itemFactory = $itemFactory;
        $this->config = $config;
    }

    public function execute()
    {
        if ($this->config->isEnabled()) {
            $this->itemFactory->create()
                ->setTitle('Scheduled item')
                ->setDescription('Created at ' . time())
                ->save();
        }
    }
}
