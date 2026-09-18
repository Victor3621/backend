<?php

declare(strict_types=1);

const ARQUIVO = __DIR__ . '/recados.json';

function e(string $texto): string
{
    return htmlspecialchars(
        $texto,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function carregar(): array
{
    if (!file_exists(ARQUIVO)) {
        return [];
    }

    $dados = json_decode(file_get_contents(ARQUIVO), true);
    return is_array($dados) ? $dados : [];
}

function salvar(array $recados): void
{
    file_put_contents(
        ARQUIVO,
        json_encode($recados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}

function validar(string $nome, string $mensagem): array
{
    $erros = [];

    if (mb_strlen($nome) < 3) {
        $erros[] = 'Nome deve ter no mínimo 3 caracteres.';
    }

    if (mb_strlen($mensagem) < 5) {
        $erros[] = 'Mensagem deve ter no mínimo 5 caracteres.';
    }

    return $erros;
}

$recados = carregar();
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');
    $erros = validar($nome, $mensagem);

    if (!$erros) {
        $recados[] = ['nome' => $nome, 'mensagem' => $mensagem];
        salvar($recados);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mural de Recados</title>
</head>
<body>
    <h1>Mural de Recados</h1>

    <?php foreach ($erros as $erro): ?>
        <p><?= e($erro) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <label>
            Nome:
            <input type="text" name="nome" minlength="3" required>
        </label>

        <br><br>

        <label>
            Mensagem:
            <textarea name="mensagem" minlength="5" required></textarea>
        </label>

        <br><br>
        <button type="submit">Enviar</button>
    </form>

    <hr>

    <?php foreach ($recados as $recado): ?>
        <article>
            <strong><?= e($recado['nome']) ?></strong>
            <p><?= nl2br(e($recado['mensagem'])) ?></p>
        </article>
    <?php endforeach; ?>
</body>
</html>
