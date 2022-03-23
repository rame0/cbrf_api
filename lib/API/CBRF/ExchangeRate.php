<?php

namespace rame0\API\CBRF;

use SimpleXMLElement;

class ExchangeRate
{
    /** @var string */
    private string $_id;

    /** @var int */
    private int $_num_code;

    /** @var string */
    private string $_char_code;

    /** @var int */
    private int $_nominal;

    /** @var string */
    private string $_name;

    /** @var float */
    private float $_value;
    /** @var float */
    private float $_rate;


    /**
     * @param string $id
     * @param int    $num_code
     * @param string $char_code
     * @param int    $nominal
     * @param string $name
     * @param float  $value
     */
    public function __construct(string $id, int $num_code, string $char_code, int $nominal, string $name, float $value)
    {
        $this->_id = $id;
        $this->_num_code = $num_code;
        $this->_char_code = $char_code;
        $this->_nominal = $nominal;
        $this->_name = $name;
        $this->_value = $value;

        $this->_rate = round($this->_value / $this->_nominal, 4);
    }


    public static function fromXML(SimpleXMLElement $item): self
    {
        $id = $item->attributes()['ID'];
        $num_code = (int)$item->NumCode;
        $char_code = (string)$item->CharCode;
        $nominal = (int)$item->Nominal;
        $name = (string)$item->Name;
        $value = (float)$item->Value;

        return new self($id, $num_code, $char_code, $nominal, $name, $value);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->_id;
    }


    /**
     * @return int
     */
    public function getNumCode(): int
    {
        return $this->_num_code;
    }


    /**
     * @return string
     */
    public function getCharCode(): string
    {
        return $this->_char_code;
    }


    /**
     * @return int
     */
    public function getNominal(): int
    {
        return $this->_nominal;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }


    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->_value;
    }


    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->_rate;
    }


}