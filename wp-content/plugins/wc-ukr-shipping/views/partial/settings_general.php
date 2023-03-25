<div id="wcus-pane-general" class="wcus-tab-pane active">
    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_api_key"><?= wcus_i18n('API key for Nova Poshta'); ?></label>
        <input type="text" id="wc_ukr_shipping_np_api_key"
               name="wc_ukr_shipping[np_api_key]"
               class="wcus-form-control"
               value="<?= get_option('wc_ukr_shipping_np_api_key', ''); ?>">
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_lang"><?= wcus_i18n('Display language of cities and departments'); ?></label>
        <select id="wc_ukr_shipping_np_lang"
                name="wc_ukr_shipping[np_lang]"
                class="wcus-form-control">
            <option value="ru" <?= get_option('wc_ukr_shipping_np_lang', 'uk') === 'ru' ? 'selected' : ''; ?>><?= wcus_i18n('Russian'); ?></option>
            <option value="uk" <?= get_option('wc_ukr_shipping_np_lang', 'uk') === 'uk' ? 'selected' : ''; ?>><?= wcus_i18n('Ukrainian'); ?></option>
        </select>
    </div>

    <div class="wcus-form-group">
        <div class="wcus-form-group--horizontal">
            <label class="wcus-switcher">
              <input type="hidden" name="wcus[checkout_new_ui]" value="0">
              <input type="checkbox" name="wcus[checkout_new_ui]" value="1" <?= (int)get_option('wcus_checkout_new_ui', 1) === 1 ? 'checked' : ''; ?>>
              <span class="wcus-switcher__control"></span>
            </label>
            <div class="wcus-control-label"><?= wcus_i18n('Use new UI'); ?></div>
        </div>
        <div class="wcus-form-group__tooltip"><?= wcus_i18n('We recommend to enable this setting as the old UI will be removed in version 2.0'); ?></div>
    </div>

    <div class="wcus-form-group wcus-form-group--horizontal">
        <label class="wcus-switcher">
            <input type="hidden" name="wcus[show_poshtomats]" value="0">
            <input type="checkbox" name="wcus[show_poshtomats]" value="1" <?= (int)get_option('wcus_show_poshtomats', 1) === 1 ? 'checked' : ''; ?>>
            <span class="wcus-switcher__control"></span>
        </label>
        <div class="wcus-control-label"><?= wcus_i18n('Show poshtomats'); ?></div>
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_np_translates_type"><?= wcus_i18n('Load translates from'); ?></label>
        <select id="wc_ukr_shipping_np_translates_type"
                name="wc_ukr_shipping[np_translates_type]"
                class="wcus-form-control">
            <option value="<?= WCUS_TRANSLATE_TYPE_PLUGIN; ?>" <?= WCUS_TRANSLATE_TYPE_PLUGIN === (int)wc_ukr_shipping_get_option('wc_ukr_shipping_np_translates_type') ? 'selected' : ''; ?>><?= wcus_i18n('Plugin settings'); ?></option>
            <option value="<?= WCUS_TRANSLATE_TYPE_MO_FILE; ?>" <?= WCUS_TRANSLATE_TYPE_MO_FILE === (int)wc_ukr_shipping_get_option('wc_ukr_shipping_np_translates_type') ? 'selected' : ''; ?>><?= wcus_i18n('Wordpress localization files'); ?></option>
        </select>
        <div class="wcus-form-group__tooltip"><?= wcus_i18n('If you are using language plugins such as WPML or Polylang - select "Wordpress localization files" option'); ?></div>
    </div>

    <div class="wcus-form-group">
        <label for="wc_ukr_shipping_spinner_color"><?= wcus_i18n('Color of spinner in frontend'); ?></label>
        <input name="wc_ukr_shipping[spinner_color]" id="wc_ukr_shipping_spinner_color" type="text" value="<?= get_option('wc_ukr_shipping_spinner_color', '#dddddd'); ?>" />
    </div>

    <div id="wcus-warehouse-loader"></div>
</div>