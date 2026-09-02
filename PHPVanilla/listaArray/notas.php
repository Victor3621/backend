<?php
declare(strict_types=1);


function calcularMedia(array $notas): float
{
    return array_sum($notas) / count($notas);
}

function verificarAprovacao(float $media): string
{
    if ($media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

$notas = [7.5, 8.0, 6.5, 9.0, 5.5];


$media = calcularMedia($notas);

echo "Média: " . $media;
echo "\nSituação: " . verificarAprovacao($media);
echo "\nMaior nota: " . max($notas);
echo "\nMenor nota: " . min($notas);
?>