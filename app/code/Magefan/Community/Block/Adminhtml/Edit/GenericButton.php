<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\Community\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\AuthorizationInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param AuthorizationInterface|null $authorization
     */
    public function __construct(
        Context $context,
        $authorization = null
    ) {
        $this->context = $context;
        $this->authorization = $authorization
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Framework\AuthorizationInterface::class
            );
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getObjectId()
    {
        return $this->context->getRequest()->getParam('id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
