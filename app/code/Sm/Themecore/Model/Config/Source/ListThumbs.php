<?php
/*------------------------------------------------------------------------
# SM Themecore - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Model\Config\Source;

class ListThumbs implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'horizontal', 'label' => __('Horizontal')],
			['value' => 'vertical', 'label' => __('Vertical')],
			['value' => 'dots', 'label' => __('Dots')],
		];
	}
}

