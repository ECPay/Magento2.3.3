<?php

namespace Ecpay\Ecpaypayment\Controller\Payment;

use Ecpay\Ecpaypayment\Helper\Data as EcpayHelper;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Redirect extends Action
{
    protected $_order;

    public function __construct(
        Context $context,
        EcpayHelper $ecpayHelper
    ) {
        parent::__construct($context);
        $this->ecpayHelper = $ecpayHelper;
    }

    public function execute()
    {
        try {

            $result = $this->ecpayHelper->getRedirectHtml();
            $resultPage = $this->resultRedirectFactory->create();

            if ($result['status'] === 'Failure') {
                $this->messageManager->addErrorMessage($result['msg']);
                $resultPage->setPath('checkout/onepage/failure');
            } else {
                $resultPage->setPath('checkout/onepage/success');
            }

            return $resultPage;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}