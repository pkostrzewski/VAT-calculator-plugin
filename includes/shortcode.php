<?php
// Shortcode to display the form
add_shortcode('vat_calculator', 'vat_display_tax_form');

function vat_display_tax_form() {
    ob_start(); ?>
    <div class="wrapper-form">
        <form id="vat-calculator-form" method="post">
            <div>
                <label for="product_name"><?php echo esc_html(__('Nazwa produktu:', 'vat_calculator')); ?></label>
                <input type="text" id="product_name" name="product_name" required>
            </div>
            <div>
                <label for="net_amount"><?php echo esc_html(__('Kwota netto (PLN):', 'vat_calculator')); ?></label>
                <input type="number" id="net_amount" name="net_amount" step="0.01" required>
            </div>
            <div>
                <label for="currency"><?php echo esc_html(__('Waluta:', 'vat_calculator')); ?></label>
                <input type="text" id="currency" name="currency" value="<?php echo esc_attr(__('PLN', 'vat_calculator')); ?>" disabled>
            </div>
            <div>
                <label for="vat_rate"><?php echo esc_html(__('Stawka VAT:', 'vat_calculator')); ?></label>
                <select id="vat_rate" name="vat_rate" required>
                    <option value="23"><?php echo esc_html(__('23%', 'vat_calculator')); ?></option>
                    <option value="22"><?php echo esc_html(__('22%', 'vat_calculator')); ?></option>
                    <option value="8"><?php echo esc_html(__('8%', 'vat_calculator')); ?></option>
                    <option value="7"><?php echo esc_html(__('7%', 'vat_calculator')); ?></option>
                    <option value="5"><?php echo esc_html(__('5%', 'vat_calculator')); ?></option>
                    <option value="3"><?php echo esc_html(__('3%', 'vat_calculator')); ?></option>
                    <option value="0"><?php echo esc_html(__('0%', 'vat_calculator')); ?></option>
                    <option value="ZW"><?php echo esc_html(__('ZW', 'vat_calculator')); ?></option>
                    <option value="NP"><?php echo esc_html(__('NP', 'vat_calculator')); ?></option>
                    <option value="OO"><?php echo esc_html(__('OO', 'vat_calculator')); ?></option>
                </select>
            </div>
            <button type="submit" id="calculate_button"><?php echo esc_html(__('Oblicz', 'vat_calculator')); ?></button>
        </form>
        <div id="result"></div>
    </div>

    <?php
    return ob_get_clean();
}