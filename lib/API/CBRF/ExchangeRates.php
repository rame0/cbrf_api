<?php

namespace rame0\API\CBRF;

use Exception;
use SimpleXMLElement;

class ExchangeRates extends Collection
{
    /**
     * @throws Exception
     */
    public function add($key_or_val, $value = null)
    {
        throw new Exception('Do not use this method. Use addRate() or addRateFromXML() instead');
    }

    /**
     * @param SimpleXMLElement $XMLElement
     * @return void
     */
    public function addRateFromXML(SimpleXMLElement $XMLElement)
    {
        $rate = ExchangeRate::fromXML($XMLElement);
        $this->addRate($rate);
    }

    /**
     * @param ExchangeRate $rate
     * @return void
     */
    public function addRate(ExchangeRate $rate)
    {
        parent::add($rate->getCharCode(), $rate);
    }

}