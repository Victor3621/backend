<?php
declare(strict_types=1);

$erros = [];

$valorVeiculo = "";
$valorEntrada = "";
$numeroParcelas = "";

$valorFinanciado = null;
$totalJuros = null;
$valorParcela = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $valorVeiculoTexto = trim((string) ($_POST["valor_veiculo"] ?? ""));
    $valorEntradaTexto = trim((string) ($_POST["valor_entrada"] ?? ""));
    $numeroParcelasTexto = trim((string) ($_POST["numero_parcelas"] ?? ""));

    $valorVeiculo = filter_var(
        $valorVeiculoTexto,
        FILTER_VALIDATE_FLOAT
    );

    $valorEntrada = filter_var(
        $valorEntradaTexto,
        FILTER_VALIDATE_FLOAT
    );

    $numeroParcelas = filter_var(
        $numeroParcelasTexto,
        FILTER_VALIDATE_INT
    );

    // Validação do valor do veículo
    if ($valorVeiculo === false || $valorVeiculo <= 0) {
        $erros["valor_veiculo"] = "Informe um valor de veículo válido.";
    }

    // Validação da entrada
    if ($valorEntrada === false || $valorEntrada < 0) {
        $erros["valor_entrada"] = "Informe um valor de entrada válido.";
    }

    // Validação do número de parcelas
    $parcelasPermitidas = [12, 24, 36, 48, 60];

    if (
        $numeroParcelas === false ||
        !in_array($numeroParcelas, $parcelasPermitidas, true)
    ) {
        $erros["numero_parcelas"] = "Número de parcelas inválido.";
    }

    // Regra: entrada mínima de 20%
    if ($erros === []) {

        $entradaMinima = $valorVeiculo * 0.20;

        if ($valorEntrada < $entradaMinima) {
            $erros["valor_entrada"] =
                "A entrada deve ser de pelo menos 20% do valor do veículo.";
        }
    }

    // Cálculo do financiamento
    if ($erros === []) {

        // Saldo que será financiado
        $valorFinanciado = $valorVeiculo - $valorEntrada;

        // Juros simples de 1,5% ao mês
        $taxaJuros = 0.015;

        $totalJuros =
            $valorFinanciado *
            $taxaJuros *
            $numeroParcelas;

        // Valor total financiado com juros
        $totalFinanciamento =
            $valorFinanciado + $totalJuros;

        // Valor de cada parcela
        $valorParcela =
            $totalFinanciamento / $numeroParcelas;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Financiamento Automotivo</title>
</head>

<body>

<main>

    <h1>Financiamento Automotivo</h1>

    <form method="POST">

        <label for="valor_veiculo">
            Valor do veículo (R$)
        </label>

        <input
            type="number"
            name="valor_veiculo"
            id="valor_veiculo"
            step="0.01"
            min="0"
            placeholder="Ex: 80000"
            value="<?= htmlspecialchars((string) $valorVeiculo) ?>"
        >

        <?php if (isset($erros["valor_veiculo"])): ?>
            <div class="erro">
                <?= htmlspecialchars($erros["valor_veiculo"]) ?>
            </div>
        <?php endif; ?>


        <label for="valor_entrada">
            Valor da entrada (R$)
        </label>

        <input
            type="number"
            name="valor_entrada"
            id="valor_entrada"
            step="0.01"
            min="0"
            placeholder="Ex: 16000"
            value="<?= htmlspecialchars((string) $valorEntrada) ?>"
        >

        <?php if (isset($erros["valor_entrada"])): ?>
            <div class="erro">
                <?= htmlspecialchars($erros["valor_entrada"]) ?>
            </div>
        <?php endif; ?>


        <label for="numero_parcelas">
            Número de parcelas
        </label>

        <select
            name="numero_parcelas"
            id="numero_parcelas"
        >
            <option value="">Selecione</option>

            <?php foreach ([12, 24, 36, 48, 60] as $parcela): ?>

                <option
                    value="<?= $parcela ?>"
                    <?= (string) $numeroParcelas === (string) $parcela ? "selected" : "" ?>
                >
                    <?= $parcela ?>x
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($erros["numero_parcelas"])): ?>
            <div class="erro">
                <?= htmlspecialchars($erros["numero_parcelas"]) ?>
            </div>
        <?php endif; ?>


        <button type="submit">
            Calcular financiamento
        </button>

    </form>


    <?php if ($valorFinanciado !== null): ?>

        <section class="resultado">

            <h2>Memória de Cálculo</h2>

            <p>
                Valor do veículo:
                <strong>
                    R$ <?= number_format($valorVeiculo, 2, ',', '.') ?>
                </strong>
            </p>

            <p>
                Valor da entrada:
                <strong>
                    R$ <?= number_format($valorEntrada, 2, ',', '.') ?>
                </strong>
            </p>

            <p>
                Valor financiado:
                <strong>
                    R$ <?= number_format($valorFinanciado, 2, ',', '.') ?>
                </strong>
            </p>

            <p>
                Total de juros:
                <strong>
                    R$ <?= number_format($totalJuros, 2, ',', '.') ?>
                </strong>
            </p>

            <p>
                Número de parcelas:
                <strong>
                    <?= $numeroParcelas ?>x
                </strong>
            </p>

            <p>
                Valor de cada parcela:
                <strong>
                    R$ <?= number_format($valorParcela, 2, ',', '.') ?>
                </strong>
            </p>

        </section>

    <?php endif; ?>

</main>

</body>
</html>
