<?php
declare(strict_types=1);

function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

function limparDocumento(string $docSujeira): string {
    return str_replace(['.', '-'], '', $docSujeira);
}

function aplicarDesconto(float &$preco, float $porcentagem): void {
    $desconto = $preco * ($porcentagem / 100);
    $preco -= $desconto;
}

// ==========================================
// SUA MISSÃO COMEÇA AQUI:
// Crie uma função chamada gerarIniciais()
// Ela deve receber uma $string (ex: "Diogo Barbosa")
// E retornar uma $string com a primeira letra de cada palavra (ex: "DB")
// DICA: Pesquise no Google como usar explode(), substr() e strtoupper() no PHP!
// ==========================================
function gerarIniciais(string $string): string {
    $palavras = explode(" ", $string);
    $iniciais = "";

    foreach ($palavras as $palavra) {
        $iniciais .= strtoupper(substr($palavra, 0, 1));
    }

    return $iniciais;
}

echo gerarIniciais("Diogo Barbosa"); // DB
