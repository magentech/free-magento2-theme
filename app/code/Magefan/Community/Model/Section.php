<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\Community\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Section
 * @package Magefan\Community\Model
 */
final class Section
{
    const MODULE = 'mfmodule';

    const ENABLED = 'enabled';

    const KEY = 'key';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * Section constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param null $name
     * @param null $key
     */
    final public function __construct(
        ScopeConfigInterface $scopeConfig,
        $name = null,
        $key = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * @return bool
     */
    final public function isEnabled()
    {
        return (bool) $this->getConfig(self::ENABLED);
    }

    /**
     * @return string
     */
    final public function getModule()
    {
        return (string) $this->getConfig(self::MODULE);
    }

    /**
     * @return string
     */
    final public function getKey()
    {
        if (null !== $this->key) {
            return $this->key;
        } else {
            return $this->getConfig(self::KEY);
        }
    }

    /**
     * @return string
     */
    final public function getName()
    {
        return (string) $this->name;
    }

    /**
     * @param $data
     * @param null $k
     * @return bool
     */
    final public function validate($data)
    {
        if (isset($data[$this->getModule()])) {
            return !empty($data[$this->getModule()]);
        }

        $id = $this->getModule();
        $k = $this->getKey();

        $l = substr($id, 1, 1);
        $d = (string) strlen($id);
        return (strpos($k, $l, 5) == 5)
            && (strpos($k, $d, 19) == 19)
            && (strlen($k) >= '3' . '2');
    }

    /**
     * @param string $field
     * @return mixed
     */
    final private function getConfig($field)
    {
        $g = 'general';
        return $this->scopeConfig->getValue(
            implode('/', [$this->name, $g, $field]),
            ScopeInterface::SCOPE_STORE,
            0
        );
    }
}
