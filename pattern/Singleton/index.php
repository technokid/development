<?php

function __autoload($class_name) {
    require_once $class_name . '.php';
}

?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

$products = new Products();
echo '<pre>';
var_dump($products->getAllProducts());
echo '</pre>';

?>
</body>
</html>