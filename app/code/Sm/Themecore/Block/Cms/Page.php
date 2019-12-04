<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sm\Themecore\Block\Cms;

/**
 * Cms page content block
 *
 * @api
 * @since 100.0.2
 */
class Page extends \Magento\Cms\Block\Page
{
    protected $_imageBlank = '';
    
	protected function _toHtml()
    {
		$html = $this->_filterProvider->getPageFilter()->filter($this->getPage()->getContent());
		$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$helper_config = $_objectManager->get('Sm\Themecore\Helper\Data');
		$useLazyload = $helper_config->getAdvanced('lazyload_group/enable_ladyloading'); /*add config Lazyload*/
		if ($useLazyload && !empty($html)) {
			$storeManager = $_objectManager->get('Magento\Store\Model\StoreManagerInterface');
			$currentStore = $storeManager->getStore();
			$mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
			$this->_imageBlank = $mediaUrl.'lazyloading/blank.png';
			$html = $this->_usedLazyLoad($html);
		}
		return $html;
    }
	
	private function _usedLazyLoad($html){
		return  preg_replace_callback('/<img(.*?)src=\"(.*?)\"(.*?)>/i', [$this, '_replaceCallback'], $html); 
	}	
	
	private function _replaceCallback($m)
    {
		preg_match_all("/<[^>]*class=\"(.*?)lazyload\"[^>]*>/i", $m[0], $matchLazy, PREG_SET_ORDER);
		preg_match_all("/<[^>]*class=\"(.*?)mark-lazy(.*?)\"[^>]*>/i", $m[0], $matchLazyCon, PREG_SET_ORDER);
		if(isset($m[0]) && empty($matchLazy) && !empty($matchLazyCon)) {
			foreach($m as $k => $n){
				if($k > 0 && isset($m[$k]) && strpos($m[$k],'mark-lazy')) {
					$classReplace = preg_replace("/class=\"(.*?)\"/i", 'class="$1 lazyload"', $m[$k]);
					$alt = isset($m[3]) && !empty($m[3]) && strpos($m[3],'alt=') ? $m[3] : '';
					return '<img '.$classReplace.' src="'.$this->_imageBlank.'" data-src="'.$m[2].'" '.$alt.'>';
				}
			}
		}else{
			return $m[0];
		}
    }
}
