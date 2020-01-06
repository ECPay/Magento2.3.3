<?php

namespace Ecpay\Ecpaypayment\Controller\Payment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class PaymentController extends Action
{
    protected $_order;

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        try {

        } catch (\Exception $e) {
            $this->exceptionLogger->logException($e);
            throw $e;
        }
    }
}