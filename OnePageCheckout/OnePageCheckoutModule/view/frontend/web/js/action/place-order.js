define(['mage/utils/wrapper'], function (wrapper) {
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, redirectOnSuccess) {
            console.log("place order overriden")
            // my own code here
            return originalAction(paymentData, redirectOnSuccess);
        });
    };
});
