<?php

require "inc/config.php";
require "inc/usuarios.class.php";
require "inc/historico.class.php";

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

  if (!empty($_POST['senha'])) {
      $senha = md5($_POST['senha']);
      $h = new historico($pdo);
      if ($h->senhaHistorico($senha)) {
          header("Location: ".BASE_URL."historico");
      } else {
          header("Location: ".BASE_URL."senha.historico");
      }
  }
  
$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);


?>

<?php require 'inc/header.php'; ?>
<?php if($u->temPermissao('ADMINISTRADOR')): ?>
    <?php require 'inc/menu.php'; ?>

	<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white py-3'>    

		<form class="col-3 mb-2" method="POST" onsubmit="return validar_redefinir_senha_logado()">

            <div class="form-group">

				<label for="atualsenha">Digite a senha:</label>

				<input class="form-control" type="password" name="senha" id="senha">

			</div>

			<input class="btn-sm btn-primary font-weight-bold" type="submit" value="ENTRAR">

		</form>

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