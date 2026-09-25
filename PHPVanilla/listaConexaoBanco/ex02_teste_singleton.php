<?php

declare(strict_types=1);

// Define o arquivo de configuração utilizado pela conexão.
const ARQUIVO_CONFIG = __DIR__ . '/database.ini';

// Carrega a classe responsável pela conexão com o banco.
require_once __DIR__ . '/ConexaoBanco.php';

// Obtém a conexão pela primeira vez.
$conexao1 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

// Obtém a mesma conexão pela segunda vez.
$conexao2 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

// Obtém o identificador interno dos objetos PDO.
$idConexao1 = spl_object_id($conexao1);
$idConexao2 = spl_object_id($conexao2);

// Compara se as duas variáveis apontam para o mesmo objeto.
$mesmaConexao = $conexao1 === $conexao2;

echo "=== Teste do padrão Singleton ===" . PHP_EOL;
echo "SPL Object ID da conexão 1: {$idConexao1}" . PHP_EOL;
echo "SPL Object ID da conexão 2: {$idConexao2}" . PHP_EOL;

if ($mesmaConexao) {
    echo "SUCESSO: as duas variáveis apontam para o mesmo objeto." . PHP_EOL;
    echo "Singleton confirmado: nenhuma segunda conexão PDO foi criada." . PHP_EOL;
} else {
    echo "FALHA: as variáveis apontam para objetos diferentes." . PHP_EOL;
    echo "O Singleton não está funcionando corretamente." . PHP_EOL;
}
