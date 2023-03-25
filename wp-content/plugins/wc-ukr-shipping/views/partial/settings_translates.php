<div id="wcus-pane-translates" class="wcus-tab-pane">
    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_method_title"><?= wcus_i18n('Shipping method name'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_method_title"
               name="wc_ukr_shipping[np_method_title]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_method_title'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_block_title"><?= wcus_i18n('Shipping block title'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_block_title"
               name="wc_ukr_shipping[np_block_title]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_block_title'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_placeholder_area"><?= wcus_i18n('Placeholder of select area field'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_placeholder_area"
               name="wc_ukr_shipping[np_placeholder_area]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_placeholder_area'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_placeholder_city"><?= wcus_i18n('Placeholder of select city field'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_placeholder_city"
               name="wc_ukr_shipping[np_placeholder_city]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_placeholder_city'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_placeholder_warehouse"><?= wcus_i18n('Placeholder of select warehouse field'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_placeholder_warehouse"
               name="wc_ukr_shipping[np_placeholder_warehouse]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_placeholder_warehouse'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_address_title"><?= wcus_i18n('Label of address selector'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_address_title"
               name="wc_ukr_shipping[np_address_title]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_address_title'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_address_placeholder"><?= wcus_i18n('Placeholder of address field'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_address_placeholder"
               name="wc_ukr_shipping[np_address_placeholder]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_address_placeholder'); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_not_found_text"><?= wcus_i18n('Empty result text'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_not_found_text"
               name="wc_ukr_shipping[np_not_found_text]"
               class="wcus-form-control"
               value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_not_found_text'); ?>">
    </div>
</div>