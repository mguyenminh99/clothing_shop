<?php

namespace App\Controllers;


use App\Repositories\LocationDistrictRepository;
use App\Repositories\LocationRepository;
use Cache;

class HomeController extends BaseController
{
    protected $locationDistrictRepository;
    protected $locationRepository;

    protected $locationData;

    public function __construct()
    {
        parent::__construct();
        $this->locationDistrictRepository = new LocationDistrictRepository();
        $this->locationRepository = new LocationRepository();
        $this->locationData = null;
    }

    public function index($city = null, $district = null)
    {
        // Cache hot data to avoid repeated DB hits on first paint
        // $cacheTtl = 1800; // 30 minutes
        // $tên = Cache::remember('fewfix:{giá trị key bất kỳ}', $cacheTtl, function () {
        // //    giá trị cần cache
        // });

        $pageTitle = '';
        $pageDescription = '';
        // If city or district parameters are provided, get location data
        if ($city || $district) {
            if ($city && $district) {
                // Get district data with city info
                $this->locationData = $this->locationDistrictRepository->findActiveByCityAndDistrict($city, $district);

                if ($this->locationData) {
                    $pageTitle = $this->locationData->city_name . ' ' . $this->locationData->name . 'で浮気・不倫問題はサレ妻探偵へ';
                    $pageDescription = $this->locationData->city_name . ' ' . $this->locationData->name . 'での浮気調査・不倫調査はお任せください';
                }
            } elseif ($city) {
                // Get city data only
                $this->locationData = $this->locationRepository->findActiveByName($city);

                if ($this->locationData) {
                    $pageTitle = $this->locationData->name . 'で浮気・不倫問題はサレ妻探偵へ';
                    $pageDescription = $this->locationData->name . 'での浮気調査・不倫調査はお任せください';
                }
            }
        }

        $data = [
            'title' => $pageTitle,
            'description' => $pageDescription,
            'location' => $this->locationData,
            'district' => $district,
            'features' => [
                'Lightweight and Fast',
                'Simple Routing System',
                'Database Abstraction Layer',
                'Template Engine',
                'Model-View-Controller Architecture'
            ]
        ];

        return $this->view('home/index', $data);
    }

    public function breacum()
    {
        $data = [
            // 'title' => 'Breacum',
            // 'description' => 'Breacum page'
        ];

        return $this->view('home/breacum', $data);
    }

    public function maintenance()
    {
        $data = [
            'noindex' => true,
        ];
        return $this->view('maintenance/index', $data);
    }

    public function contact()
    {
        $data = [
            'styles' => ['contact.css'],
            'noindex' => true,
        ];
        return $this->view('home/contact', $data);
    }


    public function company()
    {
        $data = [
            'styles' => ['company.css'],
            'noindex' => true,
        ];
        return $this->view('home/company', $data);
    }


    public function privacy()
    {
        $data = [
            'styles' => ['privacy.css'],
            'noindex' => true,
        ];
        return $this->view('home/privacy', $data);
    }
}
