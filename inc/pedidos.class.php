<?php

class pedidos {

    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getIdPedido() {
        $sql = $this->pdo->prepare("SELECT (max(id)+1) as id FROM pedidos");
        $sql->execute();
        
        $sql = $sql->fetch();
        $id = $sql['id'];

        if ($id == null) {
          $sql = $this->pdo->prepare("select auto_increment as id from information_schema.tables where table_name = 'pedidos' and table_schema = 'graficasistema'");
            $sql->execute();
            $sql = $sql->fetch();
            $id = $sql['id'];
            return $id;
        } else {
            return $id;
        }
    }

    public function addPedido($id , $id_cliente, $datahora, $obs, $produtos_id, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $desconto, $total, $valor_pago, $faltapagar, $situacao) {
        $sql = "INSERT INTO pedidos (id, id_cliente, datahora, obs, valorfrete, taxacartao, desconto,total, valorpago, faltapagar, situacao) VALUES (:id, :id_cliente, STR_TO_DATE(:datahora, '%d/%m/%Y %H:%i'), :obs, :valorfrete, :taxacartao, :desconto, :total, :valorpago, :faltapagar, :situacao)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_cliente', $id_cliente);
        $sql->bindValue(':datahora', $datahora);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':valorfrete', $valor_frete);
        $sql->bindValue(':taxacartao', $taxa_cartao);
        $sql->bindValue(':desconto', $desconto);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->execute();
       

        foreach($produtos_id as $i => $produto_id) {
            $sql = $this->pdo->prepare("INSERT INTO pedido_produtos (id_pedido, id_produto) VALUES (:id_pedido, :id_produto)");
            $sql->bindValue(":id_pedido", $id);
            $sql->bindValue(":id_produto", $produto_id);
            $sql->execute();

            $sql = $this->pdo->prepare("UPDATE pedido_produtos SET al = :altura, la = :largura, quantidade = :quantidade WHERE id_pedido = :id_pedido AND id_produto = :id_produto");
            $sql->bindValue(":altura", $al[$i]);
            $sql->bindValue(":largura", $la[$i]);
            $sql->bindValue(":quantidade", $quantidade[$i]);
            $sql->bindValue(":id_pedido", $id);
            $sql->bindValue(":id_produto", $produto_id);
            $sql->execute();
        }     
    }
    
    public function getPedido() {
        $array = array();

        $sql = "SELECT pedidos.id, pedidos.datahora, clientes.nomecompleto AS cliente, pedidos.total, pedidos.faltapagar, situacao.nome AS situacao, pedidos.obs FROM pedidos LEFT JOIN clientes ON clientes.id = pedidos.id_cliente LEFT JOIN situacao ON situacao.id = pedidos.situacao ORDER BY pedidos.datahora DESC";
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

        $sql = "SELECT pedidos.id, pedidos.cliente, pedidos.datahora, pedidos.obs, pedidos.produto, pedidos.al, pedidos.la, pedidos.quantidade, pedidos.valorunitario, pedidos.subtotal, pedidos.valorfrete, pedidos.taxacartao, pedidos.desconto, pedidos.total, pedidos.valorpago, pedidos.faltapagar, situacao.nome AS situacao FROM pedidos left JOIN situacao ON pedidos.situacao = situacao.id WHERE pedidos.id = :id";
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
		
		$sql = 'SELECT pedidos.id, pedidos.datahora, pedidos.cliente, pedidos.total, pedidos.faltapagar, pedidos.obs, situacao.nome AS situacao FROM pedidos left JOIN situacao ON situacao.id = pedidos.situacao WHERE (pedidos.cliente LIKE :nome"%" OR pedidos.cliente LIKE "%":nome OR pedidos.cliente LIKE "%":nome"%" OR situacao.nome LIKE :nome"%" OR situacao.nome LIKE "%":nome OR situacao.nome LIKE "%":nome"%")';
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

    public function gerarRelatorioGeral($anomes) {
		$array = array();

		$sql = 'SELECT datahora, sum(total) AS total_, sum(valorpago) AS valor_pago, sum(faltapagar) AS falta_pagar FROM pedidos WHERE datahora LIKE :datahora"%"';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":datahora", $anomes);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
    }
    
    public function gerarRelatorioDevedores($anomes) {
		$array = array();

		$sql = 'SELECT cliente, total, valorpago, faltapagar, datahora FROM pedidos WHERE datahora LIKE :datahora"%" AND faltapagar > 0';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":datahora", $anomes);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}
}