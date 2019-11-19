<?php

class clientes {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addCliente($nomecompleto, $fone, $cep, $rua, $numero, $complemento, $bairro, $cidade, $uf) {
        $sql = 'INSERT INTO clientes SET nomecompleto = :nomecompleto, fone = :fone, cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, uf = :uf';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nomecompleto", $nomecompleto);
        $sql->bindValue(":fone", $fone);
        $sql->bindValue(":cep", $cep);
        $sql->bindValue(":rua", $rua);
        $sql->bindValue(":numero", $numero);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":bairro", $bairro);
        $sql->bindValue(":cidade", $cidade);
        $sql->bindValue(":uf", $uf);
        $sql->execute();
    }

    public function getCliente() {
        $array = array();

        $sql = 'SELECT * FROM clientes ORDER BY nomecompleto ASC';
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getClienteBuscar($nome) {
        $array = array();

        $sql = 'SELECT * FROM clientes WHERE nomecompleto LIKE CONCAT(:nome, "%") ORDER BY nomecompleto ASC';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nome", $nome);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function delCliente($id) {
        $sql = 'DELETE FROM clientes WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function upCliente($id, $nomecompleto, $fone, $cep, $rua, $numero, $complemento, $bairro, $cidade, $uf) {
        $sql = 'UPDATE clientes SET nomecompleto = :nomecompleto, fone = :fone, cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, uf = :uf WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":nomecompleto", $nomecompleto);
        $sql->bindValue(":fone", $fone);
        $sql->bindValue(":cep", $cep);
        $sql->bindValue(":rua", $rua);
        $sql->bindValue(":numero", $numero);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":bairro", $bairro);
        $sql->bindValue(":cidade", $cidade);
        $sql->bindValue(":uf", $uf);
        $sql->execute();
    }

    public function getClienteEdit($id) {
        $array = array();

        $sql = 'SELECT * FROM clientes WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }
}    