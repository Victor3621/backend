<?php
declare(strict_types=1);
?>
<?php
    $cargoUsuario = "auxiliar";
    $senhaDigitada = "amopao";
    $senhaSistema = "SenhaSegura123";
    if (($cargoUsuario == "Gerente" || $cargoUsuario == "Diretor" ) && ($senhaDigitada == "SenhaSegura123")) {
        echo "Acesso liberado";
    } else{
        echo "Acesso negado";
    }
?>