<?php
declare(strict_types=1);

//isso é uma classe, ou seja usa POO

final class AlmoxarifadoDAO{
    //atributo = caracteristica
    private PDO $pdo;
    //métodos = ações
    public function __constructor(PDO $pdo){
        $this->pdo = $pdo;
    }
    // metodo do crud
    //
}