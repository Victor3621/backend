<?php
declare(strict_types=1);
?>
<?php
    $ingresso = 40;
    $isEstudante = true;

    $diaSemana = "Quarta";

    if ($diaSemana == "Segunda" || $diaSemana == "Terça"){
        $ingresso = $ingresso * 0.8;
    } elseif ($diaSemana == "Quarta"){
        $ingresso = $ingresso * 0.5;
    } elseif ($diaSemana == "Quinta" || $diaSemana == "Sexta" || $diaSemana == "Sabado" || $diaSemana == "Domingo"){
        $ingresso = $ingresso * 0.8;
    };

    if ($isEstudante == true){
        $ingresso = $ingresso * 0.5;
    } else {
        $ingresso = $ingresso * 1;
    };
    echo "O valor do Igresso é: $ingresso";
?>