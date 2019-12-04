<?php
namespace Sm\Themecore\Block\Html;

class Breadcrumbs extends \Magento\Theme\Block\Html\Breadcrumbs
{
    public function getCrumbs()
    {
        return $this->_crumbs;
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
}
?>