<?php
if ( ! defined('ABSPATH')) {
    exit;
}
?>

<div class="wcus-pro-features">
    <div class="wcus-card">
        <div class="wcus-card__content">
            <div class="wcus-card__title wcus-pro-features__title"><?= wcus_i18n('Get more features from our PRO version'); ?></div>
            <div class="wcus-pro-features__list">
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Full address shipping integration (using Nova Poshta address API)'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Automatic calculation of shipping costs. Supporting W2W, W2D and COD delivery calculation'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Shipping calculation based on order total'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Ability to customize separated shipping costs for address shipping'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Ability to generate TTN. Support all of types: W2W, W2D, D2W, D2D'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Possibility of mass generation of TTN in one click'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Print TTN of all types: A4 (1 copy), A4 (2 copies), sticker 85x85, sticker 100х100 (zebra)'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Automatic email notifications after TTN creation'); ?>
                </div>
                <div class="wcus-pro-features__feature">
                    <?= wcus_i18n('Premium support'); ?>
                </div>
            </div>

            <a target="_blank" href="https://kirillbdev.pro/wc-ukr-shipping-pro/?ref=plugin" class="wcus-btn wcus-pro-features__become-pro">
                <?= wc_ukr_shipping_import_svg('star.svg'); ?>
                <?= wcus_i18n('Become PRO'); ?>
            </a>

        </div>
    </div>
</div>
