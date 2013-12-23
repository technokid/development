<?php

/*
--
-- База данных: `cart`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `model`, `price`) VALUES
(1, 'LOGITECH K810', 149.99),
(2, 'LOGITECH Wireless Gaming Mouse G700', 139.99);
*/

class Db
{
    private static $_db = null;

    public static function getInstance()
    {
        if (self::$_db === null) {
            self::$_db = new PDO('mysql:host=localhost;dbname=cart', 'root', '');
        }

        return self::$_db;
    }

    private function __construct(){ }
    private function __clone()    { }
    private function __wakeup()   { }
}
