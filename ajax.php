<?php

  require 'inc/config.php';
  require 'inc/usuarios.class.php';
  require 'inc/clientes.class.php';
  require 'inc/produtos.class.php';
  require 'inc/pedidos.class.php';
  require 'inc/historico.class.php';
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

  $id_categoria = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : '';
  $id_pedido = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : '';
  $id_situacao = isset($_POST['id_situacao']) ? $_POST['id_situacao'] : '';
  $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
  $id_produto = isset($_POST['id_produto']) ? $_POST['id_produto'] : '';
  $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
  $id_historico = isset($_POST['id_historico']) ? $_POST['id_historico'] : '';
  $add_nome_situacao = isset($_POST['add_nome_situacao']) ? $_POST['add_nome_situacao'] : '';
  $up_nome_situacao = isset($_POST['up_nome_situacao']) ? $_POST['up_nome_situacao'] : '';
  $up_id_situacao = isset($_POST['up_id_situacao']) ? $_POST['up_id_situacao'] : '';
  $del_id_situacao = isset($_POST['del_id_situacao']) ? $_POST['del_id_situacao'] : '';
  $add_nome_categoria = isset($_POST['add_nome_categoria']) ? $_POST['add_nome_categoria'] : '';
  $up_nome_categoria = isset($_POST['up_nome_categoria']) ? $_POST['up_nome_categoria'] : '';
  $up_id_categoria = isset($_POST['up_id_categoria']) ? $_POST['up_id_categoria'] : '';
  $del_id_categoria = isset($_POST['del_id_categoria']) ? $_POST['del_id_categoria'] : '';
  $add_nome_usuario = isset($_POST['add_nome_usuario']) ? $_POST['add_nome_usuario'] : '';
  $add_email_usuario = isset($_POST['add_email_usuario']) ? $_POST['add_email_usuario'] : '';
  $add_senha_usuario = isset($_POST['add_senha_usuario']) ? $_POST['add_senha_usuario'] : '';
  $add_permissao_usuario = isset($_POST['add_permissao_usuario']) ? $_POST['add_permissao_usuario'] : '';
  $buscarUsuario = isset($_POST['buscarUsuario']) ? $_POST['buscarUsuario'] : '';
  $option = $_POST['option'];
  
  $pd = new pedidos($pdo);
  $c  = new clientes($pdo);
  $p = new produtos($pdo);
  $h = new historico($pdo);

  switch ($option) {
    case 1:
      $pd->upSituacaoPedido($id_pedido, $id_situacao);
    break;
    case 2:
      $produtos = $pd->getPedidoProdutosEdit($id_pedido);

      $html = '';

      $html .= '
              <div class="table-responsive">
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
              </div>    
      ';
      echo $html;

    break;
    case 3:
      $u->delUsuario($id_usuario);
    break;
    case 4:
      $c->delCliente($id_cliente);
    break;
    case 5:
      $p->delProduto($id_produto);
    break;
    case 6:
      $pd->delPedido($id_pedido);
    break;
    case 7:
      $h->delHistorico($id_historico);
    break;
    case 8:
      $data = $pd->addSituacao($add_nome_situacao);
      echo $data;
    break;
    case 9:
      $pd->upSituacao($up_id_situacao, $up_nome_situacao);
    break;
    case 10:
      $pd->delSituacao($del_id_situacao);
    break;
    case 11:
      $data = $p->addCategoria($add_nome_categoria);
      echo $data;
    break;
    case 12:
      $p->upCategoria($up_id_categoria, $up_nome_categoria);
    break;
    case 13:
      $p->delCategoria($del_id_categoria);
    break;
    case 14:
      $p->upCategoriaProduto($id_categoria, $id_produto);
    break;
    case 15:
      $usuarios = $u->getUsuarioBuscar($buscarUsuario);
      $html = '';
      foreach($usuarios as $usuario) {
        $html .= '<tr id="'.$usuario['id'].'"><td>'.$usuario['id'].'</td>';
        $html .= '<td>'.$usuario['nome'].'</td>';
        $html .= '<td>'.$usuario['email'].'</td>';
        $html .= '<td>'.$usuario['permissao'].'</td>'; 
        $html .= '<td><a href="'.BASE_URL.'edit.usuario?id='.$usuario['id'].'"><i class="fas fa-pen" style="font-size:12pt"></i></a>
        <a id="'.$usuario['id'].'" name="'.$usuario['nome'].'" class="'.$usuario['permissao'].'" onclick="delUsuario(this)" style="cursor:pointer"><i class="fas fa-trash-alt text-danger" style="font-size:12pt"></i></a></td></tr>';
      }
                      
        echo $html;
            break;
}