<?php

namespace Ecpay\Ecpaypayment\Model\Config\Source;

class PaymentMethods
{
    public function toOptionArray()
    {
        // 後台多選格式
        return array(
            array('value' => 'credit', 'label' => '信用卡(一次付清)'),
            array('value' => 'credit_3', 'label' => '信用卡(3期)'),
            array('value' => 'credit_6', 'label' => '信用卡(6期)'),
            array('value' => 'credit_12', 'label' => '信用卡(12期)'),
            array('value' => 'credit_18', 'label' => '信用卡(18期)'),
            array('value' => 'credit_24', 'label' => '信用卡(24期)'),
            array('value' => 'webatm', 'label' => '網路ATM'),
            array('value' => 'atm', 'label' => 'ATM'),
            array('value' => 'barcode', 'label' => '超商條碼'),
            array('value' => 'cvs', 'label' => '超商代碼'),
        );
    }
}