<?php
// Shortcode to display the form
add_shortcode('vat_calculator', 'vat_display_tax_form');

function vat_display_tax_form() {
    ob_start(); ?>
    <div class="wrapper-form">
        <form id="vat-calculator-form" method="post">
            <?php wp_nonce_field('vat_calculator_nonce_action', 'vat_calculator_nonce'); ?>
            <div>
                <label for="product_name"><?php echo esc_html(__('Product Name:', 'vat_calculator')); ?></label>
                <input type="text" id="product_name" name="product_name" required>
            </div>
            <div>
                <label for="net_amount"><?php echo esc_html(__('Net Amount (PLN):', 'vat_calculator')); ?></label>
                <input type="number" id="net_amount" name="net_amount" step="0.01" required>
            </div>
            <div>
                <label for="currency"><?php echo esc_html(__('Currency:', 'vat_calculator')); ?></label>
                <input type="text" id="currency" name="currency" value="<?php echo esc_attr('PLN'); ?>" disabled>
            </div>
            <div>
                <label for="vat_rate"><?php echo esc_html(__('VAT Rate:', 'vat_calculator')); ?></label>
                <select id="vat_rate" name="vat_rate" required>
                    <option value="23"><?php echo esc_html('23%'); ?></option>
                    <option value="22"><?php echo esc_html('22%'); ?></option>
                    <option value="8"><?php echo esc_html('8%'); ?></option>
                    <option value="7"><?php echo esc_html('7%'); ?></option>
                    <option value="5"><?php echo esc_html('5%'); ?></option>
                    <option value="3"><?php echo esc_html('3%'); ?></option>
                    <option value="0"><?php echo esc_html('0%'); ?></option>
                    <option value="ZW"><?php echo esc_html('ZW'); ?></option>
                    <option value="NP"><?php echo esc_html('NP'); ?></option>
                    <option value="OO"><?php echo esc_html('OO'); ?></option>
                </select>
            </div>
            <button type="submit" id="calculate_button"><?php echo esc_html(__('Calculate', 'vat_calculator')); ?></button>
        </form>
        <div id="result"></div>
    </div>

    <?php
    return ob_get_clean();
}