<?php
namespace Sm\Themecore\Model\Cssconfig;

class Generator
{
    protected $_messageManager;
    protected $_cssconfigData;
    protected $_coreRegistry;
    protected $_storeManager;
    protected $_layoutManager;
    
    public function __construct(
        \Sm\Themecore\Helper\Cssconfig $cssconfigData,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layoutManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->_cssconfigData = $cssconfigData;
        $this->_coreRegistry = $coreRegistry;
        $this->_storeManager = $storeManager;
        $this->_layoutManager = $layoutManager;
        $this->_messageManager = $messageManager;
    }
    
    public function generateCss($type, $websiteId, $storeId){
        if(!$websiteId && !$storeId) {
            $websites = $this->_storeManager->getWebsites(false, false);
            foreach ($websites as $id => $value) {
                $this->generateWebsiteCss($type, $id);
            }
        } else {
            if($storeId) {
                $this->generateStoreCss($type, $storeId);
            } else {
                $this->generateWebsiteCss($type, $websiteId);
            }
        }        
    }
    
    protected function generateWebsiteCss($type, $websiteId) {
        $website = $this->_storeManager->getWebsite($websiteId);
        foreach($website->getStoreIds() as $storeId){
            $this->generateStoreCss($type, $storeId);
        }
    }
    protected function generateStoreCss($type, $storeId) {
        $store = $this->_storeManager->getStore($storeId);
        if(!$store->isActive())
            return;
        $storeCode = $store->getCode();
        $str1 = '_'.$storeCode;
        $str2 = $type.$str1.'.css';
        $str3 = $this->_cssconfigData->getCssConfigDir().$str2;
        $str4 = 'themecore/css/'.$type.'.phtml';
        $this->_coreRegistry->register('cssgen_store', $storeCode);
        try {
            $block = $this->_layoutManager->createBlock('Sm\Themecore\Block\Template')->setData('area','frontend')->setTemplate($str4)->toHtml();
            if(!file_exists($this->_cssconfigData->getCssConfigDir())) {
                @mkdir($this->_cssconfigData->getCssConfigDir(), 0777);
            }
            $file = @fopen($str3,"w+");
            @flock($file, LOCK_EX);
            @fwrite($file,$block);
            @flock($file, LOCK_UN);
            @fclose($file);
            if(empty($block)) {
                throw new \Exception( __("Template file is empty or doesn't exist: ".$str4) );
            }
        } catch (\Exception $e) {
            $this->_messageManager->addError(__('Failed generating CSS file: '.$str2.' in '.$this->_cssconfigData->getCssConfigDir()).'<br/>Message: '.$e->getMessage());
        }
        $this->_coreRegistry->unregister('cssgen_store');
    }
}
