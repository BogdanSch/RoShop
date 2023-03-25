<div id="wcus-pane-shipping" class="wcus-tab-pane">

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_price"><?= wcus_i18n('Shipping cost'); ?></label>
        <input type="number" id="wc_ukr_shipping_np_price"
               name="wc_ukr_shipping[np_price]"
               class="wcus-form-control"
               min="0"
               step="0.000001"
               value="<?= get_option('wc_ukr_shipping_np_price', 0); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_block_pos"><?= wcus_i18n('Shipping block position on checkout page'); ?></label>
        <select id="wc_ukr_shipping_np_block_pos"
                name="wc_ukr_shipping[np_block_pos]"
                class="wcus-form-control">
            <option value="billing" <?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_block_pos') === 'billing' ? 'selected' : ''; ?>><?= wcus_i18n('Default section'); ?></option>
            <option value="additional" <?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_block_pos') === 'additional' ? 'selected' : ''; ?>><?= wcus_i18n('Additional section'); ?></option>
        </select>
    </div>

    <div class="wcus-form-group wcus-form-group--horizontal">
        <label class="wcus-switcher">
            <input type="hidden" name="wc_ukr_shipping[address_shipping]" value="0">
            <input type="checkbox" name="wc_ukr_shipping[address_shipping]" value="1" <?= (int)get_option('wc_ukr_shipping_address_shipping', 1) === 1 ? 'checked' : ''; ?>>
            <span class="wcus-switcher__control"></span>
        </label>
        <div class="wcus-control-label"><?= wcus_i18n('Enable address shipping'); ?></div>
    </div>

    <?php /* Store last warehouse */ ?>
    <div class="wcus-form-group">
      <div class="wcus-form-group--horizontal">
        <label class="wcus-switcher">
          <input type="hidden" name="wc_ukr_shipping[np_save_warehouse]" value="0">
          <input type="checkbox" name="wc_ukr_shipping[np_save_warehouse]" value="1" <?= (int)get_option(WCUS_OPTION_SAVE_CUSTOMER_ADDRESS) === 1 ? 'checked' : ''; ?>>
          <span class="wcus-switcher__control"></span>
        </label>
        <div class="wcus-control-label"><?= wcus_i18n('Save last customer address'); ?></div>
      </div>
      <div class="wcus-form-group__tooltip"><?= wcus_i18n("This option is not working with old UI"); ?></div>
    </div>

</div>