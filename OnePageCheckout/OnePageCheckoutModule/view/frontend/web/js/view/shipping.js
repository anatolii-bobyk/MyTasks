define(
    [
        'jquery',
        'underscore',
        'Magento_Ui/js/form/form',
        'Magento_Checkout/js/action/place-order',
        'mage/utils/wrapper',
        'ko',
        'Magento_Customer/js/model/customer',
        'Magento_Customer/js/model/address-list',
        'Magento_Checkout/js/model/address-converter',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/create-shipping-address',
        'Magento_Checkout/js/action/select-shipping-address',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-address/form-popup-state',
        'Magento_Checkout/js/model/shipping-service',
        'Magento_Checkout/js/action/select-shipping-method',
        'Magento_Checkout/js/model/shipping-rate-registry',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Ui/js/modal/modal',
        'Magento_Checkout/js/model/checkout-data-resolver',
        'Magento_Checkout/js/checkout-data',
        'uiRegistry',
        'mage/translate',
        'Magento_Checkout/js/model/shipping-rate-service'
    ], function (
        $,
        _,
        Component,
        placeOrderAction,
        wrapper,
        ko,
        customer,
        addressList,
        addressConverter,
        quote,
        createShippingAddress,
        selectShippingAddress,
        shippingRatesValidator,
        formPopUpState,
        shippingService,
        selectShippingMethodAction,
        rateRegistry,
        setShippingInformationAction,
        stepNavigator,
        modal,
        checkoutDataResolver,
        checkoutData,
        registry,
        $t) {
        'use strict';

        var mixin = {

            selectShippingMethod: function (shippingMethod) {
                console.log("method overriden");
                selectShippingMethodAction(shippingMethod);
                checkoutData.setSelectedShippingRate(shippingMethod.carrier_code + '_' + shippingMethod.method_code);

                return true;
            },
            setShippingInformation: function () {
                console.log("start of setShippingMethod");
                if (this.validateShippingInformation()) {
                    quote.billingAddress(null);
                    checkoutDataResolver.resolveBillingAddress();
                    registry.async('checkoutProvider')(function (checkoutProvider) {
                        var shippingAddressData = checkoutData.getShippingAddressFromData();

                        if (shippingAddressData) {
                            checkoutProvider.set(
                                'shippingAddress',
                                $.extend(true, {}, checkoutProvider.get('shippingAddress'), shippingAddressData)
                            );
                        }
                    });
                    // setShippingInformationAction().done(
                    //     function (result) {
                    //         console.log("done function start")
                    //         stepNavigator.next();

                    // setInterval(function () {
                    // console.log('set interval')
                    // return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, redirectOnSuccess) {
                    // my own code here
                    // console.log('placeOrder method overriden')
                    // return originalAction(paymentData, redirectOnSuccess);
                    // });
                    // }, 1500);
                    // }
                    // );
                    setShippingInformationAction().done(
                        function () {
                            stepNavigator.next();
                        }
                    );
                }
            }
        };

        return function (target) { // target == Result that Magento_Ui/.../default returns.
            return target.extend(mixin); // new result that all other modules receive
        };
    });
