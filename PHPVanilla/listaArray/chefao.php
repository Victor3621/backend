<?php

$extrato = [
    ["data" => "2026-09-01", "descricao" => "Salário", "tipo" => "Entrada", "valor" => 4000.00],
    ["data" => "2026-09-02", "descricao" => "Supermercado", "tipo" => "Saida", "valor" => 450.50],
    ["data" => "2026-09-05", "descricao" => "Pix João", "tipo" => "Entrada", "valor" => 200.00],
    ["data" => "2026-09-10", "descricao" => "Conta de Luz", "tipo" => "Saida", "valor" => 120.00],
    ["data" => "2026-09-12", "descricao" => "Cinema", "tipo" => "Saida", "valor" => 65.00]
];

$totalEntradas = 0;
$totalSaidas = 0;

// Calculando os totais
foreach ($extrato as $transacao) {

    if ($transacao["tipo"] == "Entrada") {
        $totalEntradas += $transacao["valor"];
    }

    if ($transacao["tipo"] == "Saida") {
        $totalSaidas += $transacao["valor"];
    }
}

// Calculando o saldo
$saldoAtual = $totalEntradas - $totalSaidas;

// Define a cor do saldo
$corSaldo = $saldoAtual < 0 ? "red" : "green";

// Filtro de gastos altos
$gastosAltos = array_filter($extrato, function($transacao) {
    return $transacao["tipo"] == "Saida" && $transacao["valor"] > 100;
});

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Extrato Bancário</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 200px;
            box-shadow: 0 2px 5px #ccc;
        }

        .card h3 {
            margin-top: 0;
        }

        .entrada {
            color: green;
        }

        .saida {
            color: red;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .gastos-altos {
            color: #b00000;
        }
    </style>
</head>

<body>

    <h1>Meu Extrato</h1>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Entradas</h3>
            <p class="entrada">
                R$ <?= number_format($totalEntradas, 2, ",", ".") ?>
            </p>
        </div>

        <div class="card">
            <h3>Saídas</h3>
            <p class="saida">
                R$ <?= number_format($totalSaidas, 2, ",", ".") ?>
            </p>
        </div>

        <div class="card">
            <h3>Saldo Atual</h3>
            <p style="color: <?= $corSaldo ?>;">
                R$ <?= number_format($saldoAtual, 2, ",", ".") ?>
            </p>
        </div>

    </div>

    <!-- TABELA COMPLETA -->
    <h2>Transações</h2>

    <table>
        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Valor</th>
        </tr>

        <?php foreach ($extrato as $transacao): ?>

            <tr>
                <td><?= $transacao["data"] ?></td>
                <td><?= $transacao["descricao"] ?></td>
                <td><?= $transacao["tipo"] ?></td>
                <td>
                    R$ <?= number_format($transacao["valor"], 2, ",", ".") ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

    <!-- GASTOS ALTOS -->
    <h2 class="gastos-altos">
        Atenção: Gastos Altos do Mês
    </h2>

    <table>
        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Valor</th>
        </tr>

        <?php foreach ($gastosAltos as $gasto): ?>

            <tr>
                <td><?= $gasto["data"] ?></td>
                <td><?= $gasto["descricao"] ?></td>
                <td>
                    R$ <?= number_format($gasto["valor"], 2, ",", ".") ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

</body>
</html>
