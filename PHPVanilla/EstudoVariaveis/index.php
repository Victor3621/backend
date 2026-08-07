<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>estudo de variáveis</title>
</head>
<body>
    <h3>Estudo de variáveis</h3>
    <?php
    declare(strict_types=1); //blinda contra mistura acidentais de tipos de dados 
    // sintaxe de Variáveis em php
    // variáveis são representadas pelo símbolo "$" seguido do nome da variavel
    //exemplo
    $nome = "joão"; // Variável do tipo string
    $idade = 25; // Variável do tipo number
    $status = true; //variável do tipo boolean 
    $altura = 1.75; //vaiável para o tipo number (float)
    $email = null; // variavel do tio null
    #$endereco; não é possivel declarar uma variável sem atribuir um valor a ela, não existe Undefined em PHP 
    
    //Exibir as variáveis na tela
    echo "nome: $nome <b>";
    echo "Idade: $idade <br>";
    echo "Status: $status <br>";
    echo "Altura: $altura <br>";
    echo "Email: $email <br>";

    echo "<br> <h3> Contantes <\h3> <br>";

    // Constantes são representadas pela palavra "const" ou "define" seguida do nome da constante
    //Exemplos de constantes
    const PI = 3.14; //Constante do tipo Number (float)
    const EMPRESA = "google"; ////Constante do tipo String
    define("SITE", "www.google.com"); //Constante do tipo String
    // uma boa prática é ultilizar letras maiúsculas para nomear constantes, para diferenciar das variáveis

    //exibir constantes na ela
    echo "valor de PI: PI <br>";
    echo "nome da empresa: EMPRESA <br>";
    echo "site: SITE <br>";

    // tentando alterar o valor de uma constante, isso irá gerar um erro, pois constantes não podem ser alteradas
    // PI = 3.14159; // Isso é um erro
    //redeclarar uma constante também irá gerar um erro
    //const SITE = "www.google.com.br"; // Isso é um erro

    //Regra de Ouro: Sempre coloque a instrução declare(strict_types=1); no início do seu código PHP, 
    //isso blinda o seu sistema contra mistura acidentais de tipos de dados. 

    //ultilização de TEXTO ( concatenação VS interpolação)
    //exemplo de Concatenação -> juntar duas ou mais string ultilizando o operador "," (ponto0
    echo "ola, " . $nome . "! seja bem-vindo ao nosso site !<br>";

    // Exemplo de interpolação => Utilização de variaveis dentro de um texto, ultilizando aspas duplas 
    echo "$nome, $idade anos e sua altura é $altura metros. <br>"; //forma mais correta de misturar texto variáveis 
    


    ?> 



</body>
</html>