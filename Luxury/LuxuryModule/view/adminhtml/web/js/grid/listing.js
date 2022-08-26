define([
    'Magento_Ui/js/grid/listing'
], function (Listing) {
    'use strict';

    return Listing.extend({
        defaults: {
            template: 'Luxury_LuxuryModule/ui/grid/listing'
        },
        getRowClass: function (col, row) {
            if (col.index == 'luxuryTax') {

                let value = parseFloat(row.luxuryTax);

                if (value > 100 && value < 1000) {
                    return 'yellow';
                } else if (value >= 1000) {
                    return 'green';
                } else {
                    return 'white';
                }
            }
        }
    });
});
