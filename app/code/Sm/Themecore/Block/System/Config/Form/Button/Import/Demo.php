<?php
/*------------------------------------------------------------------------
# SM Themecore
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Block\System\Config\Form\Button\Import;

class Demo extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Button Label
     *
     * @var string
     */
    protected $_buttonLabel = 'Import';

    protected $_actionUrl;
    
    protected $_demoVersion;
    
    /**
     * Set Button Label
     *
     * @param string $buttonLabel
     * @return \Sm\Themecore\Block\System\Config\Form\Button\Import\Cms
     */
    public function setButtonLabel($buttonLabel)
    {
        $this->_buttonLabel = $buttonLabel;
        return $this;
    }

    /**
     * Get Action Url
     *
     * @return string
     */
    public function getActionUrl()
    {
        return $this->_actionUrl;
    }

    /**
     * Set Validate VAT Button Label
     *
     * @param string $vatButtonLabel
     * @return \Sm\Themecore\Block\System\Config\Form\Button\Import\Cms
     */
    public function setActionUrl($actionUrl)
    {
        $this->_actionUrl = $actionUrl;
        return $this;
    }
    
    /**
     * Get Import Type
     *
     * @return string
     */
    public function getDemoVersion()
    {
        return $this->_demoVersion;
    }

    /**
     * Set Validate VAT Button Label
     *
     * @param string $vatButtonLabel
     * @return \Sm\Themecore\Block\System\Config\Form\Button\Import\Cms
     */
    public function setDemoVersion($demoVersion)
    {
        $this->_demoVersion = $demoVersion;
        return $this;
    }
    
    /**
     * Set template to itself
     *
     * @return \Sm\Themecore\Block\System\Config\Form\Button\Import\Cms
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/demo_button.phtml');
        }
        return $this;
    }

    /**
     * Unset some non-related element parameters
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $buttonLabel = !empty($originalData['button_label']) ? $originalData['button_label'] : $this->_buttonLabel;
        $action = !empty($originalData['action_url']) ? $originalData['action_url'] : '';
        if($action) {
            $this->setActionUrl($action);
        }
        $demo_version = !empty($originalData['demo_version']) ? $originalData['demo_version'] : '';
        if($demo_version) {
            $this->setDemoVersion($demo_version);
        }
        $this->addData(
            [
                'button_label' => __($buttonLabel),
                'demo_version' => $demo_version,
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $this->_urlBuilder->getUrl($action),
            ]
        );

        return $this->_toHtml();
    }
}
