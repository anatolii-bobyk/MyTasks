define([
        'jquery',
        'Magento_Ui/js/modal/modal'
    ], function ($,example,modal) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            buttons: [{
                text: $.mage.__('Continue'),
                class: 'primary action submit btn btn-default',
                click: function () {
                    this.closeModal();
                }
            }]
        };
        return {
            exampleData:function(){

                $(".ajax_open").click(function(e) {
                    e.preventDefault();
                    var ajaxurl = $(this).attr('href');
                    $.ajax({
                        url:ajaxurl,
                        success: function(data) {
                            $("#events_popup").html(data).modal(options).modal('openModal');
                        },
                        error: function (xhr, status, errorThrown) {
                            console.log('Error happens. Try again.');
                        }
                    });
                });
            }
        }
    }
);
