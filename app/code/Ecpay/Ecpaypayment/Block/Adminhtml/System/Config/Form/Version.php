<?php

namespace Ecpay\Ecpaypayment\Block\Adminhtml\System\Config\Form;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Ecpay\Ecpaypayment\Helper\Data as EcpayHelper;

class Version extends Field
{
    /**
     * @var EcpayHelper
     */
    private $ecpayHelper;

    /**
     * Version constructor.
     * @param EcpayHelper $ecpayHelper
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        EcpayHelper $ecpayHelper,
        array $data = []
    ) {
        $this->ecpayHelper = $ecpayHelper;
        parent::__construct($context, $data);
    }

    /**
     * Render element value
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $version = $this->ecpayHelper->getModuleVersion();
        if (!$version) {
            $version = '--';
        }
        $output = '<div style="background-color:#eee;padding:1em;border:1px solid #ddd;">';
        $output .= 'Module version : ' . $version;
        $output .= "</div>";
        return $output;
    }
}
