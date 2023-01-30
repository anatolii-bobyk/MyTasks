define([
    'jquery',
    'underscore',
    'Magento_Ui/js/model/messages',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/payment/method-list',
    'Magento_Checkout/js/action/select-payment-method',
    'Magento_Checkout/js/action/set-payment-information',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/place-order',
    'Magento_Checkout/js/action/redirect-on-success'
], function (
    jQuery,
    _,
    messageContainer,
    quote,
    methodList,
    selectPaymentMethod,
    paymentData,
    urlBuilder,
    customer,
    placeOrderService,
    redirectOnSuccessAction
) {
    'use strict';

    return function (target) {
        var setPaymentMethods = target.setPaymentMethods;

        window.refreshOrder = 0;

        /**
         * Populate the list of payment methods
         * @param {Array} methods
         */
        target.setPaymentMethods = function (methods) {
            setPaymentMethods.apply(this, arguments);

            // if (this.getAvailablePaymentMethods().length > 0 && window.refreshOrder === 0) {
            //
            //     var serviceUrl, payload;
            //
            //     var payment = {};
            //     payment['method'] = this.getAvailablePaymentMethods()[0]['method'];
            //
            //     payload = {
            //         cartId: quote.getQuoteId(),
            //         billingAddress: quote.billingAddress(),
            //         paymentMethod: payment
            //     };
            //
            //     if (customer.isLoggedIn()) {
            //         serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
            //     } else {
            //         serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
            //             quoteId: quote.getQuoteId()
            //         });
            //         payload.email = quote.guestEmail;
            //     }
            //
            //     window.refreshOrder = 1;
            //
            //     placeOrderService(serviceUrl, payload, messageContainer);
            //     redirectOnSuccessAction.execute();
            //     location.reload();
            //     return redirectOnSuccessAction.execute();
            //     // if(redirectOnSuccessAction.execute()) {
            //     //     return true;
            //     // }
            // }
        }

        return target;
    }
});
