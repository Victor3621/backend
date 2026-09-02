<?php
declare(strict_types=1);

$funcionarios = [
    ["id" => 1, "nome" => "Ana Souza", "cargo" => "Dev Front-End", "salario" => 4500.00],
    ["id" => 2, "nome" => "Bruno Costa", "cargo" => "Dev Back-End", "salario" => 5200.00],
    ["id" => 3, "nome" => "Carla Dias", "cargo" => "Tech Lead", "salario" => 8900.00],
    ["id" => 4, "nome" => "Daniel Silva", "cargo" => "Estagiário", "salario" => 1500.00],
];

$totalFolha = 0;
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Cargo</th>
        <th>Salário</th>
    </tr>

    <?php foreach ($funcionarios as $funcionario): ?>
        <tr>
            <td><?= $funcionario["id"] ?></td>
            <td><?= $funcionario["nome"] ?></td>
            <td><?= $funcionario["cargo"] ?></td>
            <td>
                R$ <?= number_format($funcionario["salario"], 2, ",", ".") ?>
            </td>
        </tr>

        <?php
        $totalFolha += $funcionario["salario"];
        ?>
    <?php endforeach; ?>

    <tr>
        <th colspan="3">Total da Folha</th>
        <th>R$ <?= number_format($totalFolha, 2, ",", ".") ?></th>
    </tr>
</table>