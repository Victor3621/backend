<?php

$produtos = [
    1 => ["nome" => "Coxinha", "preco" => 6.00, "estoque" => 10],
    2 => ["nome" => "Suco", "preco" => 5.00, "estoque" => 8],
    3 => ["nome" => "Sanduíche", "preco" => 12.00, "estoque" => 5],
    4 => ["nome" => "Bolo", "preco" => 7.50, "estoque" => 6]
];

$pedido = [];
$opcao = 0;

do {
    echo "\n==============================\n";
    echo "       CANTINA SENAI\n";
    echo "==============================\n";
    echo "1 - Listar produtos\n";
    echo "2 - Adicionar produto ao pedido\n";
    echo "3 - Exibir resumo do pedido\n";
    echo "4 - Finalizar compra\n";
    echo "0 - Sair sem finalizar\n";
    echo "==============================\n";

    $opcao = (int) readline("Escolha uma opção: ");

    $resultado = match ($opcao) {

        1 => (function () use ($produtos) {
            echo "\n--- PRODUTOS DISPONÍVEIS ---\n";

            foreach ($produtos as $codigo => $produto) {
                echo "Código: $codigo\n";
                echo "Nome: {$produto['nome']}\n";
                echo "Preço: R$ " . number_format($produto['preco'], 2, ',', '.') . "\n";
                echo "Estoque: {$produto['estoque']}\n";
                echo "----------------------------\n";
            }

            return true;
        })(),

        2 => (function () use (&$produtos, &$pedido) {

            echo "\n--- ADICIONAR PRODUTO ---\n";

            $codigo = (int) readline("Digite o código do produto: ");

            if (!isset($produtos[$codigo])) {
                echo "Produto inexistente!\n";
                echo "Voltando ao menu...\n";
                return false;
            }

            if ($produtos[$codigo]['estoque'] <= 0) {
                echo "Produto sem estoque disponível!\n";
                return false;
            }

            $quantidade = 0;

            while (
                $quantidade <= 0 ||
                $quantidade > $produtos[$codigo]['estoque']
            ) {
                $quantidade = (int) readline(
                    "Digite a quantidade (estoque disponível: " .
                    $produtos[$codigo]['estoque'] . "): "
                );

                if ($quantidade <= 0) {
                    echo "Quantidade inválida. Digite um valor maior que zero.\n";
                } elseif ($quantidade > $produtos[$codigo]['estoque']) {
                    echo "Quantidade maior que o estoque disponível.\n";
                }
            }

            $produtos[$codigo]['estoque'] -= $quantidade;

            if (isset($pedido[$codigo])) {
                $pedido[$codigo]['quantidade'] += $quantidade;
            } else {
                $pedido[$codigo] = [
                    "nome" => $produtos[$codigo]['nome'],
                    "preco" => $produtos[$codigo]['preco'],
                    "quantidade" => $quantidade
                ];
            }

            echo "Produto adicionado ao pedido com sucesso!\n";

            return true;
        })(),

        3 => (function () use (&$pedido) {

            echo "\n--- RESUMO DO PEDIDO ---\n";

            if (empty($pedido)) {
                echo "Nenhum produto foi adicionado.\n";
                return true;
            }

            $total = 0;

            foreach ($pedido as $item) {
                $subtotal = $item['quantidade'] * $item['preco'];
                $total += $subtotal;

                echo "Nome: {$item['nome']}\n";
                echo "Quantidade: {$item['quantidade']}\n";
                echo "Preço unitário: R$ " .
                    number_format($item['preco'], 2, ',', '.') . "\n";
                echo "Subtotal: R$ " .
                    number_format($subtotal, 2, ',', '.') . "\n";
                echo "----------------------------\n";
            }

            echo "Total parcial: R$ " .
                number_format($total, 2, ',', '.') . "\n";

            return true;
        })(),

        4 => (function () use (&$pedido) {

            if (empty($pedido)) {
                echo "\nNenhum produto foi adicionado ao pedido.\n";
                echo "Não é possível finalizar uma compra vazia.\n";
                return false;
            }

            echo "\n--- FINALIZAÇÃO DA COMPRA ---\n";

            $total = 0;

            $itens = array_values($pedido);

            for ($i = 0; $i < count($itens); $i++) {
                $subtotal =
                    $itens[$i]['quantidade'] *
                    $itens[$i]['preco'];

                $total += $subtotal;
            }

            echo "Total da compra: R$ " .
                number_format($total, 2, ',', '.') . "\n";

            echo "\nForma de pagamento:\n";
            echo "1 - Pix (5% de desconto)\n";
            echo "2 - Cartão (sem desconto)\n";
            echo "3 - Dinheiro (3% de desconto)\n";

            $pagamento = (int) readline("Escolha a forma de pagamento: ");

            $resultadoPagamento = match ($pagamento) {
                1 => [
                    "nome" => "Pix",
                    "desconto" => 0.05
                ],

                2 => [
                    "nome" => "Cartão",
                    "desconto" => 0
                ],

                3 => [
                    "nome" => "Dinheiro",
                    "desconto" => 0.03
                ],

                default => null
            };

            if ($resultadoPagamento === null) {
                echo "Pagamento inválido!\n";
                return false;
            }

            $desconto = $total * $resultadoPagamento['desconto'];
            $totalFinal = $total - $desconto;

            echo "\nForma de pagamento: {$resultadoPagamento['nome']}\n";
            echo "Desconto: R$ " .
                number_format($desconto, 2, ',', '.') . "\n";
            echo "Total final: R$ " .
                number_format($totalFinal, 2, ',', '.') . "\n";

            echo "\nCompra finalizada com sucesso!\n";
            echo "Obrigado por comprar na Cantina SENAI!\n";

            return true;
        })(),

        0 => true,
        default => false
    };

    if ($opcao === 0) {
        echo "\nSaindo sem finalizar a compra...\n";
        break;
    }

    if ($opcao === 4 && $resultado === true) {
        break;
    }

    if ($resultado === false) {
        echo "\nOpção inválida ou operação não concluída.\n";
        continue;
    }

} while ($opcao !== 4 && $opcao !== 0);

echo "\nPrograma encerrado.\n";

?>