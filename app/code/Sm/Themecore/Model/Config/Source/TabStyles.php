<?php
/*------------------------------------------------------------------------
# SM Themecore - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Model\Config\Source;

class TabStyles implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'default', 'label' => __('Horizontal')],
			['value' => 'vertical', 'label' => __('Vertical')],
			['value' => 'accordion', 'label' => __('Accordion')],
		];
	}
}

