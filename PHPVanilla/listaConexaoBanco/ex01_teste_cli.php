<?php

declare(strict_types=1);

// Define o arquivo de configuração do banco de dados.
const DATABASE_CONFIG = __DIR__ . '/database.ini';

// Exibe uma mensagem no terminal e encerra a execução.
function erro(string $mensagem): never
{
    fwrite(STDERR, "ERRO: {$mensagem}" . PHP_EOL);
    exit(1);
}

// Lê e valida as configurações do arquivo database.ini.
function carregarConfiguracao(): array
{
    if (!is_file(DATABASE_CONFIG)) {
        erro('O arquivo database.ini não foi encontrado.');
    }

    $configuracao = parse_ini_file(DATABASE_CONFIG, true);

    if ($configuracao === false) {
        erro('Não foi possível ler o arquivo database.ini.');
    }

    return $configuracao;
}

// Obtém uma configuração considerando uma seção opcional.
function obterValor(array $configuracao, string $chave): string
{
    $valor = $configuracao[$chave] ?? null;

    if (is_array($valor)) {
        $valor = $valor[$chave] ?? null;
    }

    if (!is_string($valor) || $valor === '') {
        erro("Configuração '{$chave}' não encontrada.");
    }

    return $valor;
}

// Cria a conexão PDO e retorna a versão do PostgreSQL.
function testarConexao(array $configuracao): string
{
    $host = obterValor($configuracao, 'host');
    $porta = obterValor($configuracao, 'port');
    $banco = obterValor($configuracao, 'database');
    $usuario = obterValor($configuracao, 'username');
    $senha = obterValor($configuracao, 'password');

    $dsn = "pgsql:host={$host};port={$porta};dbname={$banco}";

    $pdo = new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ]);

    $resultado = $pdo->query('SELECT version()');

    return (string) $resultado->fetchColumn();
}

// Executa o teste de conexão e informa o resultado no terminal.
function executar(): void
{
    echo "Testando conexão com PostgreSQL..." . PHP_EOL;

    $configuracao = carregarConfiguracao();

    try {
        $versao = testarConexao($configuracao);

        echo "SUCESSO: porta 5432 e base de dados estão acessíveis." . PHP_EOL;
        echo "PostgreSQL: {$versao}" . PHP_EOL;
    } catch (PDOException $excecao) {
        $mensagem = $excecao->getMessage();
        $mensagem = preg_replace('/\s+/', ' ', $mensagem);

        echo "FALHA: não foi possível acessar o PostgreSQL." . PHP_EOL;
        echo "Detalhes: " . trim($mensagem) . PHP_EOL;

        exit(1);
    }
}

// Inicia o teste quando o arquivo é executado pelo terminal.
executar();
