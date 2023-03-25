<?php

namespace kirillbdev\WCUkrShipping\Services\Checkout;

use kirillbdev\WCUkrShipping\DB\NovaPoshtaRepository;
use kirillbdev\WCUkrShipping\Helpers\HtmlHelper;
use kirillbdev\WCUkrShipping\Services\TranslateService;

if ( ! defined('ABSPATH')) {
    exit;
}

class LegacyCheckoutService
{
    /**
     * @var TranslateService
     */
    private $translator;

    /**
     * Cache translates of shipping block.
     *
     * @var array
     */
    private $translates;

    /**
     * Cache area select attributes of shipping block.
     *
     * @var array
     */
    private $areaAttributes;

    /**
     * Cache city select attributes of shipping block.
     *
     * @var array
     */
    private $cityAttributes;

    /**
     * Cache warehouse select attributes of shipping block.
     *
     * @var array
     */
    private $warehouseAttributes;

    public function __construct()
    {
        $this->translator = new TranslateService();
    }

    public function renderCheckoutFields(string $type)
    {
        $this->initShippingBlockAttributes();

        ?>
        <div id="wcus_np_<?= $type; ?>_fields" class="wc-ukr-shipping-np-fields">
            <h3><?= $this->translates['block_title']; ?></h3>
            <?php
            $this->renderNativeAreaField($type);
            $this->renderNativeCityField($type);
            ?>
            <div class="j-wcus-warehouse-block">
                <?php $this->renderNativeWarehouseField($type); ?>
            </div>

            <?php if ((int)get_option('wc_ukr_shipping_address_shipping', 1) === 1) { ?>
                <div class="wc-urk-shipping-form-group" style="padding: 10px 5px;">
                    <label class="wc-ukr-shipping-checkbox">
                        <input id="wcus_np_<?= $type; ?>_custom_address_active"
                               type="checkbox"
                               name="wcus_np_<?= $type; ?>_custom_address_active"
                               class="j-wcus-np-custom-address"
                               data-relation-select="<?= 'billing' === $type ? 'wcus_np_shipping_custom_address_active' : 'wcus_np_billing_custom_address_active'; ?>"
                               value="1">
                        <?= $this->translates['address_title']; ?>
                    </label>
                </div>
                <div class="j-wcus-np-custom-address-block" style="display: none;">
                    <?php
                    woocommerce_form_field('wcus_np_' . $type . '_custom_address', [
                        'type' => 'text',
                        'input_class' => [
                            'input-text'
                        ],
                        'label' => '',
                        'placeholder' => $this->translates['address_placeholder'],
                        'default' => ''
                    ]);
                    ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    private function initShippingBlockAttributes()
    {
        if ($this->translates) {
            return;
        }

        $this->translates = $this->translator->getTranslates();
        $this->areaAttributes = $this->getAreaSelectAttributes($this->translates['placeholder_area']);
        $this->cityAttributes = $this->getCitySelectAttributes($this->translates['placeholder_city']);
        $this->warehouseAttributes = $this->getWarehouseSelectAttributes($this->translates['placeholder_warehouse']);
    }

    private function getAreaSelectAttributes($placeholder)
    {
        $options = [
            '' => $placeholder
        ];

        $repository = new NovaPoshtaRepository();
        $areas = $this->translator->translateAreas($repository->getAreas());

        foreach ($areas as $area) {
            $options[$area['ref']] = $area['description'];
        }

        return [
            'options' => $options,
            'default' => ''
        ];
    }

    private function getCitySelectAttributes($placeholder)
    {
        $options = [
            '' => $placeholder
        ];

        return [
            'options' => $options,
            'default' => ''
        ];
    }

    private function getWarehouseSelectAttributes($placeholder)
    {
        $options = [
            '' => $placeholder
        ];

        return [
            'options' => $options,
            'default' => ''
        ];
    }

    private function renderNativeAreaField($type)
    {
        ?>
        <p class="form-row" id="wcus_np_<?= $type; ?>_area_field">
        <span class="woocommerce-input-wrapper">
          <?php
          HtmlHelper::selectField('wcus_np_' . $type . '_area', [
              'options' => $this->areaAttributes['options'],
              'class' => [
                  'select',
                  'wc-ukr-shipping-select',
                  'j-wcus-select-2'
              ],
              'attributes' => [
                  'data-mirror' => 'billing' === $type ? 'wcus_np_shipping_area' : 'wcus_np_billing_area'
              ],
              'value' => $this->areaAttributes['default']
          ]);
          ?>
        </span>
        </p>
        <?php
    }

    private function renderNativeCityField($type)
    {
        ?>
        <p class="form-row" id="wcus_np_<?= $type; ?>_city_field">
        <span class="woocommerce-input-wrapper">
          <?php
          HtmlHelper::selectField('wcus_np_' . $type . '_city', [
              'options' => $this->cityAttributes['options'],
              'class' => [
                  'select',
                  'wc-ukr-shipping-select',
                  'j-wcus-select-2'
              ],
              'attributes' => [
                  'data-mirror' => 'billing' === $type ? 'wcus_np_shipping_city' : 'wcus_np_billing_city'
              ],
              'value' => $this->cityAttributes['default']
          ]);
          ?>
        </span>
        </p>
        <?php
    }

    private function renderNativeWarehouseField($type)
    {
        ?>
        <p class="form-row" id="wcus_np_<?= $type; ?>_warehouse_field">
        <span class="woocommerce-input-wrapper">
          <?php
          HtmlHelper::selectField('wcus_np_' . $type . '_warehouse', [
              'options' => $this->warehouseAttributes['options'],
              'class' => [
                  'select',
                  'wc-ukr-shipping-select',
                  'j-wcus-select-2'
              ],
              'attributes' => [
                  'data-mirror' => 'billing' === $type ? 'wcus_np_shipping_warehouse' : 'wcus_np_billing_warehouse'
              ],
              'value' => $this->warehouseAttributes['default']
          ]);
          ?>
        </span>
        </p>
        <?php
    }
}