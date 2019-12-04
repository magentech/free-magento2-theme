<?php

namespace Sm\Magetheme\Model\Import;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory as BlockCollectionFactory;
use Magento\Cms\Model\BlockFactory as BlockFactory;
use Magento\Cms\Model\ResourceModel\Block as BlockResourceBlock;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;
use Magento\Cms\Model\PageFactory as PageFactory;
use Magento\Cms\Model\ResourceModel\Page as PageResourceBlock;

class Cms
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    protected $_storeManager;
    
    private $_importPath; 
    
    protected $_parser;
    
    protected $_blockCollectionFactory;

    protected $_blockRepository;
    
    protected $_blockFactory;
    
    protected $_pageCollectionFactory;

    protected $_pageRepository;
    
    protected $_pageFactory;
    
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        BlockCollectionFactory $blockCollectionFactory,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        BlockFactory $blockFactory,
        PageCollectionFactory $pageCollectionFactory,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        PageFactory $pageFactory
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_blockCollectionFactory = $blockCollectionFactory;
        $this->_blockFactory = $blockFactory;
        $this->_blockRepository = $blockRepository;
        $this->_pageCollectionFactory = $pageCollectionFactory;
        $this->_pageFactory = $pageFactory;
        $this->_pageRepository = $pageRepository;
        $this->_importPath = BP . '/app/code/Sm/Magetheme/etc/import/';
        $this->_parser = new \Magento\Framework\Xml\Parser();
    }

    public function importCms($type)
    {
        // Default response
        $gatewayResponse = new DataObject([
            'is_valid' => false,
            'import_path' => '',
            'request_success' => false,
            'request_message' => __('Error during Import CMS Sample Datas.'),
        ]);

        try {
            $xmlPath = $this->_importPath . $type . '.xml';
            $overwrite = false;
            
            if($this->_scopeConfig->getValue("magetheme/theme_install/overwrite_".$type)) {
                $overwrite = true;
            }
            
            if (!is_readable($xmlPath))
            {
                throw new \Exception(
                    __("Can't get the data file for import cms blocks/pages: ".$xmlPath)
                );
            }
            $data = $this->_parser->load($xmlPath)->xmlToArray();
            $cms_collection = null;
            $conflictingOldItems = array();
            
            $i = 0;
            foreach($data['root'][$type]['cms_item'] as $_item) {
                $exist = false;
                if($type == "blocks") {
                    $cms_collection = $this->_blockCollectionFactory->create()->addFieldToFilter('identifier', $_item['identifier']);
                    if(count($cms_collection) > 0)
                        $exist = true;
                    
                }else {
                    $cms_collection = $this->_pageCollectionFactory->create()->addFieldToFilter('identifier', $_item['identifier']);
                    if(count($cms_collection) > 0)
                        $exist = true;
                    
                }
                if($overwrite) {
                    if($exist) {
                        $conflictingOldItems[] = $_item['identifier'];
                        if($type == "blocks")
                            $this->_blockRepository->deleteById($_item['identifier']);
                        else
                            $this->_pageRepository->deleteById($_item['identifier']);
                    }
                } else {
                    if($exist) {
                        $conflictingOldItems[] = $_item['identifier'];
                        continue;
                    }
                }
                $_item['stores'] = [0];
                if($type == "blocks") {
                    $this->_blockFactory->create()->setData($_item)->save();
                } else {
                    $this->_pageFactory->create()->setData($_item)->save();
                }
                $i++;
            }
            $message = "";
            if ($i)
                $message = $i." item(s) was(were) imported.";
            else
                $message = "No items were imported.";
            
            $gatewayResponse->setIsValid(true);
            $gatewayResponse->setRequestSuccess(true);

            if ($gatewayResponse->getIsValid()) {
                if ($overwrite){
                    if($conflictingOldItems){
                        $message .= "Items (".count($conflictingOldItems).") with the following identifiers were overwritten:<br/>".implode(', ', $conflictingOldItems);
                    }
                } else {
                    if($conflictingOldItems){
                        $message .= "<br/>Unable to import items (".count($conflictingOldItems).") with the following identifiers (they already exist in the database):<br/>".implode(', ', $conflictingOldItems);
                    }
                }
            }
            $gatewayResponse->setRequestMessage(__($message));
        } catch (\Exception $exception) {
            $gatewayResponse->setIsValid(false);
            $gatewayResponse->setRequestMessage($exception->getMessage());
        }

        return $gatewayResponse;
    }
}
