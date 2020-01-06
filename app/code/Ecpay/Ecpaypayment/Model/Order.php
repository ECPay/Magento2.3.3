<?php

namespace Ecpay\Ecpaypayment\Model;

use Magento\Checkout\Model\Session as CheckoutSession;

class Order
{
    /**
     * Order comment - Notification
     */
    const NOTIFY_CREATE_ORDER_RESULT = true;

    const NOTIFY_PAYMENT_RESULT = true;

    const NOTIFY_SIMULATE_PAID = false;

    const NOTIFY_GET_CODE_RESULT = true;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $_order;

    public function __construct(
        CheckoutSession $checkoutSession
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_order = $checkoutSession->getLastRealOrder();
    }

    public function getAdditionalInformation()
    {
        return $this->_order->getPayment()->getAdditionalInformation();
    }

    public function getLastRealOrder()
    {
        return $this->_checkoutSession->getLastRealOrder();
    }

    public function getOrder($orderId)
    {
        return $this->_order->loadByIncrementId($orderId);
    }

    public function getOrderId()
    {
        return $this->_checkoutSession->getLastRealOrderId();
    }

    public function getOrderState($statusCode)
    {
        switch ($statusCode) {
            case 'pending':
                return \Magento\Sales\Model\Order::STATE_NEW;
            default:
                return $statusCode;
        }
    }

    public function emailCommentSender($order, $comment)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $emailCommentSender = $objectManager->create('\Magento\Sales\Model\Order\Email\Sender\OrderCommentSender');
        $emailCommentSender->send($order, true, $comment);
    }
}