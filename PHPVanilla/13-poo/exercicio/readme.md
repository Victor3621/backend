1. Ocupam memoria desnecessaria, não tem como deixar privado ou protegido as classes ou seus atributos, em uma manutenção, teria de alterar o código inteiro e ainda tem a margem do erro de "arrumar a parte errada" e também permitir que outras variavel herdem caracterirsticas dessa classe abstrata.
2. Ele constroi na memoria a informação de que foi criada uma nova conta corrente e envia os dados para o sistema da qual ococrre essa conta
3. Ele pega **Essa** variavel e não altera as outras. Todas as contas tem saldo, porém quando eu tenho um débito em uma conta apenas o saldo de duas contas irá mudar e não a de todas
4. Para assim proteger os atributos, para que você não coloque que seu saldo é de 1M sendo qeu antes você tinha R$ 10.00 e não houve transferencia nem positiva nem negativa na conta. os atributos são privados e os metodos publicos
5. o private não permite que outras classes herdem caracteristicas da classe, o private sim
6.  uso do `Property Promotion`no construtor é um exemplo, não precisamos declarar os atributos e depois fazer o construtor, basta declarar os atributos diretamente dentro do construtor.

```php
class TitularProperty {
    public function __construct(
        private string $nome,
        private string $cpf
    ){}
}

//isso é igual 

class TitularSemProperty {
    private string $nome;
    private string $cpf;

    public function __construct(string $nome, string $cpf){
        $this->nome = $nome;
        $this->cpf = $cpf
    }
}
```
7. como seu nome já diz, os valores lá inseridos são apenas para leitura, uma vez declarados são imutaveis
8. A Conta é a versão base, que não importa qual conta escolha ela sempre vai ter essas caracteristicas, enquanto a corrente ou poupança tem elas e mais algumas ou interferem e alteram e Conta base. è tipo um mouse, ele pode ser de escritório ou gamer, mas ainda assim é um mouse
9. Ela verifica que cumpre os requisitos de uma conta e executa a ação, já que as duas que existem não impedem de receber transferencias vindas ou oriundas de apenas uma versão delas, a transferencia pode ser feita, desde que tenha uma origem e um destino
10. para evitar enchessão de saco, o cliente não sabe os termos técnicos então é melhor retornar uma mensagem de erro genérica e que reolva o problema do que o relatório especifico do log ou null ou false, serve pra explicar pro cliente o erro que deu, seja de internet ou saldo.