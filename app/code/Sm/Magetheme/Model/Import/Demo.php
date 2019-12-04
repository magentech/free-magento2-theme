<?php

namespace Sm\Magetheme\Model\Import;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;

class Demo
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    protected $_storeManager;
    protected $_parser;
    protected $_configFactory;
    protected $_objectManager;
    private $_importPath;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $configFactory
    )
    {
        $this->_scopeConfig   = $scopeConfig;
        $this->_storeManager  = $storeManager;
        $this->_configFactory = $configFactory;
        $this->_objectManager = $objectManager;
        $this->_importPath    = BP . '/app/code/Sm/Magetheme/etc/import/';
        $this->_parser        = new \Magento\Framework\Xml\Parser();
    }

    public function importDemo($demo_version, $store = NULL, $website = NULL)
    {
        // Default response
        $gatewayResponse = new DataObject([
            'is_valid' => false,
            'import_path' => '',
            'request_success' => false,
            'request_message' => __('Error during Import ' . $demo_version . '.'),
        ]);

        try {
            $xmlPath   = $this->_importPath . $demo_version . '.xml';
            $overwrite = true;

            if (!is_readable($xmlPath)) {
                throw new \Exception(
                    __("Can't get the data file for import " . $demo_version . ": " . $xmlPath)
                );
            }
            $data     = $this->_parser->load($xmlPath)->xmlToArray();
            $scope    = "default";
            $scope_id = 0;
            if ($store && $store > 0) // store level
            {
                $scope    = "stores";
                $scope_id = $store;
            } elseif ($website && $website > 0) // website level
            {
                $scope    = "websites";
                $scope_id = $website;
            }
            foreach ($data['root']['config'] as $b_name => $b) {
                foreach ($b as $c_name => $c) {
                    foreach ($c as $d_name => $d) {
                        if (is_array($d) && !empty($d)) {
                            foreach ($d as $e => $f) {
                                $this->_configFactory->saveConfig($b_name . '/' . $c_name . '/' . $d_name . '/' . $e, $f, $scope, $scope_id);
                            }
                        } else {
                            $this->_configFactory->saveConfig($b_name . '/' . $c_name . '/' . $d_name, $d, $scope, $scope_id);
                        }
                    }
                }
            }
            //$gatewayResponse->setData("import_path",$config);

            $gatewayResponse->setIsValid(true);
            $gatewayResponse->setRequestSuccess(true);

            if ($gatewayResponse->getIsValid()) {
                $gatewayResponse->setRequestMessage(__('Success to Import ' . $demo_version . '.'));
            } else {
                $gatewayResponse->setRequestMessage(__('Error during Import ' . $demo_version . '.'));
            }
        } catch (\Exception $exception) {
            $gatewayResponse->setIsValid(false);
            $gatewayResponse->setRequestMessage($exception->getMessage());
        }

        return $gatewayResponse;
    }
}
