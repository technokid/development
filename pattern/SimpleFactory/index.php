<?php

function __autoload($class_name) {
    require_once $class_name . '.php';
}

?>
<!doctype html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

$products = array(
    array(
        'id'    => 1,
        'model' => 'LOGITECH K810',
        'price' => '149.99',
        'type'  => 'keyboard'
    ),
    array(
        'id'    => 2,
        'model' => 'LOGITECH Wireless Gaming Mouse G700',
        'price' => '139.99',
        'type'  => 'mouse'
    )
);

$productsFactory = new ProductFactory();

$cart = array();
foreach ($products as $product) {
    $cart[] = $productsFactory->make($product);
}

echo "<pre>";
var_dump($cart);
echo "</pre>";

?>
</body>
</html>