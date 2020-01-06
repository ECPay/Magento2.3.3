define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'ecpay_ecpaypayment', // payment_method_code
                component: 'Ecpay_Ecpaypayment/js/view/payment/method-renderer/ecpaypayment' // js_renderer_component
            },
            // other payment method renderers if required
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);