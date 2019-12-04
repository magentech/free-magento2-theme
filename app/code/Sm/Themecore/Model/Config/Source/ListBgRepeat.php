<?php
/*------------------------------------------------------------------------
# SM Themecore - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Model\Config\Source;

class ListBgRepeat implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'repeat', 'label' => __('Repeat')],
			['value' => 'repeat-x', 'label' => __('Repeat X')],
			['value' => 'repeat-y', 'label' => __('Repeat Y')],
			['value' => 'no-repeat', 'label' => __('No Repeat')],
		];
	}
}