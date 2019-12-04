<?php
/*------------------------------------------------------------------------
# SM Themecore - Version 1.0.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\Themecore\Model\Config\Source;

class ListBodyFont implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'Arial', 'label' => __('Arial')],
			['value' => 'Arial Black', 'label' => __('Arial-black')],
			['value' => 'Courier New', 'label' => __('Courier New')],
			['value' => 'Georgia', 'label' => __('Georgia')],
			['value' => 'Tahoma', 'label' => __('Tahoma')],
			['value' => 'Times New Roman', 'label' => __('Times New Roman')],
			['value' => 'Trebuchet', 'label' => __('Trebuchet')],
			['value' => 'Verdana', 'label' => __('Verdana')],
			['value' => 'google_font', 'label' => __('Google Font')]
		];
	}
}