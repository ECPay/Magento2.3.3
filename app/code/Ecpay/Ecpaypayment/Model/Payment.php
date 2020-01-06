<?php

namespace Ecpay\Ecpaypayment\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Payment\Helper\Data as MagentoPaymentHelper;
use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Payment\Model\Method\Logger;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Store\Model\StoreManagerInterface;

class Payment extends AbstractMethod
{
    protected $_code  = 'ecpay_ecpaypayment';

    protected $_formBlockType = 'Magento\Payment\Block\Form';
    protected $_infoBlockType = 'Magento\Payment\Block\Info\Instructions';

    protected $_isGateway                   = true;
    protected $_isInitializeNeeded          = true;
    protected $_canOrder                    = true;
    protected $_canAuthorize                = true;
    protected $_canCapture                  = true;
    protected $_canRefundInvoicePartial     = true;
    protected $_canVoid                     = true;
    protected $_canUseInternal              = false;
    protected $_canFetchTransactionInfo     = true;

    protected $_order;
    protected $_scopeConfig;
    protected $_storeManager;
    protected $_urlBuilder;

    private $prefix = 'ecpay_';
    private $libraryList = array('ECPayPaymentHelper.php');

    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        MagentoPaymentHelper $paymentData,
        ScopeConfigInterface $scopeConfig,
        Logger $logger,
        StoreManagerInterface $storeManager,
        UrlInterface $urlInterface,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );
        $this->_urlInterface = $urlInterface;
        $this->_storeManager = $storeManager;
    }

    public function getValidPayments()
    {
        $payments = $this->getEcpayConfig('payment_methods', true);

        if (empty($payments)) {
            return [];
        }

        $trimed = trim($payments);
        return explode(',', $trimed);
    }

    public function isValidPayment($choosenPayment)
    {
        $payments = $this->getValidPayments();
        return (in_array($choosenPayment, $payments));
    }

    public function isPaymentAvailable(CartInterface $quote = null)
    {
        $result = 0;
        $baseCurrencyCode = $this->_storeManager->getStore()->getBaseCurrencyCode();
        $currentCurrencyCode = $this->_storeManager->getStore()->getCurrentCurrencyCode();

        if ($this->checkModuleSetting() === false) {
            return 5;
        }

        if (empty($this->getValidPayments())) {
            return 4;
        }

        if ($baseCurrencyCode !== 'TWD') {
            $result += 1;
        }

        if ($currentCurrencyCode !== 'TWD') {
            $result += 2;
        }

        return $result;
    }

    public function getEcpayConfig($id)
    {
        return $this->getMagentoConfig($this->prefix . $id);
    }

    public function getMagentoConfig($id)
    {
        return $this->getConfigData($id);
    }

    public function getHelper() {
        $merchant_id = $this->getEcpayConfig('merchant_id');
        $helper = new \ECPayPaymentHelper();
        $helper->setMerchantId($merchant_id);
        return $helper;
    }

    public function getModuleUrl($action = '')
    {
        if ($action !== '') {
            $route = $this->_code . '/payment/' . $action;
        } else {
            $route = '';
        }
        return $this->getMagentoUrl($route);
    }

    public function getMagentoUrl($route)
    {
        return $this->_urlInterface->getUrl($route);
    }

    public function checkModuleSetting()
    {
        $merchantId = $this->getEcpayConfig('merchant_id');
        $hashKey = $this->getEcpayConfig('hash_key');
        $hashIv = $this->getEcpayConfig('hash_iv');

        if (empty($merchantId) || empty($hashKey) || empty($hashIv)) {
            return false;
        }
        return true;
    }
}