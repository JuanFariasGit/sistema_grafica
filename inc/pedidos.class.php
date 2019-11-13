<?php

class pedidos {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addPedido($cliente, $datahora, $obs, $produtos, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $total, $valor_pago, $faltapagar) {
        $sql = "INSERT INTO pedidos (cliente, datahora, obs, produto, al, la, quantidade, valorunitario, subtotal, valorfrete, taxacartao, total, valorpago, faltapagar) VALUE (:cliente, :datahora, :obs, :produto, :al, :la, :quantidade, :valorunitario, :subtotal, :valorfrete, :taxacartao, :total, :valorpago, :faltapagar)";
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
}