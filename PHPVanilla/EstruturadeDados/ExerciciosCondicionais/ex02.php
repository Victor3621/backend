<?php
declare(strict_types=1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $valorCompra = 185.96;
    $statusFrete = ($valorCompra >= 250) ? "Frete grátis" : "Frete R$ 25,00";
    echo $statusFrete;
    ?>

</body>
</html>