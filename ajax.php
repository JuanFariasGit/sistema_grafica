<?php

require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
session_start();

if(!empty($_SESSION['logado'])) {
    $id = $_SESSION['logado'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id AND ip = :ip");
    $sql->bindValue(":id", $id);
    $sql->bindValue(":ip", $ip);
    $sql->execute();
    
    if($sql->rowCount() == 0) {
        header("Location: ".BASE_URL."login");
        exit;
    }
  } else {
    header("Location: ".BASE_URL."login");
    exit;
  }

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

if(($u->temPermissao("ADMINISTRADOR")) || ($u->temPermissao("PADRÃO"))) {
  $id_pedido = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : '';
  $id_situacao = isset($_POST['id_situacao']) ? $_POST['id_situacao'] : '';
  $option = $_POST['option'];
  $pd = new pedidos($pdo);

  switch ($option) {
    case 1:
      $pd->upSituacaoPedido($id_pedido, $id_situacao);
    break;
    case 2:
      $produtos = $pd->getPedidoProdutosEdit($id_pedido);

      $html = '';

      $html .= '
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">PRODUTO</th>
                    <th scope="col">QUANT</th>
                  </tr>  
                </thead>
                <tbody>
      ';
      foreach ($produtos as $produto) {
        $html .= "<tr><td>".$produto['produto']."</td>";
        $html .= "<td>".$produto['quantidade']."</td></tr>";
      }
      $html .= '
              </tbody>
            </table>  
      ';
      echo $html;

    break;
  }
} else {
  header("Location: ".BASE_URL."login");
}