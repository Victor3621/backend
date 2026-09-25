1. Pdo é o que permite que meu código em php se ligue com meu banco de dados

2. A string DSN (Data Source Name) é uma sequência de configuração usada para informar a uma aplicação como e onde se conectar a um banco de dados. No PostgreSQL, ela reúne os parâmetros necessários para estabelecer essa conexão.
Um exemplo seria:
postgresql://usuario:senha@localhost:5432/meu_banco
Os parâmetros mencionados têm as seguintes finalidades:
host: especifica o endereço do servidor onde o PostgreSQL está sendo executado. Pode ser um nome de domínio, um endereço IP ou, em ambientes locais, localhost.
port: indica a porta de rede na qual o PostgreSQL está aguardando conexões. A porta padrão é 5432, embora ela possa ser alterada na configuração do servidor.
dbname: identifica o nome do banco de dados específico ao qual a aplicação deseja se conectar. Um mesmo servidor PostgreSQL pode hospedar vários bancos de dados.

3. 5432 port

4. o exception ja é por si só um erro, e isso facilita o jeito pra gente resolver os problemas - mesmo qeu não resolvamos o problema.

5. faz com que os resultados das consultas sejam retornados como arrays associativos, usando os nomes das colunas como chaves:
[
    'id' => 1,
    'nome' => 'João'
]

6. Porque cada chamada a:
$pdo = new PDO(...);
pode estabelecer uma nova conexão/sessão com o PostgreSQL. Essa conexão ocupa um dos slots disponíveis definidos por max_connections enquanto estiver ativa.

7. Se a classe ConexaoBanco estiver implementando o padrão Singleton, o construtor deve ser private para impedir que outras partes do programa criem objetos diretamente com new.

8. Nunca é recomendado deixar usuário e senha do banco hardcoded nos scripts PHP porque isso cria um risco de segurança e dificulta a manutenção da aplicação.
Por exemplo, evitar:
$pdo = new PDO(
    'pgsql:host=localhost;port=5432;dbname=meu_banco',
    'admin',
    'MinhaSenha123'
);
Principais problemas
Vazamento de credenciais: se o código for exposto, enviado por engano para um repositório Git ou compartilhado, as credenciais podem ser comprometidas.
Dificuldade para trocar senhas: uma alteração da senha exige localizar e modificar o código que contém a credencial.
Ambientes diferentes: desenvolvimento, homologação e produção normalmente utilizam bancos e credenciais diferentes. Deixar os valores no código dificulta essa separação.
Controle de acesso: credenciais podem acabar sendo acessíveis a pessoas que precisam apenas consultar ou modificar o código, mas não deveriam conhecer a senha do banco.
Histórico do Git: mesmo removendo a senha posteriormente, ela pode continuar registrada no histórico de commits.

9. Porque PDOException::getMessage() pode revelar detalhes internos da aplicação e do banco de dados que não deveriam ser enviados ao usuário final.
Por exemplo:
try {
    $pdo->query($sql);
} catch (PDOException $e) {
    echo $e->getMessage();
}
Uma mensagem de erro pode revelar informações como:
Nome do banco de dados e, dependendo do erro, nomes de tabelas ou colunas.
Estrutura da consulta SQL que estava sendo executada
Endereço ou detalhes da conexão com o PostgreSQL.
Caminhos internos do servidor, em determinadas situações.
Informações que ajudam um atacante a entender a arquitetura da aplicação e identificar vulnerabilidades.