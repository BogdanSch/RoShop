<?php

namespace kirillbdev\WCUkrShipping\Http\Controllers;

use kirillbdev\WCUkrShipping\DB\OptionsRepository;
use kirillbdev\WCUSCore\Http\Contracts\ResponseInterface;
use kirillbdev\WCUSCore\Http\Controller;
use kirillbdev\WCUSCore\Http\Request;

if ( ! defined('ABSPATH')) {
    exit;
}

class OptionsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return ResponseInterface
     */
    public function save($request)
    {
        parse_str($request->get('data'), $data);

        $result = $this->validate($data);

        if (true !== $result) {
            return $this->jsonResponse([
                'success' => false,
                'errors' => $result
            ]);
        }

        $optionsRepository = new OptionsRepository();
        $optionsRepository->save($data);

        return $this->jsonResponse([
            'success' => true,
            'data' => [
                'api_key' => get_option('wc_ukr_shipping_np_api_key', ''),
                'message' => wcus_i18n('Settings saved successfully!')
            ]
        ]);
    }

    /**
     * @param array $data
     *
     * @return array|bool
     */
    private function validate($data)
    {
        $errors = [];

        if ( ! isset($data['wc_ukr_shipping']['np_method_title']) || strlen($data['wc_ukr_shipping']['np_method_title']) === 0) {
            $errors['wc_ukr_shipping_np_method_title'] = __('validation_required', WCUS_TRANSLATE_DOMAIN);
        }

        if ( ! isset($data['wc_ukr_shipping']['np_address_title']) || strlen($data['wc_ukr_shipping']['np_address_title']) === 0) {
            $errors['wc_ukr_shipping_np_address_title'] = __('validation_required', WCUS_TRANSLATE_DOMAIN);
        }

        return $errors ? $errors : true;
    }
}