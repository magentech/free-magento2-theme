<?php

namespace Sm\Themecore\Controller\Adminhtml\System\Config\Cms;

use Magento\Framework\Controller\Result\JsonFactory;

class Import extends \Sm\Themecore\Controller\Adminhtml\System\Config\Cms
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Check whether vat is valid
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->_import();

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData([
            'valid' => (int)$result->getIsValid(),
            'import_path' => $result->getImportPath(),
            'message' => $result->getRequestMessage(),
        ]);
    }
}
