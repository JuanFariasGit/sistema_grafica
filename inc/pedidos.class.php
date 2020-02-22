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

    public function addPedido($id , $id_cliente, $emissao, $obs, $produtos, $id_produtos, $al, $la, $quantidade, $valorunitario, $valor_frete, $valor_arte, $valor_outros, $taxa_cartao, $desconto, $total, $valor_pago, $faltapagar, $situacao, $entrega, $vendedor) {
        $sql = "INSERT INTO pedidos (id, id_cliente, emissao, obs, valorfrete, valorarte, valoroutros, taxacartao, desconto, total, valorpago, faltapagar, situacao, entrega, vendedor) VALUES (:id, :id_cliente, STR_TO_DATE(:emissao, '%d/%m/%Y %H:%i'), :obs, :valorfrete, :valorarte, :valoroutros, :taxacartao, :desconto, :total, :valorpago, :faltapagar, :situacao, STR_TO_DATE(:entrega, '%d/%m/%Y'), :vendedor)";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_cliente', $id_cliente);
        $sql->bindValue(':emissao', $emissao);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':valorfrete', $valor_frete);
        $sql->bindValue(':valorarte', $valor_arte);
        $sql->bindValue(':valoroutros', $valor_outros);
        $sql->bindValue(':taxacartao', $taxa_cartao);
        $sql->bindValue(':desconto', $desconto);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->bindValue(':entrega', $entrega);
        $sql->bindValue(":vendedor", $vendedor);
        $sql->execute();
                
        foreach($produtos as $i => $produto) {
            $sql = "SELECT unidademedida FROM produtos WHERE id = :id_produto";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_produto", $id_produtos[$i]);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $sql = $sql->fetch();
                $uni = $sql['unidademedida'];
            } 
            
            $sql = $this->pdo->prepare("INSERT INTO pedido_produtos (id_pedido, produto, uni, al, la, quantidade, valoruni) VALUES (:id_pedido, :produto, :uni, :al, :la, :quantidade, :valoruni)");
            $sql->bindValue(":id_pedido", $id);
            $sql->bindValue(":produto", $produto);
            $sql->bindValue(":uni", $uni);
            $sql->bindValue(":al", $al[$i]);
            $sql->bindValue(":la", $la[$i]);
            $sql->bindValue(":quantidade", $quantidade[$i]);
            $sql->bindValue(":valoruni", number_format(explode(" ", $valorunitario[$i])[1], 2, ",", "."));
            $sql->execute();
        }     
    }
    
    public function getPedido() {
        $array = array();

        $sql = "SELECT pedidos.id, pedidos.emissao, clientes.nomecompleto AS cliente, pedidos.total, pedidos.faltapagar, situacao.nome AS situacao, pedidos.obs FROM pedidos LEFT JOIN clientes ON clientes.id = pedidos.id_cliente LEFT JOIN situacao ON situacao.id = pedidos.situacao ORDER BY pedidos.emissao DESC";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $pedidos = $sql->fetchAll();
            foreach($pedidos as $pedido) {
                ($pedido['situacao'] != "Concluído") ? array_push($array, $pedido) : "";
            }
        }
        return $array;
    }

    public function addSituacao($nomesituacao) {
        $sql = "INSERT INTO situacao (nome) VALUES (:situacao)";
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

    public function upPedido($id , $id_cliente, $emissao, $obs, $produtos, $id_produtos, $al, $la, $quantidade, $valorunitario, $valor_frete, $valor_arte, $valor_outros, $taxa_cartao, $desconto, $total, $valor_pago, $faltapagar, $situacao, $entrega) {
        $sql = "UPDATE pedidos SET id_cliente = :id_cliente, emissao = STR_TO_DATE(:emissao, '%d/%m/%Y %H:%i'), obs = :obs, valorfrete = :valorfrete, valorarte = :valorarte, valoroutros = :valoroutros, taxacartao = :taxacartao, desconto = :desconto, total = :total, valorpago = :valorpago, faltapagar = :faltapagar, situacao = :situacao, entrega = STR_TO_DATE(:entrega, '%d/%m/%Y %H:%i') WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_cliente', $id_cliente);
        $sql->bindValue(':emissao', $emissao);
        $sql->bindValue(':obs', $obs);
        $sql->bindValue(':valorfrete', $valor_frete);
        $sql->bindValue(':valorarte', $valor_arte);
        $sql->bindValue(':valoroutros', $valor_outros);
        $sql->bindValue(':taxacartao', $taxa_cartao);
        $sql->bindValue(':desconto', $desconto);
        $sql->bindValue(':total', $total);
        $sql->bindValue(':valorpago', $valor_pago);
        $sql->bindValue(':faltapagar', $faltapagar);
        $sql->bindValue(':situacao', $situacao);
        $sql->bindValue(':entrega', $entrega);
        $sql->execute();
        
        $sql = $this->pdo->prepare("DELETE FROM pedido_produtos WHERE id_pedido = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        foreach($produtos as $i => $produto) {
            $sql = "SELECT unidademedida FROM produtos WHERE id = :id_produto";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_produto", $id_produtos[$i]);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $sql = $sql->fetch();
                $uni = $sql['unidademedida'];
            } 
            
            $sql = $this->pdo->prepare("INSERT INTO pedido_produtos (id_pedido, produto, uni, al, la, quantidade, valoruni) VALUES (:id_pedido, :produto, :uni, :al, :la, :quantidade, :valoruni)");
            $sql->bindValue(":id_pedido", $id);
            $sql->bindValue(":produto", $produto);
            $sql->bindValue(":uni", $uni);
            $sql->bindValue(":al", $al[$i]);
            $sql->bindValue(":la", $la[$i]);
            $sql->bindValue(":quantidade", $quantidade[$i]);
            $sql->bindValue(":valoruni", str_replace(",", ".", explode(" ", $valorunitario[$i])[1]));
            $sql->execute();
        }
    }

    public function getPedidoEdit($id) {
        $array = array();

        $sql = "SELECT pedidos.id, pedidos.emissao, clientes.nomecompleto AS cliente, pedidos.total, pedidos.faltapagar, situacao.nome AS situacao, pedidos.obs, pedidos.valorfrete, pedidos.valorarte, pedidos.valoroutros, pedidos.taxacartao, pedidos.valorpago, pedidos.desconto, pedidos.entrega, pedidos.vendedor  FROM pedidos LEFT JOIN clientes ON clientes.id = pedidos.id_cliente LEFT JOIN situacao ON situacao.id = pedidos.situacao WHERE pedidos.id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getPedidoProdutosEdit($id) {
        $array = array();

        $sql = $this->pdo->prepare("SELECT produto, uni, al, la, quantidade, valoruni, al*la*quantidade*valoruni  AS subtotal FROM pedido_produtos WHERE id_pedido = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getPedidoBuscar($nome) {
		$array = array();
		
		$sql = 'SELECT pedidos.id, clientes.nomecompleto as cliente, pedidos.emissao, pedidos.obs, pedidos.valorfrete, pedidos.taxacartao, pedidos.desconto, pedidos.total, pedidos.valorpago, pedidos.faltapagar, situacao.nome as situacao FROM pedidos LEFT JOIN clientes ON pedidos.id_cliente = clientes.id LEFT JOIN situacao ON pedidos.situacao = situacao.id WHERE clientes.nomecompleto LIKE "%":nome"%" OR situacao.nome LIKE "%":nome"%"';
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

    public function gerarRelatorioGeral($anomes, $vendedor) {
		$array = array();

		$sql = 'SELECT emissao, sum(total) AS total_, sum(valorpago) AS valor_pago, sum(faltapagar) AS falta_pagar FROM pedidos WHERE  emissao LIKE :emissao"%" AND vendedor = :vendedor';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":vendedor", $vendedor);
		$sql->bindValue(":emissao", $anomes);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
    }
    
    public function gerarRelatorioDevedores($anomes, $vendedor) {
		$array = array();

		$sql = 'SELECT pedidos.emissao, clientes.nomecompleto AS cliente, pedidos.total, pedidos.valorpago, pedidos.faltapagar FROM pedidos LEFT JOIN clientes ON clientes.id = pedidos.id_cliente WHERE pedidos.emissao LIKE :emissao"%" AND pedidos.faltapagar > 0 AND vendedor = :vendedor';
		$sql = $this->pdo->prepare($sql);
        $sql->bindValue(":vendedor", $vendedor);
		$sql->bindValue(":emissao", $anomes);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
    }
    
    public function getRelatorioQuatidadePedidosClientes($anomes, $vendedor) {
        $array_cliente = array();
        $array_relatorio_cliente = array();

        $sql = $this->pdo->prepare('SELECT clientes.nomecompleto AS cliente FROM pedidos LEFT JOIN clientes ON clientes.id = pedidos.id_cliente WHERE pedidos.emissao LIKE :emissao"%" ORDER BY clientes.nomecompleto');
		$sql->bindValue(":emissao", $anomes);
        $sql->execute();

        if ($sql->rowCount() > 0) { 
            $array_cliente = $sql->fetchAll();
            $verificador = "";
            foreach($array_cliente as $cliente) {
                if ($verificador != $cliente) {
                    $verificador = $cliente;
                    $sql = $this->pdo->prepare('SELECT pedidos.emissao, clientes.nomecompleto AS cliente, count(pedidos.id_cliente) AS quantidade FROM pedidos LEFT JOIN clientes ON clientes.id = pedidos.id_cliente WHERE clientes.nomecompleto = :cliente AND emissao LIKE :emissao"%" AND vendedor = :vendedor');
                    $sql->bindValue(":cliente", $cliente['cliente']);
                    $sql->bindValue(":emissao", $anomes);
                    $sql->bindValue(":vendedor", $vendedor);
                    $sql->execute();
                    array_push($array_relatorio_cliente, $sql->fetch());
                }    
            }
            return $array_relatorio_cliente;
        }
    }

    public function upSituacaoPedido($id_pedido, $id_situacao) {
        $sql = $this->pdo->prepare("UPDATE pedidos SET situacao = :id_situacao WHERE id = :id_pedido");
        $sql->bindValue(":id_pedido", $id_pedido);
        $sql->bindValue(":id_situacao", $id_situacao);
        $sql->execute();
    }
}