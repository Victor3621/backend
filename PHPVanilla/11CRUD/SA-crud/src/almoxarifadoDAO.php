<?php
declare(strict_types=1);

//isso é uma classe, ou seja usa POO

final class AlmoxarifadoDAO{
    //atributo = caracteristica
    private PDO $pdo;
    //métodos = ações
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    // metodo do crud
    //Read
    public function ListarTodos(): array {
        $sql = "SELECT * FROM pecas_industriais ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): ?array{
        $sql= "SELECT * FROM pecas_industriais WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id",$id, PDO::PARAM_INT);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }
    //CREATE
    public function salvar(array $dados): bool {
        $sql = "INSERT INTO pecas_industriais
        (codigo_sku, descricao, categoria, quantidade, preco_unitario)
        VALUES (:sku, :descricao, :categoria, :quantidade, :preco)";
        //se tem entrada de dados por input , fazer o prepare
        $stmt = $this->pdo->prepare($sql);

        $resultado = $stmt->execute([
            ":sku"          => strtoupper((trim($dados["codigo_sku"]))),
            ":descricao"    => trim($dados["descricao"]),
            ":categoria"    => trim($dados["categoria"]),
            ":quantidade"   => (int)$dados["quantidade"],
            ":preco"        => (float)$dados["preco_unitario"]
        ]);
        return $resultado;
    }

    public function atualizar(int $id, array $dados):bool{
        $sql = "UPDATE pecas_industriais
        SET codigo_sku = :sku, descricao = :descricao, categoria =:categoria, quantidade = :quantidade, preco_unitario = :preco WHERE id =:id";
        //se tem entrada de dados por input , fazer o prepare
        $stmt = $this->pdo->prepare($sql);

        $resultado = $stmt->execute([
            ":id"           => $dados["id"],
            ":sku"          => strtoupper((trim($dados["codigo_sku"]))),
            ":descricao"    => trim($dados["descricao"]),
            ":categoria"    => trim($dados["categoria"]),
            ":quantidade"   => (int)$dados["quantidade"],
            ":preco"        => (float)$dados["preco_unitario"]
        ]);
        return $resultado;
    }

    public function excluir (int $id): bool{
        $sql = "DELETE FROM precas_industriais WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function buscarPorTermo(string $termo):array {
        $sql = "SELECT * FROM pecas_industriais
                WHERE codigo_sku ILIKE :termo OR descricao ILIKE :termo OR categoria ILIKE :termo
                ORDER BY descricao ASC";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([":termo" =>"%" . trim($termo) . "%"]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}