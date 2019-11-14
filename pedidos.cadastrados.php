<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header('Location: '.BASE_URL.'login');
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$pd = new pedidos($pdo);
$pedidos = $pd->getPedido();
?>

<?php require 'inc/header.php'; ?>

    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
      <?php require 'inc/menu.php'; ?> 
      <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark" style='min-height: 50vh'>    
        <h4 class="font-weight-bold">Pedidos Cadastrados</h4> 
        <form method="get">
          <div class="form-group d-sm-flex align-items-center">
            <input class="form-control my-1" type="search" name="buscarCliente">
            <input class="btn-sm btn-primary m-1 font-weight-bold" type="submit" value="BUSCAR">
          </div>
        </form>         
        <div class="table-responsive">
          <table class="table table-dark text-center">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Total</th>
                <th scope="col">Falta Pagar</th>
                <th scope="col">Situação</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo $pedido['id']; ?></td>
                    <td><?php echo $pedido['cliente']; ?></td>
                    <td><?php echo explode(":", $pedido['total'])[1]; ?></td>
                    <td><?php echo explode(":", $pedido['faltapagar'])[1]; ?></td>
                    <td><?php echo $pedido['situacao']; ?></td>
                    <td>
                      <a class="btn btn-sm btn-success my-1" href="<?php echo BASE_URL; ?>edit.pedido?id=<?php echo $pedido['id']; ?>">EDIT</a>
                      <a id="<?php echo $pedido['id']; ?>" name="<?php echo $pedido['cliente']; ?>" class="btn btn-danger btn-sm" onclick="delPedido(this)" style="cursor:pointer">DEL</a>
                    </td>
                </tr>
            <?php endforeach; ?>    
            </tbody>
          </table>
        </div>
      </div>
      <?php else:
        header('Location: '.BASE_URL.'login');  
        ?>   
    <?php endif; ?>

<?php require 'inc/footer.php'; ?>