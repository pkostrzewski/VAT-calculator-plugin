jQuery(document).ready(function($) {
    $('#vat-calculator-form').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            action: 'vat_calculate_tax',
            product_name: $('#product_name').val(),
            net_amount: $('#net_amount').val(),
            vat_rate: $('#vat_rate').val(),
        };

        $.post(vat_ajax_obj.ajax_url, formData, function(response) {
            var result = JSON.parse(response);
            $('#result').html(result.message);
        });
    });
});