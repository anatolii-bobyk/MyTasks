<?php

declare(strict_types=1);

namespace Widget\WidgetModule\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Information extends Template implements BlockInterface
{
    protected $_template = 'widget/information.phtml';
}
