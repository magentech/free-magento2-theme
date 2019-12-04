<?php

namespace Sm\Themecore\Model\Config\Source;

class Columns implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('1 Column')],
            ['value' => '2', 'label' => __('2 Columns')],
            ['value' => '3', 'label' => __('3 Columns')],
            ['value' => '4', 'label' => __('4 Columns')],
            ['value' => '5', 'label' => __('5 Columns')],
            ['value' => '6', 'label' => __('6 Columns')],
            ['value' => '7', 'label' => __('7 Columns')],
            ['value' => '8', 'label' => __('8 Columns')],
        ];
    }
}