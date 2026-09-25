<?php

declare(strict_types=1);

// Implementa uma conexão PDO única por ambiente.
final class ConexaoBanco
{
    /** @var array<string, PDO> */
    private static array $conexoes = [];

    // Carrega a seção solicitada do arquivo INI.
    public static function carregarAmbiente(string $ambiente): array
    {
        $arquivo = __DIR__ . '/database.ini';

        if (!is_file($arquivo)) {
            throw new RuntimeException('Arquivo database.ini não encontrado.');
        }

        $configuracoes = parse_ini_file($arquivo, true);

        if ($configuracoes === false || !isset($configuracoes[$ambiente])) {
            throw new RuntimeException(
                "Ambiente '{$ambiente}' não encontrado no database.ini."
            );
        }

        return $configuracoes[$ambiente];
    }

    // Retorna ou cria a conexão PDO do ambiente solicitado.
    public static function obterConexao(
        string $ambiente,
        string $arquivoConfig
    ): PDO {
        if (isset(self::$conexoes[$ambiente])) {
            return self::$conexoes[$ambiente];
        }

        $configuracao = self::carregarConfiguracao(
            $ambiente,
            $arquivoConfig
        );

        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $configuracao['db_host'],
            $configuracao['db_port'],
            $configuracao['db_name']
        );

        self::$conexoes[$ambiente] = new PDO(
            $dsn,
            $configuracao['db_user'],
            $configuracao['db_password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        return self::$conexoes[$ambiente];
    }

    // Carrega uma seção específica do arquivo informado.
    private static function carregarConfiguracao(
        string $ambiente,
        string $arquivoConfig
    ): array {
        if (!is_file($arquivoConfig)) {
            throw new RuntimeException(
                'Arquivo de configuração não encontrado.'
            );
        }

        $configuracoes = parse_ini_file($arquivoConfig, true);

        if ($configuracoes === false || !isset($configuracoes[$ambiente])) {
            throw new RuntimeException(
                "Ambiente '{$ambiente}' não encontrado."
            );
        }

        return $configuracoes[$ambiente];
    }
}
