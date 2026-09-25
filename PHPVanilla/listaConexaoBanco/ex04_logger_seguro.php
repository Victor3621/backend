<?php

declare(strict_types=1);

// Registra mensagens da aplicação no arquivo sistema.log.
final class Logger
{
    private const ARQUIVO_LOG = __DIR__ . '/logs/sistema.log';

    // Registra uma mensagem com o nível informado.
    public static function registrarLog(
        string $nivel,
        string $mensagem
    ): void {
        $niveisPermitidos = ['INFO', 'WARNING', 'ERROR'];

        if (!in_array($nivel, $niveisPermitidos, true)) {
            throw new InvalidArgumentException(
                "Nível de log inválido: {$nivel}"
            );
        }

        self::criarDiretorio();
        $dataHora = date('Y-m-d H:i:s');
        $linha = "[{$dataHora}] [{$nivel}] {$mensagem}" . PHP_EOL;

        file_put_contents(self::ARQUIVO_LOG, $linha, FILE_APPEND);
    }

    // Cria o diretório de logs caso ele não exista.
    private static function criarDiretorio(): void
    {
        $diretorio = dirname(self::ARQUIVO_LOG);

        if (!is_dir($diretorio) && !mkdir($diretorio, 0777, true)) {
            throw new RuntimeException(
                'Não foi possível criar o diretório de logs.'
            );
        }
    }
}
