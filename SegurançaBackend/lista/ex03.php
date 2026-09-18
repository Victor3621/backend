<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars(
        $texto,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

$busca = $_GET['q'] ?? '';
?>

<form method="get">
    <input
        type="text"
        name="q"
        value="<?= e($busca) ?>"
    >
    <button type="submit">Buscar</button>
</form>

<p>Você buscou por: <?= e($busca) ?></p>
