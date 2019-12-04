<?php

namespace Sm\Themecore\Block;

class Template extends \Magento\Framework\View\Element\Template
{
    public $_coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper_config = $objectManager->get('Sm\Themecore\Helper\Data');

        $enableBoxedLayout     = $helper_config->getLayout('use_boxed_layout');
        $enableNewsletterPopup = $helper_config->getAdvanced('newsletter_group/show_newsletter_popup');
        $enableLadyloading     = $helper_config->getAdvanced('lazyload_group/enable_ladyloading');
        $enableStickyMenu      = $helper_config->getGeneral('navigation_group/menu_ontop');

        if ($enableBoxedLayout) {
            $this->pageConfig->addBodyClass('layout-boxed');
        }

        if ($enableNewsletterPopup) {
            $this->pageConfig->addBodyClass('enable-newsletter-popup');
        }

        if ($enableLadyloading) {
            $this->pageConfig->addBodyClass('enable-ladyloading');
        }

        if ($enableStickyMenu) {
            $this->pageConfig->addBodyClass('enable-stickymenu');
        }

        return parent::_prepareLayout();
    }
}
