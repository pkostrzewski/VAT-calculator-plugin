jQuery(document).ready(function($) {
    $('#vat-calculator-form').on('submit', function(event) {
        event.preventDefault();

        // Checking if all fields are filled
        var productName = $('#product_name').val().trim();
        var netAmount = parseFloat($('#net_amount').val());
        var vatRate = $('#vat_rate').val();
        var nonce = $('#vat_calculator_nonce').val();

        if (!productName || isNaN(netAmount) || netAmount <= 0 || !vatRate) {
            $('#result').html(vat_calculator_data.error_message);
            return;
        }     

        var formData = {
            action: 'vat_calculate_tax',
            product_name: productName,
            net_amount: netAmount,
            vat_rate: vatRate,
            vat_calculator_nonce: nonce
        };

        $.ajax({
            type: 'POST',
            url: vat_ajax_obj.ajax_url,
            data: formData,
            success: function(response) {
                $('#result').html(response.success ? response.data.message : response.data.message);
            },
            error: function() {
                $('#result').html(vat_calculator_data.calculation_error);
            }
        });
    });    
});