<?php
declare(strict_types=1);

function aplicarDesconto(float &$preco, float $porcentagem): void
{
    $preco -= $preco * ($porcentagem / 100);
}

// Teste
$preco = 200.00;

echo "Antes: R$ " . number_format($preco, 2, ',', '.') . PHP_EOL;

aplicarDesconto($preco, 15);

echo "Depois: R$ " . number_format($preco, 2, ',', '.') . PHP_EOL;
