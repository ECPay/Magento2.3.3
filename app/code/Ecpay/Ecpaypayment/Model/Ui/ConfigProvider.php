<?php

namespace Ecpay\Ecpaypayment\Model\Ui;

use Ecpay\Ecpaypayment\Helper\Data as EcpayHelper;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Payment\Helper\Data as PaymentHelper;

/**
 * Class ConfigProvider
 */
final class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'ecpay_ecpaypayment';

    /**
     * @var MethodInterface
     */
    protected $_method;

    /**
     * @var PaymentHelper
     */
    private $_ecpayHelper;

    public function __construct(
        EcpayHelper $ecpayHelper,
        PaymentHelper $paymentHelper
    ) {
        $this->_ecpayHelper = $ecpayHelper;
        $this->_method = $paymentHelper->getMethodInstance(self::CODE);
    }

    public function getValidPayments()
    {
        $msg = $this->isPaymentAvailable();

        if (!empty($msg)) {
            $list = $msg;
        } else {
            $payments = $this->_ecpayHelper->getEcpayConfig('payment_methods');
            $trimed   = trim($payments);
            $list     = explode(',', $trimed);
        }

        return $list;
    }

    public function isPaymentAvailable()
    {
        $msg = [];
        $result = $this->_ecpayHelper->isPaymentAvailable();

        switch ($result) {
            case 1:
                $msg = ['綠界整合金流僅支援台幣(TWD)結帳，請通知店家設定幣別為台幣'];
                break;
            case 2:
                $msg = ['綠界整合金流僅支援台幣(TWD)結帳，請切換成台幣結帳'];
                break;
            case 3:
                $msg = ['綠界整合金流僅支援台幣(TWD)結帳'];
                break;
            case 4:
                $msg = ['店家尚未選擇付款方式'];
                break;
            case 5:
                $msg = ['請聯絡店家確認「綠界整合金流」設定是否正確'];
                break;
        }

        return $msg;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'payment' => [
                self::CODE => [
                    'isPaymentAvailable'  => empty($this->isPaymentAvailable()) ? true : false,
                    'ecpayPaymentMethods' => $this->getValidPayments(),
                ]
            ]
        ];
    }
}
