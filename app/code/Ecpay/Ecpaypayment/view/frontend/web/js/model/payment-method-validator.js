define(
    [
        'jquery',
        'mage/translate',
        'Magento_Ui/js/model/messageList',
        'Magento_Checkout/js/model/quote'
    ],
    function ($, $t, messageList, quote) {
        'use strict';
        return {
            validate: function () {

                let isValid = true;
                const paymentMethod = quote.paymentMethod().method;

                const dataForm = $('#ecpay_payment_form');
                const choosenPayment = dataForm.find('select[name="ecpay_choosen_payment"]').val();
                const paymentMethods = window.checkoutConfig.payment.ecpay_ecpaypayment.ecpayPaymentMethods;

                if (paymentMethod === 'ecpay_ecpaypayment') {
                    if (paymentMethods.indexOf(choosenPayment) === -1) {
                        isValid = false;
                    }
                }

                if (!isValid) {
                    messageList.addErrorMessage({ message: $t('Invalid payment method.') });
                }

                return isValid;
            }
        }
    }
);