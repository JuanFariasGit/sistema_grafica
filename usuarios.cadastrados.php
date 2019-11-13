<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
session_start();


if(empty($_SESSION['logado'])) {
	header('Location: '.BASE_URL.'login');
	exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
if(empty($_GET['buscarUsuario'])) {
  $usuarios = $u->getUsuario();
} else {
  $nome = trim($_GET['buscarUsuario']);
  $usuarios = $u->getUsuarioBuscar($nome);
}
?>

<?php require 'inc/header.php'; ?>

<?php if($u->temPermissao('ADMINISTRADOR')): ?>
      <?php require 'inc/menu.php'; ?> 
      <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark" style='min-height: 50vh'>    
        <h4 class="font-weight-bold">Usuários Cadastrados</h4>
        <form method="get">
          <div class="form-group d-sm-flex align-items-center">
            <input class="form-control my-1" type="search" name="buscarUsuario">
            <input class="btn-sm btn-primary m-1 font-weight-bold" type="submit" value="BUSCAR">
          </div>
        </form> 
        <div id="msgAlert"></div>
        <div class="table-responsive">
          <table class="table table-dark text-center">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome de usuário</th>
                <th scope="col">E-mail</th>
                <th scope="col">Tipo de Conta de Usuário</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($usuarios as $usuario): ?>
              <tr>
                <td><p class="my-1"><?php echo $usuario['id']; ?></p></td>
                <td><p class='my-1'><?php echo $usuario['nome']; ?></p></td>
                <td><p class='my-1'><?php echo $usuario['email']; ?></p></td>
                <td>
                  <p class='my-1'>
                    <?php if($usuario['permissao'] == 'ADMINISTRADOR') {
                              echo 'Administrador';
                          } elseif($usuario['permissao'] == 'PADRÃO') {
                              echo 'Padrão';
                          }; 
                    ?>
                  </p>
                </td>
                <td>
                  <a class="btn btn-sm btn-success my-1" href="<?php echo BASE_URL; ?>edit.usuario?id=<?php echo $usuario['id']; ?>">EDIT</a>
                  <a id="<?php echo $usuario['id']; ?>" name="<?php echo $usuario['nome']; ?>" class="btn btn-danger btn-sm <?php echo $usuario['permissao'] ?>" onclick="delUsuario(this)" style="cursor:pointer">DEL</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>   
  <?php else:
            require 'inc/menu.php';
        echo   "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                    <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                    <img class='my-2' width='300px' src='assets/imagens/logo.png'>
                </div>
               "         
       ?>          
<?php endif; ?>  

<?php require 'inc/footer.php'; ?>