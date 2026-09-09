<?php
declare(strict_types=1);


$produtos = [
    ['nome' => 'Teclado USB', 'categoria' => 'Eletrônicos', 'preco' => 80.00],
    ['nome' => 'Mouse sem fio', 'categoria' => 'Eletrônicos', 'preco' => 65.00],
    ['nome' => 'Caderno', 'categoria' => 'Papelaria', 'preco' => 25.00],
    ['nome' => 'Caneta azul', 'categoria' => 'Papelaria', 'preco' => 3.50],
    ['nome' => 'Monitor 24 polegadas', 'categoria' => 'Eletrônicos', 'preco' => 899.90],
];

$mensagemSucesso = ""; 
$erros = []; 
$nome = ""; 
$email = ""; 
$cadastros= [
    ["nome" => "Jose", "email" => "jose@email.com"]
];

$buscaProduto = trim((string) ($_GET["produto"] ?? ""));
$precoMaximoTexto = trim((string) ($_GET["preco_maximo"] ?? ""));
$categoria = trim((string) ($_GET["categoria"] ?? ""));

$produtosFiltrado = $produtos;

if ($buscaProduto !== "" || $precoMaximoTexto !== "" || $categoria !== "") {

    $produtosFiltrado = array_filter(
        $produtos,
        function (array $produto) use (
            $buscaProduto,
            $precoMaximoTexto,
            $categoria
        ): bool {

            $nomeStatus = true;
            $precoStatus = true;
            $categoriaStatus = true;

            // Filtro pelo nome
            if ($buscaProduto !== "") {
                $nomeStatus = str_contains(
                    strtolower($produto["nome"]),
                    strtolower($buscaProduto)
                );
            }

            // Filtro pelo preço máximo
            if ($precoMaximoTexto !== "") {
                $precoMaximo = filter_var(
                    $precoMaximoTexto,
                    FILTER_VALIDATE_FLOAT
                );

                $precoStatus =
                    $precoMaximo !== false &&
                    $produto["preco"] <= $precoMaximo;
            }

            // Filtro pela categoria
            if ($categoria !== "") {
                $categoriaStatus =
                    strtolower($produto["categoria"]) === strtolower($categoria);
            }

            return $nomeStatus && $precoStatus && $categoriaStatus;
        }
    );
}


if($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim((string) ($_POST["nome"] ?? "")); 
    $email = trim((string) ($_POST["email"] ?? "")); 

    if(strlen($nome)<3){
        $erros["nome"] = "Informe um nome com pelo menos 3 caracteres";
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erros["email"] = "Informe um email Válido!";
    }

    if($erros === []){
        $mensagemSucesso = "Cadastro Realizado com sucesso!";
        $usuario = ["nome" => $nome,"email" => $email];
        array_push($cadastros, $usuario);
    }

    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de GET e POST no PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Exemplo prático: GET e POST</h1>

        <section>
            <h2>Utilização de filtro pela URL (GET)</h2>

            <form action="index.php" method="GET">
                <label for="produto">Nome do Produto</label>
                <input type="text" name="produto" id="produto" placeholder="Buscar Produto">

                <label for="preco_maximo">Preço Máximo</label>
                <input type="number" name="preco_maximo" id="preco_maximo" step="0.01" placeholder="100">

                <label for="produto">Categoria</label>
                <input type="text" name="categoria" id="categoria" placeholder="categoria">

                <button type="submit">Pesquisar</button>
            </form>

            <h2>Lista de Produtos Filtrados</h2>
            <p>Observem que os dados da pesquisa aparecem na URL</p>

            <?php if ($produtosFiltrado === []): ?>
                <p class="vazio">Nenhum produto encontrado.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtosFiltrado as $produto): ?>
                            <tr>
                                <td><?= $produto['nome'] ?></td>
                                <td><?= $produto['categoria'] ?></td>
                                <td>
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </section>

        <section>
            <h2>Cadastro de Alunos com POST</h2>
            <p>Os dados serão enviados no corpo(body) da requisição e não aparecem na URL</p>

            <?php if($mensagemSucesso !== ""):?>
                <div class="sucesso">
                    <?=  $nome ?><br>
                    <?= $email ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="POST">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu Nome">
                <?php if(isset($erros["nome"])): ?>
                    <div class="erro">
                        <?= $erros["nome"] ?>
                    </div> 
                <?php endif; ?>  
            </form>

            <form action="index.php" method="POST">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Digite seu Email">
                <?php if(isset($erros["email"])): ?>
                    <div class="erro">
                        <?= $erros["email"] ?>
                    </div> 
                <?php endif; ?>
            </form>
            
            <button type="submit">Cadastrar</button>


        </section>

    </main>
    
</body>
</html>