<?php
/*------------------------------------------------------------------------
# SM Filter Products - Version 1.4.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\FilterProducts\Model\Config\Source;

class TypeFilter implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
	{
		return [
			['value' => 'featured_products', 'label' => __('Featured Products')],
			['value' => 'best_sellers', 'label' => __('Best Sellers')],
			['value' => 'lastest_products', 'label' => __('New Products')],
			['value' => 'special_products', 'label' => __('Special Products')],
			['value' => 'viewed_products', 'label' => __('Most Viewed')],
			['value' => 'other_products', 'label' => __('Products in Category')],
			['value' => 'countdown_products', 'label' => __('Countdown Products ')]
		];
	}
}