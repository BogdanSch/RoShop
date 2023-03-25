<?php

namespace kirillbdev\WCUkrShipping\Services;

use kirillbdev\WCUkrShipping\DB\Repositories\CityRepository;

if ( ! defined('ABSPATH')) {
    exit;
}

class AddressService
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var TranslateService
     */
    private $translateService;

    public function __construct()
    {
        $this->cityRepository = new CityRepository();
        $this->translateService = new TranslateService();
    }

    public function getDefaultCities()
    {
        return array_map(function($item) {
            $key = 'uk' === $this->translateService->getCurrentLanguage()
                ? 'description'
                : 'description_ru';

            return [
                'name' => $item[$key],
                'value' => $item['ref']
            ];
        }, $this->cityRepository->getCitiesByRefs($this->getDefaultCityRefs()));
    }

    private function getDefaultCityRefs()
    {
        $refs = [
            // Київ
            '8d5a980d-391c-11dd-90d9-001a92567626',
            // Харків
            'db5c88e0-391c-11dd-90d9-001a92567626',
            // Дніпро
            'db5c88f0-391c-11dd-90d9-001a92567626',
            // Запоріжжя
            'db5c88c6-391c-11dd-90d9-001a92567626',
            // Одеса
            'db5c88d0-391c-11dd-90d9-001a92567626',
            // Львів
            'db5c88f5-391c-11dd-90d9-001a92567626',
            // Маріуполь
            'db5c8944-391c-11dd-90d9-001a92567626',
            // Кривий Ріг
            'db5c890d-391c-11dd-90d9-001a92567626',
            // Миколаїв
            'db5c888c-391c-11dd-90d9-001a92567626',
            // Чернігів
            'db5c897c-391c-11dd-90d9-001a92567626',
            // Суми
            'db5c88e5-391c-11dd-90d9-001a92567626',
            // Вінниця
            'db5c88de-391c-11dd-90d9-001a92567626',
            // Черкаси
            'db5c8902-391c-11dd-90d9-001a92567626',
            // Херсон
            'db5c88cc-391c-11dd-90d9-001a92567626',
            // Полтава
            'db5c8892-391c-11dd-90d9-001a92567626',
            // Житомир
            'db5c88c4-391c-11dd-90d9-001a92567626',
            // Краматорськ
            'db5c8927-391c-11dd-90d9-001a92567626',
            // Рівне
            'db5c896a-391c-11dd-90d9-001a92567626',
            // Івано-Франківськ
            'db5c8904-391c-11dd-90d9-001a92567626',
            // Кременчук
            '8d5a9813-391c-11dd-90d9-001a92567626',
            // Тернопіль
            'db5c8900-391c-11dd-90d9-001a92567626',
            // Луцьк
            'db5c893b-391c-11dd-90d9-001a92567626',
            // Біла Церква
            'db5c88ce-391c-11dd-90d9-001a92567626',
            // Чернівці
            'e221d642-391c-11dd-90d9-001a92567626',
            // Хмельницький
            'db5c88ac-391c-11dd-90d9-001a92567626',
            // Кам'янець-Подільський
            'db5c8914-391c-11dd-90d9-001a92567626'
        ];

        return apply_filters('wcus_default_cities', $refs);
    }
}