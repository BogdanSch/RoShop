<?php
  if ( ! defined('ABSPATH')) {
      exit;
  }
?>

<div class="wcus-layout">

  <div id="wc-ukr-shipping-settings" class="wcus-settings">
    <div class="wcus-settings__header">
      <h1 class="wcus-settings__title"><?= wcus_i18n('Settings'); ?></h1>
      <div class="wcus-settings__head-buttons">
        <a target="_blank" href="https://kirillbdev.pro/docs/wcus-base-setup/" class="wcus-btn wcus-btn--docs wcus-btn--md wcus-settings__docs">
            <?= wc_ukr_shipping_import_svg('docs.svg'); ?>
            <?= wcus_i18n('Documentation'); ?>
        </a>
        <button type="submit" form="wc-ukr-shipping-settings-form" class="wcus-settings__submit wcus-btn wcus-btn--primary wcus-btn--md"><?= wcus_i18n('Save'); ?></button>
      </div>
      <div id="wcus-settings-success-msg" class="wcus-settings__success wcus-message wcus-message--success"></div>
    </div>
    <div class="wcus-settings__content">
      <form id="wc-ukr-shipping-settings-form" action="/" method="POST">
        <ul class="wcus-tabs">
          <li data-pane="wcus-pane-general" class="active"><?= wcus_i18n('General'); ?></li>
          <li data-pane="wcus-pane-shipping"><?= wcus_i18n('Shipping'); ?></li>
          <li data-pane="wcus-pane-translates"><?= wcus_i18n('Translates'); ?></li>
        </ul>
        <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/settings_general'); ?>
        <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/settings_shipping'); ?>
        <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/settings_translates'); ?>
      </form>
    </div>
  </div>

    <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/pro_promotion'); ?>

</div>
