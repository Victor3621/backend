<?php

declare(strict_types=1);

require_once __DIR__ . '/ConexaoBanco.php';
require_once __DIR__ . '/Logger.php';

const ARQUIVO_CONFIG = __DIR__ . '/database.ini';
const AMBIENTE = 'development';
const ITERACOES = 50;

// Mede o tempo de execução em segundos com alta precisão.
function iniciarCronometro(): float
{
    return hrtime(true) / 1_000_000_000;
}

// Cria uma conexão PDO nova em cada iteração.
function benchmarkSemSingleton(array $config): array
{
    $inicio = iniciarCronometro();
    $memoriaInicial = memory_get_usage(true);

    for ($i = 0; $i < ITERACOES; $i++) {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $config['db_host'],
            $config['db_port'],
            $config['db_name']
        );

        $pdo = new PDO(
            $dsn,
            $config['db_user'],
            $config['db_password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $pdo->query('SELECT 1');
        $pdo = null;
    }

    return criarResultado($inicio, $memoriaInicial);
}

// Reutiliza a mesma conexão durante todas as iterações.
function benchmarkComSingleton(): array
{
    $inicio = iniciarCronometro();
    $memoriaInicial = memory_get_usage(true);

    for ($i = 0; $i < ITERACOES; $i++) {
        $conexao = ConexaoBanco::obterConexao(
            AMBIENTE,
            ARQUIVO_CONFIG
        );

        $conexao->query('SELECT 1');
    }

    return criarResultado($inicio, $memoriaInicial);
}

// Calcula as métricas finais de cada benchmark.
function criarResultado(
    float $inicio,
    int $memoriaInicial
): array {
    $tempo = iniciarCronometro() - $inicio;
    $memoriaFinal = memory_get_usage(true);

    return [
        'tempo' => $tempo,
        'memoria' => max(0, $memoriaFinal - $memoriaInicial),
    ];
}

// Exibe os resultados medidos em uma tabela HTML.
function exibirTabela(array $semSingleton, array $singleton): void
{
    $tempoReducao = calcularReducao(
        $semSingleton['tempo'],
        $singleton['tempo']
    );

    $memoriaReducao = calcularReducao(
        $semSingleton['memoria'],
        $singleton['memoria']
    );

    echo '<table border="1" cellpadding="8">';
    echo '<tr><th>Métrica</th><th>50x new PDO</th>';
    echo '<th>50x Singleton</th><th>Redução</th></tr>';

    exibirLinha(
        'Tempo',
        formatarTempo($semSingleton['tempo']),
        formatarTempo($singleton['tempo']),
        number_format($tempoReducao, 2, ',', '.') . '%'
    );

    exibirLinha(
        'Memória',
        formatarMemoria($semSingleton['memoria']),
        formatarMemoria($singleton['memoria']),
        number_format($memoriaReducao, 2, ',', '.') . '%'
    );

    echo '</table>';
}

// Exibe uma linha da tabela HTML.
function exibirLinha(
    string $metrica,
    string $semSingleton,
    string $singleton,
    string $reducao
): void {
    echo '<tr>';
    echo "<td>{$metrica}</td>";
    echo "<td>{$semSingleton}</td>";
    echo "<td>{$singleton}</td>";
    echo "<td>{$reducao}</td>";
    echo '</tr>';
}

// Calcula a porcentagem de redução entre duas métricas.
function calcularReducao(float $original, float $novo): float
{
    if ($original <= 0) {
        return 0.0;
    }

    return (($original - $novo) / $original) * 100;
}

// Formata o tempo para apresentação.
function formatarTempo(float $segundos): string
{
    return number_format($segundos * 1000, 3, ',', '.') . ' ms';
}

// Formata o consumo de memória para apresentação.
function formatarMemoria(int $bytes): string
{
    return number_format($bytes / 1024, 2, ',', '.') . ' KB';
}

// Executa os dois benchmarks e apresenta os resultados.
function executar(): void
{
    try {
        $config = ConexaoBanco::carregarAmbiente(AMBIENTE);

        $semSingleton = benchmarkSemSingleton($config);
        $singleton = benchmarkComSingleton();

        echo '<h2>Benchmark de conexões PostgreSQL</h2>';
        echo '<p>Iterações: ' . ITERACOES . '</p>';

        exibirTabela($semSingleton, $singleton);
    } catch (Throwable $erro) {
        echo '<p>ERRO: ' . htmlspecialchars(
            $erro->getMessage(),
            ENT_QUOTES,
            'UTF-8'
        ) . '</p>';

        exit(1);
    }
}

executar();
