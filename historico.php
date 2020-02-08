<?php 
require 'inc/config.php';
require 'inc/usuarios.class.php';
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

if(empty($_SESSION['senha_historico'])) {
  header("Location: ".BASE_URL."senha.historico");
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);

$h = new historico($pdo);
$historico = $h->getHistorico();
?>

<?php require 'inc/header.php'; ?>

    <?php if($u->temPermissao('ADMINISTRADOR')): ?>
                <?php require 'inc/menu.php'; ?>
                <div class="text-white bg-dark py-5 container-fluid">
                    <h4 class="text-center font-weight-bold">HISTÓRICO DE LOGIN</h4>
                    <div id="msgAlert"></div>
                    <div class="table-responsive">
                      <table class="table table-dark text-center">
                        <thead>
                          <tr>
                            <th scope="col">ID do Acesso</th>
                            <th scope="col">Nome de usuário</th>
                            <th scope="col">Data E Hora</th>
                            <th scope="col">IP</th>
                            <th scope="col">SO</th>
                            <th scope="col">Navegador</th>
                            <th scope="col">Ação</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach($historico as $h): ?>
                            <tr id="<?php echo $h['id']; ?>">
                                <td><?php echo $h['id']; ?></td>
                                <td><?php echo $h['usuario']; ?></td>
                                <td><?php echo date('d/m/Y H:i',strtotime($h['datahora'])); ?></td>
                                <td><?php echo $h['ip']; ?></td>
                                <td><?php echo $h['so']; ?></td>
                                <td><?php echo $h['navegador']; ?></td>
                                <td><a id="<?php echo $h['id']; ?>" name="<?php echo $h['usuario']; ?>" class="btn btn-danger btn-sm" onclick="delHistorico(this)" style="cursor:pointer">DEL</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                </div>       
        <?php else:
            require 'inc/menu.php';
        echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                    <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                    <img class='my-2' width='300px' src='assets/imagens/logo.png'>
                </div>
            "         
    ?>         
    <?php endif; ?>

<?php require 'inc/footer.php'; ?>
