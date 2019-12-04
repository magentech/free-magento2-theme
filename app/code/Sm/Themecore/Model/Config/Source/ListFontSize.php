<?php
/*------------------------------------------------------------------------
# SM Themecore - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Model\Config\Source;

class ListFontSize implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => '10px', 'label' => __('10px')],
			['value' => '11px', 'label' => __('11px')],
			['value' => '12px', 'label' => __('12px')],
			['value' => '13px', 'label' => __('13px')],
			['value' => '14px', 'label' => __('14px')],
			['value' => '15px', 'label' => __('15px')],
			['value' => '16px', 'label' => __('16px')],
			['value' => '17px', 'label' => __('17px')],
			['value' => '18px', 'label' => __('18px')],
			['value' => '19px', 'label' => __('19px')],
			['value' => '20px', 'label' => __('20px')],
		];
	}
}