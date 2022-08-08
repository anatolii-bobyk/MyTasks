<?php

namespace Tutorial\TutorialModule\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\State;

class CreateMyProducts implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * Module data setup variable
     *
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * Product factory variable
     *
     * @var ProductFactory $product
     */
    private $product;

    /**
     * State variable
     *
     * @var State $state
     */
    private $state;

    /**
     * constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ProductFactory $product
     * @param State $state
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ProductFactory           $product,
        State                    $state
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->product = $product;
        $this->state = $state;
    }

    /**
     * Apply function
     *
     * @return void
     */
    public function apply(): void
    {
        $this->state->setAreaCode('frontend');

        for ($i = 1; $i <= 2; $i++) {
            $myProduct = $this->product->create();
            $myProduct->setStatus(1);
            $myProduct->setAttributeSetId(4);
            $myProduct->setTypeId('simple');
            $myProduct->setTaxClassId(0);
            $myProduct->setPrice(120);
            $myProduct->setVisibility(4);
            $myProduct->setStockData(
                array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 100
                )
            );

            if ($i == 1) {
                $myProduct->setSku('My Tutorial');
                $myProduct->setName('My Tutorial');
            } else {
                $myProduct->setSku('Study Plan');
                $myProduct->setName('My Study Plan');
            }
            $myProduct->save();
        }
    }

    /**
     * revert function
     *
     * @return void
     */
    public function revert(): void
    {

    }

    /**
     * getDependencies function
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * getAliases function
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}

?>