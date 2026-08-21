<?php
declare(strict_types=1);

function CalcularIMC (float $peso, float $altura):
float{
    return $calculoimc = $peso / ($altura * $altura);
}

$imc = CalcularIMC(89.87, 1.91);
echo "Seu IMC é " . number_format($imc, 2, ',', '.');

?>