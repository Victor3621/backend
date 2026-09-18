<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars(
        $texto,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function validarUrl(string $url): ?string
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return null;
    }

    if (
        !str_starts_with($url, 'http://') &&
        !str_starts_with($url, 'https://')
    ) {
        return null;
    }

    return $url;
}

$nome = trim($_POST['nome'] ?? '');
$url = trim($_POST['url'] ?? '');
$linkValido = validarUrl($url);
$erro = $linkValido === null ? 'URL inválida.' : '';
?>

<form method="post">
    <input type="text" name="nome" required>
    <input type="url" name="url" required>
    <button type="submit">Cadastrar</button>
</form>

<?php if ($erro): ?>
    <p><?= e($erro) ?></p>
<?php elseif ($linkValido): ?>
    <p><?= e($nome) ?></p>
    <a href="<?= e($linkValido) ?>" target="_blank">
        Visitar Portfólio
    </a>
<?php endif; ?>
