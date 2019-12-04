<?php
/*------------------------------------------------------------------------
# SM Filter Products - Version 1.4.0
# Copyright (c) 2016 YouTech Company. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: YouTech Company
# Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

namespace Sm\FilterProducts\Model\Config\Source;

use \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class ListCategory implements \Magento\Framework\Option\ArrayInterface
{
	protected $_categoryCollectionFactory;

	public function __construct(\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $objectManager)
	{
		$this->_categoryCollectionFactory = $objectManager;
	}

	public function toOptionArray()
	{
		$collection = $this->_categoryCollectionFactory->create();
		$collection->addAttributeToSelect('name')
			->addPathFilter('^1/[0-9/]+')
			->addIsActiveFilter()
			->load();

		$options = [];
		$cats = [];

		foreach ($collection as $category) {
			$c = new \stdClass();
			$c->label = $category->getName();
			$c->value = $category->getId();
			$c->level = $category->getLevel();
			$c->parentid = $category->getParentId();
			$cats[$c->value] = $c;
		}

		foreach ($cats as $id => $c) {
			if (isset($cats[$c->parentid])) {
				if (!isset($cats[$c->parentid]->child)) {
					$cats[$c->parentid]->child = array();
				}
				$cats[$c->parentid]->child[] =& $cats[$id];
			}
		}
		foreach ($cats as $id => $c) {
			if (!isset($cats[$c->parentid])) {
				$stack = array($cats[$id]);
				while (count($stack) > 0) {
					$opt = array_pop($stack);
					$option = array(
						'label' => ($opt->level > 1 ? str_repeat('- - ', $opt->level - 1) : '') . $opt->label,
						'value' => $opt->value
					);
					array_push($options, $option);
					if (isset($opt->child) && count($opt->child)) {
						foreach (array_reverse($opt->child) as $child) {
							array_push($stack, $child);
						}
					}
				}
			}
		}
		unset($cats);
		return $options;
	}
}