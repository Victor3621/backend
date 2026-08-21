<?php
declare(strict_types=1);

function FormatarNome(string $nome): string {
    return (ucfirst(strtolower(trim($nome))));
}

echo FormatarNome("       MAria          ");
?>