define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Ecpay_Ecpaypayment/js/model/payment-method-validator'
    ],
    function (Component, additionalValidators, paymentMethodValidator) {
        'use strict';
        additionalValidators.registerValidator(paymentMethodValidator);
        return Component.extend({});
    }
);