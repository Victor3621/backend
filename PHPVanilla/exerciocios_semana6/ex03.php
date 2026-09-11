<?php
declare(strict_types=1);

$mensagemSucesso = "";
$erros = [];

$email = "";
$senha = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim((string) ($_POST["email"] ?? ""));
    $senha = trim((string) ($_POST["senha"] ?? ""));

    // Validação do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros["email"] = "Informe um e-mail válido.";
    }

    // Validação da senha
    if (strlen($senha) < 6) {
        $erros["senha"] = "A senha deve ter no mínimo 6 caracteres.";
    }

    // Verificação das credenciais
    if ($erros === []) {

        if (
            $email === "admin@senai.br" &&
            $senha === "senhaSegura123"
        ) {
            $mensagemSucesso = "Bem-vindo!";
        } else {
            $erros["login"] = "Credenciais inválidas";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
</head>

<body>

<main>

    <h1>Login</h1>

    <?php if ($mensagemSucesso !== ""): ?>

        <div class="sucesso">

            <h2><?= htmlspecialchars($mensagemSucesso) ?></h2>

            <p>
                Login realizado com sucesso!
            </p>

        </div>

    <?php endif; ?>


    <?php if (isset($erros["login"])): ?>

        <div class="erro">
            <?= htmlspecialchars($erros["login"]) ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <label for="email">
            E-mail
        </label>

        <input
            type="text"
            name="email"
            id="email"
            placeholder="Digite seu e-mail"
            value="<?= htmlspecialchars($email) ?>"
        >

        <?php if (isset($erros["email"])): ?>

            <div class="erro">
                <?= htmlspecialchars($erros["email"]) ?>
            </div>

        <?php endif; ?>


        <label for="senha">
            Senha
        </label>

        <input
            type="password"
            name="senha"
            id="senha"
            placeholder="Digite sua senha"
        >

        <?php if (isset($erros["senha"])): ?>

            <div class="erro">
                <?= htmlspecialchars($erros["senha"]) ?>
            </div>

        <?php endif; ?>


        <button type="submit">
            Entrar
        </button>

    </form>

</main>

</body>
</html>
