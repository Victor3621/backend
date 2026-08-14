<?php
declare(strict_types=1);
?>
    <?php
    $peso = 85.5;
    $altura = 1.75;

    $imc = $peso / ($altura * $altura);
    
    if ($imc < 18.85){
        echo "Abaixo do peso";
    } elseif($imc >=18.5 || $imc<= 24.9){
        echo "Peso normal";
    } elseif ($imc >=25.0 || $imc<= 29.9){
        echo "Sobrepeso";
    } elseif ($imc >=30.0 || $imc<= 34.9){
        echo "Obdesidade grau 1";
    }else {
        echo "Obesidade grau 2 ou 3";
    }
    ?>