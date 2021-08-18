<?php
use Mapon\MaponApi;

class GetRouteService
{
    /** @var MaponApi */
    protected $api;

    public function __construct()
    {
        $apiKey = '5333a9720180356462a0d9615a38f6dfff4581aa';
        $apiUrl = 'https://mapon.com/api/v1/';
        $this->api = new MaponApi($apiKey, $apiUrl);
    }

    /**
     * @return array
     * @throws \Mapon\ApiException
     */
    public function getRoute()
    {
        $dateFrom = (isset($_GET['date_from']) && $_GET['date_from'])? $_GET['date_from'] : '2017-01-01';
        $dateTill = (isset($_GET['date_till']) && $_GET['date_till'])? $_GET['date_till'] : '2017-01-09';
        $result = (array) $this->api->get('route/list', [
            'from' => $dateFrom.'T00:00:00Z',
            'till' => $dateTill.'T23:59:59Z',
            'include' => array('polyline', 'speed')
        ]);

        return $result;
    }
}