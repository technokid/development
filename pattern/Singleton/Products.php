<?php

class Products
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = Db::getInstance();
    }

    public function getAllProducts()
    {
        $result = $this->_db->query("SELECT * FROM products");

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}