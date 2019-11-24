<?php

class produtos {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addProduto($nome, $unidademedida, $categoria, $valor) {
        $sql = 'INSERT INTO produtos SET nome = :nome, unidademedida = :unidademedida, categoria = :categoria, valor = :valor';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':unidademedida', $unidademedida);
        $sql->bindValue(':categoria', $categoria);
        $sql->bindValue(':valor', $valor);
        $sql->execute();
    }
   
    public function getProduto() {
        $array = array();

        $sql = 'SELECT produtos.id, produtos.nome, produtos.unidademedida, produtos.valor, categorias.nome AS categoria FROM produtos JOIN categorias on produtos.categoria = categorias.id ORDER BY nome ASC';
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getCategoria() {
        $array = array();

        $sql = 'SELECT * FROM categorias';
        $sql =  $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function addCategoria($nome) {
        $sql = 'INSERT INTO categorias SET nome = :nome';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->execute();
    }

    public function delCategoria($nome) {
        $sql = 'DELETE FROM categorias WHERE nome = :nome';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->execute();
    }

    public function delProduto($id) {
        $sql = 'DELETE FROM produtos WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function getProdutoEdit($id) {
        $array = array();

        $sql = 'SELECT * FROM produtos WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function upProduto($id, $nome, $unidademedida, $categoria, $valor) {
        $sql = 'UPDATE produtos SET nome = :nome, unidademedida = :unidademedida, categoria = :categoria, valor = :valor WHERE id = :id';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':unidademedida', $unidademedida);
        $sql->bindValue(':categoria', $categoria);
        $sql->bindValue(':valor', $valor);
        $sql->execute();
    }

    public function getProdutoBuscar($nome) {
		$array = array();
		
		$sql = 'SELECT * FROM produtos WHERE nome LIKE CONCAT(:nome, "%") OR categoria LIKE CONCAT(:nome, "%") ORDER BY nome ASC';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":nome", $nome);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}
}