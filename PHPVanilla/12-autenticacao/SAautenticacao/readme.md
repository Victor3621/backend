# Situação de Aprendizagem Usando Sessão , Cookie e Autenticação

## Estrutura do Projeto

Organize sua pasta extamento com a seguinte árvores de arquivos

```text
SAAutenticacao/
├── config/
│   └── database.ini        <- Credenciais protegidas de acesso ao PostgreSQL
├── logs/
│   └── database.log        <- Logs do Banco de Dados
├── src/
│   ├── ConexaoBanco.php    <- Conexão Singleton PDO com PostgreSQL
│   ├── UsuarioDAO.php      <- Camada de persistência para consulta e cadastro
│   ├── AuthService.php     <- Serviço de gerenciamento de sessão e expiração
│   └── guard.php           <- Middleware interceptador de páginas restritas
├── schema.sql              <- Estrutura da tabela de usuários corporativos
├── login.php               <- Tela de autenticação pública
├── dashboard.php           <- Painel restrito protegido
├── logout.php              <- Encerramento seguro de sessão
├── cadastro.php            <- Página de Cadastro de Usuários
├── .gitignore              <- Arquivos não Versionados
└── README.md               <- Documentação do Projeto
```

# Situação de Aprendizagem Usando Sessão , Cookie e Autenticação

## Estrutura do Projeto

Organize sua pasta extamento com a seguinte árvores de arquivos

```text
SAAutenticacao/
├── config/
│   └── database.ini        <- Credenciais protegidas de acesso ao PostgreSQL
├── logs/
│   └── database.log        <- Logs do Banco de Dados
├── src/
│   ├── ConexaoBanco.php    <- Conexão Singleton PDO com PostgreSQL
│   ├── UsuarioDAO.php      <- Camada de persistência para consulta e cadastro
│   ├── AuthService.php     <- Serviço de gerenciamento de sessão e expiração
│   └── guard.php           <- Middleware interceptador de páginas restritas
├── schema.sql              <- Estrutura da tabela de usuários corporativos
├── login.php               <- Tela de autenticação pública
├── dashboard.php           <- Painel restrito protegido
├── logout.php              <- Encerramento seguro de sessão
├── cadastro.php            <- Página de Cadastro de Usuários
├── .gitignore              <- Arquivos não Versionados
└── README.md               <- Documentação do Projeto
```

## Criação da Tabela no Banco de Dados(PostgreSQL)

```sql
-- Criação da tabela devera ser dentro do banco almoxarifado_senai

CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL DEFAULT 'OPERADOR' CHECK (perfil IN ('ADMIN', 'OPERADOR')),
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

```

## Configurar os Dados do Banco e Criar a Conexão Singleton

Configurar os Dados do Banco de Dados (`config/datbase.ini`)

```ini
; config/database.ini
[database]
db_driver   = pgsql
db_host     = 127.0.0.1
db_port     = 5432
db_name     = almoxarifado_senai
db_user     = postgres
db_pass     = postgres
```

Criar a Classe de Conexão com o Banco de Dados em Formato Singleton (`src/ConexaoBanco.php`)
