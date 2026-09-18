<?php

declare(strict_types=1);

const ARQUIVO = __DIR__ . '/chat.json';

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

function salvar(array $mensagens): void
{
    file_put_contents(
        ARQUIVO,
        json_encode($mensagens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}

$mensagens = carregar();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (mb_strlen($mensagem) > 250) {
        $erro = 'A mensagem não pode ultrapassar 250 caracteres.';
    } elseif ($mensagem !== '') {
        $mensagens[] = $mensagem;
        salvar($mensagens);
    }
}
?>

<form method="post">
    <textarea name="mensagem" maxlength="250" required></textarea>
    <button type="submit">Enviar</button>
</form>

<?php if ($erro): ?>
    <p><?= e($erro) ?></p>
<?php endif; ?>

<h2>Chat</h2>

<?php foreach ($mensagens as $mensagem): ?>
    <p>
        <?= nl2br(e($mensagem)) ?>
    </p>
<?php endforeach; ?>
