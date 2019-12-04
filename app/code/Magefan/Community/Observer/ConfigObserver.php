<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\Community\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magefan\Community\Model\SectionFactory;
use Magefan\Community\Model\Section\Info;
use Magento\Framework\Message\ManagerInterface;

/**
 * Community observer
 */
class ConfigObserver implements ObserverInterface
{
    /**
     * @var SectionFactory
     */
    private $sectionFactory;

    /**
     * @var Info
     */
    private $info;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * ConfigObserver constructor.
     * @param SectionFactory $sectionFactory
     * @param Info $info
     * @param ManagerInterface $messageManager
     */
    final public function __construct(
        SectionFactory $sectionFactory,
        Info $info,
        ManagerInterface $messageManager
    ) {
        $this->sectionFactory = $sectionFactory;
        $this->info = $info;
        $this->messageManager = $messageManager;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    final public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        $groups = $request->getParam('groups');
        if (empty($groups['general']['fields']['enabled']['value'])) {
            return;
        }

        $key = isset($groups['general']['fields']['key']['value'])
            ? $groups['general']['fields']['key']['value']
            : null;

        $section = $this->sectionFactory->create([
            'name' => $request->getParam('section'),
            'key' => $key
        ]);

        if (!$section->getModule()) {
            return;
        }

        $data = $this->info->load([$section]);

        if (!$section->validate($data)) {
            $groups['general']['fields']['enabled']['value'] = 0;
            $request->setPostValue('groups', $groups);

            $this->messageManager->addError(
                implode(array_reverse(
                    [
                        '.','d','e','l','b','a','s','i','d',' ','y','l','l','a','c','i','t','a','m',
                        'o','t','u','a',' ','n','e','e','b',' ','s','a','h',' ','n','o','i','s','n',
                        'e','t','x','e',' ','e','h','T',' ','.','d','i','l','a','v','n','i',' ','r',
                        'o',' ','y','t','p','m','e',' ','s','i',' ','y','e','K',' ','t','c','u','d',
                        'o','r','P'
                    ]
                ))
            );
        }
    }
}
