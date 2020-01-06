<?php
namespace Ecpay\Ecpaypayment\Controller\Payment;

use Ecpay\Ecpaypayment\Helper\Data as EcpayHelper;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;

class Response extends Action implements CsrfAwareActionInterface
{
    protected $_checkoutSession;

    public function __construct(
        Context $context,
        EcpayHelper $ecpayHelper,
        Session $checkoutSession
    ) {
        parent::__construct($context);
        $this->_checkoutSession = $checkoutSession;
        $this->ecpayHelper = $ecpayHelper;
    }

    public function execute()
    {
        try {
            $this->ecpayHelper->getPaymentResult();

            $this->_redirect('checkout/onepage/success');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function createCsrfValidationException(
        RequestInterface $request
    ): ?InvalidRequestException {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
