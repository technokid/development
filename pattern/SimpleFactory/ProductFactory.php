<?php

class ProductFactory
{
    private $_types = array();

    public function __construct()
    {
        $this->_types = array(
            'keyboard' => 'Keyboard',
            'mouse'    => 'Mouse'
        );
    }

    public function make($product)
    {
        if (!array_key_exists($product['type'], $this->_types)) {
            throw new InvalidArgumentException("Тип {$product['type']} не найден.");
        }

        $className = $this->_types[$product['type']];

        return new $className($product);
    }
}