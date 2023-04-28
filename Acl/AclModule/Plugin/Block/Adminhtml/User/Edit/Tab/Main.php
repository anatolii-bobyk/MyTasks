<?php

namespace Acl\AclModule\Plugin\Block\Adminhtml\User\Edit\Tab;

use Closure;
use Magento\Framework\Registry;
use Magento\User\Model\User;

class Main
{
    /** @var Registry */
    protected $_coreRegistry;

    /**
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->_coreRegistry = $registry;
    }

    /**
     * Get form HTML
     *
     * @return string
     */
    public function aroundGetFormHtml(
        \Magento\User\Block\User\Edit\Tab\Main $subject,
        Closure                                $proceed
    )
    {
        /** @var $model User */
        $model = $this->_coreRegistry->registry('permissions_user');

        $form = $subject->getForm();
        if (is_object($form)) {
            $fieldset = $form->addFieldset('group_custom_fieldset', ['legend' => __('My Custom Group Acl')]);
            $fieldset->addField(
                'group_custom',
                'text',
                [
                    'name' => 'group_custom',
                    'label' => __('Group'),
                    'id' => 'group_custom',
                    'title' => __('group_custom'),
                    'required' => false,
                    'note' => 'Group '
                ]
            );
            $form->addValues(
                [
                    'group_custom' => $model->getData('group_custom'),
                ]
            );
            $subject->setForm($form);
        }
        return $proceed();
    }
}

