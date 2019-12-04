<?php
/*------------------------------------------------------------------------
# SM Filter Products - Version 1.4.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\FilterProducts\Model\Config\Source;

class TypeShow implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value'=>'simple', 'label'=>__('Simple')],
			['value'=>'slide', 'label'=>__('Slide')]
		];
	}
}