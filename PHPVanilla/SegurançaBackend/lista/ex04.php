<?php

declare(strict_types=1);

function sanitizarTexto(string $dado): string
{
    return strip_tags(trim($dado));
}

function validarColaborador(array $dados): array
{
    $erros = [];

    if ($dados['nome'] === '') {
        $erros['nome'] = 'Nome é obrigatório.';
    }

    if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'E-mail inválido.';
    }

    if (filter_var($dados['matricula'], FILTER_VALIDATE_INT) === false) {
        $erros['matricula'] = 'Matrícula deve ser um inteiro.';
    }

    if (filter_var($dados['salario'], FILTER_VALIDATE_FLOAT) === false) {
        $erros['salario'] = 'Salário deve ser um número válido.';
    }

    return $erros;
}

$dados = [
    'nome' => sanitizarTexto($_POST['nome'] ?? ''),
    'email' => sanitizarTexto($_POST['email'] ?? ''),
    'matricula' => trim($_POST['matricula'] ?? ''),
    'salario' => trim($_POST['salario'] ?? '')
];

$erros = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? validarColaborador($dados)
    : [];
?>

<form method="post">
    <label>
        Nome:
        <input type="text" name="nome" required>
    </label><br>

    <label>
        E-mail:
        <input type="email" name="email" required>
    </label><br>

    <label>
        Matrícula:
        <input type="number" name="matricula" required>
    </label><br>

    <label>
        Salário:
        <input type="text" name="salario" required>
    </label><br>

    <button type="submit">Cadastrar</button>
</form>

<?php if ($erros): ?>
    <h2>Corrija os seguintes erros:</h2>
    <ul>
        <?php foreach ($erros as $campo => $erro): ?>
            <li><?= e($campo) ?>: <?= e($erro) ?></li>
        <?php endforeach; ?>
    </ul>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <h2>Colaborador cadastrado!</h2>
    <p>Nome: <?= e($dados['nome']) ?></p>
    <p>E-mail: <?= e($dados['email']) ?></p>
    <p>Matrícula: <?= e($dados['matricula']) ?></p>
    <p>Salário: <?= e($dados['salario']) ?></p>
<?php endif; ?>
