<?php

namespace rame0\API\CBRF;

use DateTime;
use SimpleXMLElement;

class Client
{
    /** @var string */
    private string $_URL = 'https://cbr.ru/';

    /**
     * Constructor.
     * @param string $URL
     */
    public function __construct(string $URL)
    {
        $this->_URL = $URL;
    }

    public function getRates(?DateTime $date = null): ExchangeRates
    {
        $url = $this->_URL . 'scripts/XML_daily.asp';
        $params = [];
        if (!empty($date)) {
            $params['date_req'] = $date->format('d/m/Y');
        }

        $xml = $this->request($url, $params);

        $rates = new ExchangeRates();
        foreach ($xml as $value) {
            $rates->addRateFromXML($value);
        }

        return $rates;
    }

    private function request($url, $params): SimpleXMLElement
    {
        $query = http_build_query($params);
        return simplexml_load_file("$url?$query");
    }


}