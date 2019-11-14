<?php

class pedidos {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addPedido($cliente, $datahora, $obs, $produtos, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $total, $valor_pago, $faltapagar, $situacao) {
        $sql = "INSERT INTO pedidos (cliente, datahora, obs, produto, al, la, quantidade, valorunitario, subtotal, valorfrete, taxacartao, total, valorpago, faltapagar, situacao) VALUE (:cliente, :datahora, :obs, :produto, :al, :la, :quantidade, :valorunitario, :subtotal, :valorfrete, :taxacartao, :total, :valorpago, :faltapagar, :situacao)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':cliente', $cliente);
        $sql->bindValue(':datahora', $datahora);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':produto', $produtos);
        $sql->bindValue(':al', $al);
        $sql->bindValue(':la', $la);
        $sql->bindValue(':quantidade', $quantidade);
        $sql->bindValue(':valorunitario', $valorunitario);
        $sql->bindValue(':subtotal', $subtotal);
        $sql->bindValue(':valorfrete', $valor_frete);
        $sql->bindValue(':taxacartao', $taxa_cartao);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->execute();
    }
    
    public function getPedido() {
        $array = array();

        $sql = "SELECT * FROM pedidos";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function addSituacao($nomesituacao) {
        $sql = "INSERT INTO situacao (nome) VALUE (:situacao)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":situacao", $nomesituacao);
        $sql->execute();
    }

    public function getSituacao() {
        $array = array();

        $sql = "SELECT * FROM situacao";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function delPedido($id) {
        $sql = "DELETE FROM pedidos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();   
    }

    public function delSituacao($nomesituacao) {
        $sql = "DELETE FROM situacao WHERE nome = :nome";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":nome", $nomesituacao);
        $sql->execute();
    }

    public function upPedido($id, $cliente, $datahora, $obs, $produtos, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $total, $valor_pago, $faltapagar, $situacao) {
        $sql = "UPDATE pedidos SET cliente = :cliente, datahora = :datahora, obs = :obs, produto = :produto, al = :al, la = :la, quantidade = :quantidade, valorunitario = :valorunitario, subtotal = :subtotal, valorfrete = :valorfrete, taxacartao = :taxacartao, total = :total, valorpago = :valorpago, faltapagar = :faltapagar, situacao = :situacao WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':cliente', $cliente);
        $sql->bindValue(':datahora', $datahora);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':produto', $produtos);
        $sql->bindValue(':al', $al);
        $sql->bindValue(':la', $la);
        $sql->bindValue(':quantidade', $quantidade);
        $sql->bindValue(':valorunitario', $valorunitario);
        $sql->bindValue(':subtotal', $subtotal);
        $sql->bindValue(':valorfrete', $valor_frete);
        $sql->bindValue(':taxacartao', $taxa_cartao);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->execute();
    }

    public function getPedidoEdit($id) {
        $array = array();

        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getPedidoBuscar($cliente) {
		$array = array();
		
		$sql = 'SELECT * FROM pedidos WHERE cliente LIKE CONCAT(:cliente, "%")';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":cliente", $cliente);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}
}