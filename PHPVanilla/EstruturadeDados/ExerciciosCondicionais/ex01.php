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
    $idade = 57;

    if ($idade < 16) {
        echo "Voto Proibido";
    } elseif  ($idade <= 17 ||  $idade >= 70 ){
        echo "Voto Facultativo";
    } else {
        echo "Voto Obrigatório";
    };
    ?>

</body>
</html>