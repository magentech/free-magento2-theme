<?php

namespace Sm\Magetheme\Block;

class Header extends \Magento\Framework\View\Element\Template
{
    protected $_logo;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        array $data = []
    )
    {
        $this->_logo = $logo;
        parent::__construct($context, $data);
    }


    /**
     * @return string
     */
    public function getLogoAlt()
    {
        return $this->_logo->getLogoAlt();
    }
}
