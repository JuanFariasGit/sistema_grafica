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
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);
$array_u = $u->getUsuario();

$array_nome  = array();
foreach ($array_u as $nome_u) {
    array_push($array_nome, strtolower($nome_u['nome']));
}

$array_email = array();
foreach ($array_u as $email_u) {
    array_push($array_email, strtolower($email_u['email']));
}

$nome = $email = $senha = $permissao = $nome_exist = $email_exist = $nome_err = $email_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(in_array(strtolower($_POST['nome']), $array_nome)) {
        $nome_err = 'Já existe um usuário com o nome '.$_POST['nome'];
    } else {
        $nome  = addslashes($_POST['nome']);
    }
    
    if(in_array(strtolower($_POST['email']), $array_email)) {
        $email_err   = 'Já existe um usuário com o email '.$_POST['email'];
    } else {
        $email = addslashes($_POST['email']);
    }
    
    $permissao = addslashes($_POST['checkbox']);            
    $senha = md5($_POST['senha']);

    if(!empty($nome) && !empty($email)) {
        $u->addUsuario($nome, $email, $senha, $permissao);
        header("Location: ".BASE_URL."usuarios.cadastrados");
        exit;
    }    
}

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
                <div class="text-white bg-dark py-5 container-fluid">
                    <form method="POST" class="my-auto" onsubmit="return validar_usuario()">
                        <div class="d-flex justify-content-center">                            
                            <h4 class="font-weight-bold">USUÁRIO</h4>
                        </div>    
                        <div class="form-group col-sm-6 col-12 mx-auto">
                            <label for="nome">Nome de usuário:  <span class="text-danger"><?php echo $nome_err; ?></span></label>
                            <input class="form-control" type="nome" name="nome" id="nome" value="<?php if(!empty($nome)) { echo $nome; }; ?>">
                        </div>
                        <div class="form-group col-sm-6 col-12 mx-auto">
                            <label for="email">E-mail: <span class="text-danger"><?php echo $email_err; ?></span></label>
                            <input class="form-control" type="email" name="email" id="email" value="<?php if(!empty($email)) { echo $email; }; ?>">
                        </div>
                        <div class="form-group col-sm-6 col-12 mx-auto">
                            <label for="senha">Senha:</label>    
                            <input class="form-control" type="password" name="senha" id="senha">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group form-check-inline">
                                <input type="radio" class="form-check-input" id="checkbox0" name="checkbox" value="ADMINISTRADOR" <?php if($permissao == 'ADMINISTRADOR') { echo 'checked="checked"';} ?>>
                                <label class="form-check-label" for="checkbox0">Administrador</label>
                            </div>
                            <div class="form-group form-check-inline">
                                <input type="radio" class="form-check-input" id="checkbox1" name="checkbox" value="PADRÃO" <?php if($permissao == 'PADRÃO') { echo 'checked="checked"';} ?>>
                                <label class="form-check-label" for="checkbox1">Padrão</label>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <input class="btn-sm btn-primary font-weight-bold border-0" type="submit" value="CADASTRAR">
                        </div>
                    </form>
                    <form method="get">
                      <hr style="background-color:white;">
                      <div class="form-group d-sm-flex align-items-center justify-content-center">
                        <input class="form-control my-2" type="search" name="buscarUsuario" style="max-width: 500px">
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
        echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                    <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                    <img class='my-2' width='300px' src='assets/imagens/logo.png'>
                </div>
            "         
    ?>         
    <?php endif; ?>

<?php require 'inc/footer.php'; ?>
