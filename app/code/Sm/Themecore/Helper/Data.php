<?php
/*------------------------------------------------------------------------
# SM Themecore
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Helper;

use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    public function __construct(
        StoreManagerInterface $storeManagerInterface,
        \Magento\Framework\App\Helper\Context $context
    )
    {
        $this->_storeManager = $storeManagerInterface;
        parent::__construct($context);
    }

    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getGeneral($name, $storeCode = null)
    {
        return $this->scopeConfig->getValue(
            'themecore/general/' . $name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }

    public function getLayout($name, $storeCode = null)
    {
        return $this->scopeConfig->getValue(
            'themecore/theme_layout/' . $name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }

    public function getListingLayout($name, $storeCode = null)
    {
        return $this->scopeConfig->getValue(
            'themecore/product_listing/' . $name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }

    public function getProductDetail($name, $storeCode = null)
    {
        return $this->scopeConfig->getValue(
            'themecore/product_detail/' . $name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }

    public function getAdvanced($name, $storeCode = null)
    {
        return $this->scopeConfig->getValue(
            'themecore/advanced/' . $name,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }

    /**
     * @param $hexCode
     * @param $adjustPercent
     * @param   float $adjustPercent A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
     * @return string
     */
    function adjustBrightness($hexCode, $adjustPercent)
    {
        $hexCode = ltrim($hexCode, '#');

        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }

        $hexCode = array_map('hexdec', str_split($hexCode, 2));

        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount    = ceil($adjustableLimit * $adjustPercent);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return implode($hexCode);
    }

    public function getLabelProduct($_product)
    {
        $newLabelText    = __('New');
        $saleLabelText   = __('Sale');
        $showNewLabel    = $this->scopeConfig->getValue('themecore/advanced/product_group/show_newlabel', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $showSaleLabel   = $this->scopeConfig->getValue('themecore/advanced/product_group/show_salelabel', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $showSalePercent = $this->scopeConfig->getValue('themecore/advanced/product_group/show_discount', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $product_label = "";
        $labelProduct  = "";
        if ($showNewLabel) {
            $now      = date("Y-m-d");
            $newsFrom = substr($_product->getData('news_from_date'), 0, 10);
            $newsTo   = substr($_product->getData('news_to_date'), 0, 10);

            if ($newsTo != '' || $newsFrom != '') {
                if (($newsTo != '' && $newsFrom != '' && $now >= $newsFrom && $now <= $newsTo) || ($newsTo == '' && $now >= $newsFrom) || ($newsFrom == '' && $now <= $newsTo)) {
                    $product_label .= '<div class="product-label new-label">' . $newLabelText . '</div>';
                }
            }
        }

        if ($showSaleLabel) {
            $defaultPrice = $_product->getPrice();
            $finalPrice   = $_product->getFinalPrice();

            if ($finalPrice < $defaultPrice) {
                if ($showSalePercent) {
                    $save_percent  = 100 - round(($finalPrice / $defaultPrice) * 100);
                    $product_label .= '<div class="product-label sale-label">' . '-' . $save_percent . '%' . '</div>';
                } else {
                    $product_label .= '<div class="product-label sale-label">' . $saleLabelText . '</div>';
                }
            }
        }

        if ($product_label)
            $labelProduct = '<div class="product-labels">' . $product_label . '</div>';


        return $labelProduct;
    }
}