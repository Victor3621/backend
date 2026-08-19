<?php

$categoria = 'A';
$divida = 100.00;

$taxa = match ($categoria) {
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05
};

echo "<h2>Projeção da Dívida - 12 Meses</h2>";

echo "<table border='1' cellpadding='8'>";
echo "<tr>
        <th>Mês</th>
        <th>Dívida Inicial</th>
        <th>Juros</th>
        <th>Saldo Atualizado</th>
      </tr>";

for ($mes = 1; $mes <= 12; $mes++) {

    $dividaInicial = $divida;

    if ($mes == 6) {
        echo "<tr>";
        echo "<td>$mes</td>";
        echo "<td>R$ " . number_format($dividaInicial, 2, ',', '.') . "</td>";
        echo "<td>ISENTO</td>";
        echo "<td>R$ " . number_format($divida, 2, ',', '.') . "</td>";
        echo "</tr>";

        continue;
    }

    $juros = $divida * $taxa;
    $divida = $divida + $juros;

    echo "<tr>";
    echo "<td>$mes</td>";
    echo "<td>R$ " . number_format($dividaInicial, 2, ',', '.') . "</td>";
    echo "<td>R$ " . number_format($juros, 2, ',', '.') . "</td>";
    echo "<td>R$ " . number_format($divida, 2, ',', '.') . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<p><strong>Categoria:</strong> $categoria</p>";
echo "<p><strong>Taxa de juros:</strong> " . ($taxa * 100) . "% ao mês</p>";
?>