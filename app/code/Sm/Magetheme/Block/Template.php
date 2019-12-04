<?php

namespace Sm\Magetheme\Block;

class Template extends \Magento\Framework\View\Element\Template
{
    public $_coreRegistry;
    protected $_logo;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->_logo         = $logo;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $page          = $objectManager->get('Magento\Framework\View\Page\Config');
        $helper_config = $objectManager->get('Sm\Magetheme\Helper\Data');
        $headerStyle   = $helper_config->getThemeLayout('header_style');
        $productStyle  = $helper_config->getThemeLayout('product_style');
        $footerStyle   = $helper_config->getThemeLayout('footer_style');
        $rtlLayout     = $helper_config->getThemeLayout('direction_rtl');

        $this->pageConfig->addBodyClass($headerStyle . '-style');
        $this->pageConfig->addBodyClass($productStyle . '-style');
        $this->pageConfig->addBodyClass($footerStyle . '-style');

        if ($rtlLayout) {
            $extRtl = "_rtl";
            $page->addPageAsset('css/bootstrap_rtl.css');
            $this->pageConfig->addBodyClass('rtl-layout');
        } else {
            $extRtl = "";
        }

        $headerCss    = 'css/' . $headerStyle . $extRtl . '.css';
        $footerCss    = 'css/' . $footerStyle . $extRtl . '.css';
        $productCss   = 'css/' . $productStyle . $extRtl . '.css';
        $pageThemeCss = 'css/pages-theme' . $extRtl . '.css';

        $page->addPageAsset($headerCss);
        $page->addPageAsset($productCss);
        $page->addPageAsset($pageThemeCss);
        $page->addPageAsset($footerCss);

        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getLogoAlt()
    {
        return $this->_logo->getLogoAlt();
    }
}
