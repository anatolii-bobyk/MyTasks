<?php

namespace News\NewsModule\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use News\NewsModule\Model\ItemFactory;
use Magento\Framework\Console\Cli;

class AddItem extends Command
{
    const INPUT_KEY_TITLE = 'title';
    const INPUT_KEY_DESCRIPTION = 'description';
    const INPUT_KEY_IMAGE = 'image';

    private $itemFactory;

    public function __construct(ItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('news:item:add')
            ->addArgument(
                self::INPUT_KEY_TITLE,
                InputArgument::REQUIRED,
                'News title'
            )->addArgument(
                self::INPUT_KEY_DESCRIPTION,
                InputArgument::OPTIONAL,
                'News description'
            )->addArgument(
                self::INPUT_KEY_IMAGE,
                InputArgument::OPTIONAL,
                'News image'
            );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $this->itemFactory->create();
        $item->setTitle($input->getArgument(self::INPUT_KEY_TITLE));
        $item->setDescription($input->getArgument(self::INPUT_KEY_DESCRIPTION));
        $item->setImage($input->getArgument(self::INPUT_KEY_IMAGE));
        $item->setIsObjectNew(true);
        $item->save();
        return Cli::RETURN_SUCCESS;
    }

}

