<?php
declare(strict_types=1);

function CalcularIMC (float $peso, float $altura):
float{
    return $calculoimc = $peso / ($altura * $altura);
}

$imc = CalcularIMC(89.87, 1.91);
echo "Seu IMC é " . number_format($imc, 2, ',', '.');

if($imc < 18.5){
    echo "\nAbaixo do peso";
} else if ($imc == 18.5 || $imc <=24.9){
    echo "\nPeso normal";
} else if ($imc >=25 || $imc <= 29.9){
    echo "\nSobrepeso";
} else{
    echo "\nObesidade";
}
?>