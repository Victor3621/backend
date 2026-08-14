<?php
declare(strict_types=1);
?>
<?php
    $siglaEstado = "ro";

    $valorFrete = match ($siglaEstado){
        "sp","rj","mg", "es", => 35.00,
        "pr","sc", "rs", => 45.0,
        "ba","ce","pe", => 60.00,
        default => 80.00,
    };
    echo "Para o estado $siglaEstado, o frete é R$ $valorFrete";
?>