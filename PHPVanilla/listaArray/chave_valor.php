<?php
declare(strict_types=1);

$usuario = [
    "nome" => "Carlos Eduardo",
    "idade" => 28,
    "cidade" => "Americana",
    "estado" => "SP",
    "premium" => true
];

$nome = $usuario["nome"];

if ($usuario["premium"]) {
    $nome .= " ⭐";
}
?>

<div class="card">
    <h2><?= $nome ?></h2>
    <p>Idade: <?= $usuario["idade"] ?></p>
    <p>Localização: <?= $usuario["cidade"] ?> - <?= $usuario["estado"] ?></p>
</div>
?>