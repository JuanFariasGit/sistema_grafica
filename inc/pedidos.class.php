<?php

class pedidos {

    private $pdo;
    private $id_pedido;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addPedido($cliente, $datahora, $obs, $produtos, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $desconto, $total, $valor_pago, $faltapagar, $situacao) {
        $sql = "INSERT INTO pedidos (cliente, datahora, obs, produto, al, la, quantidade, valorunitario, subtotal, valorfrete, taxacartao, desconto,total, valorpago, faltapagar, situacao) VALUES (:cliente, STR_TO_DATE(:datahora, '%d/%m/%Y %H:%i'), :obs, :produto, :al, :la, :quantidade, :valorunitario, :subtotal, :valorfrete, :taxacartao, :desconto, :total, :valorpago, :faltapagar, :situacao)";
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
        $sql->bindValue(':desconto', $desconto);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->execute();
    }
    
    public function getPedido() {
        $array = array();

        $sql = "select pedidos.id, pedidos.cliente, pedidos.datahora, pedidos.obs, pedidos.produto, pedidos.al, pedidos.la, pedidos.quantidade, pedidos.valorunitario, pedidos.subtotal, pedidos.valorfrete, pedidos.taxacartao, pedidos.desconto, pedidos.total, pedidos.valorpago, pedidos.faltapagar, situacao.nome as situacao from pedidos join situacao on pedidos.situacao = situacao.id order by pedidos.datahora desc";
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

    public function upSituacao($id,$nome) {
        $sql = "UPDATE situacao SET nome = :situacao WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":situacao", $nome);
        $sql->execute();
    }

    public function getSituacao() {
        $array = array();

        $sql = "SELECT * FROM situacao ORDER BY nome ASC";
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

    public function delSituacao($id) {
        $sql = "DELETE FROM situacao WHERE situacao.id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function upPedido($id, $cliente, $datahora, $obs, $produtos, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $desconto, $total, $valor_pago, $faltapagar, $situacao) {
        $sql = "UPDATE pedidos SET cliente = :cliente, datahora = STR_TO_DATE(:datahora, '%d/%m/%Y %H:%i'), obs = :obs, produto = :produto, al = :al, la = :la, quantidade = :quantidade, valorunitario = :valorunitario, subtotal = :subtotal, valorfrete = :valorfrete, taxacartao = :taxacartao, desconto = :desconto, total = :total, valorpago = :valorpago, faltapagar = :faltapagar, situacao = :situacao WHERE id = :id";
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
        $sql->bindValue(':desconto', $desconto);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->execute();
    }

    public function getPedidoEdit($id) {
        $array = array();

        $sql = "SELECT pedidos.id, pedidos.cliente, pedidos.datahora, pedidos.obs, pedidos.produto, pedidos.al, pedidos.la, pedidos.quantidade, pedidos.valorunitario, pedidos.subtotal, pedidos.valorfrete, pedidos.taxacartao, pedidos.desconto, pedidos.total, pedidos.valorpago, pedidos.faltapagar, situacao.nome AS situacao FROM pedidos JOIN situacao ON pedidos.situacao = situacao.id WHERE pedidos.id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getPedidoBuscar($nome) {
		$array = array();
		
		$sql = 'SELECT pedidos.id, pedidos.datahora, pedidos.cliente, pedidos.total, pedidos.faltapagar, pedidos.obs, situacao.nome AS situacao FROM pedidos JOIN situacao ON situacao.id = pedidos.situacao WHERE (pedidos.cliente LIKE :nome"%" OR pedidos.cliente LIKE "%":nome OR pedidos.cliente LIKE "%":nome"%" OR situacao.nome LIKE :nome"%" OR situacao.nome LIKE "%":nome OR situacao.nome LIKE "%":nome"%")';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":nome", $nome);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
    }
    
    public function getPedidoVisualizar($id) {
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
}