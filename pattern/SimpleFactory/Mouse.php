<?php

class Mouse implements ProductInterface
{
    protected $_id;
    protected $_model;
    protected $_price;

    public function __construct($product)
    {
        $this->_id = $product['id'];
        $this->_model = $product['model'];
        $this->_price = $product['price'];
    }

    function getId()
    {
        return $this->_id;
    }

    function getModel()
    {
        return $this->_model;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function getType()
    {
        return 'mouse';
    }
}