/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config:
        {
            mixins: {
                'Magento_Checkout/js/model/payment-service':
                    {'OnePageCheckout_OnePageCheckoutModule/js/mixin/payment-service-mixin': true}
            }
        },
    map: {
        '*': {
            'Magento_Checkout/template/payment.html': 'OnePageCheckout_OnePageCheckoutModule/template/payment.html',
            'Magento_Checkout/template/shipping.html': 'OnePageCheckout_OnePageCheckoutModule/template/shipping.html'
        }
    }
};
